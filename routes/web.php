<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::fallback(function () {
    return view('errors.404');
});

Route::group(['middleware' => 'checkAuthAndRole'], function () {

    Route::get('/menu-data', [App\Http\Controllers\C_menu::class, 'index'])->name('menudata');
    Route::get('/listDataMenu', [App\Http\Controllers\C_menu::class, 'listDataMenu'])->name('listDataMenu');
    Route::post('/addDataMenu', [App\Http\Controllers\C_menu::class, 'addDataMenu'])->name('addDataMenu');
    Route::post('/deleteDataMenu', [App\Http\Controllers\C_menu::class, 'deleteDataMenu'])->name('deleteDataMenu');
    Route::post('/updateDataMenu', [App\Http\Controllers\C_menu::class, 'updateDataMenu'])->name('updateDataMenu');

    Route::get('/submenu-data', [App\Http\Controllers\C_submenu::class, 'index'])->name('submenudata');
    Route::get('/listDataSubMenu', [App\Http\Controllers\C_submenu::class, 'listDataSubMenu'])->name('listDataSubMenu');
    Route::post('/addDataSubMenu', [App\Http\Controllers\C_submenu::class, 'addDataSubMenu'])->name('addDataSubMenu');
    Route::post('/deleteDataSubMenu', [App\Http\Controllers\C_submenu::class, 'deleteDataSubMenu'])->name('deleteDataSubMenu');
    Route::post('/updateDataSubMenu', [App\Http\Controllers\C_submenu::class, 'updateDataSubMenu'])->name('updateDataSubMenu');

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/product', [App\Http\Controllers\C_product::class, 'index'])->name('product');
    Route::get('/listDataProduct', [App\Http\Controllers\C_product::class, 'listDataProduct'])->name('listDataProduct');
    Route::post('/addDataProduct', [App\Http\Controllers\C_product::class, 'addDataProduct'])->name('addDataProduct');
    Route::post('/deleteDataProduct', [App\Http\Controllers\C_product::class, 'deleteDataProduct'])->name('deleteDataProduct');
    Route::post('/updateDataProduct', [App\Http\Controllers\C_product::class, 'updateDataProduct'])->name('updateDataProduct');

    Route::get('/product-categori', [App\Http\Controllers\C_productcategori::class, 'index'])->name('product-categori');
    Route::get('/listDataCategori', [App\Http\Controllers\C_productcategori::class, 'listDataCategori'])->name('listDataCategori');
    Route::post('/addDataCategori', [App\Http\Controllers\C_productcategori::class, 'addDataCategori'])->name('addDataCategori');
    Route::post('/deleteDataCategori', [App\Http\Controllers\C_productcategori::class, 'deleteDataCategori'])->name('deleteDataCategori');
    Route::post('/updateDataCategori', [App\Http\Controllers\C_productcategori::class, 'updateDataCategori'])->name('updateDataCategori');

    Route::get('/product-unit', [App\Http\Controllers\C_productunit::class, 'index'])->name('product_unit');
    Route::get('/listDataUnit', [App\Http\Controllers\C_productunit::class, 'listDataUnit'])->name('listDataUnit');
    Route::post('/addDataUnit', [App\Http\Controllers\C_productunit::class, 'addDataUnit'])->name('addDataUnit');
    Route::post('/deleteDataUnit', [App\Http\Controllers\C_productunit::class, 'deleteDataUnit'])->name('deleteDataUnit');
    Route::post('/updateDataUnit', [App\Http\Controllers\C_productunit::class, 'updateDataUnit'])->name('updateDataUnit');

    Route::get('/purchase', [App\Http\Controllers\C_productunit::class, 'index'])->name('purchase');
    Route::get('/listDataPurchase', [App\Http\Controllers\C_productunit::class, 'listDataPurchase'])->name('listDataPurchase');
    Route::post('/addDataPurchase', [App\Http\Controllers\C_productunit::class, 'addDataPurchase'])->name('addDataPurchase');
    Route::post('/deleteDataPurchase', [App\Http\Controllers\C_productunit::class, 'deleteDataPurchase'])->name('deleteDataPurchase');
    Route::post('/updateDataPurchase', [App\Http\Controllers\C_productunit::class, 'updateDataPurchase'])->name('updateDataPurchase');

    Route::get('/user', [App\Http\Controllers\C_user::class, 'index'])->name('user');
    Route::get('/listDataUser', [App\Http\Controllers\C_user::class, 'listDataUser'])->name('listDataUser');
    Route::post('/addDataUser', [App\Http\Controllers\C_user::class, 'addDataUser'])->name('addDataUser');
    Route::post('/deleteDataUser', [App\Http\Controllers\C_user::class, 'deleteDataUser'])->name('deleteDataUser');
    Route::post('/updateDataUser', [App\Http\Controllers\C_user::class, 'updateDataUser'])->name('updateDataUser');

    Route::get('/user-menu', [App\Http\Controllers\C_usermenu::class, 'index'])->name('usermenu');
    Route::get('/listDataUserMenu', [App\Http\Controllers\C_usermenu::class, 'listDataUserMenu'])->name('listDataUserMenu');
    Route::post('/addDataUserMenu', [App\Http\Controllers\C_usermenu::class, 'addDataUserMenu'])->name('addDataUserMenu');
    Route::post('/deleteDataUserMenu', [App\Http\Controllers\C_usermenu::class, 'deleteDataUserMenu'])->name('deleteDataUserMenu');
    Route::post('/updateDataUserMenu', [App\Http\Controllers\C_usermenu::class, 'updateDataUserMenu'])->name('updateDataUserMenu');

    Route::get('/unit-conversion', [App\Http\Controllers\C_unitConversion::class, 'index'])->name('unit-conversion');
    Route::get('/listDataUnitConversion', [App\Http\Controllers\C_unitConversion::class, 'listDataUnitConversion'])->name('listDataUnitConversion');
    Route::post('/addDataUnitConversion', [App\Http\Controllers\C_unitConversion::class, 'addDataUnitConversion'])->name('addDataUnitConversion');
    Route::post('/deleteDataUnitConversion', [App\Http\Controllers\C_unitConversion::class, 'deleteDataUnitConversion'])->name('deleteDataUnitConversion');
    Route::post('/updateDataUnitConversion', [App\Http\Controllers\C_unitConversion::class, 'updateDataUnitConversion'])->name('updateDataUnitConversion');

});


Auth::routes();
