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
    Route::get('detalhes/candidatura/matricula/{id}', 'CandidaturasController@matricula')->name('editais.matricula');
    Route::get('detalhes/candidatura/historico/{id}', 'CandidaturasController@historico')->name('editais.historico');
    Route::get('detalhes/candidatura/percentual/{id}', 'CandidaturasController@percentual')->name('editais.percentual');
    Route::get('detalhes/candidatura/curriculum/{id}', 'CandidaturasController@curriculum')->name('editais.curriculum');
    Route::get('detalhes/candidatura/trabalho1/{id}', 'CandidaturasController@trabalho1')->name('editais.trabalho1');
    Route::get('detalhes/candidatura/trabalho2/{id}', 'CandidaturasController@trabalho2')->name('editais.trabalho2');
    Route::get('detalhes/candidatura/trabalho3/{id}', 'CandidaturasController@trabalho3')->name('editais.trabalho3');
    Route::get('detalhes/candidatura/estudo1/{id}', 'CandidaturasController@estudo1')->name('editais.estudo1');
    Route::get('detalhes/candidatura/estudo2/{id}', 'CandidaturasController@estudo2')->name('editais.estudo2');
    Route::get('detalhes/candidatura/estudo3/{id}', 'CandidaturasController@estudo3')->name('editais.estudo3');
    Route::get('detalhes/candidatura/foto/{id}', 'CandidaturasController@foto')->name('editais.foto');
    Route::get('detalhes/candidatura/comprovacao/{id}', 'CandidaturasController@comprovacao')->name('editais.comprovacao');
    Route::get('detalhes/candidatura/certificado/{id}', 'CandidaturasController@certificado')->name('editais.certificado');
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

Route::group(['prefix' => 'ccint',  'middleware' => ['auth','ccint']], function() {

    Route::get('detalhes/candidatura/matricula/{id}', 'CandidaturasController@matricula')->name('ccint.matricula');
    Route::get('detalhes/candidatura/historico/{id}', 'CandidaturasController@historico')->name('ccint.historico');
    Route::get('detalhes/candidatura/percentual/{id}', 'CandidaturasController@percentual')->name('ccint.percentual');
    Route::get('detalhes/candidatura/curriculum/{id}', 'CandidaturasController@curriculum')->name('ccint.curriculum');
    Route::get('detalhes/candidatura/trabalho1/{id}', 'CandidaturasController@trabalho1')->name('ccint.trabalho1');
    Route::get('detalhes/candidatura/trabalho2/{id}', 'CandidaturasController@trabalho2')->name('ccint.trabalho2');
    Route::get('detalhes/candidatura/trabalho3/{id}', 'CandidaturasController@trabalho3')->name('ccint.trabalho3');
    Route::get('detalhes/candidatura/estudo1/{id}', 'CandidaturasController@estudo1')->name('ccint.estudo1');
    Route::get('detalhes/candidatura/estudo2/{id}', 'CandidaturasController@estudo2')->name('ccint.estudo2');
    Route::get('detalhes/candidatura/estudo3/{id}', 'CandidaturasController@estudo3')->name('ccint.estudo3');
    Route::get('detalhes/candidatura/foto/{id}', 'CandidaturasController@foto')->name('ccint.foto');
    Route::get('detalhes/candidatura/comprovacao/{id}', 'CandidaturasController@comprovacao')->name('ccint.comprovacao');
    Route::get('detalhes/candidatura/certificado/{id}', 'CandidaturasController@certificado')->name('ccint.certificado');
    Route::get('detalhes/candidatura/carta/{id}', 'CandidaturasController@carta')->name('ccint.certificado');


    Route::get('/', 'CcintController@index');
    Route::get('detalhes/{id}', 'CcintController@details');
     Route::post('store/{id}', 'CcintController@store');
});

Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('config:clear');
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('config:cache');
    $exitCode = Artisan::call('view:clear');
    return 'DONE'; //Return anything
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
