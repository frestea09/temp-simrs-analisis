<?php
Route::group(['middleware'=>['web','auth']], function () {
  Route::get('/signaturepad/surat-pulang-paksa/{registrasi_id}', 'SignatureController@signSuratPulPak');
  Route::post('/signaturepad/surat-pulang-paksa/{registrasi_id}', 'SignatureController@signSuratPulPakAction');
  Route::get('/signaturepad/persetujuan-pasien/{EmrInapPerencanaan_id}', 'SignatureController@signPersetujuanPasien');
  Route::post('/signaturepad/persetujuan-pasien/{EmrInapPerencanaan_id}', 'SignatureController@signPersetujuanPasienAction');
  Route::get('/signaturepad/layanan-rehab/{registrasi_id}', 'SignatureController@signLayananRehab');
  Route::post('/signaturepad/layanan-rehab/{registrasi_id}', 'SignatureController@signLayananRehabAction');
  Route::get('/signaturepad/program-terapi/{registrasi_id}', 'SignatureController@signProgramTerapi');
  Route::post('/signaturepad/program-terapi/{registrasi_id}', 'SignatureController@signProgramTerapiAction');
  Route::get('/signaturepad/general-consent/{registrasi_id}', 'SignatureController@signGeneralConsent');
  Route::post('/signaturepad/general-consent/{registrasi_id}', 'SignatureController@signGeneralConsentAction');
  Route::get('/signaturepad/e-resume/{registrasi_id}', 'SignatureController@signEresume');
  Route::post('/signaturepad/e-resume/{registrasi_id}', 'SignatureController@signEresumeAction');
  Route::get('/signaturepad/pasien/{pasien_id}', 'SignatureController@signPasien');
  Route::post('/signaturepad/pasien/{pasien_id}', 'SignatureController@signPasienAction');
  Route::get('/signaturepad/saksi-paps/{id}', 'SignatureController@signSaksiPaps');
  Route::post('/signaturepad/saksi-paps/{id}', 'SignatureController@signSaksiPapsAction');

  // Informed Consent
  Route::get('/signaturepad/informed-consent-saksi/{registrasi_id}', 'SignatureController@signInformedConsentSaksi');
  Route::post('/signaturepad/informed-consent-saksi/{registrasi_id}', 'SignatureController@signInformedConsentSaksiAction');

  // Persetujuan Vaksinasi
  Route::get('/signaturepad/vaksinasi-saksi/{registrasi_id}', 'SignatureController@signVaksinasiSaksi');
  Route::post('/signaturepad/vaksinasi-saksi/{registrasi_id}', 'SignatureController@signVaksinasiSaksiAction');
  Route::get('/signaturepad/vaksinasi-pemberi-keterangan/{registrasi_id}', 'SignatureController@signVaksinasiPemberi');
  Route::post('/signaturepad/vaksinasi-pemberi-keterangan/{registrasi_id}', 'SignatureController@signVaksinasiPemberiAction');

});
