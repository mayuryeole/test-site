<?php

Route::group(array('module' => 'gallery', 'namespace' => 'App\PiplModules\gallery\Controllers', 'middleware' => 'web'), function() {
    //Your routes belong to this module.

    Route::get("/admin/gallery-list", "GalleryController@listGallery")->middleware('permission:view.gallery');
    Route::post("/gallery/add-user-ratings/","GalleryController@addUserGalleryRatings");

    Route::get("/admin/gallery-list-data", "GalleryController@listGalleryData") ->middleware('permission:view.gallery');
    Route::get("/admin/gallery/create", "GalleryController@createGallery")->middleware('permission:create.gallery');
    Route::get("/admin/gallery/manage-images/{category_id}", "GalleryController@manageImages")->middleware('permission:manageImages.gallery');
    Route::get("/admin/gallery/manage-subimages/{category_id}", "GalleryController@manageSubImages")->middleware('permission:manageImages.gallery');
    Route::post("/admin/gallery/manage-images/{category_id}", "GalleryController@manageImages")->middleware('permission:manageImages.gallery');
    Route::post("/admin/gallery/manage-subimages/{category_id}", "GalleryController@manageSubImages")->middleware('permission:manageImages.gallery');
    Route::get("/admin/gallery/manage-videos/{category_id}", "GalleryController@manageVideos")->middleware('permission:manageVideos.gallery');
    Route::get("/admin/gallery/manage-subvideos/{id}", "GalleryController@manageSubVideos")->middleware('permission:manageVideos.gallery');
    Route::post("/admin/gallery/manage-videos/{category_id}", "GalleryController@manageVideos")->middleware('permission:manageVideos.gallery');
    Route::post("/admin/gallery/manage-subvideos/{id}", "GalleryController@manageSubVideos")->middleware('permission:manageVideos.gallery');
    Route::post("/admin/gallery/create", "GalleryController@createGallery")->middleware('permission:create.gallery');
    Route::get("/admin/subgallery/create/{gallery_id}", "GalleryController@createSubGallery")->middleware('permission:create.gallery');
    Route::post("/admin/subgallery/create/{gallery_id}", "GalleryController@createSubGallery")->middleware('permission:create.gallery');
    Route::get("/admin/gallery/{category_id}/{locale?}", "GalleryController@updateGallery")->middleware('permission:update.gallery');
    Route::get("/admin/subgallery/{category_id}/{locale?}", "GalleryController@updateSubGallery")->middleware('permission:update.gallery');
    Route::post("/admin/gallery/{category_id}/{locale?}", "GalleryController@updateGallery")->middleware('permission:update.gallery');
    Route::post("/admin/subgallery/{category_id}/{locale?}", "GalleryController@updateSubGallery")->middleware('permission:update.gallery');
//    Route::delete("/admin/gallery/{category_id}", "GalleryController@deleteGallery");/->middleware('permission:delete.categories');

    Route::delete("/admin/gallery-delete-selected/{category_id}", "GalleryController@deleteSelectedGallery")->middleware('permission:delete.gallery');
    Route::delete("/admin/subgallery-delete-selected/{category_id}", "GalleryController@deleteSelectedSubGallery")->middleware('permission:delete.gallery');

    Route::delete("/admin/gallery/delete/{category_id}", "GalleryController@deleteGallery")->middleware('permission:delete.gallery');    
    Route::delete("/admin/subgallery/delete/{category_id}", "GalleryController@deleteSubGallery")->middleware('permission:delete.gallery');    


    Route::get("/admin/sub-gallery-list/{sub_category_id}", "GalleryController@listSubGallery")->middleware('permission:view.gallery');
    Route::get("/admin/sub-gallery-list-data/{sub_category_id}", "GalleryController@listSubGalleryData")->middleware('permission:view.gallery');
    Route::get("/admin/gallery/deletedImages/delete-image/{id}", "GalleryController@deleteImage")->middleware('permission:delete.gallery');
    Route::get("/admin/gallery/deletedVideo/delete-video/{id}", "GalleryController@deleteVideo")->middleware('permission:delete.gallery');

    Route::get("/admin/rooms-list", "GalleryController@listRooms")->middleware('permission:view.rooms');
    Route::get("/admin/rooms-list-data", "GalleryController@listRoomsData")->middleware('permission:view.rooms'); //
    Route::get("/admin/rooms/{category_id}/{locale?}", "GalleryController@updateRooms")->middleware('permission:update.rooms');
    Route::post("/admin/rooms/{category_id}/{locale?}", "GalleryController@updateRooms")->middleware('permission:update.rooms');
    
    // manage Gallery Ratings
    Route::get("/admin/list-gal-ratings","GalleryController@listGalRatings")->middleware('permission:view.gallery-ratings');
    Route::get("/admin/list-gal-rating-data","GalleryController@listGalRatingData")->middleware('permission:view.gallery-ratings');
    Route::get("/admin/update-gal-rating/{id}","GalleryController@updateGalRating")->middleware('permission:update.gallery-ratings');
    Route::post("/admin/update-gal-rating/{id}","GalleryController@updateGalRating")->middleware('permission:update.gallery-ratings');
    Route::delete("/admin/galary-rating/delete/{id}","GalleryController@deleteGalRating")->middleware('permission:delete.gallery-ratings');
    Route::delete("/admin/galary-rating/delete-selected/{id}","GalleryController@deleteGalRatingSelected")->middleware('permission:delete.gallery-ratings');
   
});
?>