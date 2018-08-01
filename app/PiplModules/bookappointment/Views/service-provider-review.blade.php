@extends('layouts.app')

@section('meta')
<title>My Reviews</title>



@endsection
<!--------------------------------------DASHBOARD ACCOUNT SETTING SECTION------------------------------------->

<section class="account-setting dash-cms-cust">
	<div class="container">
    	<div class="choose_experts">
        	<div class="row">
            	<div class="col-md-12">
                	<div class="experts-head text-center">
                    	<h3>My Rating and Reviews</h3>
                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                         Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,
                          when an unknown printer took a galley of type and scrambled it to make a type
                           specimen book</p>
                    </div>
                </div>
                </div>
            <div class="total_reviews">
                <span>Total Reviews you get: {{count($all_rating_count)}}</span>
            </div>    
             <!------------------------------Review and Rating section------------------------------>
             <div class="row">
             	<div class="my-reviews">
                	<div class="col-md-1">
                    
                    </div>
                    <div class="col-md-10">
                    	<div class="myreviews">
                        	<div class="row">
                            	<div class="col-md-12 col-sm-12">
                                	<div class="myrates">
                                    	<div class="cu-reviews">
                                            <ul id="review">
                                                @if(isset($my_rating) && count($my_rating)!=0)
                                                @foreach($my_rating as $rating)
                                                <li>
                                                	<div class="media">
                                                            <span class="pull-left media-left">
                                                                <div class="rate-user-img img-circle">
                                                                    @if($rating->ratingGivenBy->userInformation->gender==1)
                                                                     <img src="{{url('public/media/front/img/male-user.png')}}"/>
                                                                    @else
                                                                     <img src="{{url('public/media/front/img/woman-avatar.png')}}"/>
                                                                     @endif
                                                                </div>
                                                            </span>
                                                            <div class="media-body inform-review">
                                                            	<span class="names">{{$rating->ratingGivenBy->userInformation->first_name.' '.$rating->ratingGivenBy->userInformation->last_name}}</span>
                                                                <span class="desc">{{$rating->review}}</span>
                                                                 <span class="desc_review">
                                                                 	<?php
                                                        
                                                            $k = 0;
                                                            $is_flot = false;
                                                            $arr_rat = explode('.', $rating->rating);
                                                            if (count($arr_rat) == 1) {
                                                                $arr_rat[1] = '0';
                                                            }
                                                            if ($arr_rat[0] != "") {
                                                                if ($arr_rat[1] != '0') {
                                                                    $is_flot = "true";
                                                                }
                                                                for ($ii = 0; $ii < $arr_rat[0]; $ii++) {
                                                                    ?>
                                                                    <img  src="{{url('public/media/front/img/star-on.png')}}"/>
                                                                    <?php
                                                                    $k++;
                                                                }
                                                                if ($is_flot) {
                                                                    ?>
                                                                    <img  src="{{url('public/media/front/img/star-half.png')}}"/>
                                                                    <?php
                                                                }
                                                                if ($is_flot) {
                                                                    $s = $arr_rat[0] + 1;
                                                                } else {
                                                                    $s = $arr_rat[0];
                                                                }
                                                                if ($s < 5) {
                                                                    for ($j = $s; $j < 5; $j++) {
                                                                        ?>
                                                                        <img  src="{{url('public/media/front/img/star-off.png')}}"/>
                                                                        <?php
                                                                        $s++;
                                                                    }
                                                                }
                                                            }
                                                        
                                                        ?>
                                                                 </span>
                                                              
                                                            </div>
                                                        </div>
                                                    
                                                </li>
                                                
                                                @endforeach
                                                @endif
                                             
                                                @if(count($all_rating_count)>5)
                                                <li class="view-more-button"  id="addMore">
                                                 <center><button type="button" class="vi-more hvr-trim" onclick="showAll('{{$my_rating->last()->id}}')" ><i class="fa fa-plus" aria-hidden="true"></i></button></center>
                                                 </li>
                                                @endif  
                                            </ul>
                                            
                            			 </div>
                                         <!----------------------commnet box---------------------------->
                                         
                                    </div>
                                    
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-md-1">
                    
                    </div>
                </div>
             </div>
        </div>
    </div>
</section>

@section('footer')
    <script>
        function showAll(last_id)
        {
            $("#addMore").html('');
            $.ajax({
            url: '{{url( "/ajax-add-review" )}}',
            data: {'last_id': last_id},
            dataType: "html",
            success: function(res) {
                   if(res!='No Record Found')
                {
                 
                    $("#review").append(res);
//                    $("#addMore").show();

                } else {
                    $('#main_div').empty();
                    $("#no-record").show();
                }
             
            }
        });
        }
    </script>    
@endsection