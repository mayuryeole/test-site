@extends(config("piplmodules.back-view-layout-location"))

@section("meta")

<title>Create Category</title>

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
                <a href="{{url('admin/categories-list')}}">Manage Categories</a>
                <i class="fa fa-circle"></i>

            </li>
            
            <li>
                <a href="javascript:void(0);">Update Sub-Category</a>

            </li>
        </ul>



        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-gift"></i> Update Sub-Category
                </div>

            </div>
            <div class="portlet-body form">
                <!--<form class="form-horizontal" id="create-sub-sub-cat" role="form" action="" method="post" id="update-cat" >-->
<form class="form-horizontal" id="update-cat" role="form" action="" method="post" id="update-cat" >

                    {!! csrf_field() !!}
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-12">    
                                <div class="col-md-8">  
                                    <div class="form-group">
                                        <label class="col-md-6 control-label">Name<sup>*</sup></label>
                                        <div class="col-md-6">    
                                            <input name="name" type="text" class="form-control" id="name" value="{{old('name',stripslashes($category->name))}}">
                                            @if ($errors->has('name'))
                                            <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('name') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group @if ($errors->has('description')) has-error @endif">
                                        <label class="col-md-6 control-label">Description </label>
                                        <div class="col-md-6">     
                                            <textarea class="form-control" name="description" >{{old('description',stripslashes($category->description))}}</textarea>
                                            @if ($errors->has('description'))
                                            <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('description') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group @if ($errors->has('about_category')) has-error @endif">
                                        <label class="col-md-6 control-label">About Category </label>
                                        <div class="col-md-6">     
                                            <textarea class="form-control" name="about_category" >{{old('about_category',stripslashes($category->about_category))}}</textarea>
                                            @if ($errors->has('about_category'))
                                            <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('about_category') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <div class="col-md-12">   
                                            <button type="submit" id="submit" class="btn btn-primary  pull-right">Update</button>
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