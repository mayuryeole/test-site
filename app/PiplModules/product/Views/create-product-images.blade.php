@extends(config("piplmodules.back-view-layout-location"))
@section("meta")

<title>Create Product Image</title>

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
                <a href="{{url('/admin/products-list/?stock=&category=')}}">Manage Products</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="{{url('/admin/manage-product-image')}}/{{$product_id}}">Product Image</a>
                <i class="fa fa-circle"></i>

            </li>
            <li>
                <a href="javascript:void(0);">Create Product Image</a>

            </li>
        </ul>
@if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
            <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
        </div>
        @endif
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-gift"></i> Create A Product Image
                </div>

            </div>
            <div class="portlet-body form">
                <form class="form-horizontal" name="create_product_image" id="create_product_image" role="form" action="" method="post" enctype="multipart/form-data" >

                    {!! csrf_field() !!}
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-12">    
                                <div class="col-md-8">  
{{--<!--                                    <div class="form-group @if ($errors->has('name')) has-error @endif">--}}
                                        {{--<label class="col-md-6 control-label">Name<sup>*</sup></label>--}}
                                        {{--<div class="col-md-6">     --}}
                                            {{--<input name="name" type="text" class="form-control" id="name" value="{{old('name')}}">--}}
                                            {{--@if ($errors->has('name'))--}}
                                            {{--<span class="help-block">--}}
                                                {{--<strong class="text-danger">{{ $errors->first('name') }}</strong>--}}
                                            {{--</span>--}}
                                            {{--@endif--}}
                                        {{--</div>--}}
                                    {{--</div>-->--}}
                                     <div class="form-group @if ($errors->has('color')) has-error @endif">
                                        <label class="col-md-6 control-label">Select Color:<sup>*</sup></label>
                                        <div class="col-md-6">     
                                            <select name="color"  class="form-control" id="color" >
                                                <option value="">Select Color</option>
                                                @if(isset($filterArr) && count($filterArr)>0)
                                                @foreach($filterArr as $key=>$val)
                                                <option value="{{ $val }}">{{ $val }}</option>
                                                @endforeach
                                                @endif
                                            </select>    
                                           
                                            @if ($errors->has('color'))
                                            <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('color') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="form-group @if ($errors->has('photo')) has-error @endif">
                                        <label class="col-md-6 control-label">Image<sup>*</sup></label>
                                        <div class="col-md-6">     
                                            <input name="photo[]" type="file" class="form-control" id="photo" value="{{old('photo')}}" multiple>
                                            <span style="color: black; font-weight:bolder;" class="btn-vdo-mar" id="fileLen"></span>
                                            @if ($errors->has('photo'))
                                            <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('photo') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>

                                    <input type="hidden" name="product_id" value="{{$product_id}}">
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
    $("#photo").change(function(e){
        $("#fileLen").show();
        var files= e.target.files;
        gbl_count = e.target.files.length;

        if(gbl_count == 0){
            alert('Please select image files to upload.');
            return false;
        }
        else if(gbl_count > 4)
        {
            alert('Please select max 4 image files to upload');
            return false;
        }
        else
        {
            for(var i =0; i< gbl_count; i++)
            {
                var f = files[i];
                var file_ext = f.name.split('.').pop();
                if(file_ext=='jpg'||file_ext=='jpeg'||file_ext=='png'||file_ext=='gif')
                {
                    return true;
                }
                else{

                    alert('Please upload valid photos. eg : jpg | jpeg | png | gif');
                    return false;
                }
            }
        }

    });
</script>

<script>
    function setCategory($cat)
    {
        $('#category_id').val($cat);
    }

    
</script>


@endsection