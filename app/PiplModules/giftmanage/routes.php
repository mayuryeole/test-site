<?php
Route::group(array('module'=>'giftmanage','namespace' => 'App\PiplModules\giftmanage\Controllers','middleware'=>'web'), function() {
        //Your routes belong to this module.
	Route::get("/admin/gift-list","GiftController@listgifts")->middleware('permission:view.categories');
	Route::get("/admin/gifts-list-data","GiftController@listgiftsData")->middleware('permission:view.categories');
	Route::get("/admin/gift/create","GiftController@createGift")->middleware('permission:create.categories');
	Route::post("/admin/gift/create","GiftController@createGift")->middleware('permission:create.categories');
	Route::get("/admin/update-gift/{gift_id}","GiftController@updateGift")->middleware('permission:update.categories');
	Route::post("/admin/update-gift/{gift_id}","GiftController@updateGift")->middleware('permission:update.categories');
	Route::delete("/admin/gift/{gift_id}","GiftController@deleteGift")->middleware('permission:delete.categories');
	Route::delete("/admin/gift-delete-selected/{gift_id}","GiftController@deleteSelectedGift")->middleware('permission:delete.categories');
});