@extends(config("piplmodules.back-view-layout-location"))

@section("meta")

<title>Send Newsletter</title>

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
                <a href="{{url('admin/newsletters')}}">Manage Newsletters</a>
                <i class="fa fa-mail-forward"></i>

            </li>
            <li>
                <a href="javascript:void(0);">Select Subscriber</a>

            </li>
        </ul>



        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-gift"></i> Send Newsletter
                </div>

            </div>
            <div class="portlet-body form">

                <form class="form-horizontal"role="form" method="post" enctype="multipart/form-data">

                    {!! csrf_field() !!}
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-12">    
                                <div class="col-md-9">  
                                    <div class="form-group  @if ($errors->has('subject')) has-error @endif">
                                        <label for="page_title" class="col-md-3 control-label">Newsletter</label>

                                        <div class="col-md-9">     
                                            <input class="form-control" name="subject" value="{{old('subject',$newsletter->subject)}}"  readonly />
                                            @if ($errors->has('subject'))
                                            <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('subject') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                        <p>&nbsp;</p>
                                        <div class="form-group  @if ($errors->has('content')) has-error @endif">
                                            <label for="page_content" class="col-md-3 control-label">Subscribers<sup>*</sup></label>

                                            <div class="col-md-9">     
                                                <textarea class="form-control" name="email" required >{{old('email',$users)}}</textarea>
                                                @if ($errors->has('email'))
                                                <span class="help-block">
                                                    <strong class="text-danger">{{ $errors->first('email') }}</strong>
                                                </span>
                                                @endif
                                            </div>

                                        </div>

                                    </div>

                                    <div class="form-group">
                                        <div class="col-md-12">  
                                            
                                            <button type="submit" id="submit" class="btn btn-primary  pull-right">Send</button>
                                            <button onclick="javascript:window.history.go(-1);" type="button" class="btn btn-warning pull-right" style="margin-right: 15px;">Back</button>
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
<script src="{{url('/vendor/unisharp/laravel-ckeditor/ckeditor.js')}}"></script> 
<script>
CKEDITOR.replace('content');
</script> 
</section>
@endsection
