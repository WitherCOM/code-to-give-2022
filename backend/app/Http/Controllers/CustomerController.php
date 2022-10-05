<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    public function create(Request $request) :JsonResponse
    {
        $validated = $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'birthday' => 'required|date',
            'tel' => 'required|tel',
            'other' => 'nullable'
        ]);

        $id = DB::table('customers')->insertGetId($validated);

        return new JsonResponse(['message' => __('Successfully created customer!'),'customer_id' => $id]);
    }

    public function read($id = null): JsonResponse
    {
        if(is_null($id))
        {
            $customers = DB::select('select customer.*,links.test_id,links.test_type,links.stated_at,links.finished_at from customers
                                            inner join links on links.customer_id = customer.id;');
            return new JsonResponse(['data' => $customers]);
        }
        $customers = DB::select('select customer.*,links.test_id,links.test_type,links.stated_at,links.finished_at from customers
                                            inner join links on links.customer_id = customer.id
                                            where customers.id = ?;',[$id]);
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
