<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\productCategori;
use Validator;

class C_productcategori extends Controller
{
    public function index(Request $request)
    {
        CheckMenuRole($request->getRequestUri());

        return view('productcategories.productcategori');
    }

    public function listDataCategori(Request $request)
    {
        $data=productCategori::all();

        return response()->json($data);
    }

    public function addDataCategori(Request $request)
    {
        $messages = [
            'required' => 'attribute tidak boleh kosong',
        ];

        $validator = Validator::make($request->all(), [
            "categori" => "required",

        ], $messages);

        if ($validator->fails()) {
            return respons(400,  $validator->errors()->all()[0]);
        }

        $data = productCategori::create([
            'categori' => $request->categori,
        ]);

        return respons(200,'Data has been saved',$data);
    }

    public function deleteDataCategori(Request $request)
    {
        $messages = [
            'required' => 'attribute tidak boleh kosong',
        ];

        $validator = Validator::make($request->all(), [
            "productCategoriId" => "required",

        ], $messages);

        if ($validator->fails()) {
            return respons(400,  $validator->errors()->all()[0]);
        }

        $data = productCategori::find($request->productCategoriId);

        if($data){
            $data->delete();
            return respons(200,'Data has been deleted',$data);
        }else{
            return respons(404,'Data not found',$data);
        }


    }

    public function updateDataCategori(Request $request)
    {
        $messages = [
            'required' => 'attribute tidak boleh kosong',
        ];

        $validator = Validator::make($request->all(), [
            "productCategoriId" => "required",
            "categori" => "required",
        ], $messages);

        if ($validator->fails()) {
            return respons(400,  $validator->errors()->all()[0]);
        }

        $data = productCategori::where('productCategoriId', $request->productCategoriId)
                ->update(['categori' => $request->categori]);

        if($data){
            return respons(200,'Data has been updated',$data);
        }else{
            return respons(404,'Data not found',$data);
        }


    }
}
