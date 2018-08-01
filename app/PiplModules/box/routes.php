<?php
Route::group(array('module'=>'box','namespace' => 'App\PiplModules\box\Controllers','middleware'=>'web'), function() {
        //Your routes belong to this module.
	Route::get("/admin/box-list","BoxController@listboxes")->middleware('permission:view.box');
	Route::get("/admin/box-list-data","BoxController@listboxesData")->middleware('permission:view.box');
	Route::get("/admin/box/create","BoxController@createBox")->middleware('permission:create.box');
	Route::post("/admin/box/create","BoxController@createBox")->middleware('permission:create.box');
	Route::get("/admin/update-box/{box_id}","BoxController@updateBox")->middleware('permission:update.box');
	Route::post("/admin/update-box/{box_id}","BoxController@updateBox")->middleware('permission:update.box');
	Route::delete("/admin/box/{box_id}","BoxController@deleteBox")->middleware('permission:delete.box');
	Route::delete("/admin/box-delete-selected/{box_id}","BoxController@deleteSelectedBox")->middleware('permission:delete.box');
});