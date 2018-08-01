@extends(config("piplmodules.back-view-layout-location"))

@section("meta")

<title>Create Sub Gallery</title>

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
                <a href="{{url('/admin/sub-gallery-list/')}}/{{ $gallery_id }}">Manage Sub Gallery</a>
                <i class="fa fa-circle"></i>

            </li>
            <li>
                <a href="javascript:void(0);">Create Sub Gallery</a>

            </li>
        </ul>



        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-gift"></i> Create Sub Gallery
                </div>

            </div>
            <div class="portlet-body form">
                <form class="form-horizontal" role="form" action="" method="post" enctype="multipart/form-data" >

                    {!! csrf_field() !!}
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-12">    
                                <div class="col-md-8">                             
                                    <div>
                                        <div class="form-group">
                                            <form>
                                                <input type='hidden' name='parent_id' id='parent_id'>
                                            </form>
                                        </div>
                                        <div>
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Parent Gallery</label>
                                            <div class="col-md-12">     
                                                <input name="parent_gallery" type="text"  readonly class="form-control" id="parent_gallery" value="{{ $gallery->name }}">
                                                <input name="gallery_id" type="hidden" class="form-control" id="gallery_id" value="{{ $gallery_id }}">
                                                <input name="parent_id" type="hidden" class="form-control" id="parent_id" value="{{ $gallery_id }}">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Name<sup>*</sup></label>
                                            <div class="col-md-12">     
                                                <input name="name" type="text" class="form-control" id="name" value="{{old('name')}}">
                                                @if ($errors->has('name'))
                                                <span class="help-block">
                                                    <strong class="text-danger">{{ $errors->first('name') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group @if ($errors->has('description')) has-error @endif">
                                            <label for="description" >Description <sup>*</sup>
                                            </label>
                                            <textarea class="form-control" name="description">{{old('description')}}</textarea>

                                            @if ($errors->has('description'))
                                            <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('description') }}</strong>
                                            </span>
                                            @endif
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
                    </div>
                </form>   
            </div>
        </div>
    </div>
    <style>
        .submit-btn{
            padding: 10px 0px 0px 18px;
        }
    </style>

    <script>
        function setParentCategory($parent)
        {
            $('#parent_id').val($parent);
        }
    </script>
    @endsection