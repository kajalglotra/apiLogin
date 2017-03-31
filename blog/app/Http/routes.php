<?php
Route::get('/', function () {
    return view('welcome');
});

Route::post('/mainController', 'AjaxController@mainController');
     