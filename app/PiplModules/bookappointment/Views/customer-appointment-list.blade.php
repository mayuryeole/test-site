@extends('layouts.app')

@section('meta')
<title>My Appointments</title>



@endsection
@if(isset($user_appointments) && count($user_appointments)>0)
<section class="account-setting  dash-cms-cust">
	<div class="container">
    	<div class="choose_experts">
        	<div class="row">
            	<div class="col-md-12">
                	<div class="experts-head text-center">
                    	<h3>My Appointments</h3>
                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                         </p>
                         <p class="link-book"><a href="{{url('book-appointment')}}" class="book-link book-links">Book Appointment</a></p>
                    </div>
                </div>
            </div>
         	<!-------------------------------Appointment List---------------------->
             @foreach($user_appointments as $appointment)
                <div class="row cust-appt ap-c-l">
            	<div class="cust-appoint-list">
                	<div class="col-md-10">
                           
                    	<div class="cust-appt-list">
                        	<div class="media">
                                 <div class="media-left media-middle c-ap-img">
                                    <a href="#">
                                      <img class="media-object" src="{{url('public/media/front/img/user/'.$appointment->expert_id.'/'.$appointment->expert->userInformation->profile_picture)}}" alt="image">
                                    </a>
                                  </div>
                                  <div class="media-body">
                                    <h4 class="media-heading c-p-nam">@if(isset($appointment->expert) && $appointment->expert!=''){{$appointment->expert->userInformation->first_name.' '.$appointment->expert->userInformation->last_name}} @endif</h4>
                                    <span class="cust-app-status">
                                        
                                        @if(isset($appointment->status) && $appointment->status=='0')
                                                    Approval Pending
                                                @elseif($appointment->status=='1')
                                                    Appointment Scheduled
                                                @elseif($appointment->status=='2' && $appointment->message=='Cancelled By Customer')
                                                    Appointment Cancel
                                                @elseif($appointment->status=='2' && $appointment->message=='Rejected')
                                                    Appointment Rejected
                                                @elseif($appointment->status=='3')
                                                    Appointment Completed
                                                @elseif($appointment->status=='4')
                                                    Appointment Rescheduled
                                                @endif
                                    </span>
                                    <p class="media-cust-info inffo ">@if(isset($appointment->expert)&& $appointment->expert!=''){{$appointment->expert->userInformation->description}}@endif</p>
                                    <p class="media-cust-info dat-infos ">@if(isset($appointment->expert)&& $appointment->expert!=''){{date('d M Y h:i A',strtotime($appointment->appointment_datetime))}}@endif</p>
                                     <div class="stars-images"> <?php
                                                        $rating = \App\PiplModules\bookappointment\Models\Rating::where('appointment_id', $appointment->id)->get();
                                                        if (count($rating) > 0) {
                                                            $k = 0;
                                                            $is_flot = false;
                                                            $arr_rat = explode('.', $rating[0]['rating']);
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
                                                        } else {
                                                            for ($ss = 0; $ss < 5; $ss++) {
                                                                ?>
                                                                <img  src="{{url('public/media/front/img/star-off.png')}}"/>
                                                                <?php
                                                            }
                                                            ?>

@if(isset($appointment->status) && $appointment->status==3)
                                                                <p class="cust-rate-rev">
                                                                    <a href="javascript:void(0)"  onclick="giveRating('{{$appointment->id}}')">How am I doing? Rate me now!</a>
                                                                </p>
@endif  
                                                          <?php 
                                                         } 
                                                          ?>  
                                                        
                                                        </div>
                                   
                                    
                                  </div>
                              </div>
                        </div>
                        
                    </div>
                    <div class="col-md-2">
                    	<div class="cust-cont-detail det-cont c-app-btns">
                        	<a href="{{url('appointment/customer-appointment-detail/'.$appointment->id)}}">View Detail</a>
                        </div>
                    </div>
                </div>
            </div>
           @endforeach
        </div>
    </div>
</section>
@else

<section class="cms_info policy_privacy dash-cms-cust">
  
<div class="app">
	<div class="container">
            
    	<div class="row">
        	<div class="cms_inner_info">
            	<div class="book-appoint">
                	<div class="col-md-4 col-sm-4">
                    	<div class="book-apt">
                        		<center><img src="{{url('public/media/front/img/bg_4.png')}}" alt="image" class="img-responsive"></center>
                        </div>
                    </div>
                    <div class="col-md-8 col-sm-8">
                    	<div class="book-apt">
                        	<div class="book-apt-text ">
                             	<h3>YOU HAVE NO APPOINTMENTS, YET!</h3>
                                <h4>Don't hold it back</h4>
                                <p>Share your worries over a skype or phone call.</p>
                             </div>
                             <div class="appointment-sub-btn">
                                 <a href="{{url('book-appointment')}}" class="appoint-bttns">Make Appointment</a>
                            </div>
                        </div>
                    </div>
                   
                </div>
            </div>
        </div>
    </div>
  </div>
   
</section>
@endif
 <div class="cust-rate-review-open">
	<div class="container">
    	<div class="row">
        	<div class="col-md-12">
            	 <div class="modal fade" id="review-rate" role="dialog">
                    <div class="modal-dialog">
                    
                      <!-- Modal content-->
                      <div class="modal-content heightm">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                          <h4 class="modal-title">Review And Rating</h4>
                        </div>
                          <form method="post" action="{{url('/give-rating')}}" id="give_rating_form" name="give_rating_form"> 
                              {!!csrf_field()!!}
                        <div class="modal-body">
                             <p class="cust-rate-revs">	<span>
                                             <div  data-score id="rating"></div>
                                        </span> </p>
                          	<div class="review-box">
                            	<div class="form-group">
                                    <textarea class="form-control" rows="5" name="review" id="review" placeholder="Write your review here..."></textarea>
                                </div>
                                    <input type="hidden" value="" name="appointment_id" id="appointment_id">    
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-default review-cust-sub-btn" >Submit</button>
                        </div>
                       </form>       
                      </div>
                      
                    </div>
                 </div>
            </div>
        </div>
    </div>
</div>

<script>
    function giveRating(appointment_id)
    {
        $("#appointment_id").val(appointment_id);
        $("#review-rate").modal("show");
    }
</script>    


