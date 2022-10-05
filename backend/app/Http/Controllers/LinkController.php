<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LinkController extends Controller
{
    public function create(Request $request) : JsonResponse
    {
        $validated = $this->validate($request, [
            'customer_id' => 'required|exists:customers,id',
            'english_test_id' => 'required|exists:english_tests,id'
        ]);

        $id = DB::table('links')->insertGetId([
            'customer_id' => $validated['customer_id'],
            'test_id' => $validated['english_test_id'],
            'test_type' => 'english_test']);

        return new JsonResponse(['message' => __('Successfully generated link!'),'link_id' => $id]);

    }

    public function read($id) :JsonResponse
    {
        $link = DB::select("select links.*,customers.name,coalesce(english_tests.name) as test_name from links
                          inner join customers on links.customer_id = customer.id
                          left join english_tests on english_tests.id = links.test_id and links.test_type = 'english_test'
                          where links.id = ?;",[$id]);
        if(empty($link))
            return new JsonResponse(['message' => __('No link found!')],404);

        return new JsonResponse(['data' => $link[0]]);
    }

    public function delete($id) : JsonResponse
    {
        $state = DB::delete('delete from links where id = ?;',[$id]);

        if($state)
            return new JsonResponse(['message' => __('Successfully deleted link!')]);

        return new JsonResponse(['message' => __('Could not delete link!')],404);
    }
}
