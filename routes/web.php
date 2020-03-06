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
Route::post('/update/{id}', 'HomeController@update')->name('update');

Route::group(['prefix' => 'candidato',  'middleware' => ['auth','candidato']], function() {
    Route::post('store', 'CandidatoController@store');
    Route::post('update', 'CandidatoController@update');
    Route::get('/', 'CandidatoController@index');
    Route::get('/foto/{id}', 'CandidatoController@foto');
});


Route::group(['prefix' => 'editais',  'middleware' => ['auth','staff']], function() {
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
    Route::get('detalhes/candidatura/foto/{id}', 'CandidaturasController@foto');
    Route::get('detalhes/candidatura/certificado/{id}', 'CandidaturasController@certificado');
    Route::post('detalhes/candidatura/atualizar/certificado/{id}', 'CandidaturasController@atualizarCertificado');
    Route::post('detalhes/candidatura/atualizar/{id}', 'CandidaturasController@atualizarStatus');

    Route::get('detalhes/candidatura/{id}', 'EditaisController@candidatura');
    Route::delete('detalhes/delete/{id}','EditaisController@destroy');
    Route::get('detalhes/{id}', 'EditaisController@details');
    Route::post('atualizar/update/{id}', 'EditaisController@update')->name('editais.update');
    Route::get('atualizar/{id}', 'EditaisController@atualizar');
    Route::get('download/{id}', 'EditaisController@download');
    Route::post('store', 'EditaisController@store');
    Route::post('ccint/cadastrar', 'EditaisController@ccint');
    Route::get('/', 'EditaisController@index');
});

Route::group(['prefix' => 'candidaturas',  'middleware' => ['auth','candidato']], function() {
    Route::post('atualizacao/update/{id}', 'CandidaturasController@update');
    Route::post('inscricao/store/{id}', 'CandidaturasController@store');
    Route::post('detalhes/recurso/{id}', 'CandidaturasController@recurso')->name('recurso');
    Route::get('detalhes/{id}', 'CandidaturasController@details');
    Route::get('inscricao/{id}', 'CandidaturasController@inscricao');
    Route::get('atualizacao/{id}', 'CandidaturasController@atualizacao');
    Route::get('certificado/{id}', 'CandidaturasController@certificado')->name('candidaturas.certificado');
    Route::get('/', 'CandidaturasController@index')->middleware('candidato');
});


Route::group(['prefix' => 'equipe',  'middleware' => ['auth','admin']], function() {
    Route::post('store', 'EquipeController@store');
    Route::delete('delete/{id}','EquipeController@destroy');
    Route::get('/', 'EquipeController@index');
});

Route::group(['prefix' => 'recursos',  'middleware' => ['auth','staff']], function() {
    Route::get('/', 'RecursosController@index');
    Route::get('detalhes/{id}', 'RecursosController@details')->name('recurso.detalhes');
    Route::post('resposta/store/{id}', 'RecursosController@storeResposta')->name('resposta');
});

Route::group(['prefix' => 'ccint',  'middleware' => ['auth','staff']], function() {
    Route::get('/', 'CcintController@index');
    Route::get('detalhes/{id}', 'CcintController@details');
});

Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('config:clear');
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('config:cache');
    $exitCode = Artisan::call('view:clear');
    return 'DONE'; //Return anything
});
