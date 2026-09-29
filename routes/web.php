<?php
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

<<<<<<< HEAD
Route::get('login', function(){
    return view('login');
});
=======
Route::get('/login', function () {
    return view('login');
});
>>>>>>> f111bd6d37cb677d8e42f9710d88e4223fe408a6
