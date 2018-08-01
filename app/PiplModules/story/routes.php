<?php

Route::group(array('module' => 'story', 'namespace' => 'App\PiplModules\story\Controllers', 'middleware' => 'web'), function() {
    //Your routes belong to this module.

    Route::get("/admin/story", "StoryController@index")->middleware('permission:view.story');
    Route::get("/admin/story-post/remove-attachment/{post_id}/{original_name}", "StoryController@removeAttachment");//->middleware('permission:view.blog');
    Route::get("/admin/story-data", "StoryController@getBlogData")->middleware('permission:view.story');

    Route::get("/admin/story-post/create", "StoryController@createBlogPost")->middleware('permission:create.story');
    Route::post("/admin/story-post/create", "StoryController@createBlogPost")->middleware('permission:create.story');

    Route::delete("/admin/story-post/delete/{post_id}", "StoryController@deleteBlogPost")->middleware('permission:delete.story');
    Route::delete("/admin/story-post/delete-selected/{post_id}", "StoryController@deleteSelectedBlogPost")->middleware('permission:delete.story');

    Route::get("admin/story-post/remove-attachment/{post_id}/{attachment_id}", "StoryController@removePostAttachment");//->middleware('permission:update.blogPost');

    Route::get("admin/story-post/remove-photo/{post_id}", "StoryController@removePostPhoto");//->middleware('permission:update.blogPost');

    Route::get("/admin/story-post/{post_id}/{locale?}", "StoryController@updateBlogPost")->middleware('permission:update.story');
    Route::post("/admin/story-post/{post_id}/{locale?}", "StoryController@updateBlogPost")->middleware('permission:update.story');



    Route::get("/admin/story-categories", "StoryController@listBlogCategories")->middleware('permission:view.story-categories');
    Route::get("/admin/story-categories-data", "StoryController@listBlogCategoriesData")->middleware('permission:view.story-categories');
    Route::get("/admin/story-categories/create", "StoryController@createBlogCategories")->middleware('permission:create.story-category');
    Route::post("/admin/story-categories/create", "StoryController@createBlogCategories")->middleware('permission:create.story-category');

    Route::get("/admin/story-category/{category_id}/{locale?}", "StoryController@updateBlogCategory")->middleware('permission:update.story-category');
    Route::post("/admin/story-category/{category_id}/{locale?}", "StoryController@updateBlogCategory")->middleware('permission:update.story-category');

    Route::delete("/admin/delete-story-category/{category_id}", "StoryController@deleteBlogCategory")->middleware('permission:delete.story-category');
    Route::delete("/admin/delete-story-selected-category/{category_id}", "StoryController@deleteSelectedBlogCategory")->middleware('permission:delete.story-category');


    Route::get("/get-all-user-stories/user-story", "StoryController@viewBlogPosts");
    Route::get("/story/api/tags", "StoryController@getAllTags");

    Route::post("/story/search", function(\Illuminate\Http\Request $request) {

        if (empty($request->searchText))
            return redirect()->back()->with("search-error", "Please enter search value");

        return redirect('/story/search/' . $request->searchText);
    });

    Route::get("/story/search/{keyword}", "StoryController@searchPost");

    Route::get("/story/tags/{tag_slug}", "StoryController@viewPostsForTag");
    Route::get("/story/categories/{category_slug}", "StoryController@viewPostsForCategory");

    Route::get("/story/{post_url}", "StoryController@viewPost");
    Route::post("/story/{post_url}", "StoryController@viewPost")->middleware('auth');
});
