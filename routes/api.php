<?php
/**
 * API Routes
*/

use Illuminate\Http\Request;

Route::get('/', 'ApiController@index');
Route::get('/transacao', 'ApiController@index');
Route::get('/transacao/{id}', 'ApiController@show');
Route::get('/gerar-autorizado', 'ApiController@generateCardAccept');
Route::get('/gerar-recusado', 'ApiController@generateCardRefuse');
Route::get('/gerar-aleatorio', 'ApiController@generateCardRandom');

Route::post('/autorizar-pagamento', 'ApiController@store');
