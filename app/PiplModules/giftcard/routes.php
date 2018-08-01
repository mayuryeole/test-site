<?php
Route::group(array('module'=>'GiftCard','namespace' => 'App\PiplModules\giftcard\Controllers','middleware'=>'web'), function() {
        //Your routes belong to this module.
	Route::get("/admin/gift-card-list","GiftCardController@listGiftCards")->middleware('permission:view.categories');
	Route::get("/admin/gift-cards-list-data","GiftCardController@listGiftCardsData")->middleware('permission:view.categories');
	Route::get("/admin/giftcard/create","GiftCardController@createGiftCard")->middleware('permission:create.categories');
	Route::post("/admin/giftcard/create","GiftCardController@createGiftCard")->middleware('permission:create.categories');
	Route::get("/admin/update-gift-card/{card_id}","GiftCardController@updateGiftCard")->middleware('permission:update.categories');
	Route::post("/admin/update-gift-card/{card_id}","GiftCardController@updateGiftCard")->middleware('permission:update.categories');
	Route::delete("/admin/giftcard/{card_id}","GiftCardController@deleteGiftCard")->middleware('permission:delete.categories');
	Route::delete("/admin/gift-card-delete-selected/{card_id}","GiftCardController@deleteSelectedGiftCard")->middleware('permission:delete.categories');
	Route::get('/gift-card/{gift_card_id}','GiftCardController@showGiftCardDetails');
	Route::post('/gift-card/{gift_card_id}','GiftCardController@showGiftCardDetails');
    Route::get("chk-gift-card-duplicate","GiftCardController@chkGiftCardDuplicate");
    Route::get("/gift-card-list","GiftCardController@listGiftCardFront");
});