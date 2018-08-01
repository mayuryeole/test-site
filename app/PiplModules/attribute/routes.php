<?php
Route::group(array('module'=>'Attribute','namespace' => 'App\PiplModules\attribute\Controllers','middleware'=>'web'), function() 
                {
        //Your routes belong to this module.
	Route::get("/admin/attributes-list","AttributeController@listAttributes")->middleware('permission:view.attributes');
//        ->middleware('permission:view.attributes');
	Route::get("/admin/attributes-list-data","AttributeController@listAttributesData")->middleware('permission:view.attributes');
//        ->middleware('permission:view.categories');
	Route::get("/admin/attribute/create","AttributeController@createAttributes")->middleware('permission:create.attributes');
//	->middleware('permission:create.categories');
	Route::post("/admin/attribute/create","AttributeController@createAttributes")->middleware('permission:create.attributes');
//	->middleware('permission:create.categories');
	Route::get("/admin/attribute/{attribute_id}/{locale?}","AttributeController@updateAttribute")->middleware('permission:update.attributes');
//	->middleware('permission:update.categories');
	Route::post("/admin/attribute/{attribute_id}/{locale?}","AttributeController@updateAttribute")->middleware('permission:update.attributes');
//	->middleware('permission:update.categories');
//	Route::delete("/admin/attribute/{category_id}","CategoryController@deleteCategory")->middleware('permission:delete.categories');
	Route::delete("/admin/attribute-delete-selected/{attribute_id}","AttributeController@deleteSelectedAttribute")->middleware('permission:delete.attributes');
//	->middleware('permission:delete.categories');
        Route::delete("/admin/attribute/delete/{attribute_id}","AttributeController@deleteAttribute")->middleware('permission:delete.attributes');
//        ->middleware('permission:delete.categories');

        Route::get("/check-duplicate-attribute-name", "AttributeController@chkDuplicateAttribute");
        Route::get("/check-update-duplicate-attribute-name", "AttributeController@chkUpDuplicateAttribute");
    //check-update-duplicate-attribute-name
});
