<?php
// Test Snomed
Route::group(['middleware' => ['web', 'auth']], function () {
	Route::get('snomed_ct/{concept_id}/detail/{version}', 'SnomedCTController@detail');
	Route::get('snomed_ct/{concept_id}/children/{version}', 'SnomedCTController@children');
	Route::get('snomed_ct/insert-db/{concept_id}/{version}', 'SnomedCTController@insert');
});