<?php

namespace Tests\Traits;

use Carbon\Carbon;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

trait AuthTrait {
    private string $jwt;

    public function auth()
    {
        $id = DB::table('users')->insertGetId([
            'name' => 'Teszt Elek',
            'email' => 'teszt@teszt.hu',
            'password_hash' => Hash::make('password'),
            'confirm_token' => Str::random(100),
            'is_email_confirmed' => true
        ]);

        $payload = [
            'ttl' => Carbon::now()->addHour()->getTimestampMs(),
            'id' => $id
        ];
        $this->jwt = JWT::encode($payload,env('JWT_TOKEN',''),'HS256');
    }
}
