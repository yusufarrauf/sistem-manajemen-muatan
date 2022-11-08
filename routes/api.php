<?php

use Illuminate\Http\Request;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResources(['users' => 'API\UserController']);

Route::apiResources(['vendor-kendaraan' => 'API\VendorKendaraanController']);
Route::apiResources(['data-kendaraan' => 'API\DataKendaraanController']);

Route::post('updateStatusKendaraan', 'API\DataKendaraanController@updateStatus');
Route::apiResources(['data-kota' => 'API\DataKotaController']);

Route::apiResources(['data-muatan' => 'API\MuatanController']);

Route::apiResources(['data-pelanggan' => 'API\DataPelangganController']);

Route::apiResources(['data-ongkos' => 'API\DataOngkosController']);
Route::post('getCost', 'API\DataOngkosController@getCost');

Route::apiResources(['angkutan' => 'API\AngkutanController']);
Route::post('updateLock', 'API\AngkutanController@updateLock');
Route::post('getUnlock', 'API\AngkutanController@getUnlock');
Route::post('updateStatusAngkutan', 'API\AngkutanController@updateStatus');
Route::post('filterLaporanAngkutan', 'API\AngkutanController@filter');
Route::apiResources(['data-gaji' => 'API\DataGajiController']);
Route::post('filterMyReport', 'API\AngkutanController@filterReportSupir');
Route::post('rekapSupir', 'API\AngkutanController@rekapSupir');
Route::post('rekapVendor', 'API\AngkutanController@rekapVendor');
Route::get('myReport', 'API\AngkutanController@reportSupir');
Route::get('angkutanPalembang', 'API\AngkutanController@angkutanPalembang');
Route::post('angkutanPalembang', 'API\AngkutanController@filterAngkutanPalembang');
Route::post('updateAngkutanPalembang', 'API\AngkutanController@updateIsFiltered');
Route::get('angkutanVendor', 'API\AngkutanController@angkutanVendor');
Route::post('filterLaporanAngkutanVendor', 'API\AngkutanController@filterVendor');

Route::apiResources(['perawatan' => 'API\PerawatanController']);
Route::post('filterLaporanPerawatan', 'API\PerawatanController@filter');
Route::post('getLimitData', 'API\PerawatanController@getLimit');
Route::get('approvalData', 'API\PerawatanController@approvalData');
Route::post('approvalData', 'API\PerawatanController@filterApprovalData');
Route::post('updateApprovalData', 'API\PerawatanController@updateApprovalData');

Route::apiResources(['rekapitulasi' => 'API\RekapitulasiController']);
Route::post('filterLaporanRekapitulasi', 'API\RekapitulasiController@filter');

Route::apiResources(['data-gaji' => 'API\DataGajiController']);
Route::get('data-penggajian', 'API\DataGajiController@dataPenggajian');
Route::post('input-penggajian', 'API\DataGajiController@inputPenggajian');
Route::put('edit-penggajian/{id}', 'API\DataGajiController@editPenggajian');

Route::apiResources(['karyawan' => 'API\DataKaryawanController']);

