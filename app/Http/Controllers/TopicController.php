<?php

namespace App\Http\Controllers;

use Gate;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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
        //TODO : close_at validation
        $this->validate($request, [
            'name' => 'required | string | max:255',
            'description' => 'required | string',
            'is_unlisted' => 'required | boolean',
            'close_at' => 'required',
            'data.*.name' => 'required | string | max:255',
            'data.*.opts.*' => 'required | string | max:255',
            'data.*.type' => 'required | in:GENERAL,LOCATION,TIME,IMAGE,AUDIO,VIDEO',
            'data.*.is_multiple_choice' => 'required | boolean',
            'data.*.is_anonymous' => 'required | boolean',
            'data.*.result_visibility' => 'required | in:VISIBLE,INVISIBLE,VISIBLE_AFTER_ENDED',
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

                DB::insert('INSERT INTO question_sets(id, topic_id, name, type, is_multiple_choice, is_anonymous, result_visibility)
                            VALUES(?, ?, ?, ?, ?, ?, ?)',
                [
                    $qs_id,
                    $topic_id,
                    $data['name'],
                    $data['type'],
                    $data['is_multiple_choice'],
                    $data['is_anonymous'],
                    $data['result_visibility']
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
        $topic = DB::select('SELECT * FROM topics WHERE id = ?', [$id]);
        $proposer = DB::select('SELECT name FROM users WHERE id = ?', [$topic[0]->user_id]);
        $question_sets = DB::select('SELECT id, name, type, is_multiple_choice, is_anonymous, result_visibility
            FROM question_sets WHERE topic_id = ?', [$id]);

        $options = Array();

        // here could be optimize
        foreach($question_sets as $qs) {
            $options[] = DB::select('SELECT id, content FROM options
                WHERE topic_id = ? AND question_set_id = ?', [$id, $qs->id]);
        }

        return view('showTopic',
        [
            'topic' => $topic[0],
            'proposer' => $proposer[0],
            'question_sets' => $question_sets,
            'options' => $options
        ]);
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
        // TODO : after end edit constraint
        // TODO : add close_at validation
        $this->validate($request, [
            'type' => 'required | in:name,des,attr,qs',
            'data' => 'sometimes | required_if:type,name | string | max:255',
            'data' => 'sometimes | required_if:type,des | string',
            'is_unlisted' => 'sometimes | required_if:type,attr | boolean',
            'close_at' => 'sometimes | required_if:type,attr',
            'del' => 'sometimes | required_if:type,qs | required_without:alter',
            'del.*' => 'sometimes | required_if:type,qs | required_with:del | exists:question_sets,id,topic_id,' . $id,
            'alter' => 'sometimes | required_if:type,qs | required_without:del',
            'alter.*.id' => 'sometimes | required_if:type,qs | required_without:del | exists:question_sets,id,topic_id,' . $id,
            'alter.*.result_visibility' => 'sometimes | required_if:type,qs | required | in:VISIBLE,INVISIBLE,VISIBLE_AFTER_ENDED',
            'alter.*.opts.*' => 'sometimes | required_if:type,qs | required | string | max:255',
            'new' => 'sometimes | required_if:type,qs | required',
            'new.*.name' => 'sometimes | required_if:type,qs | required | string | max:255',
            'new.*.type' => 'sometimes | required_if:type,qs | required | in:GENERAL,LOCATION,TIME,IMAGE,AUDIO,VIDEO',
            'new.*.is_multiple_choice' => 'sometimes | required_if:type,qs | required | boolean',
            'new.*.is_anonymous' => 'sometimes | required_if:type,qs | required | boolean',
            'new.*.result_visibility' => 'sometimes | required_if:type,qs | required | in:VISIBLE,INVISIBLE,VISIBLE_AFTER_ENDED',
            'new.*.opts.*' => 'sometimes | required_if:type,qs | required | string | max:255',
        ]);
        
        $topic = DB::select('SELECT * FROM topics WHERE id = ?', [$id]);

        if(Gate::denies('update-topic', $topic[0])) {
            return redirect('/topics');
        }
        
        if($request['type'] === 'name') {
            DB::update('UPDATE topics SET name = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?', [$request['data'], $id]);
        }
        else if($request['type'] === 'des') {
            DB::update('UPDATE topics SET description = ?, updated_at = CURRENT_TIMESTAMP
                WHERE id = ?', [$request['data'], $id]);
        }
        else if($request['type'] === 'attr') {
            DB::update('UPDATE topics SET close_at = ?, is_unlisted = ?, updated_at = CURRENT_TIMESTAMP
                WHERE id = ?', [$request['close_at'], $request['is_unlisted'], $id]);
        }
        else if($request['type'] === 'qs') {
            DB::transaction(function() use (&$request, &$id) {
                DB::connection()->getPdo()->exec( 'LOCK TABLES question_sets WRITE, options WRITE, ballots WRITE' );
                if(isset($request['del'])) {
                    foreach($request['del'] as $del_id) {
                        DB::delete('DELETE FROM ballots WHERE question_set_id = ? AND topic_id = ?',
                        [
                            $del_id,
                            $id
                        ]);
                        DB::delete('DELETE FROM options WHERE question_set_id = ? AND topic_id = ?',
                        [
                            $del_id,
                            $id
                        ]);
                        DB::delete('DELETE FROM question_sets WHERE id = ? AND topic_id = ?',
                        [
                            $del_id,
                            $id
                        ]);
                    }
                }
                $new_qs_id = 1;
                if(isset($request['alter'])) {
                    foreach($request['alter'] as $task) {
                        DB::update('UPDATE question_sets SET id = ?, result_visibility = ? WHERE id = ? AND topic_id = ?',
                        [
                            $new_qs_id,
                            $task['result_visibility'],
                            $task['id'],
                            $id
                        ]);
                        
                        if(isset($task['opts'])) {
                            // GET CURRENT OPTION COUNT
                            $opt_idx = DB::select('SELECT count(*) AS aggregate FROM options 
                                WHERE topic_id = ? AND question_set_id = ?',
                            [
                                $id,
                                $new_qs_id,
                            ])[0]->aggregate;
                            print_r($opt_idx);
                            foreach($task['opts'] as $content) {
                                $opt_idx += 1;
                                DB::insert('INSERT INTO options(id, question_set_id, topic_id, content)
                                    VALUES(?, ?, ?, ?)',
                                [
                                    $opt_idx,
                                    $new_qs_id,
                                    $id,
                                    $content
                                ]);
                            }
                        }
                        $new_qs_id += 1;
                    }
                }
                if(isset($request['new'])) {
                    foreach($request['new'] as $data) {
                        DB::insert('INSERT INTO question_sets(id, topic_id, name, type, is_multiple_choice, is_anonymous, result_visibility)
                                    VALUES(?, ?, ?, ?, ?, ?, ?)',
                        [
                            $new_qs_id,
                            $id,
                            $data['name'],
                            $data['type'],
                            $data['is_multiple_choice'],
                            $data['is_anonymous'],
                            $data['result_visibility']
                        ]);

                        // Insert options
                        for($opt_id = 1; $opt_id <= count($data['opts']); ++$opt_id) {
                            DB::insert('INSERT INTO options(id, question_set_id, topic_id, content) VALUES(?, ?, ?, ?)',
                                [$opt_id, $new_qs_id, $id, $data['opts'][$opt_id - 1]]
                            );
                        }
                        $new_qs_id += 1;
                    }
                }
            DB::connection()->getPdo()->exec( 'UNLOCK TABLES' );
            });
        }

        $time = DB::select('SELECT updated_at FROM topics WHERE id = ?', [$id])[0]->updated_at;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $topic = DB::select('SELECT * FROM topics WHERE id = ?', [$id]);

        if(Gate::denies('update-topic', $topic[0])) {
            return redirect('/topics');
        }

        DB::transaction(function() use (&$id) {
            DB::delete('DELETE FROM ballots WHERE topic_id = ?', [$id]);
            DB::delete('DELETE FROM options WHERE topic_id = ?', [$id]);
            DB::delete('DELETE FROM question_sets WHERE topic_id = ?', [$id]);
            DB::delete('DELETE FROM topics WHERE id = ?', [$id]);
        });

        return redirect('/topics');
    }
}
