<?php

Route::group(['middleware' => ['web', 'auth']], function () {
	Route::view('hemodialisa/laporan', 'hemodialisa.laporan');
});
