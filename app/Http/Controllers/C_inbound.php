<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\inbound;
use App\Models\inboundetail;
use App\Models\purchase;
use App\Models\purchaseDetail;
use Validator;
use DB;
use Log;

class C_inbound extends Controller
{
    public function index(Request $request)
    {
        CheckMenuRole($request->getRequestUri());

        $d['purchase']=purchase::pluck('kodePurchase','purchaseId')->all();

        return view('inbound.inbound',$d);
    }

    public function listDataInbound()
    {
        $data=inbound::with('purchase:purchaseId,kodePurchase')->get();

        return response()->json($data);
    }

    public function addDataInbound(Request $request)
    {
        $messages = [
            'required'  => 'attribute tidak boleh kosong',
            'numeric'   => 'attribute hanya boleh angka',
        ];

        $validator = Validator::make($request->all(), [
            'purchaseId'       => "required",
            'description'         => "required",
        ], $messages);

        if ($validator->fails()) {
            return respons(400,  $validator->errors()->all());
        }

        try {
            DB::beginTransaction();

            //create data inbound
            $data = inbound::create([
                'purchaseId' => $request->purchaseId,
                'description' => $request->description,
            ]);

            $datapurchase=purchaseDetail::where('purchaseId',$request->purchaseId)->get();

            $batchInsertData = [];

            // dd($data->inboundId);
            foreach ($datapurchase as $key => $value) {
                $batchInsertData[] = [
                    'inboundId'  => $data->inboundId,
                    'productId'  => $value->productId,
                    'unitId'     => $value->unitId,
                    'prices'     => $value->prices,
                    'qty'        => $value->qty,
                ];
            }

            $inserdetail = inboundetail::insert($batchInsertData);

            DB::commit();
            return respons(200,'Data has been saved',$data);

        } catch (\Exception $e) {
            // Tangkap kesalahan jika terjadi dan batalkan transaksi
            Log::error('Database transaction failed: ' . $e->getMessage());
            DB::rollback();
            return respons(400,'DB transaction failed',$e->getMessage());
        }


    }

    public function deleteDataInbound(Request $request)
    {
        $messages = [
            'required' => 'attribute tidak boleh kosong',
        ];

        $validator = Validator::make($request->all(), [
            "inboundId" => "required",
        ], $messages);

        if ($validator->fails()) {
            return respons(400,  $validator->errors()->all()[0]);
        }

        $data = inbound::find($request->inboundId);

        if($data){
            $data->delete();
            return respons(200,'Data has been deleted',$data);
        }else{
            return respons(404,'Data not found',$data);
        }


    }

    public function updateDataInbound(Request $request)
    {
        $messages = [
            'required' => 'attribute tidak boleh kosong',
        ];

        $validator = Validator::make($request->all(), [
            'inboundId' => 'required',
            'kodeInbound' => 'required',
            'purchaseId' => 'required',
            'description' => 'required',
        ], $messages);

        if ($validator->fails()) {
            return respons(400,  $validator->errors()->all()[0]);
        }

        $data = inbound::where('inboundId', $request->inboundId)
                ->update([
                    'kodeInbound' => $request->kodeInbound,
                    'purchaseId' => $request->purchaseId,
                    'description' => $request->description,
                ]);


        if($data){
            return respons(200,'Data has been updated',$data);
        }else{
            return respons(404,'Data not found',$data);
        }


    }
}
