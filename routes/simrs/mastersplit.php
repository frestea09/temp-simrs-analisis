<?php

Route::get('mastersplit/delete/{no_po}', 'MastersplitController@delete');
Route::resource('mastersplit', 'MastersplitController');
