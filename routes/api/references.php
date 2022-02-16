<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| References Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for references.
|
*/

Route::get('owners', 'ReferencesController@owners')->name('owners');
