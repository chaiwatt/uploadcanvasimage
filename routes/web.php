<?php

Route::get('/', function () {
    return view('welcome');
});

Route::post('upload','UploadContontroller@Upload')->name('upload');