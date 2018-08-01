@extends('layouts.app')

 @section('meta')
    <title>Book Appointment </title>
 @endsection
 
@section('content')

<section class="account-setting dash-cms-cust">
	<div class="container">
    	<div class="choose_experts">
        	<div class="row">
            	<div class="col-md-12">
                	<div class="experts-head text-center">
                    	<h3>Book Your Appointment</h3>
                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                         Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,
                          when an unknown printer took a galley of type and scrambled it to make a type
                           specimen book</p>
                    </div>
                </div>
            </div>
             <!------------------------------Search Select Experts------------------------------>
            <div class="row">
            	<div class="search-ex">
                	<div class="col-md-5 col-sm-5">
                    	<div class="sear-exp-head">
                        	<h3>SELECT FROM OUR TOP EXPERTS</h3>
                        </div>
                    </div>
                    <div class="col-md-7 col-sm-7">
                    	<div class="search-exp">
                        	<input type="text" class="sear-ex" placeholder="Search Experts from List">
                            <span class="sp-ex"><i class="fa fa-search se-ex" aria-hidden="true"></i></span>
                        </div>
                    </div>
                </div>
            </div>
            <!------------------------------Select Experts------------------------------>
            <div class="row">
            	<div class="expert-slider">
                    <div class="col-md-12">
                        <div id="experts">
                            <div class="item">
                            	<div class="in-ex text-center">
                                    <div class="exp_item_img">
                                        <center><img src="img/profiler-img.png" alt="image" class="img-responsive ex-img"></center>
                                    </div>
                                    <div class="ex-name">
                                    	<p>John David</p>
                                        <p class="ex">Counselling Expert</p>
                                    </div>
                                    <div class="ex-rate">
                                    	<p>4 Rating | 25 Reviews</p>
                                    </div>
                                    <div class="last-act">
                                    	<p>4 hours ago</p>
                                    </div>
                                    <div class="check-experts">
										<span>
											<i class="fa fa-check" aria-hidden="true"></i>
										</span>
									</div>
                                </div>
                            </div>
                            <div class="item">
                            	<div class="in-ex text-center">
                                    <div class="exp_item_img">
                                        <center><img src="img/profiler-img.png" alt="image" class="img-responsive ex-img"></center>
                                    </div>
                                    <div class="ex-name">
                                    	<p>John David</p>
                                        <p class="ex">Counselling Expert</p>
                                    </div>
                                    <div class="ex-rate">
                                    	<p>4 Rating | 25 Reviews</p>
                                    </div>
                                    <div class="last-act">
                                    	<p>4 hours ago</p>
                                    </div>
                                    <div class="check-experts">
                                        <span>
                                                <i class="fa fa-check" aria-hidden="true"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                            	<div class="in-ex text-center">
                                    <div class="exp_item_img">
                                        <center><img src="img/profiler-img.png" alt="image" class="img-responsive ex-img"></center>
                                    </div>
                                    <div class="ex-name">
                                    	<p>John David</p>
                                        <p class="ex">Counselling Expert</p>
                                    </div>
                                    <div class="ex-rate">
                                    	<p>4 Rating | 25 Reviews</p>
                                    </div>
                                    <div class="last-act">
                                    	<p>4 hours ago</p>
                                    </div>
                                    <div class="check-experts">
										<span>
											<i class="fa fa-check" aria-hidden="true"></i>
										</span>
									</div>
                                </div>
                            </div>
                            <div class="item">
                            	<div class="in-ex text-center">
                                    <div class="exp_item_img">
                                        <center><img src="img/profiler-img.png" alt="image" class="img-responsive ex-img"></center>
                                    </div>
                                    <div class="ex-name">
                                    	<p>John David</p>
                                        <p class="ex">Counselling Expert</p>
                                    </div>
                                    <div class="ex-rate">
                                    	<p>4 Rating | 25 Reviews</p>
                                    </div>
                                    <div class="last-act">
                                    	<p>4 hours ago</p>
                                    </div>
                                    <div class="check-experts">
										<span>
											<i class="fa fa-check" aria-hidden="true"></i>
										</span>
									</div>
                                </div>
                            </div>
                            <div class="item">
                            	<div class="in-ex text-center">
                                    <div class="exp_item_img">
                                        <center><img src="img/profiler-img.png" alt="image" class="img-responsive ex-img"></center>
                                    </div>
                                    <div class="ex-name">
                                    	<p>John David</p>
                                        <p class="ex">Counselling Expert</p>
                                    </div>
                                    <div class="ex-rate">
                                    	<p>4 Rating | 25 Reviews</p>
                                    </div>
                                    <div class="last-act">
                                    	<p>4 hours ago</p>
                                    </div>
                                    <div class="check-experts">
										<span>
											<i class="fa fa-check" aria-hidden="true"></i>
										</span>
									</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



@endsection