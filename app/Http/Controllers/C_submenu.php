<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\subMenu;
use App\Models\menus;
use Validator;

class C_submenu extends Controller
{
    public function index(Request $request)
    {
        CheckMenuRole($request->getRequestUri());

        $d['menu']=menus::pluck('menuName','menuId')->all();
        return view('menu.submenu',$d);
    }

    public function listDataSubMenu()
    {
        $list=subMenu::with('menus:menuId,menuName')
                    ->get();

        return response()->json($list);
    }

    public function addDataSubMenu(Request $request)
    {
        $messages = [
            'required' => 'attribute tidak boleh kosong',
        ];

        $validator = Validator::make($request->all(), [
            "subMenuName"   => "required",
            "subMenuIcon"   => "required",
            "subMenuUrl"   => "required",
            "menuId"        => "required",

        ], $messages);

        if ($validator->fails()) {
            return respons(400,  $validator->errors()->all()[0]);
        }

        $data = subMenu::create([
            'subMenuName' => $request->subMenuName,
            'subMenuIcon' => $request->subMenuIcon,
            'subMenuUrl' => $request->subMenuUrl,
            'menuId' => $request->menuId,
        ]);

        return respons(200,'Data has been saved',$data);
    }

    public function deleteDataSubMenu(Request $request)
    {
        $messages = [
            'required' => 'attribute tidak boleh kosong',
        ];

        $validator = Validator::make($request->all(), [
            "subMenusId" => "required",

        ], $messages);

        if ($validator->fails()) {
            return respons(400,  $validator->errors()->all()[0]);
        }

        $data = subMenu::find($request->subMenusId);

        if($data){
            $data->delete();
            return respons(200,'Data has been deleted',$data);
        }else{
            return respons(404,'Data not found',$data);
        }


    }

    public function updateDataSubMenu(Request $request)
    {
        $messages = [
            'required' => 'attribute tidak boleh kosong',
        ];

        $validator = Validator::make($request->all(), [
            "menuId"    => "required",
            "subMenuName"  => "required",
            "subMenuIcon"  => "required",
            "subMenuUrl"  => "required",
            "subMenusId"  => "required",
        ], $messages);

        if ($validator->fails()) {
            return respons(400,  $validator->errors()->all()[0]);
        }

        $data = subMenu::where('subMenusId', $request->subMenusId)
                ->update([
                        'subMenuName' => $request->subMenuName,
                        'subMenuIcon' => $request->subMenuIcon,
                        'subMenuUrl' => $request->subMenuUrl,
                        'menuId' => $request->menuId
                ]);

        if($data){
            return respons(200,'Data has been updated',$data);
        }else{
            return respons(404,'Data not found',$data);
        }


    }
}
