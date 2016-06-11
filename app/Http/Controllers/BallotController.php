<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Http\Requests;

class BallotController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $id)
    {
        $result = DB::select('SELECT id, name FROM (
                SELECT user_id AS id FROM ballots WHERE topic_id = ? AND question_set_id = ? AND option_id = ?
            ) AS ballot NATURAL JOIN users',
        [
            $id,
            $request['qsid'],
            $request['optid']
        ]);

        return response()->json($result);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        // to perform id checking
        DB::transaction(function() use(&$request, $id) {
            DB::insert('INSERT INTO ballots(user_id, topic_id, question_set_id, option_id, cast_at)
                VALUES(?, ?, ?, ?, CURRENT_TIMESTAMP)',
            [
                Auth::user()->id,
                $id,
                $request['qsid'],
                $request['optid']
            ]);
        });
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
        // to perform id checking
        DB::transaction(function() use(&$request, $id) {
            $result = DB::select('SELECT COUNT(*) AS count FROM ballots
                WHERE user_id = ? AND topic_id = ? AND question_set_id = ?',
            [
                Auth::user()->id,
                $id,
                $request['qsid']
            ]);

            if($result[0]->count != 0) {
                DB::update('UPDATE ballots SET option_id = ?, cast_at = CURRENT_TIMESTAMP
                    WHERE user_id = ? AND topic_id = ? AND question_set_id = ?',
                [
                    $request['optid'],
                    Auth::user()->id,
                    $id,
                    $request['qsid']
                ]);
            }
            else {
                DB::insert('INSERT INTO ballots(user_id, topic_id, question_set_id, option_id, cast_at)
                    VALUES(?, ?, ?, ?, CURRENT_TIMESTAMP)',
                [
                    Auth::user()->id,
                    $id,
                    $request['qsid'],
                    $request['optid']
                ]);
            }
        });
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        // to perform id checking
        DB::transaction(function() use(&$request, $id) {
            DB::delete('DELETE FROM ballots
                WHERE user_id = ? AND topic_id = ? AND question_set_id = ? AND option_id = ?',
            [
                Auth::user()->id,
                $id,
                $request['qsid'],
                $request['optid']
            ]);
        });
    }
}
