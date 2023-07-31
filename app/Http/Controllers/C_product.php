<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\product;
use App\Models\productCategori;
use App\Models\productPrice;
use App\Models\unit;
use Validator;
use DB;

class C_product extends Controller
{
    //

    public function index(Request $request)
    {
        CheckMenuRole($request->getRequestUri());

        $d['categori']=productCategori::pluck('categori','productCategoriId')->all();
        $d['unit']=unit::pluck('unitName','unitId')->all();

        return view('product.product',$d);
    }

    public function listDataProduct()
    {
        $data=product::with('unit:unitId,unitName',
                            'categori:productCategoriId,categori',
                            'productPrice:productPriceId,price')
                ->get();

        return response()->json($data);
    }

    public function addDataProduct(Request $request)
    {
        $messages = [
            'required'  => 'attribute tidak boleh kosong',
            'numeric'   => 'attribute hanya boleh angka',
        ];

        $validator = Validator::make($request->all(), [
            'productName'       => "required",
            'dimension'         => "required",
            'qty'               => "required|numeric",
            'productCategoriId' => "required",
            'unitId'            => "required",
            'price'             => "required|numeric"
        ], $messages);

        if ($validator->fails()) {
            return respons(400,  $validator->errors()->all());
        }

        try {
            //Update data product
            $data = product::create([
                'productName' => $request->productName,
                'dimensions' => $request->dimension,
                'qty' => $request->qty,
                'productCategoriId' => $request->productCategoriId,
                'unitId' => $request->unitId,
            ]);

            //Update data price
            $price = productPrice::create([
                'productId' => $data->productId,
                'price' => $request->price,
            ]);

            //Update kolom producPriceId
            $updateProductPrice = product::where('productId', $data->productId)
                    ->update([
                        'productPriceId' => $price->productPriceId,
                    ]);

            return respons(200,'Data has been saved',$data);

            // Operasi lainnya...
        } catch (\Exception $e) {
            // Tangkap kesalahan jika terjadi dan batalkan transaksi
            DB::rollback();
            return respons(400,'DB Transaksi failed',$e);
        }


    }

    public function deleteDataProduct(Request $request)
    {
        $messages = [
            'required' => 'attribute tidak boleh kosong',
        ];

        $validator = Validator::make($request->all(), [
            "productId" => "required",
        ], $messages);

        if ($validator->fails()) {
            return respons(400,  $validator->errors()->all()[0]);
        }

        $data = product::find($request->productId);

        if($data){
            $data->delete();
            return respons(200,'Data has been deleted',$data);
        }else{
            return respons(404,'Data not found',$data);
        }


    }

    public function updateDataProduct(Request $request)
    {
        $messages = [
            'required' => 'attribute tidak boleh kosong',
        ];

        $validator = Validator::make($request->all(), [
            'productId'         => "required",
            'productPriceId'    => "required",
            'productName'       => "required",
            'dimension'         => "required",
            'qty'               => "required|numeric",
            'productCategoriId' => "required",
            'unitId'            => "required",
            'price'             => "required|numeric"
        ], $messages);

        if ($validator->fails()) {
            return respons(400,  $validator->errors()->all()[0]);
        }

        $data = product::where('productId', $request->productId)
                ->update([
                    'productName' => $request->productName,
                    'dimensions' => $request->dimension,
                    'qty' => $request->qty,
                    'productCategoriId' => $request->productCategoriId,
                    'unitId' => $request->unitId
                ]);

        //Update kolom producPriceId
        $updateProductPrice = productPrice::where('productId', $request->productId)
                                ->where('productPriceId', $request->productPriceId)
                                ->update([
                                    'price' => $request->price,
                                ]);

        if($data){
            return respons(200,'Data has been updated',$data);
        }else{
            return respons(404,'Data not found',$data);
        }


    }
}
