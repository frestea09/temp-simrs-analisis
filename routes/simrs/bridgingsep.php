<?php

Route::get('bridgingsep', 'BridgingSEPController@index');
Route::post('bridgingsep/pengajuan', 'BridgingSEPController@pengajuanSEP');
Route::get('bridgingsep/approveSEP/{id}', 'BridgingSEPController@approveSEP');
Route::post('bridgingsep/updateTanggalPulang', 'BridgingSEPController@updateTanggalPulang');
Route::get('bridgingsep/sepHapus/{sep}', 'BridgingSEPController@sepHapus');
Route::post('bridgingsep/cariSep', 'BridgingSEPController@cariSep');
Route::get('bridgingsep/data-kunjungan', 'BridgingSEPController@dataKunjungan');
Route::post('bridgingsep/data-kunjungan', 'BridgingSEPController@cariDataKunjungan');
Route::get('bridgingsep/updateBed', 'BridgingSEPController@updateBed');
Route::get('bridgingsep/histori-kunjungan', 'BridgingSEPController@historiKunjungan');
Route::post('bridgingsep/histori-kunjungan', 'BridgingSEPController@cariHistoriKunjungan');

Route::get('bridgingsep/laporan-taskid', 'BridgingSEPController@laporanTaskId');
Route::post('bridgingsep/laporan-taskid', 'BridgingSEPController@laporanTaskId');
// RUJUKAN PPK 1
Route::get('bridgingsep/referensi-kelas', 'BridgingSEPController@referensiKelas');
Route::post('bridgingsep/insert-rujukan', 'BridgingSEPController@insertRujukan');
Route::post('bridgingsep/insert-rujukan-2', 'BridgingSEPController@insertRujukan2');
Route::get('bridgingsep/update-rujukan', 'BridgingSEPController@viewUpdateRujukan');
Route::post('bridgingsep/update-rujukan', 'BridgingSEPController@viewUpdateRujukan');

//RUJUKAN PPK 2
Route::post('bridgingsep/insert-rujukan-rs', 'BridgingSEPController@rujukanPPK2');
Route::post('bridgingsep/insert-rujukan-rs-byrujukan', 'BridgingSEPController@rujukanPPK2byNomorRujukan');
Route::get('bridgingsep/get-kode-ppk2', 'BridgingSEPController@getKodePPK2');
Route::get('bridgingsep/get-diagnosa/', 'BridgingSEPController@getDiagnosa');
Route::get('bridgingsep/get-poliRujukan', 'BridgingSEPController@getPoliRujukan');
Route::get('bridgingsep/get-poli-lanjutan', 'BridgingSEPController@getKodePPK2');

//POS HD
Route::post('bridgingsep/pos-hd', 'BridgingSEPController@postHD');

//REFERENSI
Route::get('bridgingsep/dokter-bpjs/{kode}', 'BridgingSEPController@dokterBPJS');

//GET PENGAJUAN SEP
Route::get('bridgingsep/data-pengajuan-sep', 'BridgingSEPController@dataPengajuanSEP');

//Update SEP
Route::get('bridgingsep/get-dokter-dpjp', 'BridgingSEPController@getDokter');

//Cetak Rujukan
Route::get('bridgingsep/cetak-rujukan/{noSep}', 'BridgingSEPController@cetakRujukan');

// create surat kontrol
Route::post('bridgingsep/buat-surat-kontrol', 'BridgingSEPController@buatSuratKontrol');
Route::post('bridgingsep/hapus-surat-kontrol', 'BridgingSEPController@hapusSuratKontrol');

//Laporan Klaim
Route::view('bridgingsep/data-klaim', 'bridgingsep.data_klaim');
Route::post('bridgingsep/data-klaim', 'BridgingSEPController@dataKlaim');
Route::post('bridgingsep/data-klaim/pdf', 'BridgingSEPController@getDataKlaim');


Route::get('bridgingsep/get-ppk/{nama_ppk}', 'BridgingSEPController@getPpk');
Route::get('bridgingsep/kode-ppk/{nama_ppk}', 'BridgingSEPController@kodePpk');

// Jadwal dokter
Route::get('bridgingsep/cek-perbooking/{kode}', 'BridgingReferensiController@cekBooking');
Route::get('bridgingsep/jadwal-dokter', 'BridgingReferensiController@jadwalDokter');
Route::post('bridgingsep/jadwal-dokter', 'BridgingReferensiController@jadwalDokter');

// Jadwal dokter HFIS
Route::get('bridgingsep/jadwal-dokter-hfis', 'BridgingReferensiController@jadwalDokterHfis');
Route::post('bridgingsep/jadwal-dokter-hfis', 'BridgingReferensiController@jadwalDokterHfis');

// Rujukan spesialistik
Route::get('bridgingsep/rujukan-spesialistik', 'BridgingReferensiController@rujukanSpesialistik');
Route::post('bridgingsep/rujukan-spesialistik', 'BridgingReferensiController@rujukanSpesialistik');

Route::get('bridgingsep/jadwal-spesialistik', 'BridgingReferensiController@jadwalSpesialistik');
Route::post('bridgingsep/jadwal-spesialistik', 'BridgingReferensiController@jadwalSpesialistik');

Route::get('bridgingsep/sep-rk-spri', 'BridgingReferensiController@SepRkSpri');
Route::post('bridgingsep/sep-rk-spri', 'BridgingReferensiController@SepRkSpri');

// I-CARE
Route::get('bridgingsep/icare', 'BridgingReferensiController@icare');
Route::post('bridgingsep/icare', 'BridgingReferensiController@icare');

// SEP INTERNAL
Route::get('bridgingsep/hapus-sep-internal', 'BridgingReferensiController@hapusSepInternal');
Route::post('bridgingsep/hapus-sep-internal', 'BridgingReferensiController@hapusSepInternal');


Route::get('bridgingsep/antrian-belum-dilayani', 'BridgingReferensiController@antrianBelumDilayani');
Route::post('bridgingsep/antrian-belum-dilayani', 'BridgingReferensiController@antrianBelumDilayani');

Route::get('bridgingsep/antrian-belum-dilayani-poli', 'BridgingReferensiController@antrianBelumDilayaniPoli');
Route::post('bridgingsep/antrian-belum-dilayani-poli', 'BridgingReferensiController@antrianBelumDilayaniPoli');

Route::get('bridgingsep/sep-rencana-kontrol', 'BridgingReferensiController@SepRencanaKontrol');
Route::post('bridgingsep/sep-rencana-kontrol', 'BridgingReferensiController@SepRencanaKontrol');


Route::get('bridgingsep/sep-rencana-kontrol-no-kartu', 'BridgingReferensiController@SepRencanaKontrolNoKartu');
Route::post('bridgingsep/sep-rencana-kontrol-no-kartu', 'BridgingReferensiController@SepRencanaKontrolNoKartu');

Route::get('bridgingsep/sep-internal', 'BridgingReferensiController@sepInternal');
Route::post('bridgingsep/sep-internal', 'BridgingReferensiController@sepInternal');

Route::get('bridgingsep/hapus-antrol', 'BridgingReferensiController@hapusAntrol');
Route::get('bridgingsep/hapus-antrol-rujukan/{no}/{tgl}', 'BridgingReferensiController@hapusAntrolRujukan');
Route::post('bridgingsep/hapus-antrol', 'BridgingReferensiController@hapusAntrol');

Route::get('bridgingsep/tambah-pasien-antrol', 'BridgingReferensiController@tambahPasienAntrol');
Route::post('bridgingsep/tambah-pasien-antrol', 'BridgingReferensiController@tambahPasienAntrol');

//SINKRON TASKID
Route::get('bridgingsep/sinkron-taskid', 'BridgingReferensiController@sinkronTaskId');
Route::post('bridgingsep/sinkron-taskid', 'BridgingReferensiController@sinkronTaskId');

//SINKRON TASKID BY TANGGAL
Route::get('bridgingsep/sinkron-taskid-tgl', 'BridgingReferensiController@sinkronTaskIdTgl');
Route::post('bridgingsep/sinkron-taskid-tgl', 'BridgingReferensiController@sinkronTaskIdTgl');

Route::get('bridgingsep/suplesi', 'BridgingReferensiController@suplesi');
Route::post('bridgingsep/suplesi', 'BridgingReferensiController@suplesi');

Route::get('bridgingsep/fingerprint', 'BridgingReferensiController@fingerprint');
Route::post('bridgingsep/fingerprint', 'BridgingReferensiController@fingerprint');

Route::get('bridgingsep/view-fingerprint', 'BridgingReferensiController@viewFingerprint');
Route::post('bridgingsep/view-fingerprint', 'BridgingReferensiController@viewFingerprint');

Route::get('bridgingsep/rujukan-khusus', 'BridgingReferensiController@rujukanKhusus');
Route::post('bridgingsep/rujukan-khusus', 'BridgingReferensiController@rujukanKhusus');

Route::get('bridgingsep/sarana-rujukan', 'BridgingReferensiController@saranaRujukan');
Route::post('bridgingsep/sarana-rujukan', 'BridgingReferensiController@saranaRujukan');

Route::post('bridgingsep/edit-spri', 'BridgingReferensiController@editSpri');
Route::post('bridgingsep/update-spri', 'BridgingReferensiController@updateSpri');

// PRB
Route::get('bridgingsep/rujuk-balik', 'BridgingPRBController@prb');
Route::post('bridgingsep/rujuk-balik', 'BridgingPRBController@prb_search');
Route::get('bridgingsep/rujuk-balik/{reg_id}/{id?}', 'BridgingPRBController@prb_proses');
Route::get('bridgingsep/cetak-rujuk-balik/{reg_id}/{id?}', 'BridgingPRBController@prb_cetak');
Route::delete('bridgingsep/rujuk-balik/{id}', 'BridgingPRBController@prb_delete');
Route::post('bridgingsep/rujuk-balik/save', 'BridgingPRBController@prb_save');
Route::post('bridgingsep/rujuk-balik/cari-sep', 'BridgingPRBController@cari_sep');
Route::post('bridgingsep/rujuk-balik/save/{id}', 'BridgingPRBController@prb_update');
Route::get('bridgingsep/rujuk-balik/ref/obat/prb', 'BridgingPRBController@search_referensi_obat_prb');

Route::get('bridgingsep/sync-obat-prb/{obat}', 'BridgingPRBController@sync_obat_prb');


// ANTRIAN
Route::get('bridgingsep/dashboard-pertanggal', 'BridgingReferensiController@dashboardAntrianPerTanggal');
Route::post('bridgingsep/dashboard-pertanggal', 'BridgingReferensiController@dashboardAntrianPerTanggal');
Route::get('bridgingsep/dashboard-perbulan', 'BridgingReferensiController@dashboardAntrianPerBulan');
Route::post('bridgingsep/dashboard-perbulan', 'BridgingReferensiController@dashboardAntrianPerBulan');
// LOG ANTRIAN
Route::get('bridgingsep/log-antrian', 'BridgingReferensiController@logAntrian');
Route::post('bridgingsep/log-antrian', 'BridgingReferensiController@logAntrian');
Route::post('bridgingsep/log-antrian/pdf', 'BridgingReferensiController@logAntrianPDF');

// Dashboard Rate Antrian
Route::get('bridgingsep/dashboard-antrianrate', 'BridgingReferensiController@DashboardRateantrian');
Route::post('bridgingsep/dashboard-antrianrate', 'BridgingReferensiController@DashboardRateantrian');

Route::get('bridgingsep/log-bed/{id?}', 'BridgingReferensiController@logBed');
Route::post('bridgingsep/log-bed', 'BridgingReferensiController@logBed');


Route::get('bridgingsep/edit-dokter-hfis/{kodedokter}/{kodepoli}/{kodesubspesialis}', 'BridgingReferensiController@editJadwalDokterHfis');
Route::post('bridgingsep/update-jadwal-dokter-hfis', 'BridgingReferensiController@updateJadwalDokterHfis');

Route::get('bridgingsep/list-taskid', 'BridgingReferensiController@listTaskid');
Route::post('bridgingsep/list-taskid', 'BridgingReferensiController@listTaskid');

// HAPUS ANTROL
Route::get('bridgingsep/batal-antrol', 'BridgingReferensiController@batalAntrol');
Route::post('bridgingsep/batal-antrol', 'BridgingReferensiController@batalAntrol');

Route::get('bridgingsep/dashboard-koneksi', 'DashboardKoneksiBpjsController@index');
Route::get('koneksi-vclaim/{type?}', 'DashboardKoneksiBpjsController@koneksiVclaim')->name('koneksi_delete_sep');
Route::get('data-koneksi-vclaim/{type?}', 'DashboardKoneksiBpjsController@dataKoneksiVclaim');

Route::get('data-kunjungan-dashboard/{type?}', 'DashboardKoneksiBpjsController@dataKunjunganDashboard');
Route::get('data-kunjungan-poli-dashboard', 'DashboardKoneksiBpjsController@dataKunjunganPoliDashboard');