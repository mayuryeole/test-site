@extends(config("piplmodules.back-view-layout-location"))
@section("meta")

<title>Create Rivaah Gallery</title>

@endsection


@section('content')
<link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="{{url('/')}}/public/media/backend/css/style.css">
<link rel="stylesheet" href="{{url('/')}}/public/media/backend/css/bootstrap-datetimepicker.min.css">
<link rel="stylesheet" href="{{url('/')}}/public/media/backend/css/flexselect.css" media="screen">
<link rel="stylesheet" href="{{url('/')}}/public/media/backend/css/color-product.css" media="screen">



<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<div class="page-content-wrapper">
    <div class="page-content">
        <!-- BEGIN PAGE BREADCRUMB -->
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <a href="{{url('admin/dashboard')}}">Dashboard</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="{{url('admin/rivaah-galleries-list')}}">Manage Rivaah</a>
                <i class="fa fa-circle"></i>

            </li>
            <li>
                Create Rivaah Gallery

            </li>
        </ul>

        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-gift"></i> Create A Rivaah Gallery
                </div>

            </div>
            <div class="portlet-body form">
                <form class="form-horizontal" name="create_rivaah_gallery" id="create_rivaah_gallery" role="form" action="" method="post" enctype="multipart/form-data" >
                    {!! csrf_field() !!}
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-12">    
                                <div class="col-md-8">  
                                    {{--<div class="form-group">--}}
                                        {{--<label class="col-md-6 control-label">Select Category<sup>*</sup></label>--}}
                                        {{--<div class="col-md-6">  --}}
                                            {{--<select class="form-control flexselect" id="category" name="category" onclick="setCategory(this.value)">--}}
                                                {{--<option value="">Select Category</option>--}}
                                        {{--@foreach($all_category as $key=>$val)--}}
                                                {{--<option value="{{$val->id}}" name="category" id="category">{{$val->name}}</option>--}}
                                                {{--@endforeach                                            </select>--}}
                                            {{--<input type='hidden' name='category_id' id='category_id'>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                   
                                    <div class="form-group @if ($errors->has('name')) has-error @endif">
                                        <label class="col-md-6 control-label">Gallery Name<sup>*</sup></label>
                                        <div class="col-md-6">     
                                            <input name="name" type="text" class="form-control" id="name" value="{{old('name')}}">
                                            @if ($errors->has('name'))
                                            <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('name') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group @if ($errors->has('description')) has-error @endif">
                                        <label class="col-md-6 control-label">Description<sup>*</sup></label>
                                        <div class="col-md-6">     
                                            <textarea rows="15" cols="10" name="description" type="text" class="form-control" id="description" value="{{old('description')}}"></textarea>
                                            @if ($errors->has('description'))
                                            <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('description') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                        <div class="form-group">
                                        <div class="col-md-12">   
                                            <input type="submit" class="btn btn-primary  pull-right" value="Create">
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

<script>
    function setCategory($cat)
    {
        $('#category_id').val($cat);
    }
jQuery(document).ready(function() {
    $("select .flexselect").flexselect();
  // $("#category").flexselect();
});
</script>

<script type="text/javascript" src="{{url('/')}}/public/media/backend/js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript" src="{{url('/')}}/public/media/backend/js/flexselect.js"></script>
<script type="text/javascript" src="{{url('/')}}/public/media/backend/js/liquidmetal.js"></script>
<script type="text/javascript" src="{{url('/')}}/public/media/backend/js/color-product.js"></script>

@endsection