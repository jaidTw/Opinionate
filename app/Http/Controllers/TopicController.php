<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
            'close_at' => 'required',
            'data.*.name' => 'required',
            'data.*.opts.*' => 'required',
            'data.*.type' => 'required',
            'data.*.is_multiple_choice' => 'boolean | required',
            'data.*.is_synced' => 'boolean | required',
            'data.*.is_anonymous' => 'boolean | required',
            'data.*.result_visibility' => 'required',
        ]);

        $topic_id = 0;

        DB::transaction(function() use (&$request, &$topic_id) {

            // Insert topic
            DB::insert('INSERT INTO topics(user_id, name, description, is_unlisted, close_at, created_at, updated_at)
                        VALUES(?, ?, ?, ?, ?, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)',
            [
                Auth::user()->id, 
                $request['name'], 
                $request['description'], 
                $request['is_unlisted'],
                $request['close_at']
            ]);

            $topic_id = DB::getPdo()->lastInsertId();

            // Insert question sets
            for($qs_id = 1; $qs_id <= count($request['data']); ++$qs_id) {
                $data = $request['data'][$qs_id - 1];

                DB::insert('INSERT INTO question_sets(id, topic_id, name, type, is_multiple_choice, is_synced, is_anonymous, result_visibility)
                            VALUES(?, ?, ?, ?, ?, ?, ?, ?)',
                [
                    $qs_id,
                    $topic_id,
                    $data['name'],
                    strtoupper($data['type']),
                    $data['is_multiple_choice'],
                    $data['is_synced'],
                    $data['is_anonymous'],
                    strtoupper($data['result_visibility']),
                ]);

                // Insert options
                for($opt_id = 1; $opt_id <= count($data['opts']); ++$opt_id) {
                    DB::insert('INSERT INTO options(id, question_set_id, topic_id, content) VALUES(?, ?, ?, ?)',
                        [$opt_id, $qs_id, $topic_id, $data['opts'][$opt_id - 1]]
                    );
                }
            }
        });
        return $topic_id;
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
        $question_sets = DB::select('SELECT id, name, type, is_multiple_choice, is_synced, is_anonymous, result_visibility
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
