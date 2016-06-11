<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Http\Requests;

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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, $qsid)
    {
        $question_sets = DB::select('SELECT id, name, type, is_multiple_choice, is_synced, is_anonymous, result_visibility
            FROM question_sets WHERE topic_id = ? AND id = ?', [$id, $qsid]
        );

        $options = DB::select('SELECT id, content
            FROM options WHERE topic_id = ? AND question_set_id = ?', [$id, $qsid]
        );

        $response = Array(
            'question_set' => $question_sets[0],
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

        $all_ballots = DB::select('SELECT COUNT(*) AS count
            FROM ballots WHERE topic_id = ? AND question_set_id = ? GROUP BY option_id', [$id, $qsid]
        );

        $response['all_ballots'] = $all_ballots;
        return response()->json($response);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
