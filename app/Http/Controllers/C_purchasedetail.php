<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\purchaseDetail;
use App\Models\purchase;
use App\Models\unit;
use App\Models\product;
use Validator;
use DB;

class C_purchasedetail extends Controller
{
    public function index(Request $request)
    {
        CheckMenuRole('/purchase/detail/');

        $d['purchaseinfo']=purchase::with('supplier:supplierId,supplierName')->find($request->purchaseId);

        $d['unit']=unit::pluck('unitName','unitId')->all();
        $d['product']=product::pluck('productName','productId')->all();

        $d['purchaseId']=$request->purchaseId;

        return view('purchase.purchasedetail',$d);
    }

    public function listDataPurchase(Request $request)
    {
        $data=purchaseDetail::with('unit:unitId,unitName','product:productId,productName')
                ->where('purchaseId',$request->purchaseId)->get();

        return response()->json($data);
    }

    public function addDataPurchase(Request $request)
    {
        $messages = [
            'required'  => 'attribute tidak boleh kosong',
            'numeric'   => 'attribute hanya boleh angka',
        ];

        $validator = Validator::make($request->all(), [
            'purchaseId' => "required",
            'productId'  => "required",
            'unitId'     => "required",
            'price'      => "required|numeric",
            'qty'       => "required|numeric",
        ], $messages);

        if ($validator->fails()) {
            return respons(400,  $validator->errors()->all());
        }

        try {
            //Update data product
            $data = purchaseDetail::create([
                'purchaseId' => $request->purchaseId,
                'productId'  => $request->productId,
                'unitId'     => $request->unitId,
                'prices'     => $request->price,
                'qty'        => $request->qty,
            ]);
             // Operasi lainnya...

            return respons(200,'Data has been saved',$data);
        } catch (\Exception $e) {
            // Tangkap kesalahan jika terjadi dan batalkan transaksi
            DB::rollback();
            return respons(400,'DB Transaksi failed',$e);
        }


    }

    public function deleteDataPurchase(Request $request)
    {
        $messages = [
            'required' => 'attribute tidak boleh kosong',
        ];

        $validator = Validator::make($request->all(), [
            "purchaseDetailId" => "required",
        ], $messages);

        if ($validator->fails()) {
            return respons(400,  $validator->errors()->all()[0]);
        }

        $data = purchaseDetail::find($request->purchaseDetailId);

        if($data){
            $data->delete();
            return respons(200,'Data has been deleted',$data);
        }else{
            return respons(404,'Data not found',$data);
        }


    }

    public function updateDataPurchase(Request $request)
    {
        $messages = [
            'required' => 'attribute tidak boleh kosong',
        ];

        $validator = Validator::make($request->all(), [
            'purchaseDetailId'  => "required",
            'purchaseId'        => "required",
            'productId'         => "required",
            'unitId'            => "required",
            'price'             => "required",
            'qty'               => "required",
        ], $messages);

        if ($validator->fails()) {
            return respons(400,  $validator->errors()->all()[0]);
        }

        $data = purchaseDetail::where('purchaseDetailId', $request->purchaseDetailId)
                ->update([
                    'purchaseId' => $request->purchaseId,
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
}
