<?php

Route::group(array('module' => 'bookappointment', 'prefix' => 'get-appointment', 'namespace' => 'App\PiplModules\bookappointment\Controllers', 'middleware' => 'web'), function() {
    //Your routes belong to this module.


    Route::get("/book-appointment", "AppointmentController@allExpertListing");
    Route::get("/appointment/mode-of-contact/{user_id}", "AppointmentController@contactMode");
    Route::get("ajax-search-user-from-city", "AppointmentController@searchInCity");
    Route::get("ajax-search-user-from-state", "AppointmentController@searchInState");
    Route::get("ajax-search-user-from-category", "AppointmentController@searchInCategory");
    Route::get("ajax-search-user-from-zipcode", "AppointmentController@searchInZipcode");
    
    Route::get("/my-appointments", "AppointmentController@myAppointment");
    Route::get("/my-appointment/detail/{appointment_id}", "AppointmentController@appointmentDetails");
    Route::get("/my-appointments/accept-appointment/{appointment_id}", "AppointmentController@acceptAppointment");
    Route::get("/my-appointments/reject-appointment/{appointment_id}", "AppointmentController@cancelAppointment");
    Route::get("/my-appointments/reschedule-appointment/{appointment_id}", "AppointmentController@rescheduleAppointment");
    
    Route::get("book-reschedule-appointment/{appointment_id}/{tid}", "AppointmentController@bookRescheduleAppointment");
    Route::get("/reschedule-appointment/booking-detail/{appointment_id}/{tid}", "AppointmentController@rescheduleAppointmentDetail");
    Route::get("/appointment/customer-appointment-detail/{appointment_id}", "AppointmentController@customerAppointmentDetail");


    //19 Feb 18
    Route::get("search-student-counsel", "AppointmentController@searchStudentCounsel");
    Route::get("search-adult-counsel", "AppointmentController@searchAdultCounsel");
    Route::get("search-institution-counsel", "AppointmentController@searchInstitutionCounsel");
    Route::get("search-upbeat-counsel", "AppointmentController@searchUpbeatCounsel");



    //Rating section routes here
    Route::post("/give-rating", "AppointmentController@userGiveRating");
    Route::get("/admin/rating-list", "AppointmentController@ratingList");
    Route::get("admin/list-rating-data", "AppointmentController@backendRatingListData");
    Route::get("admin/rating/change-status/{rating_id}", "AppointmentController@changeRatingStatus");
    Route::get("/admin/update-rating/{rating_id}", "AppointmentController@updateRating");
    Route::post("/admin/update-rating/{rating_id}", "AppointmentController@updateRating");
    Route::delete("/admin/delete-rating/{rating_id}", "AppointmentController@deleteRating");
    Route::delete("/admin/delete-selected-rating/{rating_id}", "AppointmentController@deleteRating");
    Route::get("/my-reviews", "AppointmentController@myReviews");
    Route::get("/ajax-add-review", "AppointmentController@ajaxAddReviews");
    Route::get("makecall", "AppointmentController@makeCall");

    //service provider appointment routes goes here
    Route::get("service-provider/appointments-list", "AppointmentController@serviceProviderAppointments");
    Route::get('user-feedback/{appointment_id}', "AppointmentController@giveFeedback");
    Route::post('post-feedback-form/{appointment_id}', "AppointmentController@saveFeedback");
    // Cron for send notification to expert and customer 
    Route::get("/appointment-reminder-cron", "AppointmentController@sendAppointmentReminderCron");
    Route::get("/check-appointment-time", "AppointmentController@checkAppointmentTime");
    Route::get("/is-chat-start", "AppointmentController@checkChatStart");
    Route::get("/thank-you", "AppointmentController@thankYou");
    
    
    /*************** New Appointments Route ***********************/
    Route::get("/book-business-appointment", "AppointmentController@bookBusinessAppointment");
    Route::post("/post-book-business-appointment", "AppointmentController@postBookBusinessAppointment");
    Route::get('/availabily', "AppointmentController@showFullCalendar");
    /**************************************************************/
});


Route::group(array('module' => 'bookappointment', 'namespace' => 'App\PiplModules\bookappointment\Controllers', 'middleware' => 'web'), function() {
    Route::get("/admin/manage-appointments", "AppointmentController@manageAppointment")->middleware('permission:view.appointment');
    Route::get("/admin/manage-appointment-data", "AppointmentController@manageAppointmentData")->middleware('permission:view.appointment');
    Route::get("admin/manage-appointments/view-detail/{appointment_id}", "AppointmentController@viewAppointmentDetail")->middleware('permission:view.appointment');
});

/*
 * availabilities route start here
 */
