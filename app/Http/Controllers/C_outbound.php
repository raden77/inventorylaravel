<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\outbound;
use Validator;
use DB;
use Log;

class C_outbound extends Controller
{
    public function index(Request $request)
    {
        CheckMenuRole($request->getRequestUri());

        return view('outbound.outbound');
    }

    public function listDataOutbound()
    {
        $data=outbound::all();

        return response()->json($data);
    }

    public function addDataOutbound(Request $request)
    {
        $messages = [
            'required'  => 'attribute tidak boleh kosong',
            'numeric'   => 'attribute hanya boleh angka',
        ];

        $validator = Validator::make($request->all(), [
            'description' => "required",
        ], $messages);

        if ($validator->fails()) {
            return respons(400,  $validator->errors()->all());
        }

        try {
            DB::beginTransaction();

            //create data inbound
            $data = outbound::create([
                'description' => $request->description,
            ]);


            DB::commit();
            return respons(200,'Data has been saved',$data);

        } catch (\Exception $e) {
            // Tangkap kesalahan jika terjadi dan batalkan transaksi
            Log::error('Database transaction failed: ' . $e->getMessage());
            DB::rollback();
            return respons(400,'DB transaction failed',$e->getMessage());
        }


    }

    public function deleteDataOutbound(Request $request)
    {
        $messages = [
            'required' => 'attribute tidak boleh kosong',
        ];

        $validator = Validator::make($request->all(), [
            "outboundId" => "required",
        ], $messages);

        if ($validator->fails()) {
            return respons(400,  $validator->errors()->all()[0]);
        }

        $data = outbound::find($request->outboundId);

        if($data){
            $data->delete();
            return respons(200,'Data has been deleted',$data);
        }else{
            return respons(404,'Data not found',$data);
        }


    }

    public function updateDataOutbound(Request $request)
    {
        $messages = [
            'required' => 'attribute tidak boleh kosong',
        ];

        $validator = Validator::make($request->all(), [
            'outboundId' => 'required',
            'kodeOutbound' => 'required',
            'description' => 'required',
        ], $messages);

        if ($validator->fails()) {
            return respons(400,  $validator->errors()->all()[0]);
        }

        $data = outbound::where('outboundId', $request->outboundId)
                ->update([
                    'kodeOutbound' => $request->kodeOutbound,
                    'description' => $request->description,
                ]);


        if($data){
            return respons(200,'Data has been updated',$data);
        }else{
            return respons(404,'Data not found',$data);
        }


    }
}
