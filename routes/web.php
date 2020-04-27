<?php

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

/*Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');*/

Route::get('/', 'Mailing\MailingPageController@LoadPageData')->name('mainPage');

/*Route::get('/', function () {
    return view('layouts/mailing');
});*/

Auth::routes();
//Route::get('/home', 'HomeController@index')->name('home');

Route::post('/save-csv-file/', 'Mailing\CsvController@saveCsvFile', function (){
    return redirect('/');
})->name('saveCsvFile');
Route::post('/', 'Mailing\MailingPageController@createParticipant', function (){
    return redirect('/');
})->name('createParticipant');
Route::post('remove/participant/{user_id}', 'Mailing\MailingPageController@removeParticipant')->name('removeParticipant');

//Route::resource('companies', 'CompanyController');
//Route::resource('participants', 'ParticipantController');
