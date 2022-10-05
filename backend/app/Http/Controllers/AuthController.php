<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Firebase\JWT\JWT;
use http\Env\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login(Request $request) : JsonResponse
    {
        $this->validate($request,[
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = DB::select('select id,password_hash from users where email = ? and is_email_confirmed = true',[$request->input('email')]);
        if(!empty($user) && Hash::check($request->input('password'),$user[0]->password_hash))
        {
            $payload = [
                'ttl' => Carbon::now()->addHour()->getTimestampMs(),
                'id' => $user[0]->id
            ];
            $jwt = JWT::encode($payload,env('JWT_TOKEN',''),'HS256');
            return new JsonResponse(['message' => 'Successfully logged in','jwt' => $jwt]);
        }

        return new JsonResponse(['message' => 'Invalid email or password, or email is not confirmed!'],403);
    }

    public function register(Request $request) : JsonResponse
    {
        $this->validate($request,[
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);
        $confirm_token = Str::random(100);
        if(empty(DB::select("select * from users where email = ?",[$request->input('email')])))
            DB::insert("insert into users (name,email,password_hash,confirm_token) values (?,?,?,?)",[
                $request->input('name'),
                $request->input('email'),
                Hash::make($request->input('password')),
                $confirm_token
            ]);
        else
            return new JsonResponse(['message' => __('The email address is occupied!')],403);
        if(env('APP_DEBUG', true))
            return new JsonResponse(['message' => __('Successfully registered'),'confirm_token' => $confirm_token]);
        else
            return new JsonResponse(['message' => __('Successfully registered')]);
    }

    public function confirm($token): JsonResponse
    {
        $state = DB::update('update users set is_email_confirmed = true where confirm_token = ?',[$token]);

        if($state)
            return new JsonResponse(['message' => __('Successfully confirmed email!')]);
        else
            return new JsonResponse(['message' => __('Could not confirm email!')],404);
    }
}
