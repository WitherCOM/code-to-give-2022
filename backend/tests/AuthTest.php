<?php

namespace Tests;

use Laravel\Lumen\Testing\DatabaseMigrations;

class AuthTest extends TestCase
{
    use DatabaseMigrations;

    public function test_register_endpoint()
    {
        $this->json('POST','/register',[
            'name' => 'Teszt Elek',
            'email' => 'teszt.elek@teszt.com',
            'password' => 'password'
        ])->seeJson([
            'message' => true,
            'jwt' => true
        ]);

    }
}
