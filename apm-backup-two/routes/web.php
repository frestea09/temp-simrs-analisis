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

// Route::get('/', function () {
//     return view('welcome');
// })->name('home');

Route::get('/', 'HomeController@home')->name('home');
Route::get('/load-poli/{loket}/{posisi}', 'HomeController@poli');


Route::get('/jadwal/dokter', 'JadwalDokterController@index')->name('jadwal-dokter');
Route::get('/polis', 'ReservasiController@poli')->name('polis');
Route::post('/jadwal/jadwal-dokter-hfis', 'JadwalDokterController@jadwalDokterHfis')->name('jadwal-dokter-hfis');

Route::get('/reservasi', 'ReservasiController@index')->name('reservasi');
Route::get('/reservasi-lama', 'ReservasiController@indexLama')->name('reservasiLama');
Route::post('/reservasi/store', 'ReservasiController@store')->name('store-reservasi');
Route::post('/reservasi/cari-pasien', 'ReservasiController@cariPasien')->name('cari-pasien');
Route::post('/reservasi/pilih-pasien', 'ReservasiController@pilihPasien')->name('pilih-pasien');
Route::get('/reservasi/checkin/{id_reservasi}/{no_rm?}', 'ReservasiController@checkin')->name('cetak-resume-reservasi');
Route::get('/reservasi/cetak/{id_reservasi}/{id_antrian?}', 'ReservasiController@cetak');
Route::get('/reservasi/cetak-baru/{id_reservasi}/{no_rm}', 'ReservasiController@cetakBaru');

// Route::get('/reservasi/sep/{id_reservasi}/{no_rm?}', 'ReservasiController@checkinSep')->name('sep');
// Cek Reservasi
Route::get('/reservasi/cek', 'ReservasiController@cek')->name('cek-reservasi');
Route::get('/reservasi/cek-kontrol', 'ReservasiController@cekKontrol')->name('cek-reservasi-kontrol');
Route::get('/reservasi/cek-tes', 'ReservasiController@cekTesting')->name('cek-reservasi-testing');
Route::post('/reservasi/cek', 'ReservasiController@cekReservasi')->name('cek-reservasi');

// reservasi cek umum
Route::get('/reservasi/cek-umum', 'ReservasiController@cekUmum')->name('cek-reservasi-umum');
Route::post('/reservasi/cek-umum', 'ReservasiController@cekReservasiUmum')->name('cek-reservasi-umum');
Route::get('/reservasi/checkin-umum/{id_reservasi}/{no_rm?}', 'ReservasiController@checkinUmum')->name('cetak-resume-reservasi-umum');
// Cek RUJUKAN PASIEN BARU
Route::get('/reservasi/cetak-sep/{no_sep}', 'ReservasiController@cetak_sep');
Route::get('/reservasi/cek-baru', 'ReservasiController@cekBaru')->name('cek-reservasi-baru');
Route::post('/reservasi/cek-baru', 'ReservasiController@cekReservasiBaru')->name('cek-reservasi-baru');

// FORM CEKIN PASIEN BARU
Route::get('/reservasi/cekin-pasien-baru/{noRujukan}', 'ReservasiController@formCekInReservasiBaru')->name('form-cek-reservasi-baru');
Route::post('/reservasi/store-cekin-pasienBaru', 'ReservasiController@storeCekInReservasiBaru')->name('form-cek-reservasi-baru');
Route::post('/reservasi/store-cekin-sep', 'ReservasiController@storeCekinSep')->name('form-cek-sep');

Route::get('/reservasi/sep/{id_reservasi}/{no_rm?}', 'ReservasiController@formCekinSep')->name('form-sep');
Route::get('/reservasi/sep-kontrol/{id_reservasi}/{no_rm?}', 'ReservasiController@formCekinSepKontrol')->name('form-sep-kontrol');

Route::get('/reservasi/cekin-ajax/{id_reservasi}/{no_rm?}', 'ReservasiController@checkinAjax')->name('cekin');
Route::get('/reservasi/cek-sep/{id}/{no_rm?}', 'ReservasiController@cekSep')->name('cek-sep');
Route::get('/reservasi/response-kunjungan/{id}/{no_rm?}', 'ReservasiController@responseKunjungan')->name('cek-sep');

Route::post('/pasien/pasien-baru', 'PasienController@pasienBaru')->name('pasien-baru');

Route::post('/antrean/kiosk/cekJadwal/{kode}','JadwalDokterController@cekJadwal');
Route::post('/antrean/kiosk/booking','ReservasiController@booking');
Route::get('/pasien/get-kelurahan','DemografiController@getKelurahan')->name('get-kabupaten');

Route::post('/ambilantrean','ReservasiController@ambilantrean');

// Route::get('/pasien/getdistrict/{regency_id}',[App\Http\Controllers\DemografiController::class, 'getKecamatan'])->name('get-kecamatan');
// Route::get('/pasien/getdesa/{district_id}',[App\Http\Controllers\DemografiController::class, 'getDesa'])->name('get-desa');
// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');