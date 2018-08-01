<?php
Route::group(array('module'=>'Category','namespace' => 'App\PiplModules\category\Controllers','middleware'=>'web'), function() {
        //Your routes belong to this module.
	Route::get("/admin/categories-list","CategoryController@listCategories")->middleware('permission:view.categories');
	Route::get("/admin/categories-list-data","CategoryController@listCategoriesData")->middleware('permission:view.categories');
	Route::get("/admin/category/create","CategoryController@createCategories")->middleware('permission:create.categories');
	Route::post("/admin/category/create","CategoryController@createCategories")->middleware('permission:create.categories');
        Route::get("/admin/category/create_subcategories/{cat_id}","CategoryController@createSubCategories")->middleware('permission:create.categories');
        Route::post("/admin/category/create_subcategories/{cat_id}","CategoryController@createSubCategories")->middleware('permission:create.categories');
        Route::get("/admin/category/create_subsubcategories/{cat_id}","CategoryController@createSubSubCategories")->middleware('permission:create.categories');
        Route::post("/admin/category/create_subsubcategories/{cat_id}","CategoryController@createSubSubCategories")->middleware('permission:create.categories');
	Route::get("/admin/category/{category_id}/{locale?}","CategoryController@updateCategory")->middleware('permission:update.categories');
	Route::post("/admin/category/{category_id}/{locale?}","CategoryController@updateCategory")->middleware('permission:update.categories');
        Route::get("/admin/subcategory/{category_id}/{locale?}","CategoryController@updateSubCategory")->middleware('permission:update.categories');
	Route::post("/admin/subcategory/{category_id}/{locale?}","CategoryController@updateSubSubCategory")->middleware('permission:update.categories');
        Route::get("/admin/subsubcategory/{category_id}/{locale?}","CategoryController@updateSubSubCategory")->middleware('permission:update.categories');
	Route::post("/admin/subsubcategory/{category_id}/{locale?}","CategoryController@updateSubSubCategory")->middleware('permission:update.categories');
	Route::delete("/admin/category/{category_id}","CategoryController@deleteCategory")->middleware('permission:delete.categories');
	Route::delete("/admin/category-delete-selected/{category_id}","CategoryController@deleteSelectedCategory")->middleware('permission:delete.categories');
        Route::delete("/admin/category/delete/{category_id}","CategoryController@deleteCategory")->middleware('permission:delete.categories');
        Route::get("/admin/subcategories-list/{category_id}","CategoryController@listSubCategories")->middleware('permission:view.categories');
        Route::get("/admin/subcategories-list-data/{category_id}","CategoryController@listSubCategoriesData")->middleware('permission:view.categories');
        Route::get("/admin/subsubcategories-list/{category_id}","CategoryController@listSubSubCategories")->middleware('permission:view.categories');
        Route::get("/admin/subsubcategories-list-data/{category_id}","CategoryController@listSubSubCategoriesData")->middleware('permission:view.categories');

        Route::get("/check-duplicate-category","CategoryController@checkDupicateCategory");
        Route::get("/check-duplicate-main-category","CategoryController@checkDupicateMainCategory");

         Route::get("/admin/manage-category-discounts/{category_id}", "CategoryController@giveCategoryDiscount");//->middleware('permission:view.productCategories');
    Route::post("/admin/manage-category-discounts/{category_id}", "CategoryController@giveCategoryDiscount");//->middleware('permission:view.productCategories');

//        category attributes
    Route::get("/admin/manage-category-attributes/{category_id}", "CategoryController@listCategoryAttributes");
    Route::get("/admin/manage-category/attributes-data/{category_id}", "CategoryController@listCategoryAttributesData");
    Route::get("/admin/manage-category/attributes-value/{category_id}/{attribute_id}", "CategoryController@updateCategoryAttributesValue");

    Route::post("/admin/manage-category/attributes-value/{category_id}/{attribute_id}", "CategoryController@updateCategoryAttributesValue");
    Route::delete("/admin/delete-category/attributes-value/{attribute_id}", "CategoryController@deleteCategoryAttributesValue");
    Route::delete("/admin/delete-category-selected-attributes-value/{attribute_id}", "CategoryController@deleteSelectedCategoryAttributesValue");
    Route::post('/admin/remove-category-discount','CategoryController@removeCatDiscount');

});
