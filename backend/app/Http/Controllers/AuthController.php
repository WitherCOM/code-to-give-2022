<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Firebase\JWT\JWT;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request) : JsonResponse
    {
        $this->validate($request,[
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = DB::select('select id,password_hash from users where email = ?',[$request->input('email')]);
        if(!empty($user) && Hash::check($request->input('password'),$user[0]->password_hash))
        {
            $payload = [
                'ttl' => Carbon::now()->addHour()->getTimestampMs(),
                'id' => $user[0]->id
            ];
            $jwt = JWT::encode($payload,env('JWT_TOKEN',''),'HS256');
            return new JsonResponse(['message' => 'Successfully logged in','jwt' => $jwt]);
        }

        return new JsonResponse(['message' => 'Invalid email or password!'],403);
    }

    public function register(Request $request) : JsonResponse
    {
        $this->validate($request,[
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        if(empty(DB::select("select * from users where email = ?",[$request->input('email')])))
            DB::insert("insert into users (name,email,password_hash) values (?,?,?)",[
                $request->input('name'),
                $request->input('email'),
                Hash::make($request->input('password'))
            ]);
        else
            return new JsonResponse(['message' => __('The email address is occupied!')],403);

        return new JsonResponse(['message' => __('Successfully registered')]);
    }
}
