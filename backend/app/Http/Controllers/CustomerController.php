<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    public function create(Request $request) :JsonResponse
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'birthday' => 'required|date',
            'tel' => 'required|tel',
            'other' => 'nullable'
        ]);

        DB::insert('insert into customers (name,email,birthday,tel,other) VALUES (?,?,?,?,?);',[
            $request->input('name'),
            $request->input('email'),
            $request->input('birthday'),
            $request->input('tel'),
            $request->input('other'),
        ]);

        return new JsonResponse(['message' => __('Successfully created customer!')]);
    }

    public function read($id = null): JsonResponse
    {
        if(is_null($id))
        {
            $customers = DB::select('select * from customers;');
            return new JsonResponse(['data' => $customers]);
        }
        $customers = DB::select('select * from customers where id = ?;',[$id]);
        if(!empty($customers))
            return new JsonResponse(['data' => $customers[0]]);

        return new JsonResponse(['message' => 'English test not found!'],404);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'birthday' => 'required|date',
            'tel' => 'required|tel',
            'other' => 'nullable'
        ]);

        $state = DB::update('update customers set name=?,email=?,birthday=?,tel=?,other=? where id = ?;',[
            $request->input('name'),
            $request->input('email'),
            $request->input('birthday'),
            $request->input('tel'),
            $request->input('other'),
            $id
        ]);

        if($state)
            return new JsonResponse(['message' => __('Successfully updated customer!')]);

        return new JsonResponse(['message' => __('Could not update customer!')],404);

    }

    public function delete(Request $request, $id) : JsonResponse
    {
        $state = DB::delete('DELETE FROM customers WHERE id = ?',[$id]);

        if($state)
            return new JsonResponse(['message' => __('Successfully deleted customer!')]);

        return new JsonResponse(['message' => __('Could not delete customer!')],404);
    }
}
