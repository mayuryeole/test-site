<?php
Route::group(array('module'=>'display','namespace' => 'App\PiplModules\display\Controllers','middleware'=>'web'), function() {
        //Your routes belong to this module.
	Route::get("/admin/display-list","DisplayController@listdisplays")->middleware('permission:view.display');
	Route::get("/admin/display-list-data","DisplayController@listdisplaysData")->middleware('permission:view.display');
	Route::get("/admin/display/create","DisplayController@createDisplay")->middleware('permission:create.display');
	Route::post("/admin/display/create","DisplayController@createDisplay")->middleware('permission:create.display');
	Route::get("/admin/update-display/{display_id}","DisplayController@updateDisplay")->middleware('permission:update.display');
	Route::post("/admin/update-display/{display_id}","DisplayController@updateDisplay")->middleware('permission:update.display');
	Route::delete("/admin/display/{display_id}","DisplayController@deleteDisplay")->middleware('permission:delete.display');
	Route::delete("/admin/display-delete-selected/{display_id}","DisplayController@deleteSelectedBox")->middleware('permission:delete.display');
});