<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\userMenu;
use App\Models\User;
use App\Models\subMenu;
use Validator;

class C_usermenu extends Controller
{
    public function index(Request $request)
    {
        CheckMenuRole($request->getRequestUri());

        $d['subMenu']=subMenu::pluck('subMenuName','subMenusId')->all();
        $d['user']=User::pluck('name','id')->all();
        return view('usermenu.usermenu',$d);
    }

    public function listDataUserMenu()
    {
        $list=userMenu::with('User:id,name','subMenu:subMenusId,subMenuName')
                        ->get();

        return response()->json($list);
    }

    public function addDataUserMenu(Request $request)
    {
        $messages = [
            'required' => 'attribute tidak boleh kosong',
        ];

        $validator = Validator::make($request->all(), [
            "id" => "required",
            "subMenuId" => "required",
        ], $messages);

        if ($validator->fails()) {
            return respons(400,  $validator->errors()->all()[0]);
        }

        $data = userMenu::create([
            'id' => $request->id,
            'subMenusId' => $request->subMenuId,
        ]);

        return respons(200,'Data has been saved',$data);
    }

    public function deleteDataUserMenu(Request $request)
    {
        $messages = [
            'required' => 'attribute tidak boleh kosong',
        ];

        $validator = Validator::make($request->all(), [
            "userMenuId" => "required",

        ], $messages);

        if ($validator->fails()) {
            return respons(400,  $validator->errors()->all()[0]);
        }

        $data = userMenu::find($request->userMenuId);

        if($data){
            $data->delete();
            return respons(200,'Data has been deleted',$data);
        }else{
            return respons(404,'Data not found',$data);
        }


    }

    public function updateDataUserMenu(Request $request)
    {
        $messages = [
            'required' => 'attribute tidak boleh kosong',
        ];

        $validator = Validator::make($request->all(), [
            "userMenuId" => "required",
            "id" => "required",
            "subMenusId " => "required",
        ], $messages);

        if ($validator->fails()) {
            return respons(400,  $validator->errors()->all()[0]);
        }

        $data = userMenu::where('userMenuId', $request->userMenuId)
                ->update([
                    'id' => $request->id,
                    'subMenusId' => $request->subMenusId,
                ]);

        if($data){
            return respons(200,'Data has been updated',$data);
        }else{
            return respons(404,'Data not found',$data);
        }


    }
}
