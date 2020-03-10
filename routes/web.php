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

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->group(function () {
     Route::get('/central','Admin@central');   
    Route::get('/produse',"Admin@produse");
    Route::get('/details',"Admin@details");
    Route::get('/gettags',"Admin@getTags");
    Route::get('/deleteTags',"Admin@deleteTags");
    Route::get('/deleteSizes',"Admin@deleteSize");
    Route::get('/deleteRef_Product_Types',"Admin@deleteprotypes");
    Route::post('/addtag',"Admin@addtag");
    Route::get('/createProd',"Admin@createprod");
    Route::get('/createOrder',"Admin@createOrder");
    Route::post('/createprodt',"Admin@createprodtype");
    Route::post('/createTag',"Admin@createTag");
    Route::post('/createSize',"Admin@createSize");
    Route::post('/addsize',"Admin@addsize");
    Route::post('/rmtag',"Admin@rmtag");
    Route::post("/updatesize","Admin@updatesize");
    Route::post("/rmsizes","Admin@rmsizes");
    Route::post("/updateprod","Admin@updateprod");
    Route::get("/delprod","Admin@delprod");

    Route::post("/save_order_status","Admin@savestatus");
    Route::post("/deleteorderedi","Admin@deleteorderedi");
    Route::get('/deleteOrder','Admin@deleteorder');
    Route::get('/accessUser','Admin@superuser');
    Route::get('/resetUser','Admin@resetuser');
});