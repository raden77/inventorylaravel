<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\purchase;
use App\Models\suppliers;
use Validator;
use DB;

class C_purchase extends Controller
{
    public function index(Request $request)
    {
        CheckMenuRole($request->getRequestUri());

        $d['supplier']=suppliers::pluck('supplierName','supplierId')->all();

        return view('purchase.purchase',$d);
    }

    public function listDataPurchase()
    {
        $data=purchase::with('supplier:supplierId,supplierName')->get();

        return response()->json($data);
    }

    public function addDataPurchase(Request $request)
    {
        $messages = [
            'required'  => 'attribute tidak boleh kosong',
            'numeric'   => 'attribute hanya boleh angka',
        ];

        $validator = Validator::make($request->all(), [
            'supplierId'       => "required",
            'description'         => "required",
        ], $messages);

        if ($validator->fails()) {
            return respons(400,  $validator->errors()->all());
        }


        try {
            //Update data product
            $data = purchase::create([
                'supplierId' => $request->supplierId,
                'description' => $request->description,
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
            "purchaseId" => "required",
        ], $messages);

        if ($validator->fails()) {
            return respons(400,  $validator->errors()->all()[0]);
        }

        $data = purchase::find($request->purchaseId);

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
            'purchaseId' => 'required',
            'kodePurchase' => 'required',
            'supplierId' => 'required',
            'description' => 'required',
        ], $messages);

        if ($validator->fails()) {
            return respons(400,  $validator->errors()->all()[0]);
        }

        $data = purchase::where('purchaseId', $request->purchaseId)
                ->update([
                    'kodePurchase' => $request->kodePurchase,
                    'supplierId' => $request->supplierId,
                    'description' => $request->description,
                ]);


        if($data){
            return respons(200,'Data has been updated',$data);
        }else{
            return respons(404,'Data not found',$data);
        }


    }
}
