<?php
Route::group(array('module'=>'coupon','namespace' => 'App\PiplModules\coupon\Controllers','middleware'=>'web'), function() {
        //Your routes belong to this module.
	Route::get("/admin/coupons-list","CouponController@listCoupons")->middleware('permission:view.coupon');
	Route::get("/admin/coupons-list-data","CouponController@listCouponsData")->middleware('permission:view.coupon');
	Route::get("chk-coupon-duplicate","CouponController@chkCouponCodeDuplicate");
	Route::get("/admin/coupon/create","CouponController@createCoupon")->middleware('permission:create.coupon');
	Route::post("/admin/coupon/create","CouponController@createCoupon")->middleware('permission:create.coupon');
	Route::get("/admin/update-coupon/{coupon_id}","CouponController@updateCoupon")->middleware('permission:update.coupon');
	Route::post("/admin/update-coupon/{coupon_id}","CouponController@updateCoupon")->middleware('permission:update.coupon');
	Route::delete("/admin/coupon/{coupon_id}","CouponController@deleteCoupon")->middleware('permission:delete.coupon');
	Route::delete("/admin/coupon-delete-selected/{coupon_id}","CouponController@deleteSelectedCoupon")->middleware('permission:delete.coupon');

	//list users
//	Route::get("/admin/manage-coupon-users/{coupon}","CouponController@listCouponRegisteredUsers");
    Route::get("/admin/manage-coupon-users/{coupon}/{user_type}","CouponController@listCouponRegisteredUsers");
    Route::get("/admin/list-registered-users-coupon-data/{coupon}/{user_type?}","CouponController@listCouponRegisteredUsersData");
    Route::post("/admin/send-to-user/{coupon_id}/{user_id}","CouponController@sendCouponToUser");
    Route::post("/admin/send-to-selected-user/{coupon_id}/{user_id}","CouponController@sendCouponToSelectedUser");

});