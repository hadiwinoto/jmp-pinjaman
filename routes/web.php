<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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

Auth::routes();
Route::get('/logout', 'Auth\LoginController@logout');


// view
Route::group(['middleware' => 'auth'], function () {
  Route::get('/', 'HomeController@homePage');
  Route::get('/kasbon', 'Kasbon\KelolaKasbonController@index');
  Route::get('/data/dashboard', 'Rekap\RekapKasbonController@dataDashboard');
  Route::get('/kasbon/detail/{id}', 'Kasbon\KelolaKasbonController@showDetail');

  Route::get('/user-management', 'Management\ManagementController@showManagement');
  Route::get('/master-data', 'Management\ManagementController@showMasterData');
  Route::post('/master-data/submit', 'Management\ManagementController@createMasterGroup');
  Route::get('/master-data/fetchdata', 'Management\ManagementController@getDayaBagian');
  Route::post('/master-data/delete/group', 'Management\ManagementController@deleteDataGroup');
  Route::get('/master-data/fetchbagianbyid', 'Management\ManagementController@getBagianByid');

  Route::post('/master-data/submit/pekerjaan', 'Management\ManagementController@createMasterPekerjaan');
  Route::get('/master-data/fetchdata/pekerjaan', 'Management\ManagementController@getDataPekerjaan');
  Route::get('/master-data/pekerjaanbyid', 'Management\ManagementController@getPekerjaanByid');
  Route::post('/master-data/delete/pekerjaan', 'Management\ManagementController@deleteDataPekerjaan');
  Route::post('/master-data/non-aktifkan', 'Management\ManagementController@nonAktifkanKaryawan');

  Route::get('/master-data/groupbyid', 'Management\ManagementController@getDataGroupByid');

  Route::post('/master-data/submit/bagian', 'Management\ManagementController@createMasterBagian');
  Route::post('/master-data/delete/bagian', 'Management\ManagementController@deleteDataBagian');

  //karyawan
  Route::get('/data/pinjaman/karyawan/export', 'Rekap\RekapKasbonController@downloadRekapAll');
  Route::get('/data/pinjaman/karyawan/export/{id}', 'Rekap\RekapKasbonController@downloadRekapById');
  
});

Route::group(['middleware' => 'auth','prefix' => 'profile'], function () {
  Route::get('/user', 'Management\ManagementController@showProfile');
  Route::get('/user/all', 'Management\ManagementController@getDataKaryawan');
  Route::post('/user/submit', 'Management\ManagementController@submitDataKaryawan');
  Route::post('/user/submit/foto', 'Management\ManagementController@uploadFoto');
  Route::get('/user/byid', 'Management\ManagementController@getDataKaryawanByid');

});


//api 
Route::group(['middleware' => 'auth','prefix' => 'api'], function () {
  
  Route::get('/get/data/karyawan/kasbon', 'Kasbon\KelolaKasbonController@getDataKaryawan');
  Route::get('/get/data/pinjaman/karyawan/kasbon', 'Kasbon\KelolaKasbonController@getRincianPinjaman');
  Route::get('/get/data/pinjaman/karyawan/kasbonbyid','Kasbon\KelolaKasbonController@editKasbon');

  Route::post('/pinjaman/langsung', 'Kasbon\KelolaKasbonController@submitKasbonLangsung');
  Route::post('/bayar/langsung', 'Kasbon\KelolaKasbonController@submitBayarLangsung');
  Route::post('/datakasbon/edit', 'Kasbon\KelolaKasbonController@submitEditKasbon');
  Route::post('/datakasbon/delete', 'Kasbon\KelolaKasbonController@deleteDataPinjaman');


});
