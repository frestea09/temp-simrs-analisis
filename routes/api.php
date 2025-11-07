<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('pengunjung_irj/{tga?}/{tgb?}', 'ApiController@pengunjung');
Route::get('pengunjung_ird/{tga?}/{tgb?}', 'ApiController@pengunjung_ird');

Route::post('lica-report', 'ApiController@licaReport');

Route::get('info-kamar', 'ApiController@infoKamar');

Route::get('cara-bayar', 'ApiController@caraBayar');
Route::get('poliklinik', 'ApiController@poliklinik');
Route::get('dokter', 'ApiController@dokter');
Route::get('cari-no-rm/{rm}', 'ApiController@cariNoRm');
Route::post('daftar-online', 'ApiController@daftarOnline');

Route::get('antrian-poli/{tanggal?}/{poli_id?}', 'ApiController@antrianPoli');
Route::get('fasilitas', 'ApiController@fasilitas');
Route::get('jadwaldokter/kodepoli/{kodepoli}', 'ApiController@jadwalDokter');
Route::get('ref/dokter', 'ApiController@refDokter'); 
// Route::get('jadwal-dokter/kode', 'ApiController@jadwalDokter');




//Siranap
Route::get('siranap', 'Api\SiranapController@index');

//Poli-Order
Route::post('poli-order', 'Api\PacsController@store');
Route::get('poli-order/show/{id}', 'Api\PacsController@show');
Route::post('poli-order/update/{id}', 'Api\PacsController@update');
Route::get('poli-order/destroy/{id}', 'Api\PacsController@destroy');

Route::post('lis/insert', 'Api\LisController@store');

//PacsExpertise
Route::post('expertise', 'Api\PacsController@expertise');


//========================================= BPJS API =============================

Route::get('antrean/token', 'ApiController@token');
Route::post('antrol/antrian', 'ApiController@antrian');
Route::post('antrol/statusAntrian', 'ApiController@rekapAntrian');
Route::post('mobilejkn/operasiPasien', 'ApiController@Operasi');
Route::post('mobilejkn/jadwalOperasi', 'ApiController@tanggalOperasi');
Route::post('antrol/sisaAntrian', 'ApiController@sisaAntrian');
Route::post('antrol/batalAntrian', 'ApiController@batalAntrian');
Route::post('antrol/cekIn', 'ApiController@cekIn');
Route::post('antrol/pasienBaru', 'ApiController@pasienBaru');

Route::get('antrol/tambahAntrian', 'ApiController@tambahAntrian');
Route::get('antrol/updateWaktu', 'ApiController@updatewaktu');
// Route::get('antrol/batalAntrian', 'ApiController@batalAntrianBpjs');

Route::post('jadwaldokter/updatejadwaldokter', 'ApiController@updateJadwalDokter');

//========================================= BPJS API 2=============================

Route::prefix('bpjs')->group(function () {
    Route::post('token', 'Api2Controller@token');
    Route::post('antrian', 'Api2Controller@antrian');
    Route::post('rekap-antrian', 'Api2Controller@rekapAntrian');
    Route::post('operasi', 'Api2Controller@Operasi');
    Route::post('search-operasi', 'Api2Controller@tanggalOperasi');
    Route::post('antrian', 'Api2Controller@antrian');

    Route::post('operasi-baru', 'Api2Controller@operasiBaru');
});

// SADEREK API
Route::namespace('AndroidSaderek')->middleware('cors')->group(function () {
    Route::prefix('saderek/v1')->group(function () {
        Route::get('getScreening/{no}', 'ScreeningController@getScreening');
        Route::get('getScreeningAll', 'ScreeningController@getScreeningAll');
        Route::post('saveScreening', 'ScreeningController@saveScreening');
        Route::post('saveScreeningAll', 'ScreeningController@saveScreeningAll');
        Route::post('getScreening', 'ScreeningController@showScreening');

        Route::get('resultScreening/{type}/{id}', 'ScreeningController@resultScreening');

        Route::post('daftar-online', 'ApiController@daftarOnline');
        Route::post('loginUser', 'ApiController@loginUser');
        Route::post('cek-pendaftaran', 'ApiController@cekPendaftaran');
        Route::post('cek-pendaftaran-uuid', 'ApiController@cekPendaftaranByUUID');

        // bpjs
        Route::post('getRujukan', 'ApiController@getRujukan');
        Route::post('getPeserta', 'ApiController@getPeserta');
        Route::post('getPesertaMultiple', 'ApiController@getPesertaMultiple');
        Route::post('vclaim/peserta/kartu-peserta', 'ApiController@vclaimKartuPeserta');
        Route::post('vclaim/peserta/nik', 'ApiController@vclaimNIK');
        // end bpjs

        Route::post('getPendaftaran', 'ApiController@getPendaftaran');
        Route::post('checkin', 'ApiController@checkin');

        Route::post('countScreening', 'ApiController@countScreening');


        //kanggo
        Route::get('cek-update', 'ApiController@cekUpdate');
        Route::get('cek-pengumuman', 'ApiController@pengumuman');
    });
});
// END SADEREK API

//  NEW API
Route::namespace('Android')->middleware('cors')->group(function () {
    Route::prefix('v1')->group(function () {
        Route::get('direksi/manajemen', 'ApiController@all_manajemen');
        Route::get('pages/{type}', 'ApiController@show_page');
        Route::get('pages/detail/{id}', 'ApiController@show_page_detail');
        Route::get('kamar-tersedia', 'ApiController@show_kamar');
        Route::get('tentang-kami', 'ApiController@about_us');
        Route::get('visi-misi', 'ApiController@visimisi');
        Route::get('syarat-ketentuan', 'ApiController@syaratketentuan');
        Route::get('petunjuk-penggunaan', 'ApiController@petunjukpenggunaan');
        
        Route::get('poliklinik', 'ApiController@poliklinik');
        Route::get('cara-bayar', 'ApiController@caraBayar');
        Route::get('dokter/{poli_id}', 'ApiController@dokter');
        Route::get('jadwal-dokter', 'ApiController@jadwalDokter');
        Route::get('fasilitas', 'ApiController@fasilitas');
        Route::get('slider', 'ApiController@slider');
        // API BPJS
        Route::get('rujukan/{no_rujukan}', 'ApiController@rujukan');
        
        Route::post('jadwal-dokter-hfis', 'ApiController@jadwalDokterHfis');
        
        Route::get('cek-update', 'ApiController@cekUpdate');

        Route::get('kuota/{tgl}/{poli}', 'ApiController@cekKuota');
       
        Route::post('login', 'AuthApiController@login'); 
        Route::post('login-new', 'AuthApiController@loginNew'); 
        Route::post('forget-password', 'AuthApiController@forgetPassword');

        // Route::middleware('auth:pasien-api',function(Request $request) {
            Route::get('user', 'ApiController@getUser');
            Route::get('cek-pendaftaran', 'ApiController@cekPendaftaran');
            Route::post('cek-pendaftaran', 'ApiController@cekPendaftaranDetail');
            Route::post('daftar-online', 'ApiController@daftarOnline');

            Route::get('user-new', 'ApiController@getUserNew');
            Route::post('daftar-online-new', 'ApiController@daftarOnlineNew');
            Route::get('cek-pendaftaran-new', 'ApiController@cekPendaftaranNew');
            Route::post('cek-pendaftaran-new', 'ApiController@cekPendaftaranDetailNew');

        // });
    });
});