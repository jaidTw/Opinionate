<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $topics = DB::select(
            'SELECT id, user_id, name, username, is_unlisted
                FROM topics NATURAL JOIN
                (SELECT id AS user_id, name AS username FROM users) AS users_inf
                WHERE user_id = ?', [Auth::user()->id]);
        $pagination = new LengthAwarePaginator($topics, count($topics), 5, Paginator::resolveCurrentPage(), ['path' => Paginator::resolveCurrentPath()]);
        $page = $pagination->currentPage();
        $topics = array_slice($topics, ($page - 1) * 5, 5);

        return view('home', ['topics' => $topics, 'pagination' => $pagination]);
    }

    public function browse($user_id)
    {
        $user = DB::select('SELECT id, name, email, created_at FROM users WHERE id = ?', [$user_id])[0];
        $topics = DB::select('SELECT id, name, is_unlisted FROM topics WHERE user_id = ?', [$user_id]);
        $pagination = new LengthAwarePaginator($topics, count($topics), 5, Paginator::resolveCurrentPage(), ['path' => Paginator::resolveCurrentPath()]);
        $page = $pagination->currentPage();
        $topics = array_slice($topics, ($page - 1) * 5, 5);

        return view('home', ['user' => $user, 'topics' => $topics, 'pagination' => $pagination]);
    }
}
