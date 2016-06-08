<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\carbon;

use App\Http\Requests;

class TopicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $topics = DB::select(
            'SELECT id, user_id, name, username, is_unlisted
                FROM topics NATURAL JOIN
                (SELECT id AS user_id, name AS username FROM users) AS users_inf');
        return view('browseTopic', ['topics' => $topics]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->validate($request, ['name' => 'required']);
        return view('createTopic', $request->all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'is_unlisted' => 'boolean|required',
            'is_same_attr' => 'boolean|required',
            'data.*.name' => 'required',
            'data.*.opts.*' => 'required'
        ]);

        DB::transaction(function() use (&$request) {

            // Insert topic
            DB::insert('INSERT INTO topics(user_id, name, description, is_unlisted, is_same_attr, created_at, updated_at)
                        VALUES(?, ?, ?, ?, ?, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)',
            [
                Auth::user()->id, 
                $request['name'], 
                $request['description'], 
                $request['is_unlisted'],
                $request['is_same_attr']
            ]);

            $topic_id = DB::getPdo()->lastInsertId();

            // Insert question sets
            for($qs_id = 1; $qs_id <= count($request['data']); ++$qs_id) {
                $data = $request['data'][$qs_id - 1];

                DB::insert('INSERT INTO question_sets(id, topic_id, name, type, is_multiple_choice, is_synced, is_anonymous, result_visibility, close_at, visualization)
                            VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',
                [
                    $qs_id,
                    $topic_id,
                    $data['name'],
                    strtoupper($data['type']),
                    $data['is_multiple_choice'],
                    $data['is_synced'],
                    $data['is_anonymous'],
                    $data['result_visibility'],
                    $data['close_at'],
                    $data['visualization']
                ]);

                for($opt_id = 1; $opt_id <= count($data['opts']); ++$opt_id) {
                    DB::insert('INSERT INTO options(id, question_set_id, topic_id, content) VALUES(?, ?, ?, ?)',
                        [$opt_id, $qs_id, $topic_id, $data['opts'][$opt_id - 1]]
                    );
                }
            }
        });
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $topic = DB::select('SELECT * FROM topics WHERE id = :id', ['id' => $id]);
        $proposer = DB::select('SELECT name FROM users WHERE id = :id', ['id' => $topic[0]->user_id]);
        $question_sets = DB::select('SELECT id, name, type, is_multiple_choice, is_synced, is_anonymous, result_visibility, close_at, visualization
            FROM question_sets WHERE topic_id = :id', ['id' => $id]);
        $options = Array();

        foreach($question_sets as $qs) {
            $options[] = DB::select('SELECT id, content FROM options WHERE topic_id = :tid AND question_set_id = :qsid', [
                'tid' => $id,
                'qsid' => $qs->id
            ]);
        }
            

        return view('showTopic',
        [
            'topic' => $topic[0],
            'proposer' => $proposer[0],
            'question_sets' => $question_sets,
            'options' => $options,
        ]);
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
