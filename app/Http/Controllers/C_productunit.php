<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\unit;
use Validator;

class C_productunit extends Controller
{
    //
    public function index(Request $request)
    {
        CheckMenuRole($request->getRequestUri());

        return view('productsatuan.productsatuan');
    }

    public function listDataUnit()
    {
        $unitlist=unit::all();

        return response()->json($unitlist);
    }

    public function addDataUnit(Request $request)
    {
        $messages = [
            'required' => 'attribute tidak boleh kosong',
        ];

        $validator = Validator::make($request->all(), [
            "unitName" => "required",

        ], $messages);

        if ($validator->fails()) {
            return respons(400,  $validator->errors()->all()[0]);
        }

        $data = unit::create([
            'unitName' => $request->unitName,
        ]);

        return respons(200,'Data has been saved',$data);
    }

    public function deleteDataUnit(Request $request)
    {
        $messages = [
            'required' => 'attribute tidak boleh kosong',
        ];

        $validator = Validator::make($request->all(), [
            "unitId" => "required",

        ], $messages);

        if ($validator->fails()) {
            return respons(400,  $validator->errors()->all()[0]);
        }

        $data = unit::find($request->unitId);

        if($data){
            $data->delete();
            return respons(200,'Data has been deleted',$data);
        }else{
            return respons(404,'Data not found',$data);
        }


    }

    public function updateDataUnit(Request $request)
    {
        $messages = [
            'required' => 'attribute tidak boleh kosong',
        ];

        $validator = Validator::make($request->all(), [
            "unitId" => "required",
            "unitName" => "required",
        ], $messages);

        if ($validator->fails()) {
            return respons(400,  $validator->errors()->all()[0]);
        }

        $data = unit::where('unitId', $request->unitId)
                ->update(['unitName' => $request->unitName]);

        if($data){
            return respons(200,'Data has been updated',$data);
        }else{
            return respons(404,'Data not found',$data);
        }


    }
}
