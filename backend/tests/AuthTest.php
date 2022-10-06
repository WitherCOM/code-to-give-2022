<?php

namespace Tests;

use Laravel\Lumen\Testing\DatabaseMigrations;
use Tests\Traits\AuthTrait;

class AuthTest extends TestCase
{
    use DatabaseMigrations,AuthTrait;

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
        $this->auth();
        $this->json('POST','/api/login',[
            'email' => 'teszt@teszt.hu',
            'password' => 'password'
        ])->seeJsonStructure([
            'jwt'
        ])->assertResponseOk();

    }
}
