<?php

use App\Models\userMenu;

if (!function_exists('respons')) {
    function respons($code, $message, $data = [])
    {
        return response()->json([
            "message"   => $message,
            "status"    => $code,
            "data"  => $data,
        ],$code);
    }
}

if (!function_exists('CheckMenuRole')) {
    function CheckMenuRole($url)
    {
        // dd($url);
        $userdata= session('userdata');

        $pageRole= userMenu::with('User:id,name','subMenu:subMenusId,subMenuUrl')
                    ->where('id',$userdata['id'])->get();

        $filteredMenu = collect($pageRole)->map(function ($value) use($url) {
            if($url=='/'.$value->subMenu->subMenuUrl){
                return $value;
            }else{
                return false;
            }
        })->filter();

        if(count($filteredMenu)>0){
            return true;
        }else{
            abort(403, 'Unauthorized action.');
        }
    }
}






