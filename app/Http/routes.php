<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::any('/', function () {
    return view('welcome');
});

Route::auth();

Route::any('/home', 'HomeController@index');
Route::any('/topics', 'TopicController@index');

Route::any('/topics/{id}', 'TopicController@show');
Route::any('/topics/{id}/count', 'QuestionSetController@index');
Route::any('/topics/{id}/{qsid}', 'QuestionSetController@show');
//Route::post('/topics/{tid}/{qsid}/{optid}/create', 'TopicController@update')->middleware('auth');
//Route::get('/topics/{tid}/{qsid}', 'QuestionSetController@show');

// Use auth middleware to make sure user is logged in before any post
Route::post('/topics/{id}/ballot/store', 'BallotController@store')->middleware('auth');
Route::post('/topics/{id}/ballot/update', 'BallotController@update')->middleware('auth');
Route::post('/topics/{id}/ballot/destroy', 'BallotController@destroy')->middleware('auth');
Route::post('/topics/{id}/update', 'TopicController@update')->middleware('auth');
Route::post('/topics/create', 'TopicController@create')->middleware('auth');
Route::post('/topics/store', 'TopicController@store')->middleware('auth');

// For methods which is not allowed, redirect to /topics .
Route::get('/topics/create', function() { return redirect('/topics'); });
Route::get('/topics/store', function() { return redirect('/topics'); });