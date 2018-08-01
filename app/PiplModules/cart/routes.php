<?php
Route::group(array('module'=>'Cart','namespace' => 'App\PiplModules\cart\Controllers','middleware'=>'web'), function() {
    //Your routes belong to this module.
	
	Route::get("cart","CartController@showCart");
//    Route::post("/cart","CartController@proceedToCheckout");
	Route::get("/add-product-to-cart","CartController@addToCart");
    Route::get("/update-product-to-cart","CartController@updateToCart");
    Route::get("/change-cart-product-color","CartController@changeCartProductColor");
	Route::get("/remove-cart-item","CartController@removeCartItems");
//    Route::post("/proceed-to-checkout","CartController@proceedToCheckout");
    Route::post("/proceed-shipping-details","CartController@proceedShippingDetails");
    Route::post("/proceed-customer-shipping-details","CartController@proceedCustomerShippingDetails");
    Route::get("/add-remove-product-quantity","CartController@addRemoveProductQuantity");
    Route::post("/update-product-to-cart-form","CartController@updateProductToCart");
    Route::get("/get-all-cart-data-by-ajax","CartController@getCartDataByAjax");



    Route::post("/add-product-to-cart-form","CartController@addProductToCart");
    Route::get("/chekout-all-cart","CartController@checkoutAllCart");
    Route::get("/add-coupon","CartController@addCouponToCart");
    Route::get("/add-gift-card","CartController@addGiftCardToCart");
    Route::get("/remove-coupon","CartController@removeCouponFromCart");
    Route::get("/remove-promo-code","CartController@removePromoCodeFromCart");
    Route::get("/remove-gift-code","CartController@removeGiftCardFromCart");


    Route::post("/checkout-from-cart","CartController@checkoutFromCart");
    Route::get("/order-confirmation","CartController@orderConfirm");




    Route::get("/remove-box-from-cart","CartController@removeBoxFromCart");
    Route::get("/remove-paper-from-cart","CartController@removePaperFromCart");
    Route::get("/remove-display-from-cart","CartController@removeDisplayFromCart");


    Route::get("/add-promo-code","CartController@addCouponToCart");
    Route::get("/move-product-to-wishlist", "CartController@moveProductToWishlist");
    Route::get("/add-box-to-cart/{box_id}", "CartController@addBoxToCart");
    Route::get("/add-paper-to-cart/{paper_id}", "CartController@addPaperToCart");
    Route::get("/add-display-to-cart/{display_id}", "CartController@addDisplayToCart");

    Route::get("/admin/orders/{status?}", "OrderController@listOrders");
    Route::get("/admin/orders-data/{status}", "OrderController@listOrdersData");

    Route::get("/change-order-status", "OrderController@changeOrderStatus");
    Route::get("/get-label-pdf/{order_id}", "OrderController@getLabelPDF");

    Route::get("/view-order-front/{order_id}","OrderController@viewOrder");
    Route::get("/view-order-details-front/{order_id}", "OrderController@viewOrderDetails");
    Route::get("/order/view-orders", "OrderController@vieAllOrders");
    Route::post("/change-payment-status", "OrderController@changePaymentStatus");
    Route::get("/show/order-product/{order_id}", "OrderController@showOrder");
    Route::get("/fedex/service-details",'CartController@addServiceDetails');
    Route::get("/fedex/validate-final-rate-request",'CartController@validateFinalRateRequest');
    Route::post("/get-cart-grandtotal",'CartController@getGrandTotal');
    Route::get("/fedex/get-service-details",'CartController@getServiceDetails');
    Route::get("/add-both-to-cart/{product_id1}/{product_id2}","CartController@addBothToCart");
    Route::get("/order/get-order-label/{order_id}", "OrderController@getOrderLabel");
//    Route::get("/check-pin-code", "CartController@validateShippingPincode");
    Route::get('htmltopdfview',array('as'=>'htmltopdfview','uses'=>'OrderController@htmlToPdfView'));


    // DHL
    Route::get('/dhl/add-service-details','CartController@addDhlServiceDetails');
    Route::get('/cart/validate-for-checkout','CartController@validateCartForCheckout');
//    Route::get('/dhl/get-service-details','CartController@addDhlServiceDetails');



//        //Check-out routs here
//	    Route::get("/shipping-check-out","CartController@viewShippingCheckOut")->middleware('auth');
//	    Route::post("/payment-check-out","CartController@viewPaymentCheckOut")->middleware('auth');
//        Route::post("/review-check-out","CartController@viewReviewCheckOut")->middleware('auth');
//        Route::get("/review-check-out","CartController@viewReviewCheckOut")->middleware('auth');
//
//        Route::post("/change-payment-info","CartController@changePaymentInfo")->middleware('auth');
//        Route::post("/change-shipping-address","CartController@changeShippingAddress")->middleware('auth');
//
//        //add remove product quantity
//
//        //get quantity of specific vendor product
//        Route::get("/get-specific-vendor-product-quantity","CartController@getProductQuantityOfSpecificVendor")->middleware('auth');
//
//        Route::get("/add-zip-to-order","CartController@setCustomerZipcode")->middleware('auth');
//
//        //submir order
//        Route::get("/submir-order","CartController@submitOrder")->middleware('auth');
//        Route::get("/order-confirm","CartController@orderConfirm")->middleware('auth');
//
//        Route::get("/check-card","CartController@checkCard")->middleware('auth');
        
        
        
});
