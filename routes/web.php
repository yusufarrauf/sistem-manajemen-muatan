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
    return redirect('/dashboard');
});
Route::get('/cetak/slip-gaji/{kode}', 'HomeController@printSlipGaji')->where('any', '.*');
Route::get('/excel/{kode}', 'HomeController@exportExcel')->where('any', '.*');
Route::get('/cetak/rekap/invoice/{kode}', 'HomeController@printRekapInvoice')->where('any', '.*');
Route::get('/cetak/rekap/angkutan/{kode}', 'HomeController@printRekapAngkutan')->where('any', '.*');
Route::get('/cetak/rekap-supir/{bulan}/{tahun}/{nopol}', 'HomeController@printPersupir')->where('any', '.*');
Route::get('/cetak/perawatan/{bulan}/{tahun}/{nopol}', 'HomeController@printPerawatan')->where('any', '.*');
Auth::routes(['register' => false]);
Route::get('/{path}', 'HomeController@index')->where('any', '.*');
Route::get('/data-master/{path}', 'HomeController@index')->where('any', '.*');
Route::get('/input-data/{path}', 'HomeController@index')->where('any', '.*');
Route::get('/data/{path}', 'HomeController@index')->where('any', '.*');
Route::get('/penggajian/{path}', 'HomeController@index')->where('any', '.*');
Route::get('/ubah-data/angkutan/{path}', 'HomeController@index')->where('any', '.*');
