<?php

namespace App\Providers;

use Carbon\Carbon;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Auth\GenericUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {
        // Here you may define how you wish users to be authenticated for your Lumen
        // application. The callback which receives the incoming request instance
        // should return either a User instance or null. You're free to obtain
        // the User instance via an API token or any other method necessary.

        $this->app['auth']->viaRequest('api', function (Request $request) {
            $auth = $request->header('Authorization');
            if(!is_null($auth))
            {
                $jwt = explode(" ",$auth);
                if($jwt[0] === 'Bearer')
                {
                    $payload = JWT::decode($jwt[1],new Key(env('JWT_TOKEN',''),'HS256'));
                    if(Carbon::createFromTimestampMs($payload->ttl)->greaterThan(Carbon::now()))
                    {
                        $user = DB::select("select * from users where id = ?",[$payload->id]);
                        if(!empty($user))
                        {
                            return new GenericUser(array($user[0]));
                        }
                    }
                }
            }
            return null;
        });
    }
}
