<?php
Route::group(array('module'=>'wishlist','namespace' => 'App\PiplModules\wishlist\Controllers','middleware'=>'web'), function() {
        //Your routes belong to this module.
	Route::get("/ajax-add-product-in-wishlist","WishlistController@addToWishlist");

	Route::get("/wishlist","WishlistController@viewWishlist");
	Route::get("/ajax-remove-product-from-wishlist","WishlistController@removeFromWishlist");
	Route::get("/ajax-update-wishlist", "WishlistController@updateWishlist");
	Route::get("/get-product-image","WishlistController@productImage");
    Route::post("/move-product-to-cart", "WishlistController@moveProductToCart");
	
	
});