<?php

Route::group(array('module' => 'Product', 'namespace' => 'App\PiplModules\product\Controllers', 'middleware' => 'web'), function() {
    //Your routes belong to this module.
    Route::get("/admin/products-list", "ProductController@listProducts");
    Route::get("/admin/products-list-data/{stock}", "ProductController@listProductsData");
    Route::get("/admin/product/create", "ProductController@createProducts");
    Route::post("/admin/product/create", "ProductController@createProducts");
    Route::get("/admin/product-view/{product_id}", "ProductController@viewProduct");
    Route::get("/admin/product/update/{product_id}", "ProductController@updateProduct");
    Route::post("/admin/product/update/{product_id}", "ProductController@updateProduct");
    Route::get("admin/product/remove-photo/{image_id}", "BlogController@removePhoto");
    Route::delete("/admin/product-delete-selected/{product_id}", "ProductController@deleteSelectedProduct");
    Route::delete("/admin/product/delete/{product_id}", "ProductController@deleteProduct");
    
    Route::get("/check-duplicate-product", "ProductController@chkDuplicateProduct")->middleware('permission:update.productCategory');
    Route::get("/check-update-duplicate-product", "ProductController@chkUpDuplicateProduct");
    
    Route::get("/admin/manage-product-image/{product_id}", "ProductController@manageProductImages");
    Route::get("/admin/manage-product-image/data/{product_id}", "ProductController@manageProductImagesData");
    
    Route::get("/admin/product-image/create/{product_id}", "ProductController@createProductImages");
    Route::post("/admin/product-image/create/{product_id}", "ProductController@createProductImages");
    Route::get("/admin/product-image/update/{product_id}/{color}", "ProductController@updateProductImages");
    Route::post("/admin/product-image/update/{product_id}/{color}", "ProductController@updateProductImages");
    Route::delete("/admin/delete-product-image/{image_id}", "ProductController@deleteProductImages")->middleware('permission:delete.productCategory');
    Route::delete("/admin/delete-product-selected-image/{image_id}", "ProductController@deleteSelectedProductImages")->middleware('permission:delete.productCategory');

    
    
    Route::get("/admin/manage-product-attributes/{product_id}", "ProductController@listProductAttributes");
    Route::get("/admin/manage-product/attributes-data/{product_id}", "ProductController@listProductAttributesData");
    Route::get("/admin/manage-product/attributes-value/{product_id}/{attribute_id}", "ProductController@updateProductAttributesValue");

    Route::post("/admin/manage-product/attributes-value/{product_id}/{attribute_id}", "ProductController@updateProductAttributesValue");
    Route::delete("/admin/delete-product/attributes-value/{attribute_id}", "ProductController@deleteProductAttributesValue")->middleware('permission:delete.productCategory');
    Route::delete("/admin/delete-product-selected-attributes-value/{attribute_id}", "ProductController@deleteSelectedProductAttributesValue")->middleware('permission:delete.productCategory');

     /*product styles*/
    
    Route::get("/admin/product-styles", "ProductController@listStyles")->middleware('permission:view.productCategories');
    Route::get("/admin/product-styles-data", "ProductController@listStylesData")->middleware('permission:view.productCategories');
    Route::get("/admin/product-styles/create", "ProductController@createStyles")->middleware('permission:create.productCategory');
    Route::post("/admin/product-styles/create", "ProductController@createStyles")->middleware('permission:create.productCategory');

    Route::get("/admin/product-styles/{style_id}", "ProductController@updateStyles")->middleware('permission:update.productCategory');
    Route::post("/admin/product-styles/{style_id}", "ProductController@updateStyles")->middleware('permission:update.productCategory');

    Route::delete("/admin/delete-product-style/{style_id}", "ProductController@deleteStyles")->middleware('permission:delete.productCategory');
    Route::delete("/admin/delete-product-selected-style/{style_id}", "ProductController@deleteSelectedStyles")->middleware('permission:delete.productCategory');
    Route::get("/check-duplicate-style", "ProductController@chkDuplicateStyle")->middleware('permission:update.productCategory');
    
    
    /*product collection styles*/
    
    Route::get("/admin/product-collection-styles", "ProductController@listCollectionStyles")->middleware('permission:view.productCategories');
    Route::get("/admin/product-collection-styles-data", "ProductController@listCollectionStylesData")->middleware('permission:view.productCategories');
    Route::get("/admin/product-collection-styles/create", "ProductController@createCollectionStyles")->middleware('permission:create.productCategory');
    Route::post("/admin/product-collection-styles/create", "ProductController@createCollectionStyles")->middleware('permission:create.productCategory');

    Route::get("/admin/product-collection-styles/{style_id}", "ProductController@updateCollectionStyles")->middleware('permission:update.productCategory');
    Route::post("/admin/product-collection-styles/{style_id}", "ProductController@updateCollectionStyles")->middleware('permission:update.productCategory');

    Route::delete("/admin/delete-collection-product-style/{style_id}", "ProductController@deleteCollectionStyles")->middleware('permission:delete.productCategory');
    Route::delete("/admin/delete-collection-product-selected-style/{style_id}", "ProductController@deleteSelectedCollectionStyles")->middleware('permission:delete.productCategory');
    Route::get("/check-duplicate-collection-style", "ProductController@chkDuplicateCollectionStyle")->middleware('permission:update.productCategory');
    Route::get("/check-update-duplicate-collection-style", "ProductController@chkUpDuplicateCollectionStyle");
    
    /*product occasion*/
    
    Route::get("/admin/product-occasion", "ProductController@listOccasion")->middleware('permission:view.productCategories');
    Route::get("/admin/product-occasion-data", "ProductController@listOccasionData")->middleware('permission:view.productCategories');
    Route::get("/admin/product-occasion/create", "ProductController@createOccasion")->middleware('permission:create.productCategory');
    Route::post("/admin/product-occasion/create", "ProductController@createOccasion")->middleware('permission:create.productCategory');

    Route::get("/admin/product-occasion/update/{style_id}", "ProductController@updateOccasion")->middleware('permission:update.productCategory');
    Route::post("/admin/product-occasion/update/{style_id}", "ProductController@updateOccasion")->middleware('permission:update.productCategory');

    Route::delete("/admin/delete-occasion/{style_id}", "ProductController@deleteOccasion")->middleware('permission:delete.productCategory');
    Route::delete("/admin/delete-occasion-selected/{style_id}", "ProductController@deleteSelectedOccasion")->middleware('permission:delete.productCategory');

    Route::get("/check-duplicate-occasion", "ProductController@chkDuplicateOccasion")->middleware('permission:update.productCategory');
    
    
    
    Route::get("/admin/manage-discounts/{project_id}", "ProductController@giveDiscount")->middleware('permission:view.productCategories');
    Route::post("/admin/manage-discounts/{project_id}", "ProductController@giveDiscount")->middleware('permission:view.productCategories');
    Route::post("/admin/remove-product-discount","ProductController@removeDiscount");
    
    /*Inventory routes*/
    Route::get("/admin/inventory-list", "InventoryController@listInventory");
    Route::get("/admin/inventory-list-data", "InventoryController@listInventorysData");
//    Route::get("/admin/inventory/create", "InventoryController@createInventory");
//    Route::post("/admin/inventory/create", "InventoryController@createInventory");
//    Route::get("/admin/inventory-view/{inventory_id}", "InventoryController@viewInventory");
    Route::get("/admin/inventory/update/{inventory_id}", "InventoryController@updateInventory");
    Route::post("/admin/inventory/update/{inventory_id}", "InventoryController@updateInventory");
    Route::post('/get-category-size-values','ProductController@getCatSizeValue');
    
    
    
    /*Front end routes starts here*/
    //Route for front end
    Route::get("/product/dashboard", "ProductController@showDashboard");
    Route::get("/product", "ProductController@viewProductCategories");
    Route::get("/product/categories/", "ProductController@viewCategories");
    Route::get("/product/categories/{category_name}", "ProductController@viewCategories");
    Route::get("/product/lists/{category_id}", "ProductController@lists");
    Route::get("/product/searchAll", "ProductController@viewAllProducts");
    Route::get("/product/search", "ProductController@viewProductsForTag");
    Route::get("product/viewProductsDetails/{product_id}", "ProductController@viewProductsDetails");
    
    Route::get("/product/searchPrice", "ProductController@viewProductForPrice");
    Route::get("/product/searchColor", "ProductController@viewProductForColor");
    Route::get("/product/list", "ProductController@listAllProducts");
    Route::get("/product/details", "ProductController@productDetails");
//    Route::get("/search-product", "ProductController@searchProduct");
    Route::post("/product/search-product", "ProductController@searchProduct");


    Route::get("/search-product", "ProductSearchController@searchProductFront");
    Route::get("/ajax-search-product", "ProductSearchController@ajaxProductLoad");
    Route::get("/check-slider", "ProductSearchController@checkSlider");
    Route::get("/get-product-quick-view", "ProductSearchController@getAjaxProductDetail");
    Route::post("/get-product-quick-view", "ProductSearchController@getAjaxProductDetail");
    Route::get("/product/{product_id}", "ProductSearchController@getProductDetails");
    Route::get("/product/show-video/{product_id}","ProductController@getProductVideoView");

    Route::get("/admin/product/deletedImages/delete-image/{id}", "ProductController@deleteColorImage");

});
