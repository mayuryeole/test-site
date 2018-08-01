<?php
Route::group(array('module'=>'subcategory','namespace' => 'App\PiplModules\subcategory\Controllers','middleware'=>'web'), function() {
        //Your routes belong to this module.
	Route::get("/admin/subcategories-list","SubCategoryController@listSubCategories")->middleware('permission:manage.subcategory');
	Route::get("/admin/subcategories-list-data","SubCategoryController@listSubCategoriesData")->middleware('permission:manage.subcategory');
	Route::get("/admin/subcategory/create","SubCategoryController@createSubCategories")->middleware('permission:manage.subcategory');
	Route::post("/admin/subcategory/create","SubCategoryController@createSubCategories")->middleware('permission:manage.subcategory');
	Route::get("/admin/subcategory/{category_id}","SubCategoryController@updateSubCategory")->middleware('permission:manage.subcategory');
	Route::post("/admin/subcategory/{category_id}/{locale?}","SubCategoryController@updateSubCategory")->middleware('permission:manage.subcategory');
	Route::delete("/admin/subcategory/{category_id}","SubCategoryController@deleteSubCategory")->middleware('permission:manage.subcategory');
	Route::delete("/admin/subcategory-delete-selected/{category_id}","SubCategoryController@deleteSelectedSubCategory")->middleware('permission:manage.subcategory');
});