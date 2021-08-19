<?php

use Illuminate\Support\Facades\Auth;
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
    return view('auth.login');
});



Auth::routes(['register'=>false]);



Route::group(['namespace'=>'App\\Http\\Controllers','middleware' => ['auth']],function(){

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('checkUser');


    Route::get('/{page}', 'AdminController@index');

    Route::group(['prefix'=>'invoices'],function(){

        Route::get('/All','InvoicesController@index')->name('AllInvoices');
        Route::get('/add','InvoicesController@add')->name('addInvoices');
        Route::get('/section/{id}','InvoicesController@getproducts');
        Route::post('/store','InvoicesController@store')->name('storeInvoices');
        Route::get('/details/{id}','InvoicesController@details');
        Route::get('/download/{invoice_id}/{file_name}','InvoicesController@download');
        Route::get('/View_file/{invoice_id}/{file_name}','InvoicesController@View_file');
        Route::post('/destroy','InvoicesController@destroy');
        Route::get('/edit_invoice/{id}','InvoicesController@edit');
        Route::get('/edit_invoices_Ajax/{id}','InvoicesController@edit_invoices_Ajax');
        Route::post('/update','InvoicesController@update');
        Route::post('/update_details','InvoicesController@destoryInvoices');
        Route::get('/allInvoices_paid','InvoicesController@allInvoices_paid');
        Route::get('/allInvoices_unpaid','InvoicesController@allInvoices_unpaid');
        Route::get('/allInvoices_partial_paid','InvoicesController@allInvoices_partial_paid');
        Route::get('/makeAsread','InvoicesController@makeAsread');


        // control InvoicesAttachmentsController
        Route::post('/storeAttachment','InvoicesAttachmentsController@store');







        // contorl InvoicesDetailsController
        Route::post('/update_details','InvoicesDetailsController@update');
        Route::get('/archive','InvoicesDetailsController@archive');
        Route::post('/addArchive','InvoicesDetailsController@addArchive');
        Route::post('/canclArchive','InvoicesDetailsController@canclArchive');
        Route::post('/deleteArchive','InvoicesDetailsController@deleteArchive');
        Route::post('/changeStatus','InvoicesDetailsController@changeStatus');
        Route::get('/Print_invoice/{id}','InvoicesDetailsController@Print_invoice');
        Route::get('/export','InvoicesDetailsController@export');





    });

    Route::group(['prefix'=>'section'],function(){
        Route::get('/All','SectionController@index')->name('AllSection');
        Route::post('/store','SectionController@store')->name('storeSection');
        Route::post('/edit','SectionController@edit');
        Route::post('/destroy','SectionController@destroy')->name('destroy');
    });


    Route::group(['prefix'=>'product'],function(){
        Route::get('/All','ProductController@index')->name('AllProdcut');
        Route::post('/store','ProductController@store')->name('storeProdcut');
        Route::post('/edit','ProductController@edit');
        Route::post('/destroy','ProductController@destroy');
    });


    Route::group(['prefix'=>'user'],function(){

        Route::get('/index','userController@index');
        Route::get('/edit/{id}','userController@edit');
        Route::get('/create','userController@create');
        Route::post('/store','userController@store');
        Route::post('/destory','userController@destory');
        Route::post('/update','userController@update');
    });


    Route::group(['prefix'=>'role'],function(){

        Route::get('/index','RoleController@index');
        Route::get('/show/{id}','RoleController@show');
        Route::get('/edit/{id}','RoleController@edit');
        Route::post('/update','RoleController@update');
        Route::get('/destroy/{id}','RoleController@destroy');
        Route::get('/create','RoleController@create');
        Route::post('/store','RoleController@store');

    });



    Route::group(['prefix'=>'report'],function(){

        Route::get('/invoice','ReportController@index');
        Route::post('/sereach_invoice','ReportController@sereach_invoice');
        Route::get('/customer','ReportController@report_with_product_and_section');
        Route::get('/send_product_AJAX/{id}','ReportController@send_Product');
        Route::post('/sereach_customer','ReportController@sereach_customer');


    });





});




