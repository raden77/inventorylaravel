<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\menus;
use Validator;

class C_menu extends Controller
{
    public function index(Request $request)
    {
        CheckMenuRole($request->getRequestUri());

        return view('menu.menudata');
    }

    public function listDataMenu()
    {
        $list=menus::all();

        return response()->json($list);
    }

    public function addDataMenu(Request $request)
    {
        $messages = [
            'required' => 'attribute tidak boleh kosong',
        ];

        $validator = Validator::make($request->all(), [
            "menuName" => "required",
            "menuIcon" => "required",

        ], $messages);

        if ($validator->fails()) {
            return respons(400,  $validator->errors()->all()[0]);
        }

        $data = menus::create([
            'menuName' => $request->menuName,
            'menuIcon' => $request->menuIcon,
        ]);

        return respons(200,'Data has been saved',$data);
    }

    public function deleteDataMenu(Request $request)
    {
        $messages = [
            'required' => 'attribute tidak boleh kosong',
        ];

        $validator = Validator::make($request->all(), [
            "menuId" => "required",

        ], $messages);

        if ($validator->fails()) {
            return respons(400,  $validator->errors()->all()[0]);
        }

        $data = menus::find($request->menuId);

        if($data){
            $data->delete();
            return respons(200,'Data has been deleted',$data);
        }else{
            return respons(404,'Data not found',$data);
        }


    }

    public function updateDataMenu(Request $request)
    {
        $messages = [
            'required' => 'attribute tidak boleh kosong',
        ];

        $validator = Validator::make($request->all(), [
            "menuId"    => "required",
            "menuName"  => "required",
            "menuIcon"  => "required",
        ], $messages);

        if ($validator->fails()) {
            return respons(400,  $validator->errors()->all()[0]);
        }

        $data = menus::where('menuId', $request->menuId)
                ->update([
                        'menuName' => $request->menuName,
                        'menuIcon' => $request->menuIcon
                ]);

        if($data){
            return respons(200,'Data has been updated',$data);
        }else{
            return respons(404,'Data not found',$data);
        }


    }
}
