<?php

Route::group(array('module'=>'Artist', 'namespace' => 'App\PiplModules\artist\Controllers','middleware'=>'web'), function() {
    //Your routes belong to this module.
	
//manage aritst
        Route::get("admin/manage-artist","ArtistController@listRegisteredArtist")->middleware('permission:view.manage-artist');

        Route::get("/admin/list-artist-data","ArtistController@listArtist")->middleware('permission:view.manage-artist');
	
        Route::delete("/admin/delete-artist/{user_id}","ArtistController@deleteArtist")->middleware('permission:delete.artist');
	Route::delete("/admin/delete-selected-artist/{user_id}","ArtistController@deleteSelectedArtist")->middleware('permission:delete.artist');
        
        Route::get("/admin/artist/update/{page_id}","ArtistController@updateArtist")->middleware('permission:update.artist');
        Route::post("/admin/artist/update/{page_id}","ArtistController@updateArtist")->middleware('permission:update.artist');	
        
        Route::get("admin/create-registered-artist","ArtistController@createRegisteredArtist")->middleware('permission:create.artist');
	Route::post("admin/create-registered-artist","ArtistController@createRegisteredArtist")->middleware('permission:create.artist');     
//for multiple image delete        
        Route::get("/admin/artist/deletedImages/delete-image/{id}","ArtistController@deleteImage")->middleware('permission:view.manage-artist');
        Route::get("chk-artist-email-duplicate","ArtistController@chkArtistDuplicateEmail");


       // Artist appointment controller


        Route::get('artist/appointment/{artist_id}',"ArtistAppointmentController@getArtistAppointment");
        Route::post('artist/appointment/customer-info',"ArtistAppointmentController@setArtistAppointment");
        Route::get('admin/manage-artist-appointments','ArtistAppointmentController@listArtistAppointments');
        Route::get("/admin/list-artist-appointment-data","ArtistAppointmentController@listArtistAppointmentData");

        Route::delete("/admin/delete-artist-appointment/{user_id}","ArtistAppointmentController@deleteArtistAppointment")->middleware('permission:delete.appointment');
        Route::delete("/admin/delete-selected-artist-appointment/{user_id}","ArtistAppointmentController@deleteSelectedArtistAppointment")->middleware('permission:delete.appointment');
        Route::get("/admin/artist-appointment/view/{id}","ArtistAppointmentController@viewArtistAppointment");
//manage aritst end

});
