@extends(config("piplmodules.back-view-layout-location"))
@section("meta")

<title>Create Occasion</title>

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
                <a href="{{url('/admin/product-occasion')}}">Manage Occasion</a>
                <i class="fa fa-circle"></i>

            </li>
            <li>
                <a href="javascript:void(0);">Create Occasion</a>

            </li>
        </ul>

        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-gift"></i> Create A Occasion
                </div>
            </div>
            <div class="portlet-body form">
                <form class="form-horizontal" name="create_occasion" id="create_occasion" role="form" action="" method="post" enctype="multipart/form-data" >
                    {!! csrf_field() !!}
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-12">    
                                <div class="col-md-8">  
                                    <div class="form-group @if ($errors->has('occasion_name')) has-error @endif">
                                        <label class="col-md-6 control-label">Occasion<sup>*</sup></label>
                                        <div class="col-md-6">     
                                            <input name="occasion_name" type="text" class="form-control" id="occasion_name" value="{{old('occasion_name')}}">
                                            @if ($errors->has('occasion_name'))
                                            <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('occasion_name') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                        <div class="form-group">
                                        <div class="col-md-12">   
                                            <button type="submit" id="submit" class="btn btn-primary  pull-right">Create</button>
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

    
</script>


@endsection