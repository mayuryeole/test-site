<?php

Route::group(array('module' => 'newsletter', 'namespace' => 'App\PiplModules\newsletter\Controllers', 'middleware' => 'web'), function() {

    Route::get("/newsletter", "NewsletterController@index");
    Route::post("/newsletter/subscribe", "NewsletterController@subscribeToNewsletter");

    Route::get("/admin/newsletters", "NewsletterController@listNewsletters")->middleware('permission:view.newsletter');
    Route::get("/admin/newsletter-data", "NewsletterController@listNewslettersData")->middleware('permission:view.newsletter');

    Route::get("/admin/newsletter/create", "NewsletterController@createNewsletter")->middleware('permission:create.newsletter');
    Route::post("/admin/newsletter/create", "NewsletterController@createNewsletter")->middleware('permission:create.newsletter');

    Route::get("/admin/newsletter/{newletter_id}", "NewsletterController@updateNewsletter")->middleware('permission:update.newsletter');
    Route::post("/admin/newsletter/{newletter_id}", "NewsletterController@updateNewsletter")->middleware('permission:update.newsletter');

    Route::delete("/admin/newsletter/delete/{newletter_id}", "NewsletterController@deleteNewsletter")->middleware('permission:delete.newsletter');
    Route::delete("/admin/newsletter/delete-selected/{newletter_id}", "NewsletterController@deleteNewsletter")->middleware('permission:delete.newsletter');

    Route::get("/admin/send-newsletter/{newletter_id}", "NewsletterController@distributeNewsletters")->middleware('permission:send.newsletter');
    Route::get("/admin/select-newsletter-users/{newletter_id}", "NewsletterController@selectUsersNewsletter");
    Route::post("/admin/select-newsletter-users/{newletter_id}", "NewsletterController@selectUsersNewsletter");

        Route::get("/admin/unsubscribe-user/{user}", "NewsletterController@unsubscribeNewsletter");
        Route::post("/admin/unsubscribe-user/{user}", "NewsletterController@unsubscribeNewsletter");

});
