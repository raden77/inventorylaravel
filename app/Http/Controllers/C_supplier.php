<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\suppliers;
use Validator;
use DB;

class C_supplier extends Controller
{
    public function index(Request $request)
    {
        CheckMenuRole($request->getRequestUri());

        return view('supplier.supplier');
    }

    public function listDataSuppliers()
    {
        $list=suppliers::all();

        return response()->json($list);
    }

    public function addDataSuppliers(Request $request)
    {
        $messages = [
            'required' => 'attribute tidak boleh kosong',
        ];

        $validator = Validator::make($request->all(), [
            "supplierName" => "required",
            "address" => "required",
        ], $messages);

        if ($validator->fails()) {
            return respons(400,  $validator->errors()->all()[0]);
        }

        $data = suppliers::create([
            'supplierName' => $request->supplierName,
            'address' => $request->address,
        ]);

        return respons(200,'Data has been saved',$data);
    }

    public function deleteDataSuppliers(Request $request)
    {
        $messages = [
            'required' => 'attribute tidak boleh kosong',
        ];

        $validator = Validator::make($request->all(), [
            "supplierId" => "required",
        ], $messages);

        if ($validator->fails()) {
            return respons(400,  $validator->errors()->all()[0]);
        }

        $data = suppliers::find($request->supplierId);

        if($data){
            $data->delete();
            return respons(200,'Data has been deleted',$data);
        }else{
            return respons(404,'Data not found',$data);
        }


    }

    public function updateDataSuppliers(Request $request)
    {
        $messages = [
            'required' => 'attribute tidak boleh kosong',
        ];

        $validator = Validator::make($request->all(), [
            "supplierId" => "required",
            "supplierName" => "required",
            "address" => "required",
        ], $messages);

        if ($validator->fails()) {
            return respons(400,  $validator->errors()->all()[0]);
        }

        $data = suppliers::where('supplierId', $request->supplierId)
                ->update([
                    'supplierName' => $request->supplierName,
                    'address' => $request->address,
                ]);

        if($data){
            return respons(200,'Data has been updated',$data);
        }else{
            return respons(404,'Data not found',$data);
        }


    }
}
