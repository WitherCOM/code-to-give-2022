<?php

namespace Tests;

use Laravel\Lumen\Testing\DatabaseMigrations;

class AuthTest extends TestCase
{
    use DatabaseMigrations;

    public function test_register_endpoint()
    {
        $this->json('POST','/api/register',[
            'name' => 'Teszt Elek',
            'email' => 'teszt.elek@teszt.com',
            'password' => 'password'
        ])->seeJsonStructure([
            'message',
        ])->assertResponseOk();
    }

    public function test_login_endpoint()
    {
        $response = $this->json('POST','/api/register',[
            'name' => 'Teszt Elek',
            'email' => 'teszt.elek@teszt.com',
            'password' => 'password'
        ]);
        $token = $response->response->json()['confirm_token'];
        $this->json('GET',"api/confirm/$token")
            ->seeJsonStructure(['message'])->assertResponseOk();
        $this->json('POST','/api/login',[
            'email' => 'teszt.elek@teszt.com',
            'password' => 'password'
        ])->seeJsonStructure([
            'jwt'
        ])->assertResponseOk();

    }
}
