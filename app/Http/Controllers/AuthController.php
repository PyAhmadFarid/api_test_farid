<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    function login(Request $request)
    {

        $user = User::where("email", $request->email)->first();
        if (!$user) {
            return response()->json([
                'message' => 'email not found',
                'err' => 'email',
            ], 401);
        }

        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'wrong password',
                'err' => 'password'
            ], 401);
        }

        $token = $user->createToken('token-name')->plainTextToken;
        return response()->json([
            'message' => 'success',
            'user' => $user,
            'token' => $token
        ]);
    }

    function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'logout success'
        ]);
    }

    function register(Request $request){
        $val = $request->validate([
            'user_name' =>'required|unique:users,user_name',
            'email'=>'required|unique:users,email',
            'password'=>'required|confirmed',
            'full_name'=>'required',
            'gender'=>'required|in:M,F',
            'address'=>'required',
            'birth_date'=>'required|date_format:Y-m-d'
        ]);


        $user = User::create([
            'user_name'=>$val['user_name'],
            'email'=>$val['email'],
            'password'=> Hash::make($val['password']),
            'role'=>'customer'
        ]);


        $Customer = Customer::create([
            'id_user'=> $user->id,
            'full_name'=>$val['full_name'],
            'gender'=>$val['gender'],
            'address'=>$val['address'],
            'birth_date'=>$val['birth_date']
        ]);

        $token = $user->createToken('token-name')->plainTextToken;

        $data = [
            'message'=>'success',
            'user'=>[
                'user_name'=>$user->user_name,
                'email'=>$user->email,
            ],
            'customer'=>$Customer,
            'token'=>$token
        ];
        

        return response()->json($data);


    }

    function profile(){

        $user = Auth::user();
        $user->Customer;
        $data = [
            'message'=>'success',
            'user'=>$user,
        ];
        return response()->json([$data]);
    }
}
