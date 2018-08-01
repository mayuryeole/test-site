<?php

Route::group(array('module' => 'Inventory', 'namespace' => 'App\PiplModules\inventory\Controllers', 'middleware' => 'web'), function() {
    //Your routes belong to this module.
    Route::get("/admin/inventory-list", "InventoryController@listInventory");
    Route::get("/admin/inventory-list-data", "InventoryController@listInventoryData");
//    Route::get("/admin/inventory/create", "InventoryController@createInventory");
//    Route::post("/admin/inventory/create", "InventoryController@createInventory");
//    Route::get("/admin/inventory-view/{inventory_id}", "InventoryController@viewInventory");
    Route::get("/admin/inventory/update/{inventory_id}", "InventoryController@updateInventory");
    Route::post("/admin/inventory/update/{inventory_id}", "InventoryController@updateInventory");
    
    Route::get("/admin/inventory/create-excel", "InventoryController@createInventoryExcel");
    Route::post("/admin/inventory/import-excel", "InventoryController@ImportInventoryExcel");
    Route::post("/admin/bulk-upload/upload-product", "InventoryController@uploadBulkProduct");
    Route::get("/admin/inventory/show-product-media/{type}",'InventoryController@goToBulkProductList');
    Route::get("/admin/inventory/remove-product-media/{type}/{name}",'InventoryController@removeBulkProductMedia');
    //Route::get("/admin/inventory/show-list-product-media/{type}",'InventoryController@goToBulkProductListData');
       
});
