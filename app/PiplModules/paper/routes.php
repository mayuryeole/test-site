<?php
Route::group(array('module'=>'paper','namespace' => 'App\PiplModules\paper\Controllers','middleware'=>'web'), function() {
        //Your routes belong to this module.
	Route::get("/admin/paper-list","PaperController@listpapers")->middleware('permission:view.paper');
	Route::get("/admin/papers-list-data","PaperController@listpapersData")->middleware('permission:view.paper');
	Route::get("/admin/paper/create","PaperController@createPaper")->middleware('permission:create.paper');
	Route::post("/admin/paper/create","PaperController@createPaper")->middleware('permission:create.paper');
	Route::get("/admin/update-paper/{paper_id}","PaperController@updatePaper")->middleware('permission:update.paper');
	Route::post("/admin/update-paper/{paper_id}","PaperController@updatePaper")->middleware('permission:update.paper');
	Route::delete("/admin/paper/{paper_id}","PaperController@deletePaper")->middleware('permission:delete.paper');
	Route::delete("/admin/paper-delete-selected/{paper_id}","PaperController@deleteSelectedPaper")->middleware('permission:delete.paper');
});