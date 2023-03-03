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

Route::get('/', 'App\Http\Controllers\HomepageController@index')->name('home');
Route::get('/login', 'App\Http\Controllers\ConnectionController@connect')->name('try.login');
Route::get('/php', function () {
    return phpinfo();
});

Route::get('/fill', 'App\Http\Controllers\fonctionsController@fill_eim_table')->name('fill');

Route::get('/speedtest', 'App\Http\Controllers\fonctionsController@speedtest')->name('speedtest');
Route::get('/eims', 'App\Http\Controllers\fonctionsController@eims')->name('eims');
Route::get('/csv', 'App\Http\Controllers\fonctionsController@tocsv')->name('csv');

Route::get('/portail', function () {
    return redirect('https://portail.intranet.cg974.fr/');
})->name('portail');

Route::post('/ip_to_json', 'App\Http\Controllers\fonctionsController@ip_to_json')->name('ip_to_json');
Route::post('/model_to_json', 'App\Http\Controllers\fonctionsController@model_to_json')->name('model_to_json');
Route::post('/fill_eim_table', 'App\Http\Controllers\fonctionsController@fill_eim_table')->name('fill_eim_table');
Route::post('/count_id', 'App\Http\Controllers\fonctionsController@count_id')->name('count_id');
Route::post('/check_oid', 'App\Http\Controllers\fonctionsController@check_oid')->name('check_oid');
Route::post('/get_all_oid_quota', 'App\Http\Controllers\fonctionsController@get_all_oid_quota')->name('get_all_oid_quota');
Route::post('/ext_ping', 'App\Http\Controllers\fonctionsController@ext_ping')->name('ext_ping');
Route::post('/ext_reset', 'App\Http\Controllers\fonctionsController@ext_reset')->name('ext_reset');
Route::post('/ext_infotip', 'App\Http\Controllers\fonctionsController@ext_infotip')->name('ext_infotip');
Route::post('/ext_toner', 'App\Http\Controllers\fonctionsController@ext_toner')->name('ext_toner');

// Route::get('/faq', function () {
//     return view('livewire.faq-component');
// });

