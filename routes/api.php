<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// // LOGIN API
// Route::post('/loginApi', 'AdminController@login');

// // Manage Users and Reports  API
// Route::post('/addAdminUserApi', 'ManageUsersAndReportsController@addAdminUserApi');
// Route::get('/getAdminUsersDataApi', 'ManageUsersAndReportsController@getAdminUsersData');
// Route::post('/editAdminUserApi', 'ManageUsersAndReportsController@editAdminUserApi');
// Route::post('/deleteAdminUserApi', 'ManageUsersAndReportsController@deleteAdminUserApi');

// // Dashboard API
// Route::post('/requesterInvoiceApi', 'DashboardController@storeInvoiceForms');
// Route::any('/queryFormsApi', 'DashboardController@invoiceRequesterDataQuery');
// Route::any('/getFormsCountPerStatusApi', 'DashboardController@getFormCountPerStatus');
// Route::any('/approveInvoiceFormApi', 'DashboardController@approveInvoiceForm');
// Route::any('/dispatchInvoiceApi', 'DashboardController@dispatchInvoiceForm');
// Route::any('/sendAmountApi', 'DashboardController@sendAmount');
// Route::any('/completeInvoiceApi', 'DashboardController@pickedUpInvoiceForm');

// // Inventory API
// Route::post('/addInventoryApi', 'InventoryController@storeInventoryForms');
// Route::any('/getInventorysDataApi', 'InventoryController@getInventorysData');
// Route::post('/editInventoryApi', 'InventoryController@editInventoryApi');
// Route::post('/deleteInventoryApi', 'InventoryController@deleteInventoryApi');
// Route::get('/getInventoryArrayApi', 'InventoryController@getInventoryArrayApi');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
