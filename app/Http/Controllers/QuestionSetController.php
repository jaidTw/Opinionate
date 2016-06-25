<?php

namespace App\Http\Controllers;

use Gate;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Http\Requests;
use Carbon\Carbon;

class QuestionSetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $result = DB::select('SELECT COUNT(id) AS qs_count
            FROM question_sets WHERE topic_id = ?', [$id]
        );
        return response()->json($result[0]);
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, $qsid)
    {
        $question_set = DB::select('SELECT id, name, type, is_multiple_choice, is_anonymous, result_visibility
            FROM question_sets WHERE topic_id = ? AND id = ?', [$id, $qsid]
        )[0];

        $options = DB::select('SELECT id, content
            FROM options WHERE topic_id = ? AND question_set_id = ?', [$id, $qsid]
        );

        $response = Array(
            'question_set' => $question_set,
            'options' => $options
        );

        if(Auth::check()) {
            $user_ballot = DB::select('SELECT option_id
                FROM ballots WHERE topic_id = ? AND question_set_id = ? AND user_id = ?',
            [
                $id,
                $qsid,
                Auth::user()->id
            ]);

            $response['user_ballot'] = $user_ballot;
        }

        $topic = DB::select('SELECT user_id, close_at FROM topics WHERE id = ?', [$id])[0];

        if(Gate::allows('delete-topic', $topic)
           || $question_set->result_visibility === "VISIBLE"
           || ($question_set->result_visibility === "VISIBLE_AFTER_ENDED") && Carbon::now('Asia/Taipei') > Carbon::parse($topic->close_at, 'Asia/Taipei')) {

            $all_ballots = DB::select('SELECT COUNT(*) AS count, option_id
                FROM ballots WHERE topic_id = ? AND question_set_id = ? GROUP BY option_id', [$id, $qsid]
            );

            $response['all_ballots'] = $all_ballots;
        }

        return response()->json($response);
    }
}
