<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    function show(Request $request){
        $product = new Product;

        if($request->product_name){
            $product = $product->where('product_name','LIKE','%'.$request->product_name.'%');
        }

        $product = $product->paginate(20);
        return response()->json($product);


    }
    function add(Request $request){
        $val = $request->validate([
            'product_name'=>'required',
            'price'=>'required',
            'stock'=> 'required'
        ]);

        $product = Product::create($val);

        $data = [
            'message' => 'success create product',
            'product'=>$product
        ];
        return response()->json($data);
    }

    function edit(Request $request,$id_product){
        $product = Product::find($id_product);

        if(!$product){
            return response()->json([
                'message'=>'product not found'
            ]); 
        }

        $product->fill($request->all());
        $product->save();
        $data = [
            'message' => 'success edit product',
            'product'=>$product
        ];
        return response()->json($data); 
    }

    function delete($id_product){
        $product = Product::find($id_product);
        if(!$product){
            return response()->json([
                'message'=>'product not found'
            ]); 
        }

        $product->delete();
        #$product->save();
        return response()->json([
            'message'=>'success delete product'
        ]); 
    }
}
