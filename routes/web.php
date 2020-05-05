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

Auth::routes();

Route::post('/save-csv-file/', 'Mailing\CsvController@saveCsvFile')->name('saveCsvFile');

Route::post('/', 'Mailing\MailingPageController@createParticipant', function (){
    return redirect('/');
})->name('createParticipant');

Route::post('remove/participant/{user_id}', 'Mailing\MailingPageController@removeParticipant')->name('removeParticipant');

Route::post('remove/company', 'Mailing\MailingPageController@removeCompany')->name('removeCompany');

Route::post('update/participant', 'Mailing\MailingPageController@updateParticipantForCompany')->name('updateParticipantForCompany');

Route::get('unsubscribe/{user_id}', 'Mailing\MailController@unsubscribe');

Route::get('unsubscribe/peer-list/{user_id}', 'Mailing\MailController@unsubscribePeerList');

Route::post('/start-mailing', 'Mailing\MailingPageController@initMailing')->name('startMailing');

Route::post('update/peer-reflection', 'Mailing\MailingPageController@updatePeerReflection')->name('updatePeerReflection');

Route::post('remove/peer-reflection', 'Mailing\MailingPageController@removePeerReflection')->name('removePeerReflection');

Route::post('update/self-reflection', 'Mailing\MailingPageController@updateSelfReflection')->name('updateSelfReflection');

Route::post('remove/self-reflection', 'Mailing\MailingPageController@removeSelfReflection')->name('removeSelfReflection');

//Route::resource('companies', 'CompanyController');
//Route::resource('participants', 'ParticipantController');
