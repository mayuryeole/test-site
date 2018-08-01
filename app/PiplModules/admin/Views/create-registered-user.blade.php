@extends(config("piplmodules.back-view-layout-location"))

@section("meta")

<title>Create User</title>

@endsection

@section('content')
<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/jquery/1/jquery.min.js"></script>
<!-- Include Date Range Picker -->
<script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />

<div class="page-content-wrapper">
    <div class="page-content">
        <!-- BEGIN PAGE BREADCRUMB -->
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <a href="{{url('admin/dashboard')}}">Dashboard</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="{{url('admin/manage-users')}}">Manage Users</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="javascript:void(0)">Create New User</a>

            </li>
        </ul>

        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-gift"></i> Create User
                </div>

            </div>
            <div class="portlet-body form">
                <form class="form-horizontal"  method="post" name="create_user" id="create_user_register" >
                    {!! csrf_field() !!}
                    <input type='hidden' name='user_type' id='user_type'>
                    <!--<input type='hidden' name='otp_status' id='otp_status' value="1">-->
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-12">    
                                <div class="col-md-8">   
                                    <div class="form-group {{ $errors->has('user') ? ' has-error' : '' }}">
                                        <label class="col-md-6 control-label">Select User Type:<sup>*</sup></label>

                                        <div class="col-md-6">     
                                            <select class="form-control" name="user" id="user" onchange="selectUser(this.value)">
                                                <option value=""  >--Select--</option>
                                                <option id="Customer_user" value="3">Customer User</option>
                                                <option id="Business_user" value="4">Business User</option>
                                            </select>
                                            <!--<input type="hidden" id='' name='user_type' value="">-->
                                            @if ($errors->has('user_type'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('user') }}</strong>
                                            </span>
                                            @endif
                                        </div>

                                    </div>
                                   
                                    <div class="form-group {{ $errors->has('first_name') ? ' has-error' : '' }}">
                                        <label class="col-md-6 control-label">First Name:<sup>*</sup></label>

                                        <div class="col-md-6">     
                                            <input name="first_name" type="text" class="form-control" id="first_name" value="{{old('first_name')}}">
                                            @if ($errors->has('first_name'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('first_name') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group {{ $errors->has('last_name') ? ' has-error' : '' }}">
                                        <label class="col-md-6 control-label">Last Name:<sup>*</sup></label>
                                        <div class="col-md-6">         
                                            <input type="text" class="form-control" id="last_name" name="last_name" value="{{old('last_name')}}">

                                            @if ($errors->has('last_name'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('last_name') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                                        <label class="col-md-6 control-label">Email:<sup>*</sup></label>
                                        <div class="col-md-6">      
                                            <input type="email" class="form-control" id="email" name="email" value="{{old('email')}}">
                                            @if ($errors->has('email'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                                        <label class="col-md-6 control-label">Password:<sup>*</sup></label>
                                        <div class="col-md-6">    
                                            <input type="Password" class="form-control" id="password" name="password" value="{{old('password')}}">
                                            @if ($errors->has('password'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group {{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                        <label class="col-md-6 control-label">Confirm Password:<sup>*</sup></label>
                                        <div class="col-md-6">    
                                            <input type="Password" class="form-control" id="password_confirmation" name="password_confirmation" value="{{old('password_confirmation')}}">
                                            @if ($errors->has('password_confirmation'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('password_confirmation') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
<!--                                    <div class="form-group {{ $errors->has('gender') ? ' has-error' : '' }}">
                                        <label class="col-md-6 control-label">Gender <sup style='color:red;'>*</sup> </label>
                                        <div class="col-md-6">    
                                            <select class="form-control" name="gender" id="gender">
                                                <option value=""  >--Select--</option>
                                                <option value="1" @if (old("gender") === "1") selected @endif>Male</option>
                                                <option value="2" @if (old("gender") === "1") selected @endif>Female</option>

                                            </select>

                                            @if ($errors->has('gender'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('gender') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>-->
                                    <div class="form-group {{ $errors->has('user_mobile') ? ' has-error' : '' }}">
                                        <label class="col-md-6 control-label">Mobile:</label>
                                        <div class="col-md-6">  
                                            <input type="text" class="form-control" id="user_mobile" name="user_mobile" value="{{old('user_mobile')}}">
                                            @if ($errors->has('user_mobile'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('user_mobile') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>

<!--                                    <div class="form-group{{ $errors->has('birth_date') ? ' has-error' : '' }}">
                                            <label class="col-md-6 control-label">Birth Date: </label>
                                            <div class="col-md-6">
                                            <input type="text" class="form-control"  name="birth_date" id="birth_date" value="{{old('birth_date')}}">
                            @if ($errors->has('birth_date'))
                            <span class="help-block">
                                <p>{{ $errors->first('birth_date') }}</p>
                            </span>
                            @endif
                                            </div>
                    </div>
                                        <div class="form-group{{ $errors->has('anniversary_date') ? ' has-error' : '' }}">
                                            <label class="col-md-6 control-label">Anniversary Date: </label>
                                            <div class="col-md-6">
                                            <input type="text" class="form-control"  name="anniversary_date" id="anniversary_date" value="{{old('birth_date')}}">
                            @if ($errors->has('anniversary_date'))
                            <span class="help-block">
                                <p>{{ $errors->first('anniversary_date') }}</p>
                            </span>
                            @endif
                        
                    </div>
                                        </div>-->
                                <div class="business_user_detail" id="business_user_detail">
                                        <div class="form-group{{ $errors->has('company_name') ? ' has-error' : '' }}">
                                            <label class="col-md-6 control-label">Company Name </label>
                                            <div class="col-md-6">
                                            <input type="text" class="form-control" name="company_name" value="{{old('company_name')}}">
                                            @if ($errors->has('company_name'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('company_name') }}</strong>
                                            </span>
                                            @endif
                                            </div>
                                        </div>
                                        <div class="form-group{{ $errors->has('company_type') ? ' has-error' : '' }}">
                                            <label class="col-md-6 control-label">Company Type </label>
                                            <div class="col-md-6">
                                            <input type="text" class="form-control" name="company_type" value="{{old('company_type')}}">
                                            @if ($errors->has('company_type'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('company_type') }}</strong>
                                            </span>
                                            @endif
                                            </div>
                                        </div>
                                        
                                        <div class="form-group{{ $errors->has('pan_card_number') ? ' has-error' : '' }}">
                                            <label class="col-md-6 control-label">Pan Card Number </label>
                                            <div class="col-md-6">
                                            <input type="text" class="form-control" name="pan_card_number" value="{{old('pan_card_number')}}">
                                            @if ($errors->has('pan_card_number'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('pan_card_number') }}</strong>
                                            </span>
                                            @endif
                                            </div>
                                        </div>

                                        <div class="form-group{{ $errors->has('addressline1') ? ' has-error' : '' }}">
                                            <label class="col-md-6 control-label">Address Line 1 </label>
                                            <div class="col-md-6">
                                            <input type="text" name="addressline1" class="form-control" value="{{ old('addressline1') }}" />
                                            @if ($errors->has('addressline1'))
                                            <span class="help-block">
                                                <p>{{ $errors->first('addressline1') }}</p>
                                            </span>
                                            @endif
                                        </div>
                                        </div>
                                        <div class="form-group{{ $errors->has('addressline2') ? ' has-error' : '' }}">
                                             <label class="col-md-6 control-label">Address Line 2 </label>
                                             <div class="col-md-6">
                                            <input type="text" name="addressline2" class="form-control" value="{{ old('addressline2') }}" />
                                            @if ($errors->has('addressline2'))
                                            <span class="help-block">
                                                <p>{{ $errors->first('addressline2') }}</p>
                                            </span>
                                            @endif
                                        </div>
                                        </div>
                                        
                                        <div class="form-group{{ $errors->has('gst_no') ? ' has-error' : '' }}">
                                            <label class="col-md-6 control-label">GST Number </label>
                                            <div class="col-md-6">
                                            <input type="text" class="form-control" name="gst_no" value="{{old('gst_no')}}">
                                            @if ($errors->has('gst_no'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('gst_no') }}</strong>
                                            </span>
                                            @endif
                                            </div>
                                        </div>
                                        
                                        <div class="form-group{{ $errors->has('tax_id') ? ' has-error' : '' }}">
                                            <label class="col-md-6 control-label">Tax Number </label>
                                            <div class="col-md-6">
                                            <input type="text" class="form-control" name="tax_id" value="{{old('tax_id')}}">
                                            @if ($errors->has('tax_id'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('tax_id') }}</strong>
                                            </span>
                                            @endif
                                            </div>
                                        </div>
                                </div>
                                
                                <div class="form-group">
                                    <div class="col-md-12">   
                                        <button type="submit" id="submit" class="btn btn-primary  pull-right">Create User</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

            </div>

            </form>
        </div>
    </div>
</div>
</div>

@endsection

<script>
    function selectUser(user) {
//        alert(user);
        if(user==3){
         $("#business_user_detail").hide();
            $('#user_type').val(user);
         
        }
        else if(user==4){
           $("#business_user_detail").show(); 
            $('#user_type').val(user);
        }
        else if(user==""){
         $("#business_user_detail").hide();
            $('#user_type').val(user);
         
        }
               
    }
</script>

    
   <script>
    
    $(document).ready(function() {
//        alert(1);
            $("input#birth_date").singleDatePicker();
               $("input#anniversary_date").singleDatePicker();
       
          });

          $.fn.singleDatePicker = function() {
                var today = new Date();
                var dd = today.getDate();
                var mm = today.getMonth()+1; //January is 0!
                alert()
                var yyyy = today.getFullYear();
                alert(yyyy);
                var user_date='';
                if(mm<0){
                user_date =  yyyy+'-0'+mm + '-' + dd ;
            }
            else{
                user_date =  yyyy+'-'+mm + '-' + dd ;
            }
                
//                alert(yyyy)
            
//            alert(birth_date);
            $(this).on("apply.daterangepicker", function(e, picker) {
              picker.element.val(picker.startDate.format(picker.locale.format));
            });
            return $(this).daterangepicker({
                locale: {
      format: 'YYYY-MM-DD'
    },
    
//            startDate: start,
        maxDate: user_date,
                 showDropdowns: true,
              singleDatePicker: true,
              autoUpdateInput: false
            });
          };

$.fn.singleDatePicker = function() {
              var today = new Date();
                var dd = today.getDate();
                var mm = today.getMonth()+1; //January is 0!
                
                var yyyy = today.getFullYear();
                
                var user_anni_date='';
                if(mm<0){
                user_anni_date =  yyyy+'-0'+mm + '-' + dd ;
            }
            else{
                user_anni_date =  yyyy+'-'+mm + '-' + dd ;
            }
                
//                alert(yyyy)
            
//            alert(birth_date);
            $(this).on("apply.daterangepicker", function(e, picker) {
              picker.element.val(picker.startDate.format(picker.locale.format));
            });
            return $(this).daterangepicker({
                locale: {
      format: 'YYYY-MM-DD'
    },
    
//            startDate: start,
        maxDate:user_anni_date,
                 showDropdowns: true,
              singleDatePicker: true,
              autoUpdateInput: false
            });
          };

    </script>