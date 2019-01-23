<?php
/**
 * Web Routes
*/

Route::get('/', 'UsuarioController@create');
Route::get('/form-cadastro', 'UsuarioController@create');
Route::get('/assinatura', 'AssinaturaController@index');
Route::get('/assinatura/{id}', 'AssinaturaController@show');

Route::post('/save-usuario', 'UsuarioController@store');
Route::post('/save-assinatura', 'AssinaturaController@store');

Route::get('/api-pagamento/gerar-autorizado', 'AssinaturaController@generateCardAccept');
Route::get('/api-pagamento/gerar-recusado', 'AssinaturaController@generateCardRefuse');
Route::get('/api-pagamento/gerar-aleatorio', 'AssinaturaController@generateCardRandom');
