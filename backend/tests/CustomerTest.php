<?php

namespace Tests;

use Illuminate\Auth\GenericUser;
use Illuminate\Support\Facades\DB;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Tests\Traits\AuthTrait;

class CustomerTest extends TestCase
{
    use DatabaseMigrations,AuthTrait;

    public function test_customer_create()
    {
        $this->auth();

        $this->json('POST','/api/customer',[
            'name' => 'Customer János',
            'email' => 'customer.janos@gmail.com',
            'birthday' => '2022-10-28',
            'tel' => '+36 22 666 9999'
        ],['Authorization' => 'Bearer '.$this->jwt])->assertResponseOk();


    }

    public function test_customer_read()
    {
        $this->auth();
        $id = DB::table('customers')->insertGetId([
            'name' => 'Customer János',
            'email' => 'customer.janos@gmail.com',
            'birthday' => '2022-10-28',
            'tel' => '+36 22 666 9999'
        ]);
        $this->json('GET',"/api/customer/$id",[
            'name' => 'Customer János',
            'email' => 'customer.janos@gmail.com',
            'birthday' => '2022-10-28',
            'tel' => '+36 22 666 9999'
        ],['Authorization' => 'Bearer '.$this->jwt])->assertResponseOk();

        $this->json('GET',"/api/customer",[
            'name' => 'Customer János',
            'email' => 'customer.janos@gmail.com',
            'birthday' => '2022-10-28',
            'tel' => '+36 22 666 9999'
        ],['Authorization' => 'Bearer '.$this->jwt])->assertResponseOk();
    }

    public function test_customer_update()
    {
        $this->auth();
        $id = DB::table('customers')->insertGetId([
            'name' => 'Customer János',
            'email' => 'customer.janos@gmail.com',
            'birthday' => '2022-10-28',
            'tel' => '+36 22 666 9999'
        ]);
        $res =$this->json('PATCH',"/api/customer/$id",[
            'name' => 'Customer János',
            'email' => 'customer.janos@gmail.com',
            'birthday' => '2022-10-23',
            'tel' => '+36 22 666 9999'
        ],['Authorization' => 'Bearer '.$this->jwt])->assertResponseOk();
    }
}
