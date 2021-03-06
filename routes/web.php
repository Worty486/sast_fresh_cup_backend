<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/home', function () {
    return view('mark');
});


Route::any('/password/{any}', function ($any) {
    if(request()->method() == 'GET') {
        return redirect('/');
    }else{
        return response()->json([
            'ret'  => 403,
            'desc' => 'forbidden!',
            'data' => ''
        ], 403);
    }
});

Route::group(['prefix' => 'mark', 'as' => 'mark.', 'middleware' => ['auth','examiners']], function () {
    Route::get('/', 'MarkController@index')->name('index');

    Route::post('/submit', 'MarkController@mark')->middleware('answer.exist')->name('mark');
    Route::post('/progress', 'MarkController@progress')->name('progress');
    Route::post('/request', 'MarkController@request')->middleware('problem.exist')->name('request');

});

Auth::routes(['register' => false]);


