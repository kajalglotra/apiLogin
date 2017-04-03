<?php
Route::get('/', function () {
    echo "Hello";
});

Route::post('/mainController', 'AjaxController@mainController');
     