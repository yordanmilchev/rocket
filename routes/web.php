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
    return redirect('/createcv');
});

Route::get('/createcv','App\Http\Controllers\\MainController@createcv')->name('createcv');
Route::get('/showrecords','App\Http\Controllers\\MainController@showrecords')->name('showrecords');
Route::post('/createdbrecord','App\Http\Controllers\\MainController@createdbrecord')->name('createdbrecord');
Route::get('/adduni','App\Http\Controllers\\MainController@adduni')->name('adduni');
Route::get('/addskill','App\Http\Controllers\\MainController@addskill')->name('addskill');
Route::get('/fetchcv','App\Http\Controllers\\MainController@fetchcv')->name('fetchcv');



