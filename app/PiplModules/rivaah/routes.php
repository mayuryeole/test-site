<?php

Route::group(array('module' => 'Rivaah', 'namespace' => 'App\PiplModules\rivaah\Controllers', 'middleware' => 'web'), function() {
    //Your routes belong to this module.
    Route::get("/admin/rivaah-galleries-list", "RivaahController@listRivaahGalleries");
    Route::get("/admin/rivaah-galleries-list-data", "RivaahController@listRivaahGalleriesData");
    Route::get("/admin/rivaah/create", "RivaahController@createRivaahGallery");
    Route::post("/admin/rivaah/create","RivaahController@createRivaahGallery");
    Route::get("/admin/rivaah/update/{gallery_id}", "RivaahController@updateRivaahGallery");
    Route::post("/admin/rivaah/update/{gallery_id}", "RivaahController@updateRivaahGallery");
    Route::delete("/admin/rivaah-delete-selected/{gallery_id}", "RivaahController@deleteSelectedRivaahGallery");
    Route::delete("/admin/rivaah/delete/{gallery_id}", "RivaahController@deleteRivaahGallery");
    Route::get("/admin/rivaah/manage-images/{category_id}", "RivaahController@manageImages");
    Route::post("/admin/rivaah/manage-images/{category_id}", "RivaahController@manageImages");
    Route::get("/admin/rivaah/deletedImages/delete-image/{id}", "RivaahController@deleteImage");
    Route::get("/check-duplicate-rivaah-gallery", "RivaahController@chkDuplicateRivaahGallery");
    Route::get("/check-update-duplicate-rivaah-gallery", "RivaahController@chkUpDuplicateRivaahGallery");


    Route::get('/rivaah-story/{image_id}','RivaahController@rivaahStory');
    Route::get('/rivaah-story-details/{image_id}','RivaahController@rivaahStoryDetails');
    Route::get('/rivaah-story-semi-details/{image_id}','RivaahController@rivaahStorySemiDetails');
});
