@extends(config("piplmodules.back-view-layout-location"))

@section("meta")

<title>View Appointment</title>

@endsection

@section('content')
<div class="page-content-wrapper">
    <div class="page-content">
        <!-- BEGIN PAGE BREADCRUMB -->
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <a href="{{url('admin/dashboard')}}">Dashboard</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="{{url('admin/manage-appointments')}}">Manage Appointment</a>
                <i class="fa fa-circle"></i>

            </li>
            <li>
                <a href="javascript:void(0);">View Appointment Detail</a>

            </li>
        </ul>
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-gift"></i> View Appointment
                </div>

            </div>
            <div class="portlet-body form">

                <div class="form-body">
                    <div class="row"> 
                        <div class="form-group clearfix ">
                            <label class="col-md-4 control-labels">Customer Name:</label>

                            <div class="col-md-8">     
                                <label class="apt-back"> @if(isset($appointment) && count($appointment)>0) @if(!empty($appointment->customer->userInformation->first_name)){{$appointment->customer->userInformation->first_name}} @endif @if(!empty($appointment->customer->userInformation->last_name)) {{ $appointment->customer->userInformation->last_name }} @endif @endif</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group clearfix ">
                            <label class="col-md-4 control-labels">Customer Email:</label>

                            <div class="col-md-8">
                                <label class="apt-back"> @if(isset($appointment) && count($appointment)>0) @if(!empty($appointment->customer_email)){{$appointment->customer_email}} @endif @endif</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group clearfix ">
                            <label class="col-md-4 control-labels">Customer Mobile No:</label>

                            <div class="col-md-8">
                                <label class="apt-back"> @if(isset($appointment) && count($appointment)>0) @if(!empty($appointment->customer_phone)){{$appointment->customer_phone}} @endif @endif</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group clearfix ">
                            <label class="col-md-4 control-labels">Customer Country:</label>
                            <div class="col-md-8">
                                <label class="apt-back"> @if(isset($appointment) && count($appointment)>0) @if(!empty($appointment->customer_country)){{$appointment->customer_country}} @endif @endif</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group clearfix">
                            <label class="col-md-4 control-label">Appointment With:</label>

                            <div class="col-md-8">     
                                <label> @if(isset($appointment) && count($appointment)>0){{$appointment->expert->userInformation->first_name}} @endif</label>
                            </div>
                        </div>  
                    </div>

                    <div class="row">
                        <div class="form-group clearfix">
                            <label class="col-md-4 control-label">Appointment Status:</label>

                            <div class="col-md-8">
                                <label>
                                    @if( $appointment->status==0)
                                    Pending
                                    @elseif($appointment->status==1)
                                    Scheduled
                                    @elseif($appointment->status==2 && $appointment->message=="Cancelled By Customer" )
                                    Cancel
                                    @elseif($appointment->status==2 && $appointment->message=="Rejected" )
                                    Rejected
                                    @elseif($appointment->status==3 )
                                    Completed
                                    @elseif($appointment->status==4 )
                                    Rescheduled
                                    @endif
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group clearfix">
                            <label class="col-md-4 control-label">Appointment DateTime:</label>

                            <div class="col-md-8">
                                <label> <?php echo date('d M Y h:i a', strtotime($appointment->appointment_datetime)) ?></label>

                            </div>

                        </div>
                    </div>
                    <div class="row">  
                        <div class="form-group clearfix">
                            <label class="col-md-4 control-labels">Contact Id:</label>

                            <div class="col-md-8">     
                                <label class="apt-back"> @if(isset($appointment->contact_id) && $appointment->contact_id!=''){{ $appointment->contact_id }} @endif</label>

                            </div>

                        </div> 
                    </div>         

                    <div class="row">  
                        <div class="form-group clearfix">
                            <label class="col-md-4 control-labels">Appointment Purpose:</label>

                            <div class="col-md-8">     
                                <label class="apt-back"> @if(isset($appointment->purpose) && $appointment->purpose!=''){{ $appointment->purpose }} @endif</label>

                            </div>

                        </div> 
                    </div>
                </div>

            </div>


            </div>
        </div>
    </div>
<!-- </div>
 -->
@endsection
