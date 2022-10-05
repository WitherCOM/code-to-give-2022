<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class EnglishTestController extends Controller
{
    public function create(Request $request) : JsonResponse
    {
        $this->validate($request,[
            "name" => "required",
            "level" => "required|enum:ELEMENTARY,INTERMEDIATE,UPPER-INTERMEDIATE",
            "limit" => 'required|number|min:1',
            "text_to_read" => "required",
            "essay_title" => "required",
            "questions" => "required|array|size:10",
            "questions.*" => "required|array",
            "questions.*.question" => "required",
            "questions.*.answer_1" => "required",
            "questions.*.answer_2" => "required",
            "questions.*.answer_3" => "required",
        ]);

        DB::insert("INSERT INTO english_tests (name,level,limit,text_to_read,essay_title,questions,created_at,updated_at)
                            VALUES (?,?,?,?,?,?,:now,:now);",
            [
               $request->input('name'),$request->input('level'),$request->input('limit'),
                $request->input('text_to_read'),
                $request->input('essay_title'),$request->input('questions'),'now' => Carbon::now()
        ]);

        return new JsonResponse(['message' => __('Successfully created english test!')]);
    }

    public function read($id = null) : JsonResponse
    {
        if(is_null($id))
        {
            $tests = DB::select('select * from english_tests;');
            return new JsonResponse(['data' => $tests]);
        }
        $tests = DB::select('select * from english_tests where id = ?;',[$id]);
        if(!empty($tests))
            return new JsonResponse(['data' => $tests[0]]);

        return new JsonResponse(['message' => 'English test not found!'],404);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request,[
            "name" => "required",
            "level" => "required|enum:ELEMENTARY,INTERMEDIATE,UPPER-INTERMEDIATE",
            "limit" => 'required|number|min:1',
            "text_to_read" => "required",
            "essay_title" => "required",
            "questions" => "required|array|size:10",
            "questions.*" => "required|array",
            "questions.*.question" => "required",
            "questions.*.answer_1" => "required",
            "questions.*.answer_2" => "required",
            "questions.*.answer_3" => "required",
        ]);

        $state = DB::update('UPDATE english_tests SET name = ?,level=?,text_to_read = ?,essay_title=?,questions=?,updated_at=? WHERE id = ?;',[
            $request->input('name'),$request->input('level'),$request->input('limit'),
            $request->input('text_to_read'),
            $request->input('essay_title'),$request->input('questions'),Carbon::now(),$id
        ]);
        if($state)
            return new JsonResponse(['message' => __('Successfully updated english test!')]);

        return new JsonResponse(['message' => __('Could not update test!')],404);

    }

    public function delete(Request $request, $id) : JsonResponse
    {
        $state = DB::delete('DELETE FROM english_tests WHERE id = ?;',[$id]);

        if($state)
            return new JsonResponse(['message' => __('Successfully deleted english test')]);

        return new JsonResponse(['message' => __('Could not delete english test')],404);
    }
}
