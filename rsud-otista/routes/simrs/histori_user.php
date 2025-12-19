<?php

Route::get('histori-user', 'HistoriUserLoginController@index');
Route::get('histori-user-data/{bulan}', 'HistoriUserLoginController@dataHistoriLogin');
Route::get('histori-user-excel/{tga?}/{tgb?}', 'HistoriUserLoginController@excelHistori');
