@extends(config("piplmodules.back-view-layout-location"))

@section("meta")

<title>Update Country Info</title>

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
					<a href="{{url('admin/countries/list')}}">Manage Countries</a>
                                        <i class="fa fa-circle"></i>
					
				</li>
				<li>
					<a href="javascript:void(0);">Update Country</a>
					
				</li>
                        </ul>

  
    
      <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box blue">
             <div class="portlet-title">
                        <div class="caption">
                                <i class="fa fa-gift"></i> Update Country Info
                        </div>

             </div>
             <div class="portlet-body form">
              <form class="form-horizontal" role="form" action="" method="post" name="update_country" id="update_country" >
            
                 {!! csrf_field() !!}
                 <div class="form-body">
                   <div class="row">
                        <div class="col-md-12">    
                      <div class="col-md-8">  
                         <div class="form-group">
                          <label class="col-md-6 control-label">Name<sup>*</sup></label>
                       
                            <div class="col-md-6">     
                           <input name="name" type="text" class="form-control" id="name" value="{{old('name',$country_info->name)}}">
                            @if ($errors->has('name'))
                              <span class="help-block">
                                  <strong class="text-danger">{{ $errors->first('name') }}</strong>
                              </span>
                              @endif
                          </div>
                          </div>
                          <div class="form-group">
                              <label class="col-md-6 control-label">ISO 2<sup>*</sup></label>

                              <div class="col-md-6">
                                  <input name="iso" type="text" class="form-control" id="iso" value="{{old('iso',$country_info->iso_code)}}">
                                  @if ($errors->has('iso'))
                                      <span class="help-block">
                                  <strong class="text-danger">{{ $errors->first('iso') }}</strong>
                              </span>
                                  @endif
                              </div>
                          </div>
                          <div class="form-group">
                              <label class="col-md-6 control-label">Digits<sup>*</sup></label>

                              <div class="col-md-6">
                                  <input name="digit" type="text" class="form-control" id="digit" value="{{old('digit',$country_info->digit)}}">
                                  @if ($errors->has('digit'))
                                      <span class="help-block">
                                  <strong class="text-danger">{{ $errors->first('digit') }}</strong>
                              </span>
                                  @endif
                              </div>
                          </div>
                          <div class="form-group @if ($errors->has('pattern')) has-error @endif">
                              <label class="col-md-6 control-label">Code Pattern<sup>*</sup></label>
                              <div class="col-md-6">
                                  <label class="radio-inline"><input type="radio" name="pattern" value="0" @if($country_info->pattern ==0) checked @endif>Numeric</label>
                                  <label class="radio-inline"><input type="radio" name="pattern" value="1" @if($country_info->pattern ==1) checked @endif>Alphanumeric</label><br />

                              </div>
                              @if ($errors->has('pattern')) <span class="help-block"> <strong class="text-danger">{{ $errors->first('pattern') }}</strong> </span> @endif

                          </div>
                          <div class="form-group">
                         <div class="col-md-12">   
                            <button type="submit" id="submit" class="btn btn-primary  pull-right">Update</button>
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
        <style>
            .submit-btn{
                padding: 10px 0px 0px 18px;
            }
        </style>
 @endsection