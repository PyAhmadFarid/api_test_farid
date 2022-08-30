<?php

namespace App\Http\Controllers;

use App\Models\ProductOrder;
use Illuminate\Http\Request;

class OrderProductController extends Controller
{
    function add_order(Request $request){
        $val = $request->validate([
            'id_product'=>'required|exists:products,id',
            'amount'=>'required|numeric|min:1'
        ]);

        $val['id_customer'] = auth()->user()->customer->id;
        $val['order_date'] = date("Y-m-d");

        $order = ProductOrder::create($val);

        return response()->json([
            'message'=>'success order product',
            'order'=>$order
        ]);


    }

    function show_order(Request $request){
        $order = ProductOrder::where('id_customer','=',auth()->user()->Customer->id)->get();

        return response()->json([
            'message'=>'success show product order',
            'data'=>$order
        ]);
    }

}
