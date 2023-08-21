<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\outbound;
use App\Models\outboundDetail;
use App\Models\unit;
use App\Models\product;
use Validator;
use DB;
use Log;

class C_outboundetail extends Controller
{
    public function index(Request $request)
    {
        CheckMenuRole('/outbound/detail/');

        $d['outboundInfo']=outbound::find($request->outboundId);

        $d['unit']=unit::pluck('unitName','unitId')->all();
        $d['product']=product::pluck('productName','productId')->all();

        $d['outboundId']=$request->outboundId;

        return view('outbound.outboundetail',$d);
    }

    public function listDataOutbound(Request $request)
    {
        $data=outboundDetail::with('unit:unitId,unitName','product:productId,productName')
                ->where('outboundId',$request->outboundId)->get();

        return response()->json($data);
    }

    public function addDataOutbound(Request $request)
    {
        $messages = [
            'required'  => 'attribute tidak boleh kosong',
            'numeric'   => 'attribute hanya boleh angka',
        ];

        $validator = Validator::make($request->all(), [
            'outboundId' => "required",
            'productId'  => "required",
            'unitId'     => "required",
            'price'      => "required|numeric",
            'qty'        => "required|numeric",
        ], $messages);

        if ($validator->fails()) {
            return respons(400,  $validator->errors());
        }

        try {
            DB::beginTransaction();

            $findProduct = product::find($request->productId)->lockForUpdate()->first();

            //Update data inbound
            $data = outboundDetail::create([
                'outboundId' => $request->outboundId,
                'productId'  => $request->productId,
                'unitId'     => $request->unitId,
                'prices'     => $request->price,
                'qty'        => $request->qty,
            ]);

            DB::commit();
            return respons(200,'Data has been saved',$data);

        } catch (\Exception $e) {
            // Tangkap kesalahan jika terjadi dan batalkan transaksi
            DB::rollback();
            return respons(400,'DB Transaksi failed',$e);
        }


    }

    public function deleteDataOutbound(Request $request)
    {
        $messages = [
            'required' => 'attribute tidak boleh kosong',
        ];

        $validator = Validator::make($request->all(), [
            "outboundDetailId" => "required",
        ], $messages);

        if ($validator->fails()) {
            return respons(400,  $validator->errors()->all()[0]);
        }

        $data = outboundDetail::find($request->outboundDetailId);

        if($data){
            $data->delete();
            return respons(200,'Data has been deleted',$data);
        }else{
            return respons(404,'Data not found',$data);
        }


    }

    public function updateDataOutbound(Request $request)
    {
        $messages = [
            'required' => 'attribute tidak boleh kosong',
        ];

        $validator = Validator::make($request->all(), [
            'outboundDetailId'  => "required",
            'outboundId'        => "required",
            'productId'         => "required",
            'unitId'            => "required",
            'price'             => "required",
            'qty'               => "required",
        ], $messages);

        if ($validator->fails()) {
            return respons(400,  $validator->errors()->all()[0]);
        }

        $data = outboundDetail::where('outboundDetailId', $request->outboundDetailId)
                ->update([
                    'outboundId' => $request->outboundId,
                    'productId'  => $request->productId,
                    'unitId'     => $request->unitId,
                    'prices'     => $request->price,
                    'qty'       => $request->qty,
                ]);

        if($data){
            return respons(200,'Data has been updated',$data);
        }else{
            return respons(404,'Data not found',$data);
        }


    }

    public function validDataOutbound(Request $request)
    {
        $messages = [
            'required' => 'attribute tidak boleh kosong',
        ];

        $validator = Validator::make($request->all(), [
            "outboundDetailId" => "required",
        ], $messages);

        if ($validator->fails()) {
            return respons(400,  $validator->errors()->all()[0]);
        }

        $data = outboundDetail::find($request->outboundDetailId);

        $productfind=product::find($data->productId);

        $qtyOut= $productfind->qty-$data->qty;
        if($data){
            $updateqty = product::where('productId',$data->productId)
                ->update([
                    'qty'=> $qtyOut,
                ]);

            return respons(200,'Data has been accepted',$data);
        }else{
            return respons(404,'Data not found',$data);
        }


    }
}
