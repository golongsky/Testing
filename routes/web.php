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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/chartdata', 'HomeController@chartData')->name('chartdata');
Route::get('/tldata', 'HomeController@tlData')->name('tldata');
Route::get('/loadknobs', 'HomeController@loadknobs')->name('loadknobs');
Route::get('/myteamticketdetails', 'HomeController@myteamTicket')->name('myteamticketdetails');


// All Routes for ETR
Route::get('/etr', 'EtrController@index')->name('etr');
Route::get('/mytrx', 'EtrController@pullmytrx')->name('mytrx');
Route::post('/f-mytrx', 'EtrController@filteredrmytrx')->name('f-mytrx');
Route::get('/trans-type', 'EtrController@transtype')->name('trans-type');
Route::get('/last-id', 'EtrController@lastId')->name('last-id');
Route::post('/trnx-save', 'EtrController@store')->name('trnx-save');
Route::get('/etrcontroller', 'EtrController@etrcontroller')->name('etrcontroller');
Route::post('/getdropdown', 'EtrController@show')->name('getdropdown');
Route::post('/email-trnx-save', 'EtrController@emailstore')->name('email-trnx-save');

Route::post('/import', 'ImportExcelController@store')->name('import');
Route::get('/pulllastupload', 'ImportExcelController@show')->name('pulllastupload');
Route::post('/deletupload', 'ImportExcelController@destroy')->name('deletUpload');

Route::get('/emailist', 'EtrController@emailist')->name('emailist');
Route::post('/updateislock', 'EtrController@updateislock')->name('updateislock');
Route::post('/ticketlock', 'EtrController@ticketlock')->name('ticketlock');
Route::post('/checkticket', 'EtrController@checkticket')->name('checkticket');
Route::post('/stp', 'EtrController@startProcess')->name('stp');
Route::post('/checklock', 'EtrController@checkLock')->name('checklock');
Route::post('/release', 'EtrController@release')->name('release');



// All Routes for Coaching
Route::get('/ctl', 'CoachingController@index')->name('ctl');
Route::get('/pull-form', 'CoachingController@showform')->name('pull-form');
Route::post('/pulldetails', 'CoachingController@show')->name('pulldetails');
Route::post('/new-form', 'CoachingController@createform')->name('new-form');
Route::post('/uploadform', 'CoachingController@uploadform')->name('uploadform');
Route::post('/creategoal', 'CoachingController@creategoal')->name('creategoal');
Route::post('/updategoal', 'CoachingController@updategoal')->name('updategoal');
Route::post('/createmilestone', 'CoachingController@createmilestone')->name('createmilestone');
Route::post('/updateMilestone', 'CoachingController@updateMilestone')->name('updateMilestone');
Route::post('/createfeedback', 'CoachingController@createfeedback')->name('createfeedback');
Route::post('/deletegoal', 'CoachingController@deletegoal')->name('deletegoal');
Route::any('/accepdeclinecoaching', 'CoachingController@accepdeclinecoaching')->name('accepdeclinecoaching');

// All Routes for QMS


// All Routes for Action Item
Route::get('/action-logs', 'ActionController@index')->name('action-logs');


// All Routes for Calendar
Route::get('/calendar', 'CalendarController@index')->name('calendar');
Route::get('/showSchedule', 'CalendarController@showSchedule')->name('showSchedule');



// All Routes for Profile
Route::get('/profile', 'ProfileController@index')->name('profile');


// All Routes for User Management
Route::get('/umgt', 'UserManagementController@index')->name('umgt');
Route::get('/all-user', 'UserManagementController@show')->name('all-user');
Route::get('/fill-dropdown', 'UserManagementController@store')->name('fill-dropdown');
Route::post('/fill-group', 'UserManagementController@storegroup')->name('fill-group');
Route::post('/new-user', 'UserManagementController@create')->name('new-user');
Route::post('/update-user', 'UserManagementController@update')->name('update-user');
Route::post('/new-user-data', 'UserManagementController@pulldata')->name('new-user-data');
Route::post('/delete-user', 'UserManagementController@destroy')->name('delete-user');

// All Routes for Analytics
Route::get('/analytics', 'AnalyticsController@index')->name('analytics');


// All Routes for QMS
Route::get('/qms', 'QMSController@index')->name('qms');