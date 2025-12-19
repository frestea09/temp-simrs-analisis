<?php

use Illuminate\Http\Request;
Route::get('sipeka/form-user', 'KeluhanPasienController@index');
Route::get('sipeka/store', 'KeluhanPasienController@store');
Route::get('sipeka/', 'KeluhanPasienController@form_user');
Route::get('sipeka/store-user', 'KeluhanPasienController@store_user');
Route::get('sipeka/cari-laporan', 'KeluhanPasienController@cari_laporan');
Route::get('sipeka/cari', 'KeluhanPasienController@cari');
Route::get('frontoffice/download-all/{registrasi_id}', 'FrontofficeController@downloadAll');
Route::get('/get-dokter/{id}', 'FrontofficeController@getDokter');
Route::get('/ajax/cek-folio/{id}/{poli_id}', 'AjaxController@cekFolio');
Route::get('/ajax-cek-kamar/{regid}', 'AjaxController@cekKamar');

Route::get('/status-pemeriksaan/{id}/{userDokter}', 'AjaxController@statusPemeriksaan');


Route::get('laborat/registered-new', 'PemeriksaanLabController@teregistrasi');
Route::get('laborat/data-registered-new', 'LaboratoriumController@dataRegistered');
Route::post('laborat/registered-new', 'LaboratoriumController@registeredByTanggal');


Route::get('/exporttarifold/{bulan}', 'BridgingSEPController@exporttarif')->name('login2');
Route::post('/proccess-login', 'BridgingSEPController@login2')->name('login2');
// Route::get('sinkron-batch-obat/{gudang_id}', 'BridgingSEPController@sinkronBatch');
// Rou/te::get('updateobat', 'BridgingSEPController@updateobat');
// Route::get('updatebatch', 'BridgingSEPController@updatebatch');
// Route::get('updatetarif', 'BridgingReferensiController@updatedatabase');
// Route::get('updatebeds', 'BridgingReferensiController@updateBed');
Route::get('sinkron-irj/{reg_id}', 'BridgingReferensiController@sinkronIrj');
Route::get('sinkron-pasien/mulai/{start}/selesai/{end}', 'BridgingReferensiController@sinkronPasien');
Route::get('sinkron-rm/{id_pasien}', 'BridgingReferensiController@sinkronRm');
Route::get('penjualan-sinkron-faktur/{faktur}/{reg_id}/{harga}', 'BridgingReferensiController@sinkronFaktur');
Route::get('signature', 'SepController@signature');
Route::get('sinkron-taskid-cron', 'BridgingReferensiController@sinkronTaskidCron');
Route::get('sinkron-taskid-cron4', 'BridgingReferensiController@sinkronTaskidCron4');
Route::get('sinkron-taskid-cron5', 'BridgingReferensiController@sinkronTaskidCron5');
Route::get('sinkron-taskid-cron6', 'BridgingReferensiController@sinkronTaskidCron6');

Route::get('poli/{poli}', 'SepController@poli');
Route::get('ref-dokter/{polikode}', 'SepController@ref_dokter');
Route::get('task-list', 'BridgingReferensiController@taskList');
Route::get('cekdoub', 'BridgingReferensiController@cekDoub');
include __DIR__ . '/simrs/antrian.php';

Auth::routes();
// if (!env('ALLOW_REGISTRATION', false)) {
Route::get('/register', 'SepController@returnRedirectRegister');
// Route::any('/register', function() {
// 	return redirect('/');
// });
// }
// Auth::routes(['register' => false]);
Route::get('/', 'HomeController@index')->name('home');
Route::get('/updatedatabase', 'BridgingReferensiController@updatedatabase')->name('home');
Route::get('/home', 'HomeController@index')->name('home');
include __DIR__ . '/simrs/covid.php';

include __DIR__ . '/simrs/displaytempattidur.php';


// DISPLAY INFORMASI PENGUNJUNG

Route::get('display/informasi', 'DashboardController@display');

// ANTRIAN POLI
Route::post('/antrian_poli/savetouch', 'AntrianPoliController@savetouch');
Route::get('/antrian_poli/datalayarlcd/{poli_id}', 'AntrianPoliController@datalayarlcd');
Route::get('/antrian_poli/antrian_terakhir', 'AntrianPoliController@dataAntrianTerakhir');
Route::post('/antrian_poli/getdisplay', 'AntrianPoliController@getDisplay');
Route::get('/antrian_poli/layarlcd', 'AntrianPoliController@layarlcd')->name('antrian_poli.layarlcd');

// TV1 & TV2 Versi 1

//new antrian poli tv1
// Route::get('/antrian_poli/layarlcd/tv1', 'AntrianPoliController@layarlcdtv1')->name('antrian_poli.layarlcdtv1');

//new antrian poli tv2
// Route::get('/antrian_poli/layarlcd/tv2', 'AntrianPoliController@layarlcdtv2')->name('antrian_poli.layarlcdtv2');

// TV1 & TV2 Versi 2
//TV1
Route::get('/antrian_poli/tv1', 'AntrianPoliController@layarlcdpolitv1')->name('antrian_poli.layarlcd_poli');

//Poli Anak
Route::get('/antrian_poli/datalayarlcdanak/', 'AntrianPoliController@datalayarlcdanak')->name('antrian_poli.datalayarlcdanak');
//Poli Neurologi(Syaraf)
Route::get('/antrian_poli/datalayarlcdneurologi/', 'AntrianPoliController@datalayarlcdneurologi')->name('antrian_poli.datalayarlcdneurologi');
//Poli Penyakit Dalam
Route::get('/antrian_poli/datalayarlcdpenyakitdalam/', 'AntrianPoliController@datalayarlcdpenyakitdalam')->name('antrian_poli.datalayarlcdpenyakitdalam');
//Poli GERIATRI
Route::get('/antrian_poli/datalayarlcdgeriatri/', 'AntrianPoliController@datalayarlcdgeriatri')->name('antrian_poli.datalayarlcdgeriatri');


//TV2
Route::get('/antrian_poli/tv2', 'AntrianPoliController@layarlcdpolitv2')->name('antrian_poli.layarlcd_poli_2');
//Poli Bedah
Route::get('/antrian_poli/datalayarlcdbedah/', 'AntrianPoliController@datalayarlcdbedah')->name('antrian_poli.datalayarlcdbedah');
//Poli Bidan
Route::get('/antrian_poli/datalayarlcdbidan/', 'AntrianPoliController@datalayarlcdbidan')->name('antrian_poli.datalayarlcdbidan');
//Poli Gigi
Route::get('/antrian_poli/datalayarlcdgigi/', 'AntrianPoliController@datalayarlcdgigi')->name('antrian_poli.datalayarlcdgigi');
//Poli MCU/Karyawan
Route::get('/antrian_poli/datalayarlcdmcu/', 'AntrianPoliController@datalayarlcdmcu')->name('antrian_poli.datalayarlcdmcu');
//Poli THT
Route::get('/antrian_poli/datalayarlcdtht/', 'AntrianPoliController@datalayarlcdtht')->name('antrian_poli.datalayarlcdtht');
//Poli Umum
Route::get('/antrian_poli/datalayarlcdumum/', 'AntrianPoliController@datalayarlcdumum')->name('antrian_poli.datalayarlcdumum');
//Poli Geriatri
Route::get('/antrian_poli/datalayarlcdgeriatri/', 'AntrianPoliController@datalayarlcdgeriatri')->name('antrian_poli.datalayarlcdgeriatri');


// TV1 & TV2 Versi 3 (Update Terbaru)
//TV1
Route::get('/antrian/tv1', 'AntrianPoliController@layarpolitv1')->name('antrian_poli.poli_tv1');

//POLI ANAK
Route::get('/antrian_poli/datalayarlcdanakdiperiksa/', 'AntrianPoliController@datalayarlcdanakdiperiksa')->name('antrian_poli.datalayarlcdanakdiperiksa');
Route::get('/antrian_poli/datalayarlcdanakantrian/', 'AntrianPoliController@datalayarlcdanakantrian')->name('antrian_poli.datalayarlcdanakantrian');
//POLI SYARAF
Route::get('/antrian_poli/datalayarlcdsyarafperiksa/', 'AntrianPoliController@datalayarlcdsyarafperiksa')->name('antrian_poli.datalayarlcdsyarafperiksa');
Route::get('/antrian_poli/datalayarlcdsyarafantrian/', 'AntrianPoliController@datalayarlcdsyarafantrian')->name('antrian_poli.datalayarlcdsyarafantrian');
//POLI PENYAKIT DALAM
Route::get('/antrian_poli/datalayarlcddalamperiksa/', 'AntrianPoliController@datalayarlcddalamperiksa')->name('antrian_poli.datalayarlcddalamperiksa');
Route::get('/antrian_poli/datalayarlcddalamantrian/', 'AntrianPoliController@datalayarlcddalamantrian')->name('antrian_poli.datalayarlcddalamantrian');
//POLI GERIATRI
Route::get('/antrian_poli/datalayarlcdgeriatriperiksa/', 'AntrianPoliController@datalayarlcdgeriatriperiksa')->name('antrian_poli.datalayarlcdgeriatriperiksa');
Route::get('/antrian_poli/datalayarlcdgeriatriantrian/', 'AntrianPoliController@datalayarlcdgeriatriantrian')->name('antrian_poli.datalayarlcdgeriatriantrian');
//TV1
Route::get('/antrian/tv2', 'AntrianPoliController@layarpolitv2')->name('antrian_poli.poli_tv2');
//POLI BEDAH
Route::get('/antrian_poli/layarbedahperiksa/', 'AntrianPoliController@bedahperiksa')->name('antrian_poli.bedahperiksa');
Route::get('/antrian_poli/layarbedahantrian/', 'AntrianPoliController@bedahantrian')->name('antrian_poli.layarbedahantrian');
//POLI KEBIDANAN
Route::get('/antrian_poli/layarbidanperiksa/', 'AntrianPoliController@bidanperiksa')->name('antrian_poli.layarbidanperiksa');
Route::get('/antrian_poli/layarbidanantrian/', 'AntrianPoliController@bidanantrian')->name('antrian_poli.layarbidanantrian');
//POLI GIGI
Route::get('/antrian_poli/layargigiperiksa/', 'AntrianPoliController@gigiperiksa')->name('antrian_poli.layargigiperiksa');
Route::get('/antrian_poli/layargigiantrian/', 'AntrianPoliController@gigiantrian')->name('antrian_poli.layargigiantrian');
//POLI THT
Route::get('/antrian_poli/layarthtperiksa/', 'AntrianPoliController@thtperiksa')->name('antrian_poli.layarthtperiksa');
Route::get('/antrian_poli/layarthtantrian/', 'AntrianPoliController@thtantrian')->name('antrian_poli.layarthtantrian');
//POLI MCU
Route::get('/antrian_poli/layarmcuperiksa/', 'AntrianPoliController@mcuperiksa')->name('antrian_poli.layarmcuperiksa');
Route::get('/antrian_poli/layarmcuantrian/', 'AntrianPoliController@mcuantrian')->name('antrian_poli.layarmcuantrian');

Route::get('/antrian_poli/layarlcd2', 'AntrianPoliController@layarlcd2');
Route::get('/antrian_poli/layarlcd3', 'AntrianPoliController@layarlcd3');
Route::get('/antrian_poli/suara', 'AntrianPoliController@suara')->name('antrian_poli.suara');
Route::get('/antrian_poli/ajax_suara', 'AntrianPoliController@ajaxSuara')->name('antrian_poli.ajax_suara');
Route::get('/antrian_poli/ajax_suara_tv2', 'AntrianPoliController@ajaxSuaraTv2')->name('antrian_poli.ajax_suara_tv2');

// Antrian Versi Baru 24/11/2023
Route::post('/antrian_poliklinik/update/{id}', 'AntrianPoliController@updateStatusPanggil');

Route::get('/antrian_poliklinik/tv1', 'AntrianPoliController@poliklinikTv1');
Route::post('/antrian_poliklinik/tv1', 'AntrianPoliController@ajaxTv1');
Route::get('/antrian_poliklinik/tv1/belum-dipanggil', 'AntrianPoliController@ajaxTv1BelumDipanggil');
Route::get('/antrian_poliklinik/tv2', 'AntrianPoliController@poliklinikTv2');
Route::post('/antrian_poliklinik/tv2', 'AntrianPoliController@ajaxTv2');
Route::get('/antrian_poliklinik/tv2/belum-dipanggil', 'AntrianPoliController@ajaxTv2BelumDipanggil');
Route::get('/antrian_poliklinik/tv3', 'AntrianPoliController@poliklinikTv3');
Route::post('/antrian_poliklinik/tv3', 'AntrianPoliController@ajaxTv3');
Route::get('/antrian_poliklinik/tv3/belum-dipanggil', 'AntrianPoliController@ajaxTv3BelumDipanggil');
Route::get('/antrian_poliklinik/tv4', 'AntrianPoliController@poliklinikTv4');
Route::post('/antrian_poliklinik/tv4', 'AntrianPoliController@ajaxTv4');
Route::get('/antrian_poliklinik/tv4/belum-dipanggil', 'AntrianPoliController@ajaxTv4BelumDipanggil');
Route::get('/antrian_poliklinik/tv5', 'AntrianPoliController@poliklinikTv5');
Route::post('/antrian_poliklinik/tv5', 'AntrianPoliController@ajaxTv5');
Route::get('/antrian_poliklinik/tv5/belum-dipanggil', 'AntrianPoliController@ajaxTv5BelumDipanggil');
Route::get('/antrian_poliklinik/tv6', 'AntrianPoliController@poliklinikTv6');
Route::post('/antrian_poliklinik/tv6', 'AntrianPoliController@ajaxTv6');
Route::get('/antrian_poliklinik/tv6/belum-dipanggil', 'AntrianPoliController@ajaxTv6BelumDipanggil');
Route::get('/antrian_poliklinik/tv7', 'AntrianPoliController@poliklinikTv7');
Route::post('/antrian_poliklinik/tv7', 'AntrianPoliController@ajaxTv7');
Route::get('/antrian_poliklinik/tv7/belum-dipanggil', 'AntrianPoliController@ajaxTv7BelumDipanggil');
Route::get('/antrian_poliklinik/tv8', 'AntrianPoliController@poliklinikTv8');
Route::post('/antrian_poliklinik/tv8', 'AntrianPoliController@ajaxTv8');
Route::get('/antrian_poliklinik/tv8/belum-dipanggil', 'AntrianPoliController@ajaxTv8BelumDipanggil');
Route::get('/antrian_poliklinik/tv9', 'AntrianPoliController@poliklinikTv9');
Route::post('/antrian_poliklinik/tv9', 'AntrianPoliController@ajaxTv9');
Route::get('/antrian_poliklinik/tv9/belum-dipanggil', 'AntrianPoliController@ajaxTv9BelumDipanggil');
Route::get('/antrian_poliklinik/tv10', 'AntrianPoliController@poliklinikTv10');
Route::post('/antrian_poliklinik/tv10', 'AntrianPoliController@ajaxTv10');
Route::get('/antrian_poliklinik/tv10/belum-dipanggil', 'AntrianPoliController@ajaxTv10BelumDipanggil');
Route::get('/antrian_poliklinik/tv11', 'AntrianPoliController@poliklinikTv11');
Route::post('/antrian_poliklinik/tv11', 'AntrianPoliController@ajaxTv11');
Route::get('/antrian_poliklinik/tv11/belum-dipanggil', 'AntrianPoliController@ajaxTv11BelumDipanggil');

// Antrian PoliKlinik Per Poli 19/02/2024
Route::get('/antrian_poliklinik/poli/{poli_id}', 'AntrianPoliController@displayAntrianPerPoli');
Route::post('/antrian_poliklinik/get-current-call', 'AntrianPoliController@ajaxAntrianPerPoli');
Route::get('/antrian_poliklinik/belum-dipanggil/{poli_id}', 'AntrianPoliController@ajaxAntrianPerPoliBP');

// Antrian PoliKlinik Jantung & Dalam
Route::get('/antrian_poliklinik/jantung_dalam', 'AntrianPoliController@antrianPoliJantungDalam');
Route::post('/antrian_poliklinik/jantung_dalam/get-current-call', 'AntrianPoliController@ajaxAntrianJantungDalam');
Route::get('/antrian_poliklinik/jantung_dalam/belum-dipanggil', 'AntrianPoliController@ajaxAntrianBPJantungDalam');

Route::view('antrian-farmasi', 'antrianfarmasi.index');
Route::post('/antrianfarmasi/savetouch', 'AntrianFarmasiController@savetouch')->name('antrianfarmasi.savetouch');
Route::get('/antrian-farmasi/touch', 'AntrianFarmasiController@touch')->name('antrianfarmasi.touch');
Route::get('antrian-farmasi/suara', 'AntrianFarmasiController@suara')->name('antrianfarmasi.suara');
Route::get('antrian-farmasi/layarlcd', 'AntrianFarmasiController@layarlcd')->name('antrianfarmasi.layarlcd');

Route::get('antrian-farmasi/print', 'AntrianFarmasiController@printAntrian');
Route::get('antrian-farmasi/layarlcd/nextantrian', 'AntrianFarmasiController@antrianLayarLCD');

// Route::get('/datalayarlcd', 'AntrianController@datalayarlcd')->name('antrian.datalayarlcd');
// Route::get('/registrasi/{id}/{jenis?}', 'AntrianController@registrasi');
// Route::get('/reg_pasienlama/{id}/{jenis?}', 'AntrianController@reg_pasienlama');
// Route::get('/reg_blmterdata/{id}/{jenis?}', 'AntrianController@reg_blm_terdata');

Route::get('antrianfarmasi/', 'AntrianFarmasiController@touch')->name('antrianfarmasi');
#ANTRIAN LOKET 1
Route::get('antrian-farmasi/daftarpanggil1', 'AntrianFarmasiController@daftarpanggil1')->name('antrianfarmasi.daftarpanggil1'); //Data
Route::get('antrian-farmasi/daftarantrian1', 'AntrianFarmasiController@daftarantrian1')->name('antrianfarmasi.daftarantrian1'); //Halaman Daftar Antrian
Route::get('antrian-farmasi/ajaxPasien', 'AntrianFarmasiController@ajaxPasien');
Route::get('antrian-farmasi/insert-reg/{reg_id}/{antrian_id}', 'AntrianFarmasiController@insertReg');

Route::get('antrian-farmasi/panggil1/{id}', 'AntrianFarmasiController@panggil1')->name('antrianfarmasi.panggil1');
Route::get('antrian-farmasi/panggilkembali1/{id}', 'AntrianFarmasiController@panggilkembali1')->name('antrianfarmasi.panggilkembali1');
Route::get('antrian-farmasi/panggilselesai/{id}', 'AntrianFarmasiController@panggilSelesai')->name('antrianfarmasi.panggilselesai');
Route::get('antrian-farmasi/datalayarlcd1', 'AntrianFarmasiController@datalayarlcd1')->name('antrianfarmasi.datalayarlcd1');


#ANTRIAN LOKET 2
Route::get('antrian-farmasi/daftarpanggil2', 'AntrianFarmasiController@daftarpanggil2')->name('antrianfarmasi.daftarpanggil2'); //Data
Route::get('antrian-farmasi/daftarantrian2', 'AntrianFarmasiController@daftarantrian2')->name('antrianfarmasi.daftarantrian2'); //Halaman Daftar Antrian
Route::get('antrian-farmasi/panggil2/{id}', 'AntrianFarmasiController@panggil2')->name('antrianfarmasi.panggil2');
Route::get('antrian-farmasi/panggilkembali2/{id}', 'AntrianFarmasiController@panggilkembali2')->name('antrianfarmasi.panggilkembali2');
Route::get('antrian-farmasi/datalayarlcd2', 'AntrianFarmasiController@datalayarlcd2')->name('antrianfarmasi.datalayarlcd2');

#ANTRIAN LOKET 3
Route::get('antrian-farmasi/daftarpanggil3', 'AntrianFarmasiController@daftarpanggil3')->name('antrianfarmasi.daftarpanggil3'); //Data
Route::get('antrian-farmasi/daftarantrian3', 'AntrianFarmasiController@daftarantrian3')->name('antrianfarmasi.daftarantrian3'); //Halaman Daftar Antrian
Route::get('antrian-farmasi/panggil3/{id}', 'AntrianFarmasiController@panggil3')->name('antrianfarmasi.panggil3');
Route::get('antrian-farmasi/panggilkembali3/{id}', 'AntrianFarmasiController@panggilkembali3')->name('antrianfarmasi.panggilkembali3');
Route::get('antrian-farmasi/datalayarlcd3', 'AntrianFarmasiController@datalayarlcd3')->name('antrianfarmasi.datalayarlcd3');

#ANTRIAN LOKET 4
Route::get('antrian-farmasi/daftarpanggil4', 'AntrianFarmasiController@daftarpanggil4')->name('antrianfarmasi.daftarpanggil4'); //Data
Route::get('antrian-farmasi/daftarantrian4', 'AntrianFarmasiController@daftarantrian4')->name('antrianfarmasi.daftarantrian4'); //Halaman Daftar Antrian
Route::get('antrian-farmasi/panggil4/{id}', 'AntrianFarmasiController@panggil4')->name('antrianfarmasi.panggil4');
Route::get('antrian-farmasi/panggilkembali4/{id}', 'AntrianFarmasiController@panggilkembali4')->name('antrianfarmasi.panggilkembali4');
Route::get('antrian-farmasi/datalayarlcd4', 'AntrianFarmasiController@datalayarlcd4')->name('antrianfarmasi.datalayarlcd4');




include __DIR__ . '/simrs/antrianrawatinap.php';




















//Informasi E-Resep To Pasien V1
Route::get('/display/eresep/jalan', 'FarmasiController@displaylcderesep');

//Informasi E-Resep To Pasien V2
Route::get('/farmasi/data-lcd-eresep-pasien-new/{unit?}', 'FarmasiController@datalcdereseppasiennew')->name('farmasi.data_lcd_eresep_pasien_new');
Route::get('/farmasi/display/eresep-new/{unit?}', 'FarmasiController@lcdereseppasiennew');


Route::get('/farmasi/data-lcd-eresep-pasien/{unit?}', 'FarmasiController@datalcdereseppasien')->name('farmasi.data_lcd_eresep_pasien');
Route::get('/farmasi/data-lcd-eresep-pasien-umum/{unit?}', 'FarmasiController@datalcdereseppasienumum')->name('farmasi.data_lcd_eresep_pasien_umum');
Route::get('/informasi/{unit?}', 'FarmasiController@lcdereseppasien');
Route::get('/farmasi/display-data-lcd-eresep/{unit?}', 'FarmasiController@datalcdereseppasien')->name('farmasi.data_lcd_eresep_pasien');
Route::get('/farmasi/display-data-lcd-eresep-umum/{unit?}', 'FarmasiController@datalcdereseppasienumum')->name('farmasi.data_lcd_eresep_pasien_umum');
Route::get('/farmasi/display/eresep/{unit?}', 'FarmasiController@lcdereseppasien');
Route::get('/farmasi/display/eresep_umum/{unit?}', 'FarmasiController@lcdereseppasienumum');
Route::get('/farmasi/suara/eresep/{unit?}', 'FarmasiController@suaraereseppasien');
Route::get('/farmasi/suara-data/eresep/{unit?}', 'FarmasiController@datasuaraereseppasien')->name('farmasi.data_suara_eresep_pasien');

// include __DIR__ . '/simrs/antrianfarmasi.php';

Route::group(['middleware' => ['web', 'auth']], function () {
	include __DIR__ . '/simrs/refbpjs.php';
	include __DIR__ . '/simrs/ajax.php';
	include __DIR__ . '/simrs/satusehat.php';
	include __DIR__ . '/simrs/esign.php';
	include __DIR__ . '/simrs/obatantibiotik.php';
	include __DIR__ . '/simrs/signaturepad.php';
	include __DIR__ . '/simrs/kasir.php';
	include __DIR__ . '/simrs/kontrolpanel.php';
	include __DIR__ . '/simrs/import.php';
	include __DIR__ . '/simrs/laboratoriumCommon.php';
	include __DIR__ . '/simrs/pemeriksaanlabCommon.php';
	include __DIR__ . '/simrs/frontoffice.php';
	include __DIR__ . '/simrs/igd.php';
	include __DIR__ . '/simrs/sipeka.php';
	include __DIR__ . '/simrs/rawatjalan.php';
	include __DIR__ . '/simrs/farmasi.php';
	include __DIR__ . '/simrs/rawatinap.php';
	include __DIR__ . '/simrs/admisi.php';
	include __DIR__ . '/simrs/operasi.php';
	include __DIR__ . '/simrs/radiologi_gigi.php';
	include __DIR__ . '/simrs/radiologi.php';
	include __DIR__ . '/simrs/echocardiogram.php';
	include __DIR__ . '/simrs/spri.php';
	include __DIR__ . '/simrs/laboratorium.php';
	include __DIR__ . '/simrs/bdrs.php';
	include __DIR__ . '/simrs/tahuntarif.php';
	include __DIR__ . '/simrs/kelompoktarif.php';
	include __DIR__ . '/simrs/biayaregistrasi.php';
	include __DIR__ . '/simrs/dokter.php';
	include __DIR__ . '/simrs/pemeriksaanlab.php';
	include __DIR__ . '/simrs/penjualan.php';
	include __DIR__ . '/simrs/masterobat.php';
	include __DIR__ .  '/simrs/ppi.php';
	include __DIR__ . '/simrs/android.php';

	include __DIR__ . '/simrs/mastersplit.php';
	include __DIR__ . '/simrs/regperjanjian.php';
	include __DIR__ . '/simrs/bridging.php';
	include __DIR__ . '/simrs/fasilitas.php';
	include __DIR__ . '/simrs/gizi.php';
	include __DIR__ . '/simrs/slideshow.php';
	include __DIR__ . '/simrs/sep.php';
	include __DIR__ . '/simrs/direksi.php';
	include __DIR__ . '/simrs/inacbg.php';
	include __DIR__ . '/simrs/mastermapping.php';
	include __DIR__ . '/simrs/masteridrg.php';
	include __DIR__ . '/simrs/masterpagu.php';
	include __DIR__ . '/simrs/mapping.php';
	include __DIR__ . '/simrs/idrg.php';
	include __DIR__ . '/simrs/kelompokkelas.php';
	include __DIR__ . '/simrs/mapping_biaya.php';
	include __DIR__ . '/simrs/idrg_biaya.php';
	include __DIR__ . '/simrs/bridgingsep.php';
	include __DIR__ . '/simrs/histori_user.php';
	include __DIR__ . '/simrs/logistikmedik.php';
	include __DIR__ . '/simrs/peminjamanobat.php';
	include __DIR__ . '/simrs/pengembalianobat.php';
	include __DIR__ . '/simrs/logistiknonmedik.php';
	include __DIR__ . '/simrs/test.php';
	include __DIR__ . '/simrs/tools.php';
	include __DIR__ . '/simrs/returobatrusak.php';
	include __DIR__ . '/simrs/copyresep.php';
	include __DIR__ . '/simrs/saderek.php';
	include __DIR__ . '/simrs/mappingrl.php';
	include __DIR__ . '/simrs/emr.php';
	include __DIR__ . '/simrs/ris.php';
	include __DIR__ . '/simrs/hais.php';
	include __DIR__ . '/simrs/biayapemeriksaan.php';
	include __DIR__ . '/simrs/biayapemeriksaanmcu.php';
	include __DIR__ . '/simrs/biayapemeriksaaninfus.php';
	include __DIR__ . '/simrs/biayapemeriksaanfarmasi.php';

	// Tambahan Agus
	include __DIR__ . '/simrs/hrd.php';
	include __DIR__ . '/simrs/hemodialisa.php';
	include __DIR__ . '/simrs/pemulasaran_jenazah.php';
	include __DIR__ . '/simrs/protesagigi.php';
	include __DIR__ . '/simrs/sirs.php';
	include __DIR__ . '/simrs/rehabmedik.php';
	include __DIR__ . '/simrs/rekaplaporan.php';

	// Askep
	include __DIR__ . '/simrs/diagnosakeperawatan.php';
	include __DIR__ . '/simrs/intervensikeperawatan.php';
	include __DIR__ . '/simrs/implementasikeperawatan.php';

	// ICD IM
	include __DIR__ . '/simrs/icd9im.php';
	include __DIR__ . '/simrs/icd10im.php';
	include __DIR__ . '/simrs/icdoim.php';

	// Snomed CT
	include __DIR__ . '/simrs/snomed_ct.php';


	Route::resource('jadwal-dokter', 'JadwaldokterController');
	Route::get('hapus-jadwal/{id}', 'JadwaldokterController@hapusJadwal');

	//BPJS
	Route::view('modul-bpjs', 'bpjs.laporanrekammedis');

	//HRD
	include __DIR__ . '/hrd/mutasi.php';
	include __DIR__ . '/hrd/biodata.php';
	include __DIR__ . '/hrd/keluarga.php';
	include __DIR__ . '/hrd/pendidikan.php';
	include __DIR__ . '/hrd/kepangkatan.php';
	include __DIR__ . '/hrd/jabatan.php';
	include __DIR__ . '/hrd/gaji_berkala.php';
	include __DIR__ . '/hrd/penghargaan.php';
	include __DIR__ . '/hrd/gapok.php';
	include __DIR__ . '/hrd/cuti.php';
	include __DIR__ . '/hrd/ijin_belajar.php';
	include __DIR__ . '/hrd/disiplin.php';
	include __DIR__ . '/hrd/administrasi.php';

	// Route::resource('anak', 'AnakController');
	//Resume Pasien
	Route::get('/debug-otista/{status}', 'DebugController@toggle');
	Route::get('resume-medis/{unit}/{registrasi_id}', 'ResumePasienController@create');
	Route::get('cetak-rencana-kontrol/{registrasi_id}', 'ResumePasienController@cetakRencanaKontrol');
	Route::post('save-resume-medis', 'ResumePasienController@save');
	Route::post('save-data-sep', 'ResumePasienController@saveDataSep');
	Route::post('tte-surkon', 'ResumePasienController@tteSurkon');
	Route::get('cetak-resume-medis/{registrasi_id}', 'ResumePasienController@cetakResume');
	Route::delete('resume-medis/{id}', 'ResumePasienController@deleteResume');
	Route::get('cetak-resume-medis/pdf/{registrasi_id}', 'ResumePasienController@cetakPDFResume');
	Route::match(['get', 'post'],'cetak-resume-medis-rencana-kontrol/pdf/{registrasi_id}/{id}', 'ResumePasienController@cetakPDFResumeRencanaKontrol');
	Route::match(['get', 'post'],'cetak-resume-medis-rencana-kontrol-obgyn/pdf/{registrasi_id}/{id}', 'ResumePasienController@cetakPDFResumeRencanaKontrolObgyn');
	Route::match(['get', 'post'],'cetak-resume-medis-rencana-kontrol-gigi/pdf/{registrasi_id}/{id}', 'ResumePasienController@cetakPDFResumeRencanaKontrolGigi');
	Route::match(['get', 'post'],'cetak-resume-medis-rencana-kontrol-gizi/pdf/{registrasi_id}/{id}', 'ResumePasienController@cetakPDFResumeRencanaKontrolGizi');
	Route::match(['get', 'post'],'cetak-resume-medis-rencana-kontrol-rehab-medik/pdf/{registrasi_id}/{id}', 'ResumePasienController@cetakPDFResumeRencanaKontrolRehabMedik');
	Route::match(['get', 'post'],'cetak-resume-medis-rencana-kontrol-mata/pdf/{registrasi_id}/{id}', 'ResumePasienController@cetakPDFResumeRencanaKontrolMata');
	Route::match(['get', 'post'],'cetak-resume-medis-rencana-kontrol-paru/pdf/{registrasi_id}/{id}', 'ResumePasienController@cetakPDFResumeRencanaKontrolParu');
	Route::match(['get', 'post'],'cetak-resume-medis-rencana-kontrol-mcu/pdf/{registrasi_id}/{id}', 'ResumePasienController@cetakPDFResumeRencanaKontrolMCU');
	Route::match(['get', 'post'],'cetak-resume-medis-rencana-kontrol-hemodialisis/pdf/{registrasi_id}/{id}', 'ResumePasienController@cetakPDFResumeRencanaKontrolHemodialisis');
	Route::get('cetak-eresume-medis/pdf/{registrasi_id}/{id}', 'ResumePasienController@cetakPDFEresume');
	Route::get('cetak-tte-eresume-medis/pdf/{id}', 'ResumePasienController@cetakTTEPDFResumeMedis');
	Route::get('cetak-asesmen-igd/pdf/{registrasi_id}/{id}', 'ResumePasienController@cetakAsesmenIGD');
	Route::get('cetak-asesmen-bidan-igd-ponek/pdf/{registrasi_id}/{id}', 'ResumePasienController@cetakAsesmenBidanPonek');
	Route::get('cetak-triage-igd/pdf/{registrasi_id}/{id}', 'ResumePasienController@cetakTriageIGD');
	Route::get('cetak-treadmill/pdf/{id}', 'ResumePasienController@cetakPDFTreadmill');
	Route::get('cetak-eresume-medis/pdf-cek-tte/{id}', 'ResumePasienController@tteResume');
	Route::get('cetak-layanan-rehab/pdf/{registrasi_id}/{id}', 'ResumePasienController@cetakPDFLayananRehab');
	Route::get('cetak-all-layanan-rehab/pdf/{registrasi_id}/{pasien_id}', 'ResumePasienController@cetakAllPDFLayananRehab');
	Route::get('cetak-tte-layanan-rehab/pdf/{registrasi_id}/{id}', 'ResumePasienController@cetakTTEPDFLayananRehab');
	Route::get('cetak-tte-program-terapi/pdf/{registrasi_id}/{id}', 'ResumePasienController@cetakTTEPDFProgramTerapi');
	Route::get('cetak-program-terapi/pdf/{registrasi_id}/{id}', 'ResumePasienController@cetakPDFProgramTerapi');
	Route::get('cetak-all-program-terapi/pdf/{registrasi_id}/{pasien_id}', 'ResumePasienController@cetakAllPDFProgramTerapi');
	Route::get('cetak-tte-uji-fungsi/pdf/{registrasi_id}/{id}', 'ResumePasienController@cetakTTEPDFUjiFungsi');
	Route::get('cetak-uji-fungsi/pdf/{registrasi_id}/{id}', 'ResumePasienController@cetakPDFUjiFungsi');
	Route::get('cetak-all-uji-fungsi/pdf/{registrasi_id}/{pasien_id}', 'ResumePasienController@cetakAllPDFUjiFungsi');
	Route::get('cetak-tte-rehab-baru/pdf/{registrasi_id}/{id}', 'ResumePasienController@cetakTTEPDFRehabBaru');
	Route::get('cetak-rehab-baru/pdf/{registrasi_id}/{id}', 'ResumePasienController@cetakPDFRehabBaru');
	Route::get('cetak-all-rehab-baru/pdf/{registrasi_id}/{pasien_id}', 'ResumePasienController@cetakAllPDFRehabBaru');
	Route::get('cetak-eresume-pasien/pdf/{regId}', 'ResumePasienController@cetakPDFResumeRegistrasi');
	Route::get('cetak-eresume-pasien-inap/pdf/{regId}', 'ResumePasienController@cetakPDFResumeRanap');
	Route::get('cetak-eresume-pasien-igd/pdf/{regId}', 'ResumePasienController@cetakPDFResumeIGD');
	Route::get('cetak-tte-eresume-pasien/pdf/{regId}', 'ResumePasienController@cetakTTEPDFResumeRegistrasi');
	Route::get('cetak-tte-eresume-pasien-inap/pdf/{regId}', 'ResumePasienController@cetakTTEPDFResumeRanap');
	Route::get('cetak-tte-eresume-pasien-igd/pdf/{regId}', 'ResumePasienController@cetakTTEPDFResumeIGD');
	Route::get('cetak-treadmill-tte/pdf/{treadmill_id}', 'ResumePasienController@cetakTTEPDFTreadmill');
	Route::get('cetak-asuhan-keperawatan/pdf/{registrasi_id}/{id}', 'ResumePasienController@cetakPDFAskep');
	Route::get('cetak-asuhan-kebidanan/pdf/{registrasi_id}/{id}', 'ResumePasienController@cetakPDFAskeb');
	Route::get('cetak-formulir-edukasi-pasien-keluarga/pdf/{registrasi_id}/{id}', 'ResumePasienController@cetakEdukasiPasienKeluarga');
	Route::get('cetak-formulir-surveilans-infeksi/pdf/{registrasi_id}/{id}', 'ResumePasienController@cetakFormSurveilansInfeksi');
	Route::get('cetak-ews-dewasa/pdf/{registrasi_id}/{id}', 'ResumePasienController@cetakEwsDewasa');
	Route::get('cetak-ews-anak/pdf/{registrasi_id}/{id}', 'ResumePasienController@cetakEwsAnak');
	Route::get('cetak-ews-maternitas/pdf/{registrasi_id}/{id}', 'ResumePasienController@cetakEwsMaternitas');
	Route::get('cetak-ews-neonatus/pdf/{registrasi_id}/{id}', 'ResumePasienController@cetakEwsNeonatus');
	
	// TTE
	Route::post('tte-pdf-layanan-rehab', 'ResumePasienController@ttePDFLayananRehab');
	Route::post('tte-pdf-program-terapi', 'ResumePasienController@ttePDFProgramTerapi');
	Route::post('tte-pdf-uji-fungsi', 'ResumePasienController@ttePDFUjiFungsi');
	Route::post('tte-pdf-rehab-baru', 'ResumePasienController@ttePDFRehabBaru');
	Route::post('tte-pdf-eresume-medis', 'ResumePasienController@ttePDFResumeMedis');
	Route::post('tte-pdf-treadmill', 'ResumePasienController@ttePDFTreadmill');
	Route::post('tte-pdf-eresume-pasien', 'ResumePasienController@ttePDFResumeRegistrasi');
	Route::post('tte-pdf-eresume-pasien-igd', 'ResumePasienController@ttePDFResumeIGD');
	Route::post('tte-pdf-eresume-pasien-inap', 'ResumePasienController@ttePDFResumeRanap');
	Route::post('tte-pdf-ews', 'ResumePasienController@ttePDFEWS');

	// GIZI
	Route::match(['get', 'post'], 'cetak-cppt-gizi/pdf/{registrasi_id}/{id}', 'ResumeGiziController@cetakPDFCPPT');
	Route::match(['get', 'post'], 'cetak-skrining-gizi-dewasa/pdf/{registrasi_id}/{id}', 'ResumeGiziController@cetakSkriningGiziDewasa');
	Route::match(['get', 'post'], 'cetak-skrining-gizi-anak/pdf/{registrasi_id}/{id}', 'ResumeGiziController@cetakSkriningGiziAnak');
	Route::match(['get', 'post'], 'cetak-skrining-gizi-maternitas/pdf/{registrasi_id}/{id}', 'ResumeGiziController@cetakSkriningGiziMaternitas');
	Route::match(['get', 'post'], 'cetak-skrining-gizi-perinatologi/pdf/{registrasi_id}/{id}', 'ResumeGiziController@cetakSkriningGiziPerinatologi');
	Route::match(['get', 'post'], 'cetak-pengkajian-gizi/pdf/{registrasi_id}/{id}', 'ResumeGiziController@cetakPengkajianGizi');
	
	// Convert PDF
	Route::get('convert-pdf', 'ResumePasienController@convertPDF');
	Route::post('convert-pdf', 'ResumePasienController@convertPDF_by');

	//Pendaftaran Online
	Route::get('pendaftaran/data-pendaftaran-online', 'PendaftaranController@dataPendaftaranOnline');
	Route::get('pendaftaran/pendaftaran-online', 'PendaftaranController@dataPendaftar');
	Route::post('pendaftaran/pendaftaran-online', 'PendaftaranController@dataFilterPendaftar');
	Route::get('pendaftaran/regPendaftaran/{id}', 'PendaftaranController@regPendaftaran');
	Route::get('pendaftaran/batalRegPendaftaran/{id}', 'PendaftaranController@batalRegPendaftaran');
	Route::get('pendaftaran/cetak_pendaftaran', 'PendaftaranController@cetak_pendaftaran');
});
include __DIR__ . '/simrs/aplicare.php';

//DASHBOARD
Route::get('dashboard/updateMappingFolio', 'DashboardController@updateMappingFolio');
Route::get('dashboard', 'DashboardController@index');
Route::post('dashboard', 'DashboardController@dataDashboard');
Route::get('status-bed', 'DashboardController@statusBed');
Route::get('diagnosa', 'DashboardController@diagnosa');
Route::post('diagnosa', 'DashboardController@diagnosaByTanggal');
Route::get('pengunjung', 'DashboardController@pengunjung');
Route::post('pengunjung', 'DashboardController@pengunjungByTanggal');
Route::resource('phoneBook', 'PhoneBookController')->except('create', 'show', 'destroy');

//PENDAFTARAN
Route::get('pendaftaran/cek-pasien/{no_rm}/{tgl}', 'PendaftaranController@cekPasien');
Route::get('pendaftaran', 'PendaftaranController@index');
Route::view('pendaftaran/resumePendaftaran', 'pendaftaran.resumePendaftaran');

Route::post('pendaftaran/store', 'PendaftaranController@store');
Route::put('pendaftaran/saveRegOnline/{id}/{dummy}', 'PendaftaranController@saveRegOnline');

Route::get('pendaftaran/checkNoRm/{no_rm}/{tgl_lahir}', 'PendaftaranController@checkNoRm');

//LANDING PAGE
Route::get('ajax/{type}', 'AjaxController@index');
Route::post('ajax/saveDokterPerujuk', 'AjaxController@saveDokterPerujuk');
Route::post('ajax/savePuskesmas', 'AjaxController@savePuskesmas');
Route::post('ajax/DokterPerujuk/{id}', 'AjaxController@updateDokterPerujuk');
Route::post('ajax/Puskesmas/{id}', 'AjaxController@updatePuskesmas');
Route::delete('ajax/DokterPerujuk/{id}', 'AjaxController@deleteDokterPerujuk');
Route::delete('ajax/Puskesmas/{id}', 'AjaxController@deletePuskesmas');

//PARKIR
Route::get('parkir', 'ParkirController@index');
Route::post('parkir-save', 'ParkirController@store');
Route::get('parkir/data-parkir', 'ParkirController@dataParkir');
Route::get('parkir/parkir-cetak/{id}', 'ParkirController@parkirCetak');
Route::get('parkir/parkir-batal/{id}', 'ParkirController@parkirBatal');

//BRIVA
Route::group(['prefix' => 'briva'], function () {
	Route::get('get-token', 'BrivaController@getToken');
	Route::get('create', 'BrivaController@createVA');
});

//LANDING PAGE
Route::get('display-kamar', 'Api\LandingController@displayKamar');

//Sisrute
Route::view('display-sisrute', 'sisrute.index');

// Module Android

// Test Signature Pad
Route::get('signaturepad', 'SignatureController@index');
Route::post('signaturepad', 'SignatureController@upload')->name('signaturepad.upload');

// Export pasien (Temp)
Route::get('export-pasien/dokter/{dokter_id}', '\Modules\Pasien\Http\Controllers\PasienController@exportPasienbyDokter');