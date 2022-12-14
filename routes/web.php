<?php

use Illuminate\Http\Request;
use App\Http\Middleware\RedirectIfNotLoggedIn;

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

// Admin and common routes
Route::get('/', 'AdminController@index')->middleware(RedirectIfNotLoggedIn::class);
Route::get('/login', 'LoginController@index')->name('login');
Route::post('/loginApi', 'AdminController@login');
Route::get('/logout', 'AdminController@logout')->name('logout');
Route::get('/unauthorisedPage', 'AdminController@unauthorisedPage')->name('Unauthorised');
Route::get('/unsupportedPage', 'AdminController@unsupportedPage')->name('Unsupported');

// Manage Users and Reports 
Route::post('/addAdminUserApi', 'ManageUsersAndReportsController@addAdminUserApi');
Route::get('/getAdminUsersDataApi', 'ManageUsersAndReportsController@getAdminUsersData');
Route::get('/getMobileAppUsersDataApi', 'ManageUsersAndReportsController@getMobileAppUsersDataApi');
Route::post('/editAdminUserApi', 'ManageUsersAndReportsController@editAdminUserApi');
Route::post('/deleteAdminUserApi', 'ManageUsersAndReportsController@deleteAdminUserApi');

// Manage Symptoms
Route::get('/symptomsList', 'SymptomsListController@symptomsList')->middleware(RedirectIfNotLoggedIn::class)->name('SymptomsList');
Route::post('/addSymptomApi', 'SymptomsListController@addSymptomApi');
Route::get('/getSymptomsListDataApi', 'SymptomsListController@getSymptomsListDataApi');
Route::post('/editSymptomApi', 'SymptomsListController@editSymptomApi');
Route::post('/deleteSymptomApi', 'SymptomsListController@deleteSymptomApi');

//Contact Tracing Users List
Route::get('/autoTracingUsers', 'AutoTracingUsersController@autoTracingUsers')->middleware(RedirectIfNotLoggedIn::class)->name('AutoTracingUsers');
Route::get('/autoTracingUsersDataApi', 'AutoTracingUsersController@autoTracingUsersDataApi');

//Isolated Users List
Route::get('/isolatedPersons', 'isolatedPersonsController@isolatedPersons')->middleware(RedirectIfNotLoggedIn::class)->name('isolatedPersons');
Route::get('/isolatedPersonsDataApi', 'isolatedPersonsController@isolatedPersonsDataApi');

//Booking List
Route::get('/bookingList', 'BookingListController@bookingList')->middleware(RedirectIfNotLoggedIn::class)->name('BookingList');
Route::get('/bookingListDataApi', 'BookingListController@bookingListDataApi');
Route::post('/updateBookingInfoApi', 'BookingListController@updateBookingInfoApi');
Route::post('/updateTestResultInfoApi', 'BookingListController@updateTestResultInfoApi');

// Settings Routes
Route::get('/mobileAppUsers', 'ManageUsersAndReportsController@manageMobileAppUsers')->middleware(RedirectIfNotLoggedIn::class)->name('MobileAppUsers');
Route::get('/applicationUsers', 'ManageUsersAndReportsController@manageApplicationUsers')->middleware(RedirectIfNotLoggedIn::class)->name('ApplicationUsers');
Route::post('/deleteGlobalApi', 'ManageUsersAndReportsController@deleteGlobalApi');

?>