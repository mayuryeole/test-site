
@extends(config("piplmodules.back-view-layout-location"))

@section("meta")

<title>Add Display</title>

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
                <a href="{{url('/admin/display-list')}}">Manage Display</a>
                <i class="fa fa-circle"></i>

            </li>
            <li>
                <a href="javascript:void(0);">Add Display</a>

            </li>
        </ul>
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-gift"></i> Add Display
                </div>
            </div>
            <div class="portlet-body form">
                <form class="form-horizontal" name="create_display" id="create_display" role="form" action="{{url('/admin/display/create' )}}" method="post" enctype="multipart/form-data">
                    {!! csrf_field() !!}
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-12">    
                                <div class="col-md-8">

                                    <div class="form-group">
                                        <label class="col-md-6 control-label">Display Name<sup>*</sup></label>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="display_name" id="display-name" value="{{old('display_name')}}">
                                            @if ($errors->has('display_name'))
                                                <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('display_name') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-6 control-label">Display Weight<sup>*</sup></label>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="display_weight" id="display-weight" value="{{old('display_weight')}}">
                                            @if ($errors->has('display_weight'))
                                                <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('display_weight') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-6 control-label">Display Image<sup>*</sup></label>
                                        <div class="col-md-6">     
                                            <input type="file" class="form-control" name="image" multiple="true" id="image" value="{{old('image')}}">
                                            <img class="ribbon-image" style="display: none" id="show_image" src="#" alt="" width="50px" height="50px"/>
                                            @if ($errors->has('image'))
                                            <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('image') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-6 control-label">Status<sup>*</sup></label>

                                        <div class="col-md-6">     
                                            <select name="status" class="form-control" id="status" value="{{old('status')}}" onchange="hideShowTextbox(this)">
                                                <option value="">Select Status</option>
                                                <option value="0">Free</option>
                                                <option value="1">Paid</option>
                                             </select>
                                            @if ($errors->has('status'))
                                            <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('status') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div id="order_price_div" class="form-group" style="display: none;">
                                        <label class="col-md-6 control-label">Price<sup>*</sup></label>

                                        <div class="col-md-6">
                                            <input name="price" type="text" class="form-control" id="price" value="{{old('price')}}">
                                            @if ($errors->has('price'))
                                                <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('price') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group @if ($errors->has('description')) has-error @endif">
                                        <label class="col-md-6 control-label">Description</label>
                                        <div class="col-md-6">
                                            <textarea name="description" type="text" class="form-control" id="description" value="{{old('description')}}"></textarea>
                                            @if ($errors->has('description'))
                                                <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('description') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>

                                    {{--<div class="form-group" id="order_quantity_div" style="display: none;">--}}
                                        {{--<label class="col-md-6 control-label">Order Quantity<sup>*</sup></label>--}}
                                        {{--<div class="col-md-6">     --}}
                                            {{--<input name="order_quantity" id="order_quantity" type="text" class="form-control" value="{{old('order_quantity')}}">--}}
                                            {{--@if ($errors->has('order_quantity'))--}}
                                            {{--<span class="help-block">--}}
                                                {{--<strong class="text-danger">{{ $errors->first('order_quantity') }}</strong>--}}
                                            {{--</span>--}}
                                            {{--@endif--}}
                                        {{--</div>--}}
                                    {{--</div>--}}

                                    <div class="form-group">
                                        <div class="col-md-12">   
                                            <button type="submit" id="btn_product" name="btn_product" class="btn btn-primary  pull-right">Create</button>
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
    .error{
        color:red;
    }
    

</style>
<script type="text/javascript">

    $("#image").on("change", function(e) {

        var flag='0';
        var fileName = e.target.files[0].name;
        var arr_file = new Array();
        arr_file = fileName.split('.');
        var file_ext = arr_file[1];
        if(file_ext=='jpg'||file_ext=='JPG'||file_ext=='jpeg'||file_ext=='JPEG'||file_ext=='png'||file_ext=='PNG'|| file_ext=='GIF'||file_ext=='gif')
        {

            var files = e.target.files,

                filesLength = files.length;
            for (var i = 0; i < filesLength; i++) {
                var f = files[i];
                var fileReader = new FileReader();
                fileReader.onload = (function(e) {
                    var file = e.target;
                    $("#show_image").show();
                    $("#show_image").attr("src",e.target.result );



                });
                fileReader.readAsDataURL(f);
            }
        } else{
            $("#photo").val('');
            alert('Please choose valid image extension. eg : jpg | jpeg | png |gif');
            return false;
        }

    });

    function hideShowTextbox(t){

        if($(t).val() == 1){
            $("#order_price_div").show();
        }else{
            $("#order_price_div").hide();
        }
    }
</script>
@endsection

