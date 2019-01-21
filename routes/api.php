<?php
/**
 * API Routes
*/

use Illuminate\Http\Request;

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/gerar-autorizado', 'ApiController@generateCardAccept');
Route::get('/gerar-recusado', 'ApiController@generateCardRefuse');
Route::get('/gerar-aleatorio', 'ApiController@generateCardRandom');
Route::get('/transacao/{id}', 'ApiController@show');
Route::get('/transacao', 'ApiController@index');
Route::post('/autorizar-pagamento', 'ApiController@store');
