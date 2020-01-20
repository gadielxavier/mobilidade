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

Auth::routes();


Route::get('/home', 'HomeController@index')->name('home');
Route::get('/configuracoes', 'HomeController@configuracoes')->name('configuracoes');



Route::prefix('candidato')->group(function () {
    Route::post('store', 'CandidatoController@store');
    Route::post('update', 'CandidatoController@update');
    Route::get('/', 'CandidatoController@index')->middleware('candidato');
});


Route::prefix('editais')->group(function () {
    Route::get('detalhes/candidatura/matricula/{id}', 'CandidaturasController@matricula');
    Route::get('detalhes/candidatura/historico/{id}', 'CandidaturasController@historico');
    Route::get('detalhes/candidatura/percentual/{id}', 'CandidaturasController@percentual');
    Route::get('detalhes/candidatura/curriculum/{id}', 'CandidaturasController@curriculum');
    Route::get('detalhes/candidatura/trabalho1/{id}', 'CandidaturasController@trabalho1');
    Route::get('detalhes/candidatura/trabalho2/{id}', 'CandidaturasController@trabalho2');
    Route::get('detalhes/candidatura/trabalho3/{id}', 'CandidaturasController@trabalho3');
    Route::get('detalhes/candidatura/estudo1/{id}', 'CandidaturasController@estudo1');
    Route::get('detalhes/candidatura/estudo2/{id}', 'CandidaturasController@estudo2');
    Route::get('detalhes/candidatura/estudo3/{id}', 'CandidaturasController@estudo3');
    Route::post('detalhes/candidatura/atualizar/{id}', 'CandidaturasController@atualizarStatus');

    Route::get('detalhes/candidatura/{id}', 'EditaisController@candidatura');
    Route::delete('detalhes/delete/{id}','EditaisController@destroy');
    Route::get('detalhes/{id}', 'EditaisController@details');
    Route::post('atualizar/update/{id}', 'EditaisController@update');
    Route::get('atualizar/{id}', 'EditaisController@atualizar');
    Route::get('download/{id}', 'EditaisController@download');
    Route::post('store', 'EditaisController@store');
    Route::get('/', 'EditaisController@index');
});


Route::prefix('candidaturas')->group(function () {
    Route::post('atualizacao/update/{id}', 'CandidaturasController@update');
    Route::post('inscricao/store/{id}', 'CandidaturasController@store');
    Route::get('detalhes/{id}', 'CandidaturasController@details');
    Route::get('inscricao/{id}', 'CandidaturasController@inscricao');
    Route::get('atualizacao/{id}', 'CandidaturasController@atualizacao');
    Route::get('/', 'CandidaturasController@index')->middleware('candidato');
});
