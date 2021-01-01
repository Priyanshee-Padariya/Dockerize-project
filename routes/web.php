<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('home');
});

Route::get('/login', function() {
    return view('user.login');
});

Route::get('/add/job', function() {
    return view('employer.add');
});

Route::get('/job/index', function() {
    return view('jobseeker.index');
});

Route::get('/job/show', function() {
    return view('jobseeker.show');
});
