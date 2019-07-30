<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'namespace' => 'Api',
], function () {
    Route::get('test', 'QuestionsController@test')->name('api.questions.test');
    Route::get('questions', 'QuestionsController@index')->name('api.questions.index');
    Route::get('questions/search', 'QuestionsController@search')->name('api.questions.search');
    Route::put('questions/{question}', 'QuestionsController@update')->name('api.questions.update');
    Route::delete('questions/{question}', 'QuestionsController@destroy')->name('api.questions.destroy');
    Route::post('questions/save', 'QuestionsController@saveToFile')->name('api.questions.savetofile');
    Route::match(['post', 'get'], 'questions/addByJson', 'QuestionsController@addByJson')->name('api.questions.addByJson');
});
