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

    Route::get('/purchase', [App\Http\Controllers\C_purchase::class, 'index'])->name('purchase');
    Route::get('/listDataPurchase', [App\Http\Controllers\C_purchase::class, 'listDataPurchase'])->name('listDataPurchase');
    Route::post('/addDataPurchase', [App\Http\Controllers\C_purchase::class, 'addDataPurchase'])->name('addDataPurchase');
    Route::post('/deleteDataPurchase', [App\Http\Controllers\C_purchase::class, 'deleteDataPurchase'])->name('deleteDataPurchase');
    Route::post('/updateDataPurchase', [App\Http\Controllers\C_purchase::class, 'updateDataPurchase'])->name('updateDataPurchase');

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

    Route::get('/suppliers', [App\Http\Controllers\C_supplier::class, 'index'])->name('suppliers');
    Route::get('/listDataSuppliers', [App\Http\Controllers\C_supplier::class, 'listDataSuppliers'])->name('listDataSuppliers');
    Route::post('/addDataSuppliers', [App\Http\Controllers\C_supplier::class, 'addDataSuppliers'])->name('addDataSuppliers');
    Route::post('/deleteDataSuppliers', [App\Http\Controllers\C_supplier::class, 'deleteDataSuppliers'])->name('deleteDataSuppliers');
    Route::post('/updateDataSuppliers', [App\Http\Controllers\C_supplier::class, 'updateDataSuppliers'])->name('updateDataSuppliers');

    Route::get('/purchase/detail/{purchaseId}', [App\Http\Controllers\C_purchasedetail::class, 'index'])->name('purchase-detail');
    Route::get('/purchase/detail/listDataPurchase/{purchaseId}', [App\Http\Controllers\C_purchasedetail::class, 'listDataPurchase'])->name('detail-listDataPurchase');
    Route::post('/purchase/detail/addDataPurchase', [App\Http\Controllers\C_purchasedetail::class, 'addDataPurchase'])->name('detail-addDataPurchase');
    Route::post('/purchase/detail/deleteDataPurchase', [App\Http\Controllers\C_purchasedetail::class, 'deleteDataPurchase'])->name('detail-deleteDataPurchase');
    Route::post('/purchase/detail/updateDataPurchase', [App\Http\Controllers\C_purchasedetail::class, 'updateDataPurchase'])->name('detail-updateDataPurchase');

    Route::get('/inbound', [App\Http\Controllers\C_inbound::class, 'index'])->name('inbound');
    Route::get('/listDataInbound', [App\Http\Controllers\C_inbound::class, 'listDataInbound'])->name('listDataInbound');
    Route::post('/addDataInbound', [App\Http\Controllers\C_inbound::class, 'addDataInbound'])->name('addDataInbound');
    Route::post('/deleteDataInbound', [App\Http\Controllers\C_inbound::class, 'deleteDataInbound'])->name('deleteDataInbound');
    Route::post('/updateDataInbound', [App\Http\Controllers\C_inbound::class, 'updateDataInbound'])->name('updateDataInbound');

    Route::get('/inbound/detail/{inboundId}', [App\Http\Controllers\C_inboundetail::class, 'index'])->name('inbound-detail');
    Route::get('/inbound/detail/listDataInbound/{inboundId}', [App\Http\Controllers\C_inboundetail::class, 'listDataInbound'])->name('detail-listDataInbound');
    Route::post('/inbound/detail/addDataInbound', [App\Http\Controllers\C_inboundetail::class, 'addDataInbound'])->name('detail-addDataInbound');
    Route::post('/inbound/detail/deleteDataInbound', [App\Http\Controllers\C_inboundetail::class, 'deleteDataInbound'])->name('detail-deleteDataInbound');
    Route::post('/inbound/detail/updateDataInbound', [App\Http\Controllers\C_inboundetail::class, 'updateDataInbound'])->name('detail-updateDataInbound');
    Route::post('/inbound/detail/validDataInbound', [App\Http\Controllers\C_inboundetail::class, 'validDataInbound'])->name('detail-validDataInbound');

    Route::get('/outbound', [App\Http\Controllers\C_outbound::class, 'index'])->name('outbound');
    Route::get('/listDataOutbound', [App\Http\Controllers\C_outbound::class, 'listDataOutbound'])->name('listDataOutbound');
    Route::post('/addDataOutbound', [App\Http\Controllers\C_outbound::class, 'addDataOutbound'])->name('addDataOutbound');
    Route::post('/deleteDataOutbound', [App\Http\Controllers\C_outbound::class, 'deleteDataOutbound'])->name('deleteDataOutbound');
    Route::post('/updateDataOutbound', [App\Http\Controllers\C_outbound::class, 'updateDataOutbound'])->name('updateDataOutbound');

    Route::get('/outbound/detail/{outboundId}', [App\Http\Controllers\C_outboundetail::class, 'index'])->name('outbound-detail');
    Route::get('/outbound/detail/listDataOutbound/{outboundId}', [App\Http\Controllers\C_outboundetail::class, 'listDataOutbound'])->name('detail-listDataOutbound');
    Route::post('/outbound/detail/addDataOutbound', [App\Http\Controllers\C_outboundetail::class, 'addDataOutbound'])->name('detail-addDataOutbound');
    Route::post('/outbound/detail/deleteDataOutbound', [App\Http\Controllers\C_outboundetail::class, 'deleteDataOutbound'])->name('detail-deleteDataOutbound');
    Route::post('/outbound/detail/updateDataOutbound', [App\Http\Controllers\C_outboundetail::class, 'updateDataOutbound'])->name('detail-updateDataOutbound');
    Route::post('/outbound/detail/validDataOutbound', [App\Http\Controllers\C_outboundetail::class, 'validDataOutbound'])->name('detail-validDataOutbound');

});


Auth::routes();
