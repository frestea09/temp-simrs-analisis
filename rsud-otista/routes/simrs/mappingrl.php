<?php

Route::view('mastermapping_dashboard', 'sirs.mapping.index');

Route::namespace('Conf_rl')->group(function () {
    Route::group(['middleware' => ['web', 'auth']], function () {
        Route::resource('mastermapping_confrl31', 'Conf31Controller')->names('confrl31');
    });
    Route::group(['middleware' => ['web', 'auth']], function () {
        Route::get('data-mastermapping_confrl39', 'Conf39Controller@data_list')->name('data-mastermapping_confrl39');
        Route::get('mastermapping_confrl39/{id}/add', 'Conf39Controller@add_mapping')->name('mastermapping_confrl39.mapping');
        Route::get('data-tarif-mastermapping_confrl39/{tahuntarif_id?}/{jenis?}/{kategoritarif_id?}', 'Conf39Controller@dataTarif')->name('data-tarif-mapping');
        Route::post('simpan-conf_rl39', 'Conf39Controller@simpan_conf_rl39')->name('simpan-conf_rl39');
        Route::get('list-detail-conf-rl39/{id}', 'Conf39Controller@detailconfrl39')->name('list_detail_conf_rl39');
        Route::get('hapus-conf-rl39/{tarif_id}', 'Conf39Controller@hapus_detail_conf_rl39')->name('hapus_conf_rl39');
        Route::get('table-conf-rl39', 'Conf39Controller@table_conf_rl39')->name('table_conf_rl39');
        Route::resource('mastermapping_confrl39', 'Conf39Controller');
    });
    Route::group(['middleware' => ['web', 'auth']], function () {
        Route::get('data-mastermapping_confrl311', 'Conf311Controller@data_list')->name('data-mastermapping_confrl311');
        Route::get('mastermapping_confrl311/{id}/add', 'Conf311Controller@add_mapping')->name('mastermapping_confrl311.mapping');
        Route::get('data-tarif-mastermapping_confrl311/{tahuntarif_id?}/{jenis?}/{kategoritarif_id?}', 'Conf311Controller@dataTarif')->name('data-tarif-mapping');
        Route::post('simpan-conf_rl311', 'Conf311Controller@simpan_conf_rl311')->name('simpan-conf_rl311');
        Route::get('list-detail-conf-rl311/{id}', 'Conf311Controller@detailconfrl311')->name('list_detail_conf_rl311');
        Route::get('hapus-conf-rl311/{tarif_id}', 'Conf311Controller@hapus_detail_conf_rl311')->name('hapus_conf_rl311');
        Route::get('table-conf-rl311', 'Conf311Controller@table_conf_rl311')->name('table_conf_rl311');
        Route::resource('mastermapping_confrl311', 'Conf311Controller');
    });
    Route::group(['middleware' => ['web', 'auth']], function () {
        Route::get('data-mastermapping_confrl33', 'Conf33Controller@data_list')->name('data-mastermapping_confrl33');
        Route::get('mastermapping_confrl33/{id}/add', 'Conf33Controller@add_mapping')->name('mastermapping_confrl33.mapping');
        Route::get('data-tarif-mastermapping_confrl33/{tahuntarif_id?}/{jenis?}/{kategoritarif_id?}', 'Conf33Controller@dataTarif')->name('data-tarif-mapping');
        Route::post('simpan-conf_rl33', 'Conf33Controller@simpan_conf_rl33')->name('simpan-conf_rl33');
        Route::get('list-detail-conf-rl33/{id}', 'Conf33Controller@detailconfrl33')->name('list_detail_conf_rl33');
        Route::get('hapus-conf-rl33/{tarif_id}', 'Conf33Controller@hapus_detail_conf_rl33')->name('hapus_conf_rl33');
        Route::get('table-conf-rl33', 'Conf33Controller@table_conf_rl33')->name('table_conf_rl33');
        // Route::get('mastermapping_dashboard', 'Conf33Controller@dashboard_conf')->name('dashboard.conf');
        Route::resource('mastermapping_confrl33', 'Conf33Controller');
    });
    Route::group(['middleware' => ['web', 'auth']], function () {
        Route::get('data-mastermapping_confrl36', 'Conf36Controller@data_list')->name('data-mastermapping_confrl36');
        Route::get('mastermapping_confrl36/{id}/add', 'Conf36Controller@add_mapping')->name('mastermapping_confrl36.mapping');
        Route::get('data-tarif-mastermapping_confrl36/{tahuntarif_id?}/{jenis?}/{kategoritarif_id?}', 'Conf36Controller@dataTarif')->name('data-tarif-mapping');
        Route::post('simpan-conf_rl36', 'Conf36Controller@simpan_conf_rl36')->name('simpan-conf_rl36');
        Route::get('list-detail-conf-rl36/{id}', 'Conf36Controller@detailconfrl36')->name('list_detail_conf_rl36');
        Route::get('hapus-conf-rl36/{tarif_id}', 'Conf36Controller@hapus_detail_conf_rl36')->name('hapus_conf_rl36');
        Route::get('table-conf-rl36', 'Conf36Controller@table_conf_rl36')->name('table_conf_rl36');
        // Route::get('mastermapping_dashboard', 'Conf36Controller@dashboard_conf')->name('dashboard.conf');
        Route::resource('mastermapping_confrl36', 'Conf36Controller');
    });
    Route::group(['middleware' => ['web', 'auth']], function () {
        Route::get('data-mastermapping_confrl37', 'Conf37Controller@data_list')->name('data-mastermapping_confrl37');
        Route::get('mastermapping_confrl37/{id}/add', 'Conf37Controller@add_mapping')->name('mastermapping_confrl37.mapping');
        Route::get('data-tarif-mastermapping_confrl37/{tahuntarif_id?}/{jenis?}/{kategoritarif_id?}', 'Conf37Controller@dataTarif')->name('data-tarif-mapping');
        Route::post('simpan-conf_rl37', 'Conf37Controller@simpan_conf_rl37')->name('simpan-conf_rl37');
        Route::get('list-detail-conf-rl37/{id}', 'Conf37Controller@detailconfrl37')->name('list_detail_conf_rl37');
        Route::get('hapus-conf-rl37/{tarif_id}', 'Conf37Controller@hapus_detail_conf_rl37')->name('hapus_conf_rl37');
        Route::get('table-conf-rl37', 'Conf37Controller@table_conf_rl37')->name('table_conf_rl37');
        // Route::get('mastermapping_dashboard', 'Conf37Controller@dashboard_conf')->name('dashboard.conf');
        Route::resource('mastermapping_confrl37', 'Conf37Controller');
    });
    Route::group(['middleware' => ['web', 'auth']], function () {
        Route::get('data-mastermapping_confrl38', 'Conf38Controller@data_list')->name('data-mastermapping_confrl38');
        Route::get('mastermapping_confrl38/{id}/add', 'Conf38Controller@add_mapping')->name('mastermapping_confrl38.mapping');
        Route::get('data-tarif-mastermapping_confrl38/{tahuntarif_id?}/{jenis?}/{kategoritarif_id?}', 'Conf38Controller@dataTarif')->name('data-tarif-mapping');
        Route::post('simpan-conf_rl38', 'Conf38Controller@simpan_conf_rl38')->name('simpan-conf_rl38');
        Route::get('list-detail-conf-rl38/{id}', 'Conf38Controller@detailconfrl38')->name('list_detail_conf_rl38');
        Route::get('hapus-conf-rl38/{tarif_id}', 'Conf38Controller@hapus_detail_conf_rl38')->name('hapus_conf_rl38');
        Route::get('table-conf-rl38', 'Conf38Controller@table_conf_rl38')->name('table_conf_rl38');
        Route::resource('mastermapping_confrl38', 'Conf38Controller');
    });
    Route::group(['middleware' => ['web', 'auth']], function () {
        Route::get('data-mastermapping_confrl34', 'Conf34Controller@data_list')->name('data-mastermapping_confrl34');
        Route::get('mastermapping_confrl34/{id}/add', 'Conf34Controller@add_mapping')->name('mastermapping_confrl34.mapping');
        Route::get('data-tarif-mastermapping_confrl34/{tahuntarif_id?}/{jenis?}/{kategoritarif_id?}', 'Conf34Controller@dataTarif')->name('data-tarif-mapping');
        Route::post('simpan-conf_rl34', 'Conf34Controller@simpan_conf_rl34')->name('simpan-conf_rl34');
        Route::get('list-detail-conf-rl34/{id}', 'Conf34Controller@detailconfrl34')->name('list_detail_conf_rl34');
        Route::get('hapus-conf-rl34/{tarif_id}', 'Conf34Controller@hapus_detail_conf_rl34')->name('hapus_conf_rl34');
        Route::get('table-conf-rl34', 'Conf34Controller@table_conf_rl34')->name('table_conf_rl34');
        // Route::get('mastermapping_dashboard', 'Conf34Controller@dashboard_conf')->name('dashboard.conf');
        Route::resource('mastermapping_confrl34', 'Conf34Controller');
    });
    Route::group(['middleware' => ['web', 'auth']], function () {
        Route::get('data-mastermapping_confrl310', 'Conf310Controller@data_list')->name('data-mastermapping_confrl310');
        Route::get('mastermapping_confrl310/{id}/add', 'Conf310Controller@add_mapping')->name('mastermapping_confrl310.mapping');
        Route::get('data-tarif-mastermapping_confrl310/{tahuntarif_id?}/{jenis?}/{kategoritarif_id?}', 'Conf310Controller@dataTarif')->name('data-tarif-mapping');
        Route::post('simpan-conf_rl310', 'Conf310Controller@simpan_conf_rl310')->name('simpan-conf_rl310');
        Route::get('list-detail-conf-rl310/{id}', 'Conf310Controller@detailconfrl310')->name('list_detail_conf_rl310');
        Route::get('hapus-conf-rl310/{tarif_id}', 'Conf310Controller@hapus_detail_conf_rl310')->name('hapus_conf_rl310');
        Route::get('table-conf-rl310', 'Conf310Controller@table_conf_rl310')->name('table_conf_rl310');
        Route::resource('mastermapping_confrl310', 'Conf310Controller');
    });
    Route::group(['middleware' => ['web', 'auth']], function () {
        Route::get('data-mastermapping_confrl35', 'Conf35Controller@data_list')->name('data-mastermapping_confrl35');
        Route::get('mastermapping_confrl35/{id}/add', 'Conf35Controller@add_mapping')->name('mastermapping_confrl35.mapping');
        Route::get('data-tarif-mastermapping_confrl35/{tahuntarif_id?}/{jenis?}/{kategoritarif_id?}', 'Conf35Controller@dataTarif')->name('data-tarif-mapping');
        Route::post('simpan-conf_rl35', 'Conf35Controller@simpan_conf_rl35')->name('simpan-conf_rl35');
        Route::get('list-detail-conf-rl35/{id}', 'Conf35Controller@detailconfrl35')->name('list_detail_conf_rl35');
        Route::get('hapus-conf-rl35/{tarif_id}', 'Conf35Controller@hapus_detail_conf_rl35')->name('hapus_conf_rl35');
        Route::get('table-conf-rl35', 'Conf35Controller@table_conf_rl35')->name('table_conf_rl35');
        // Route::get('mastermapping_dashboard', 'Conf35Controller@dashboard_conf')->name('dashboard.conf');
        Route::resource('mastermapping_confrl35', 'Conf35Controller');
    });

    Route::group(['middleware' => ['web', 'auth']], function () {
        Route::get('data-mastermapping_confrl312', 'Conf312Controller@data_list')->name('data-mastermapping_confrl312');
        Route::get('mastermapping_confrl312/{id}/add', 'Conf312Controller@add_mapping')->name('mastermapping_confrl312.mapping');
        Route::get('data-tarif-mastermapping_confrl312/{tahuntarif_id?}/{jenis?}/{kategoritarif_id?}', 'Conf312Controller@dataTarif')->name('data-tarif-mapping');
        Route::post('simpan-conf_rl312', 'Conf312Controller@simpan_conf_rl312')->name('simpan-conf_rl312');
        Route::get('list-detail-conf-rl312/{id}', 'Conf312Controller@detailconfrl312')->name('list_detail_conf_rl312');
        Route::get('hapus-conf-rl312/{tarif_id}', 'Conf312Controller@hapus_detail_conf_rl312')->name('hapus_conf_rl312');
        Route::get('table-conf-rl312', 'Conf312Controller@table_conf_rl312')->name('table_conf_rl312');
        Route::resource('mastermapping_confrl312', 'Conf312Controller');
    });
});