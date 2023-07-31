<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\unitConversion;
use App\Models\unit;
use Validator;

class C_unitConversion extends Controller
{
    public function index(Request $request)
    {
        CheckMenuRole($request->getRequestUri());

        $d['unit']=unit::pluck('unitName','unitId')->all();

        return view('unitconversion.unitconversion',$d);
    }

    public function listDataUnitConversion()
    {
        $unitlist=unitConversion::with('fromUnit:unitId,unitName','toUnit:unitId,unitName')
                    ->get();

        return response()->json($unitlist);
    }

    public function addDataUnitConversion(Request $request)
    {
        $messages = [
            'required' => 'attribute tidak boleh kosong',
        ];

        $validator = Validator::make($request->all(), [
            "fromUnit"  => "required",
            "toUnit"    => "required",
            "ratio"     => "required"
        ], $messages);

        if ($validator->fails()) {
            return respons(400,  $validator->errors()->all()[0]);
        }

        $data = unitConversion::create([
            'fromUnit'  => $request->fromUnit,
            'toUnit'    => $request->toUnit,
            'ratio'     => $request->ratio,
        ]);

        return respons(200,'Data has been saved',$data);
    }

    public function deleteDataUnitConversion(Request $request)
    {
        $messages = [
            'required' => 'attribute tidak boleh kosong',
        ];

        $validator = Validator::make($request->all(), [
            "unitConversionId" => "required",

        ], $messages);

        if ($validator->fails()) {
            return respons(400,  $validator->errors()->all()[0]);
        }

        $data = unitConversion::find($request->unitConversionId);

        if($data){
            $data->delete();
            return respons(200,'Data has been deleted',$data);
        }else{
            return respons(404,'Data not found',$data);
        }


    }

    public function updateDataUnitConversion(Request $request)
    {
        $messages = [
            'required' => 'attribute tidak boleh kosong',
        ];

        $validator = Validator::make($request->all(), [
            "unitConversionId" => "required",
            "fromUnit" => "required",
            "toUnit" => "required",
            "ratio" => "required",
        ], $messages);

        if ($validator->fails()) {
            return respons(400,  $validator->errors()->all()[0]);
        }

        $data = unitConversion::where('unitConversionId', $request->unitConversionId)
                ->update([
                    'fromUnit' => $request->fromUnit,
                    'toUnit' => $request->toUnit,
                    'ratio' => $request->ratio
                ]);

        if($data){
            return respons(200,'Data has been updated',$data);
        }else{
            return respons(404,'Data not found',$data);
        }


    }
}
