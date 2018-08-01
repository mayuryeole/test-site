@extends('layouts.app')

@section('meta')
<title>My Appointments</title>



@endsection
<!--------------------------------------DASHBOARD ACCOUNT SETTING SECTION------------------------------------->
<section class="account-setting dash-cms-cust">
	<div class="container">
    	<div class="choose_experts">
        	<div class="row">
            	<div class="col-md-12">
                	<div class="experts-head text-center">
                    	<h3>My Appointments</h3>
                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                         Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,
                          when an unknown printer took a galley of type and scrambled it to make a type
                           specimen book</p>
                    </div>
                </div>
            </div>
             <!------------------------------Search Select Experts------------------------------>
            <div class="row">
            	
            </div>
             <!-----------------------------------------Pending appointment.--------------------------->
            <!--<div class="row comp-apt">
            	<div class="search-ex">
                	<div class="col-md-5 col-sm-5">
                    	<div class="sear-exp-head">
                        	<h3>My Pending Appointment.</h3>
                        </div>
                    </div>
                    <div class="col-md-7 col-sm-7">
                    	<div class="search-exp">
                        	<input type="text" class="sear-ex" placeholder="Search Rescheduled Appointment from List">
                            <span class="sp-ex"><i class="fa fa-search se-ex" aria-hidden="true"></i></span>
                        </div>
                    </div>
                </div>
            	<div class="expert-slider">
                    <div class="col-md-12">
                        @if(isset($pending_appointments) && count($pending_appointments)>0)
                                @foreach($pending_appointments as $appointment)
                        <div id="pending">
                        	<div class="item">
                            	<div class="in-exs text-center">
                                    <div class="myappoints">
                                                <div class="in-cust-im">
                                                    @if($appointment->customer->userInformation->gender=='1')
                                                    <center><img src="{{url('public/media/front/img/male-user.png')}}" alt="image" 
                                                    class="img-responsive  img-circle"></center>
                                                    @else
                                                    <center><img src="{{url('public/media/front/img/woman-avatar.png')}}" alt="image" 
                                                    class="img-responsive  img-circle"></center>
                                                    @endif
                                                </div>
                                                <div class="nam-cust-in">
                                                    <p>@if(isset($appointment->customer) && $appointment->customer!=''){{$appointment->customer->userInformation->first_name.' '.$appointment->customer->userInformation->last_name}} @endif</p>
                                                </div>
                                                <div class="cust_desc">
                                                    <p>@if(isset($appointment->customer) && $appointment->customer!=''){{$appointment->customer->userInformation->description}} @endif</p>
                                                </div>
                                                <div class="ap-time">
                                                    <p>Appointment Date and Time : <?php echo date('d M Y h:i a',strtotime($appointment->appointment_datetime))?></p>
                                                </div>
                                                <div class="ap-time">
                                                    <p>Appointment Type : @if(isset($appointment->appointmentType)&& $appointment->appointmentType!=''){{$appointment->appointmentType->mode}} @endif </p>
                                                </div>
                                               
                                        </div>
                                        <div class="reads">
                                            <a href="{{url('/my-appointment/detail/'.$appointment->id)}}">
                                                <p class="text-center">Read More</p>
                                            </a>
                                        </div>
                                        
                                </div>
                            </div>
                          
                        </div>
                        @endforeach
                        @endif
                         @if(isset($pending_appointments) && count($pending_appointments)==0)
                            <div class="row" id="no-record" >
                                <div class="col-md-12">
                                   <div class="no-rec-found"> 
                                      <p class="no-record-name">No Record Found</p>
                                  </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>-->
            <div class="row comp-apt">
            	<div class="search-ex">
                	<div class="col-md-5 col-sm-5">
                    	<div class="sear-exp-head">
                        	<h3>My Pending Appointment.</h3>
                        </div>
                    </div>
<!--                    <div class="col-md-7 col-sm-7">
                    	<div class="search-exp">
                        	<input type="text" class="sear-ex" placeholder="Search Scheduled Appointment from List">
                            <span class="sp-ex"><i class="fa fa-search se-ex" aria-hidden="true"></i></span>
                        </div>
                    </div>-->
                </div>
            	<div class="expert-slider">
                    <div class="col-md-12">
                        <div id="pending">
                            @if(isset($pending_appointments) && count($pending_appointments)>0)
                                @foreach($pending_appointments as $appointment)
                        	<div class="item">
                            	<div class="in-exs text-center">
                                    <div class="myappoints">
                                                <div class="in-cust-im">
                                                     @if($appointment->customer->userInformation->gender=='1')
                                                    <center><img src="{{url('public/media/front/img/male-user.png')}}" alt="image" 
                                                    class="img-responsive  img-circle"></center>
                                                    @else
                                                    <center><img src="{{url('public/media/front/img/woman-avatar.png')}}" alt="image" 
                                                    class="img-responsive  img-circle"></center>
                                                    @endif
                                                </div>
                                                <div class="nam-cust-in">
                                                    <p>@if(isset($appointment->customer) && $appointment->customer!=''){{$appointment->customer->userInformation->first_name.' '.$appointment->customer->userInformation->last_name}} @endif</p>
                                                </div>
                                                <div class="cust_desc">
                                                    <p>@if(isset($appointment->customer) && $appointment->customer!='')
                                                            @if(strlen($appointment->customer->userInformation->description)>200)
                                                              <p>{{substr($appointment->customer->userInformation->description,0,200)}}...</p>
                                                            @else
                                                            <p>{{($appointment->customer->userInformation->description)}}</p>
                                                            @endif
                                                       @endif
                                                    </p>
                                                </div>
                                                <div class="ap-time">
                                                    <p>Appointment Date and Time : <?php echo date('d M Y h:i a',strtotime($appointment->appointment_datetime))?></p>
                                                </div>
                                                <div class="ap-time">
                                                    <p>Appointment Type : @if(isset($appointment->appointmentType)&& $appointment->appointmentType!=''){{$appointment->appointmentType->mode}} @endif </p>
                                                </div>
                                        </div>
                                        <div class="reads">
                                            <a href="{{url('/my-appointment/detail/'.$appointment->id)}}">
                                                <p class="text-center">Read More</p>
                                            </a>
                                        </div>
                                </div>
                            </div>
                            @endforeach
                            @endif    
                          
                        </div>
                        
                        @if(isset($pending_appointments) && count($pending_appointments)==0)
                         <div class="row" id="no-record" >
                                <div class="col-md-12">
                                   <div class="no-rec-found"> 
                                      <p class="no-record-name">No Record Found</p>
                                  </div>
                                </div>
                             </div>
                        @endif
                    </div>
                </div>
            </div>
            <!------------------------------completed appointment------------------------------>
          <div class="row comp-apt">
            	<div class="search-ex">
                	<div class="col-md-5 col-sm-5">
                    	<div class="sear-exp-head">
                        	<h3>My Completed Appointment</h3>
                        </div>
                    </div>
<!--                    <div class="col-md-7 col-sm-7">
                    	<div class="search-exp">
                        	<input type="text" class="sear-ex" placeholder="Search Completed Appointment from List">
                            <span class="sp-ex"><i class="fa fa-search se-ex" aria-hidden="true"></i></span>
                        </div>
                    </div>-->
                </div>
            	<div class="expert-slider">
                    <div class="col-md-12">
                        <div id="my-appt">
                            @if(isset($completed_appointments) && count($completed_appointments)>0)
                                @foreach($completed_appointments as $appointment)
                        	<div class="item">
                            	<div class="in-exs text-center">
                                    <div class="myappoints">
                                                <div class="in-cust-im">
                                                    @if($appointment->customer->userInformation->gender=='1')
                                                    <center><img src="{{url('public/media/front/img/male-user.png')}}" alt="image" 
                                                    class="img-responsive  img-circle"></center>
                                                    @else
                                                    <center><img src="{{url('public/media/front/img/woman-avatar.png')}}" alt="image" 
                                                    class="img-responsive  img-circle"></center>
                                                    @endif
                                                </div>
                                                <div class="nam-cust-in">
                                                    <p>@if(isset($appointment->customer) && $appointment->customer!=''){{$appointment->customer->userInformation->first_name.' '.$appointment->customer->userInformation->last_name}} @endif</p>
                                                </div>
                                                <div class="cust_desc">
                                                    <p>@if(isset($appointment->customer) && $appointment->customer!='')
                                                            @if(strlen($appointment->customer->userInformation->description)>200)
                                                              <p>{{substr($appointment->customer->userInformation->description,0,200)}}...</p>
                                                            @else
                                                            <p>{{($appointment->customer->userInformation->description)}}</p>
                                                            @endif
                                                        @endif
                                                    </p>
                                                </div>
                                                <div class="ap-time">
                                                    <p>Appointment Date and Time : <?php echo date('d M Y h:i a',strtotime($appointment->appointment_datetime))?></p>
                                                </div>
                                                <div class="ap-time">
                                                    <p>Appointment Type : @if(isset($appointment->appointmentType)&& $appointment->appointmentType!=''){{$appointment->appointmentType->mode}} @endif </p>
                                                </div>
                                        </div>
                                        <div class="reads">
                                            <a href="{{url('/my-appointment/detail/'.$appointment->id)}}">
                                                <p class="text-center">Read More</p>
                                            </a>
					</div>
                                </div>
                                </div>
                                @endforeach
                                @endif  
                      
                        </div>
                        @if(isset($completed_appointments) && count($completed_appointments)==0)
                         <div class="row" id="no-record" >
                                <div class="col-md-12">
                                   <div class="no-rec-found"> 
                                      <p class="no-record-name">No Record Found</p>
                                  </div>
                                </div>
                             </div>
                        @endif
                     </div>
                        
                </div>
            </div>
             <!-------------------------------Scheduled Appointment------------------------------------>    
            <div class="row comp-apt">
            	<div class="search-ex">
                	<div class="col-md-5 col-sm-5">
                    	<div class="sear-exp-head">
                        	<h3>My Scheduled Appointment.</h3>
                        </div>
                    </div>
<!--                    <div class="col-md-7 col-sm-7">
                    	<div class="search-exp">
                        	<input type="text" class="sear-ex" placeholder="Search Scheduled Appointment from List">
                            <span class="sp-ex"><i class="fa fa-search se-ex" aria-hidden="true"></i></span>
                        </div>
                    </div>-->
                </div>
            	<div class="expert-slider">
                    <div class="col-md-12">
                        <div id="schedule">
                            @if(isset($scheduled_appointments) && count($scheduled_appointments)>0)
                                @foreach($scheduled_appointments as $appointment)
                        	<div class="item">
                            	<div class="in-exs text-center">
                                    <div class="myappoints">
                                                <div class="in-cust-im">
                                                     @if($appointment->customer->userInformation->gender=='1')
                                                    <center><img src="{{url('public/media/front/img/male-user.png')}}" alt="image" 
                                                    class="img-responsive  img-circle"></center>
                                                    @else
                                                    <center><img src="{{url('public/media/front/img/woman-avatar.png')}}" alt="image" 
                                                    class="img-responsive  img-circle"></center>
                                                    @endif
                                                </div>
                                                <div class="nam-cust-in">
                                                    <p>@if(isset($appointment->customer) && $appointment->customer!=''){{$appointment->customer->userInformation->first_name.' '.$appointment->customer->userInformation->last_name}} @endif</p>
                                                </div>
                                                <div class="cust_desc">
                                                    <p>@if(isset($appointment->customer) && $appointment->customer!='')
                                                            @if(strlen($appointment->customer->userInformation->description)>200)
                                                              <p>{{substr($appointment->customer->userInformation->description,0,200)}}...</p>
                                                            @else
                                                            <p>{{($appointment->customer->userInformation->description)}}</p>
                                                            @endif
                                                        @endif
                                                </p>
                                                </div>
                                                <div class="ap-time">
                                                    <p>Appointment Date and Time : <?php echo date('d M Y h:i a',strtotime($appointment->appointment_datetime))?></p>
                                                </div>
                                                <div class="ap-time">
                                                    <p>Appointment Type : @if(isset($appointment->appointmentType)&& $appointment->appointmentType!=''){{$appointment->appointmentType->mode}} @endif </p>
                                                </div>
                                        </div>
                                        <div class="reads">
                                            <a href="{{url('/my-appointment/detail/'.$appointment->id)}}">
                                                <p class="text-center">Read More</p>
                                            </a>
                                        </div>
                                </div>
                            </div>
                            @endforeach
                            @endif    
                          
                        </div>
                        
                        @if(isset($scheduled_appointments) && count($scheduled_appointments)==0)
                         <div class="row" id="no-record" >
                                <div class="col-md-12">
                                   <div class="no-rec-found"> 
                                      <p class="no-record-name">No Record Found</p>
                                  </div>
                                </div>
                             </div>
                        @endif
                    </div>
                </div>
            </div>
        <!-------------------------------Cancelled Appointment------------------------------------>    
            <div class="row comp-apt">
            	<div class="search-ex">
                	<div class="col-md-5 col-sm-5">
                    	<div class="sear-exp-head">
                        	<h3>My Rejected Appointment.</h3>
                        </div>
                    </div>
<!--                    <div class="col-md-7 col-sm-7">
                    	<div class="search-exp">
                        	<input type="text" class="sear-ex" placeholder="Search Cancelled Appointment. from List">
                            <span class="sp-ex"><i class="fa fa-search se-ex" aria-hidden="true"></i></span>
                        </div>
                    </div>-->
                </div>
            	<div class="expert-slider">
                    <div class="col-md-12">
                        <div id="cancel">
                            @if(isset($cancelled_appointments) && count($cancelled_appointments)>0)
                                @foreach($cancelled_appointments as $appointment)
                        	<div class="item">
                            	<div class="in-exs text-center">
                                    <div class="myappoints">
                                                <div class="in-cust-im">
                                                    @if($appointment->customer->userInformation->gender=='1')
                                                    <center><img src="{{url('public/media/front/img/male-user.png')}}" alt="image" 
                                                    class="img-responsive  img-circle"></center>
                                                    @else
                                                    <center><img src="{{url('public/media/front/img/woman-avatar.png')}}" alt="image" 
                                                    class="img-responsive  img-circle"></center>
                                                    @endif
                                                </div>
                                                <div class="nam-cust-in">
                                                    <p>@if(isset($appointment->customer) && $appointment->customer!=''){{$appointment->customer->userInformation->first_name.' '.$appointment->customer->userInformation->last_name}} @endif</p>
                                                </div>
                                                <div class="cust_desc">
                                                    <p>@if(isset($appointment->customer) && $appointment->customer!='')
                                                            @if(strlen($appointment->customer->userInformation->description)>200)
                                                              <p>{{substr($appointment->customer->userInformation->description,0,200)}}...</p>
                                                            @else
                                                            <p>{{($appointment->customer->userInformation->description)}}</p>
                                                            @endif
                                                        @endif
                                                </p>
                                                </div>
                                                <div class="ap-time">
                                                    <p>Appointment Date and Time : <?php echo date('d M Y h:i a',strtotime($appointment->appointment_datetime))?></p>
                                                </div>
                                                <div class="ap-time">
                                                    <p>Appointment Type : @if(isset($appointment->appointmentType)&& $appointment->appointmentType!=''){{$appointment->appointmentType->mode}} @endif </p>
                                                </div>
                                        </div>
                                        <div class="reads">
                                            <a href="{{url('/my-appointment/detail/'.$appointment->id)}}">
                                                <p class="text-center">Read More</p>
                                            </a>
                                        </div>
                                </div>
                            </div>
                            @endforeach
                            @endif
                        </div>
                        @if(isset($cancelled_appointments) && count($cancelled_appointments)==0)
                            <div class="row" id="no-record" >
                                <div class="col-md-12">
                                   <div class="no-rec-found"> 
                                      <p class="no-record-name">No Record Found</p>
                                  </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <!-----------------------------------------Rescheduled appointment.--------------------------->
            <div class="row comp-apt">
            	<div class="search-ex">
                	<div class="col-md-5 col-sm-5">
                    	<div class="sear-exp-head">
                        	<h3>My Rescheduled Appointment.</h3>
                        </div>
                    </div>
<!--                    <div class="col-md-7 col-sm-7">
                    	<div class="search-exp">
                        	<input type="text" class="sear-ex" placeholder="Search Rescheduled Appointment from List">
                            <span class="sp-ex"><i class="fa fa-search se-ex" aria-hidden="true"></i></span>
                        </div>
                    </div>-->
                </div>
            	<div class="expert-slider">
                    <div class="col-md-12">
                        @if(isset($rescheduled_appointments) && count($rescheduled_appointments)>0)
                                @foreach($rescheduled_appointments as $appointment)
                        <div id="rescheduled">
                        	<div class="item">
                            	<div class="in-exs text-center">
                                    <div class="myappoints">
                                                <div class="in-cust-im">
                                                    @if($appointment->customer->userInformation->gender=='1')
                                                    <center><img src="{{url('public/media/front/img/male-user.png')}}" alt="image" 
                                                    class="img-responsive  img-circle"></center>
                                                    @else
                                                    <center><img src="{{url('public/media/front/img/woman-avatar.png')}}" alt="image" 
                                                    class="img-responsive  img-circle"></center>
                                                    @endif
                                                </div>
                                                <div class="nam-cust-in">
                                                    <p>@if(isset($appointment->customer) && $appointment->customer!=''){{$appointment->customer->userInformation->first_name.' '.$appointment->customer->userInformation->last_name}} @endif</p>
                                                </div>
                                                <div class="cust_desc">
                                                    <p>@if(isset($appointment->customer) && $appointment->customer!='')
                                                            @if(strlen($appointment->customer->userInformation->description)>200)
                                                              <p>{{substr($appointment->customer->userInformation->description,0,200)}}...</p>
                                                            @else
                                                            <p>{{($appointment->customer->userInformation->description)}}</p>
                                                            @endif
                                                        @endif</p>
                                                </div>
                                                <div class="ap-time">
                                                    <p>Appointment Date and Time : <?php echo date('d M Y h:i a',strtotime($appointment->appointment_datetime))?></p>
                                                </div>
                                                <div class="ap-time">
                                                    <p>Appointment Type : @if(isset($appointment->appointmentType)&& $appointment->appointmentType!=''){{$appointment->appointmentType->mode}} @endif </p>
                                                </div>
                                               
                                        </div>
                                        <div class="reads">
                                            <a href="{{url('/my-appointment/detail/'.$appointment->id)}}">
                                                <p class="text-center">Read More</p>
                                            </a>
                                        </div>
                                        
                                </div>
                            </div>
                          
                        </div>
                        @endforeach
                        @endif
                         @if(isset($rescheduled_appointments) && count($rescheduled_appointments)==0)
                            <div class="row" id="no-record" >
                                <div class="col-md-12">
                                   <div class="no-rec-found"> 
                                      <p class="no-record-name">No Record Found</p>
                                  </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</section>

