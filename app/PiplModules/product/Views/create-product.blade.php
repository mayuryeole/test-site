@extends(config("piplmodules.back-view-layout-location"))
@section("meta")

<title>Create Product</title>

@endsection


@section('content')
<link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
{{--<link rel="stylesheet" href="{{url('/')}}/public/media/backend/css/style.css">--}}
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
                <a href="{{url('admin/products-list/?stock=&category=')}}">Manage Products</a>
                <i class="fa fa-circle"></i>

            </li>
            <li>
                <a href="javascript:void(0);">Create Product</a>

            </li>
        </ul>

        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-gift"></i> Create A Product
                </div>

            </div>
            <div class="portlet-body form">
                <form class="form-horizontal" name="create_product" id="create_product" role="form" action="" method="post" enctype="multipart/form-data" >
                    {!! csrf_field() !!}
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-12">    
                                <div class="col-md-8">  
                                    <div class="form-group">
                                        <label class="col-md-6 control-label">Select Category<sup>*</sup></label>
                                        <div class="col-md-6">
                                            {{--  //  onchange="getCatAttrVal(this.value)" --}}
                                            <select class="form-control flexselect" id="category" name="category">
                                                <option value="">Select Category</option>
                                                 @foreach($tree as $ls_category)
                                 <option @if (old('parent_id')==$ls_category->id) selected="selected" @endif value="{{$ls_category->id}}">{{$ls_category->display}}</option>
                                 @endforeach
                                            </select>
                                            <input type='hidden' name='category_id' id='category_id'>
                                        </div>
                                    </div>
                                   
                                    <div class="form-group @if ($errors->has('product_name')) has-error @endif">
                                        <label class="col-md-6 control-label">Product Name<sup>*</sup></label>
                                        <div class="col-md-6">     
                                            <input name="product_name" type="text" class="form-control" id="product_name" value="{{old('product_name')}}">
                                            @if ($errors->has('product_name'))
                                            <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('product_name') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group @if ($errors->has('product_sku')) has-error @endif">
                                        <label class="col-md-6 control-label">SKU<sup>*</sup></label>
                                        <div class="col-md-6">
                                            <input name="product_sku" type="text" class="form-control" id="product_sku" value="{{old('product_sku')}}">
                                            @if ($errors->has('product_sku'))
                                                <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('product_sku') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group @if ($errors->has('photo')) has-error @endif">
                                        <label class="col-md-6 control-label">Image<sup>*</sup></label>
                                        <div class="col-md-6">     
                                            <input name="photo" type="file" class="form-control" id="photo" value="{{old('photo')}}">
                                            <img style="display: none;width: 50px;height: 50px" id="imagePreview"/>
                                            @if ($errors->has('photo'))
                                            <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('photo') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group @if ($errors->has('product_clip')) has-error @endif">
                                        <label class="col-md-6 control-label">Video<sup>*</sup></label>
                                        <div class="col-md-6">     
                                            <input name="product_clip" type="file" class="form-control" id="product_clip" value="{{old('product_clip')}}">
                                            <span style="color: white;font-weight:bolder;display: none" class="btn-vdo-mar" id="fileLen"></span>
                                            @if ($errors->has('product_clip'))
                                            <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('product_clip') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    @if(isset($countries) && count($countries)>0)
                                        <div class="form-group">
                                            <label class="col-md-6 control-label">Country</label>
                                            <div class="col-md-6">
                                                <div class="h-color-select">
                                                    <select id="product-country" multiple="multiple" class="productCountrySelect" name="productCountry[]">

                                                        @foreach($countries as $country)
                                                            <option value="{{ $country->id }}" name="color">{{ $country->trans->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            @if ($errors->has('color'))
                                                <div class="control-label" >

                                                    <label class="help-block ">
                                                        <strong class="text-danger">{{ $errors->first('color') }}</strong>
                                                    </label>
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                    @if(isset($rivaah_gal) && count($rivaah_gal)>0)
                                    <div class="form-group">
                                        <label class="col-md-6 control-label">Rivaah</label>
                                        <div class="col-md-6">
                                            <select id="rivaah" multiple="multiple" class="rivaahSelect" name="rivaah[]">
                                                @foreach($rivaah_gal as $gal)
                                                <option value="{{ $gal->name }}" name="rivaah">{{ $gal->name }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('rivaah'))
                                                <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('rivaah') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    @endif
                                    @if(isset($colors) && count($colors)>0)
                                        <div class="form-group">
                                            <label class="col-md-6 control-label">Product Color<sup>*</sup></label>
                                            <div class="col-md-6">
                                                <div class="h-color-select">
                                                    <select id="product-color" class="productColorSelect" name="productColor[]">

                                                        @foreach($colors as $color)
                                                            <option value="{{ $color->name }}" name="color">{{ $color->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            @if ($errors->has('color'))
                                                <div class="control-label" >

                                                    <label class="help-block ">
                                                        <strong class="text-danger">{{ $errors->first('color') }}</strong>
                                                    </label>
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                    @if(isset($colors) && count($colors)>0)
                                    <div class="form-group">
                                        <label class="col-md-6 control-label">Multiple Colors</label>
                                           <div class="col-md-6">
                                           	<div class="h-color-select">
                                               <select id="color" multiple="multiple" class="colorSelect" name="color[]">
                                                  
                                                   @foreach($colors as $color)
                                                        <option value="{{ $color->name }}" name="color">{{ $color->name }}</option>
                                                   @endforeach
                                               </select>
                                            </div>
                                        </div>
                                        @if ($errors->has('color'))
                                        <div class="control-label" >
                                           
                                                <label class="help-block ">
                                                    <strong class="text-danger">{{ $errors->first('color') }}</strong>
                                                </label>
                                        </div>
                                         @endif
                                    </div>
                                    @endif
                                    
                                    <div class="form-group @if ($errors->has('price')) has-error @endif">
                                        <label class="col-md-6 control-label">Price<sup>*</sup></label>
                                        <div class="col-md-6">     
                                            <input name="price" type="text" class="form-control" id="price" value="1" value="{{old('price')}}">
                                            @if ($errors->has('price'))
                                            <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('price') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group @if ($errors->has('quantity')) has-error @endif">
                                        <label class="col-md-6 control-label">Product Quantity<sup>*</sup></label>
                                        <div class="col-md-6">     
                                            <input name="quantity" type="text" class="form-control" id="quantity" value="1" min="1">
                                            @if ($errors->has('quantity'))
                                            <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('quantity') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group @if ($errors->has('order_quantity')) has-error @endif">
                                        <label class="col-md-6 control-label"> Max Order Quantity<sup>*</sup></label>
                                        <div class="col-md-6">
                                            <input name="order_quantity" type="text" class="form-control" id="order_quantity" value="1" min="1" onkeyup="checkQuantity(this.value)">
                                            @if ($errors->has('order_quantity'))
                                                <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('order_quantity') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    {{--<div class="form-group">--}}
                                        {{--<label class="col-md-6 control-label">Product Size</label>--}}
                                        {{--<div class="col-md-6">--}}
                                            {{--<select class="form-control" id="product_size" name="product_size">--}}
                                                {{--<option value="">Select Size</option>--}}
                                            {{--</select>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                    
                                    <div class="form-group @if ($errors->has('is_featured')) has-error @endif">
                                        <label class="col-md-6 control-label">Is Featured?<sup>*</sup></label>
                                        <div class="col-md-6">     
                                            <label class="radio-inline"><input type="radio" name="is_featured" value="1">Yes</label> 
                                            <label class="radio-inline"><input type="radio" name="is_featured" value="0" checked>No</label><br />
                                         
                                        </div>
                                                           @if ($errors->has('is_featured')) <span class="help-block"> <strong class="text-danger">{{ $errors->first('is_featured') }}</strong> </span> @endif 
                            
                                    </div> 
                                    <div class="form-group @if ($errors->has('status')) has-error @endif">
                                        <label class="col-md-6 control-label">Status?<sup>*</sup></label>
                                        <div class="col-md-6">     
                                            <label class="radio-inline"><input type="radio" name="status" value="1">Enable</label> 
                                            <label class="radio-inline"><input type="radio" name="status" value="0" checked >Disable</label>
                                            @if ($errors->has('status')) <span class="help-block"> <strong class="text-danger">{{ $errors->first('status') }}</strong> </span> @endif 
                                        </div>

                                    </div> 
                                    
                                    <div class="form-group @if ($errors->has('is_available')) has-error @endif">
                                        <label class="col-md-6 control-label">Availability<sup>*</sup></label>
                                        <div class="col-md-6">     
                                            <label class="radio-inline"><input type="radio" name="is_available" value="1">Out of Stock</label> 
                                            <label class="radio-inline"><input type="radio" name="is_available" value="0" checked >In Stock</label>
                                            @if ($errors->has('is_available')) <span class="help-block"> <strong class="text-danger">{{ $errors->first('is_available') }}</strong> </span> @endif 
                                        </div>
                                        
                                    </div> 
                                    
                                    <div class="form-group @if ($errors->has('pre_order')) has-error @endif">
                                        <label class="col-md-6 control-label">Pre-Order<sup>*</sup></label>
                                        <div class="col-md-6">     
                                            <label class="radio-inline"><input type="radio" name="pre_order" onchange="addLaunchedDate(this)"  value="1" >Yes</label> 
                                            <label class="radio-inline"><input type="radio" name="pre_order" onchange="addLaunchedDate(this)"   value="0" checked>No</label>
                                            @if ($errors->has('pre_order')) <span class="help-block"> <strong class="text-danger">{{ $errors->first('pre_order') }}</strong> </span> @endif 
                                        </div>

                                    </div> 
                                    
                                    <div id="add_date" hidden="" class="form-group @if ($errors->has('launched_date')) has-error @endif">
                                        <label class="col-md-6 control-label">Product Launched Date<sup>*</sup></label>
                                        {{--<div class="col-md-6"> --}}
                                            {{--<input name="launched_date" type="text" hidden="" class="form-control" id="launched_date" value="{{old('launched_date')}}">--}}
                                                {{--@if ($errors->has('launched_date'))--}}

                                            {{--<span class="help-block">--}}
                                                {{--<strong class="text-danger">{{ $errors->first('launched_date') }}</strong>--}}
                                            {{--</span>--}}
                                            {{--@endif--}}
                                        {{--</div>--}}
                                        <div class='input-group date' id='datepicker1'>
                                            <input type='text' id='launched_date' hidden="" name="launched_date" class="form-control" value="{{old('launched_date')}}" />
                                            <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar">
                                            </span>
                                            </span>
                                            @if ($errors->has('launched_date'))
                                                <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('launched_date') }}</strong>
                                                </span>
                                            @endif

                                        </div>



                                    </div>
                                    
                                    <div class="form-group @if ($errors->has('occasion')) has-error @endif">
                                        <label class="col-md-6 control-label">Occasion</label>
                                        <div class="col-md-6">  
                                            <select class="form-control" id="occasion" name="occasion">
                                                <option value="">Select Occasion</option>
                                                @if(count($occasion)>0)
                                                @foreach($occasion as $o)
                                                <option value="{{$o->id}}">{{$o->name}}</option>
                                                @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-6 control-label">Hide Product</label>
                                        <div class="col-md-6">  
                                            <select class="form-control" id="hide_product" name="hide_product">
                                                <option value="3">Select User Type</option>
                                                <option value="0">Hide from Customer/Guest User</option>
                                                <option value="1">Hide from Business/Guest User</option>
                                                <option value="2">Hide from Both</option>
                                            </select>     
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="col-md-6 control-label">Hide Product Price</label>
                                        <div class="col-md-6">  
                                            <select class="form-control" id="hide_product_price" name="hide_product_price">
                                                <option value="3">Select User Type</option>
                                                <option value="0">Hide from Customer/Guest User</option>
                                                <option value="1">Hide from Business/Guest User</option>
                                                <option value="2">Hide from Both</option>
                                            </select>   
                                        </div>
                                    </div>
                                    
                                    
                                    
                                    
                                    <div class="form-group @if ($errors->has('style')) has-error @endif">
                                        <label class="col-md-6 control-label">Style</label>
                                        <div class="col-md-6">  
                                            <select class="form-control" id="occasion" name="style" id="style">
                                                <option value="">Select Style</option>
                                                @if(count($style)>0)
                                                @foreach($style as $s)
                                                <option value="{{$s->id}}">{{$s->name}}</option>
                                                @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group @if ($errors->has('collection_style')) has-error @endif">
                                        <label class="col-md-6 control-label">Collection Style</label>
                                        <div class="col-md-6">  
                                            <select class="form-control" id="occasion" name="collection_style" id="collection_style">
                                                <option value="">Select Collection Style</option>
                                                 @if(count($collection_style)>0)
                                                @foreach($collection_style as $c)
                                                <option value="{{$c->id}}">{{$c->name}}</option>
                                                @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>

                                    {{--<div class="form-group @if ($errors->has('short_description')) has-error @endif">--}}
                                        {{--<label class="col-md-6 control-label">Short Description<sup>*</sup></label>--}}
                                        {{--<div class="col-md-6">     --}}
                                            {{--<input name="short_description" type="text" class="form-control" id="short_description" value="{{old('short_description')}}">--}}
                                            {{--@if ($errors->has('short_description'))--}}
                                            {{--<span class="help-block">--}}
                                                {{--<strong class="text-danger">{{ $errors->first('short_description') }}</strong>--}}
                                            {{--</span>--}}
                                            {{--@endif--}}
                                        {{--</div>--}}
                                    {{--</div>--}}

                                    <div class="form-group @if ($errors->has('description')) has-error @endif">
                                        <label class="col-md-6 control-label">Description<sup>*</sup></label>
                                        <div class="col-md-6">     
                                            <textarea name="description" type="text" class="form-control" id="description" value="{{old('description')}}"></textarea>
                                            @if ($errors->has('description'))
                                            <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('description') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                        <div class="form-group">
                                        <div class="col-md-12">   
                                            <input type="submit" class="btn btn-primary pull-right" onclick="appendErrorMsgProduct()" value="Create">
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
    $(function(){
        var d = new Date();

        $("#datepicker1").datetimepicker({
            format:"yyyy/mm/dd HH:ii:ss",
            startDate:d
        });
    });


</script>
<script type="text/javascript">
    $("#photo").on("change", function(e) {

        var flag='0';
        var fileName = e.target.files[0].name;
        var arr_file = new Array();
        arr_file = fileName.split('.');
        var file_ext = arr_file[1];
        if(file_ext=='jpg'||file_ext=='JPG'||file_ext=='jpeg'||file_ext=='JPEG'||file_ext=='png'||file_ext=='PNG'||file_ext=='mpeg'||file_ext=='MPEG'||file_ext=='img'||file_ext=='IMG'||file_ext=='bpg' ||file_ext=='GIF'||file_ext=='gif')
       {

            var files = e.target.files,

                filesLength = files.length;
            for (var i = 0; i < filesLength; i++) {
                var f = files[i];
                var fileReader = new FileReader();
                fileReader.onload = (function(e) {
                    var file = e.target;
                    $("#imagePreview").show();
                    $("#imagePreview").attr("src",e.target.result );



                });
                fileReader.readAsDataURL(f);
            }
        } else{
            $("#photo").val('');
            alert('Please choose valid image extension. eg : jpg | jpeg | png |gif');
            return false;
        }

    });

</script>
<script>
    $("#product_clip").change(function(e){

        $("#fileLen").show();
        var file = e.target.files.length;
        var files= e.target.files;
        gbl_count = e.target.files.length;
            for(var i =0; i<gbl_count; i++){
                var f = files[i];

                var file_ext = f.name.split('.').pop();
                console.log(file_ext);
                if(file_ext=='mp4' || file_ext=='mp3' || file_ext=='m4v'|| file_ext=='mpg' || file_ext=='avi' || file_ext=='fly' || file_ext=='wmv' || file_ext=='webm' || file_ext=='ogg')
                {
                    return true;
                }
                else{
                    $("#product_clip").val('');
                    alert('Please upload valid videos. eg : mp4 | mp3 | m4v | mpg |avi | fly | wmv | webm | ogg');
                    return false;
                }
            }
    });



</script>

<script>
    function setCategory($cat)
    {
        $('#category_id').val($cat);
    }

    function addLaunchedDate(status) {

        if ($(status).val() == '1') {
            $("#add_date").show();
//            $("#percentage_txt").val('');
//            $("#percentage").hide();
        }
        else if ($(status).val() == '0') {
            
                $("#add_date").hide();
            
        }
        else{
            $("#add_date").hide();
        }
    }
$(function () {

            $('.colorSelect').multiselect({
                    includeSelectAllOption: true,
                    noneSelectedText: 'Select Multiple Product color'
                });

            $('.rivaahSelect').multiselect({
                includeSelectAllOption: true,
                noneSelectedText: 'Select Product Rivaah'
            });
            $('.productColorSelect').multiselect({
                includeSelectAllOption: true,
                multiple: false,
                noneSelectedText: 'Select Product color'
            });

            $('.productCountrySelect').multiselect({
                includeSelectAllOption: true,
                noneSelectedText: 'Select Multiple Countries'
            });
        });
        $(".productColorSelect").change(function ()
        {
            $('.colorSelect').siblings('div.btn-group').find( "li input[value='" + $(this).val() +"']").attr('disabled',true);
        });


        function checkQuantity(value){
//            alert(value);
            var max_order=parseInt($("#quantity").val());
            var value=parseInt(value);
//            alert(max_order);
                if(value!=""){
            if(max_order< value){
                $("#order_quantity").val("");
                alert("Please enter Max Order Quantity less than or equal to Product Quantity");
            }
        }
        }
        jQuery(document).ready(function() {
            $("select .flexselect").flexselect();
        });
</script>
<script>
    function getCatAttrVal(id) {

        $.ajax({
            url: '{{  url('/get-category-size-values') }}',
            type: "post",
            dataType: 'json',
            data: {
                category_id: id
            },
            success: function (response) {
                console.log(response);
                var select_value = '<option value="">Select Size</option>';
                if (response) {
                    for (var i = 0; i < response.length; i++) {

                        select_value += '<option value="' + response[i] + '">' + response[i] + '</option>';
                    }
                }
                $('#product_size').html(select_value);


            }
        });
    }
</script>
<style>
    .dropdown-menu label.radio input[type=radio]{
        visibility: hidden;
    }
    .dropdown-menu label.radio{
        padding-left:10px;
    }
</style>
<script type="text/javascript" src="{{url('/')}}/public/media/backend/js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript" src="{{url('/')}}/public/media/backend/js/flexselect.js"></script>
<script type="text/javascript" src="{{url('/')}}/public/media/backend/js/liquidmetal.js"></script>
<script type="text/javascript" src="{{url('/')}}/public/media/backend/js/color-product.js"></script>

@endsection
