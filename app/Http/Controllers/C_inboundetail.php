<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\inboundetail;
use App\Models\inbound;
use App\Models\unit;
use App\Models\product;
use Validator;
use DB;

class C_inboundetail extends Controller
{
    public function index(Request $request)
    {
        CheckMenuRole('/inbound/detail/');

        $d['inboundInfo']=inbound::find($request->inboundId);

        $d['unit']=unit::pluck('unitName','unitId')->all();
        $d['product']=product::pluck('productName','productId')->all();

        $d['inboundId']=$request->inboundId;

        return view('inbound.inboundetail',$d);
    }

    public function listDataInbound(Request $request)
    {
        $data=inboundetail::with('unit:unitId,unitName','product:productId,productName')
                ->where('inboundId',$request->inboundId)->get();

        return response()->json($data);
    }

    public function addDataInbound(Request $request)
    {
        $messages = [
            'required'  => 'attribute tidak boleh kosong',
            'numeric'   => 'attribute hanya boleh angka',
        ];

        $validator = Validator::make($request->all(), [
            'inboundId' => "required",
            'productId'  => "required",
            'unitId'     => "required",
            'price'      => "required|numeric",
            'qty'        => "required|numeric",
        ], $messages);

        if ($validator->fails()) {
            return respons(400,  $validator->errors()->all());
        }

        try {
            DB::beginTransaction();

            $findProduct = product::find($request->productId)->lockForUpdate()->first();

            //Update data inbound
            $data = inboundetail::create([
                'inboundId' => $request->inboundId,
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

    public function deleteDataInbound(Request $request)
    {
        $messages = [
            'required' => 'attribute tidak boleh kosong',
        ];

        $validator = Validator::make($request->all(), [
            "inboundDetailId" => "required",
        ], $messages);

        if ($validator->fails()) {
            return respons(400,  $validator->errors()->all()[0]);
        }

        $data = inboundetail::find($request->inboundDetailId);

        if($data){
            $data->delete();
            return respons(200,'Data has been deleted',$data);
        }else{
            return respons(404,'Data not found',$data);
        }


    }

    public function updateDataInbound(Request $request)
    {
        $messages = [
            'required' => 'attribute tidak boleh kosong',
        ];

        $validator = Validator::make($request->all(), [
            'inboundDetailId'  => "required",
            'inboundId'        => "required",
            'productId'         => "required",
            'unitId'            => "required",
            'price'             => "required",
            'qty'               => "required",
        ], $messages);

        if ($validator->fails()) {
            return respons(400,  $validator->errors()->all()[0]);
        }

        $data = inboundetail::where('inboundDetailId', $request->inboundDetailId)
                ->update([
                    'inboundId' => $request->inboundId,
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

    public function validDataInbound(Request $request)
    {
        $messages = [
            'required' => 'attribute tidak boleh kosong',
        ];

        $validator = Validator::make($request->all(), [
            "inboundDetailId" => "required",
        ], $messages);

        if ($validator->fails()) {
            return respons(400,  $validator->errors()->all()[0]);
        }

        $data = inboundetail::find($request->inboundDetailId);

        $productfind=product::find($data->productId);

        $qtyIn= $productfind->qty+$data->qty;
        if($data){
            $updateqty = product::where('productId',$data->productId)
                ->update([
                    'qty'=> $qtyIn,
                ]);

            return respons(200,'Data has been accepted',$data);
        }else{
            return respons(404,'Data not found',$data);
        }


    }
}
