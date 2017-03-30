<?php
Route::get('/', function () {
    return view('welcome');
});
Route::get('/mainController', 'AjaxController@login');