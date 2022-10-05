<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Js;

class EnglishFillController extends Controller
{
    public function create(Request $request,$link): JsonResponse
    {
        $this->validate($request,[
            'answers' => 'required|array|size:10',
            'answers.*' => 'required|number|min:1|max:3',
            'essay' => 'required|max:2000'
        ]);

        $link = DB::select("select links.* from links
                                  inner join english_tests on english_tests.id = links.test_id and links.test_type = 'english_tests'
              where id = ?",[$link]);
        if(empty($link) || $link[0]->test_type !== 'english_test')
            return new JsonResponse(['message' => __('Invalid link!')],404);

        if(Carbon::parse($link[0]->stated_at)->addHour()->greaterThan(Carbon::now()))
            return new JsonResponse(['message' => __('Time expired!')],403);

        DB::update('update links set finished_at = ?',[Carbon::now()]);
        $state = DB::insert('insert into english_test (link_id,answers,essay) VALUES (?,?,?,?)',[
            $link[0]->id,$request->input('answers'),$request->input('essay')
        ]);


        if(!$state)
            return new JsonResponse(['message' => __('Could not save!')],404);

        return new JsonResponse(['message' => __('Successfully saved english test!')]);
    }

    public function read($id): JsonResponse
    {
        $answer = DB::select("select english_anwers.*,links.customer_id,links.test_id from english_answers
                                    inner join links where link_id = links.id and links.test_type = 'english_type'
                                    where id = ?;",[$id]);
        if(empty($answer))
            return new JsonResponse(['message' => __('No answer found!')],404);
        return new JsonResponse(['data' => $answer]);
    }
}
