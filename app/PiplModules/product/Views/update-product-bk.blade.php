@extends(config("piplmodules.back-view-layout-location"))

@section("meta")

<title>Update Product</title>

@endsection
@section('content')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
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
                <a href="{{url('admin/products-list')}}">Manage Products</a>
                <i class="fa fa-circle"></i>

            </li>
            <li>
                <a href="javascript:void(0);">Update Product</a>

            </li>
        </ul>


        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-gift"></i> Update Product
                </div>

            </div>
            <div class="portlet-body form">
                <form class="form-horizontal" name="update_product" id="update_product" role="form" action="" method="post" enctype="multipart/form-data" >
                    {!! csrf_field() !!}
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-12">    
                                <div class="col-md-8">  
                                    <div class="form-group">
                                        <label class="col-md-6 control-label">Select Category</label>
                                        <div class="col-md-6">  
                                            <select class="form-control flexselect" id="category" name="category" onclick="setCategory(this.value)">
                                                @foreach($all_category as $key=>$val)
                                                <option value="{{$val->category_id}}" @if(isset($product->category_id) && $product->category_id==$val->category_id) selected="selected" @endif>{{$val->name}}</option>
                                                @endforeach
                                            </select>
                                         </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="col-md-6 control-label">Name</label>

                                        <div class="col-md-6">
                                            <input name="product_old_name" type="hidden" class="form-control" id="product_old_name" value="{{$product->name}}" />
                                            <input name="product_name" type="text" class="form-control" id="product_name" value="{{$product->name}}" />
                                            @if ($errors->has('product_name'))

                                            <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('product_name') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group ">
                                        <label class="col-md-6 control-label">Image</label>

                                        <div class="col-md-6">   
                                        <div class="@if(!empty($product_description->image)) input-group @endif"> @if(!empty($product_description->image))<span class="input-group-addon" id="basic-addon3"><img src="{{asset('storage/app/public/product/image/thumbnail/'.$product_description->image)}}" height="20" style="cursor:pointer" onclick="window.open('{{asset('storage/app/public/product/image/thumbnail'.$product_description->image)}}','Image','width=200,height=200,left=('+screen.width-200+'),top=('+screen.height-200+')')" /></span>@endif

                                            <input name="photo" type="file" class="form-control" id="photo" value="{{$product_description->image}}"/>
                                            @if ($errors->has('photo'))

                                            <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('photo') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    </div>
                                    <div class="form-group ">
                                        <label class="col-md-6 control-label">Video</label>

                                        <div class="col-md-6">     
                                            <input name="product_clip" type="file" class="form-control" id="product_clip" value="{{$product_description->video}}" >
                                            <span style="color: white;font-weight:bolder;display: none" class="btn-vdo-mar" id="fileLen"></span>
                                            @if ($errors->has('product_clip'))

                                            <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('product_clip') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>

{{--<!--                                    <div class="form-group">--}}
                                        {{--<label class="col-md-6 control-label">Color</label>--}}
                                        {{--<div class="col-md-6">    --}}
                                            {{--<input type='color' name='color' id="color" value="{{$product_description->color}}">--}}
                                            {{--@if ($errors->has('color'))--}}
                                            {{--<span class="help-block">--}}
                                                {{--<strong class="text-danger">{{ $errors->first('color') }}</strong>--}}
                                            {{--</span>--}}
                                            {{--@endif--}}
                                        {{--</div>--}}
                                    {{--</div>-->--}}
                                    @if(isset($rivaah_gal) && count($rivaah_gal)>0)
                                        <div class="form-group @if ($errors->has('rivaah')) has-error @endif">
                                            <label class="col-md-6 control-label">Rivaah</label>
                                            <div class="col-md-6">
                                                <select id="rivaah" multiple="multiple" name="rivaah[]">
                                                    @foreach($rivaah_gal as $gal)
                                                        <option value="{{ $gal->name }}" name="rivaah" @if(isset($rivaah_product) && in_array($gal->id,$rivaah_product) == true) selected @endif >{{ $gal->name }}</option>
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


                                    <div class="form-group @if ($errors->has('color')) has-error @endif">
                                        <label class="col-md-6 control-label">Color</label>
                                        <div class="col-md-6">
                                        	<div class="h-color-select">   
                                                 <select id="color" multiple="multiple" name="color[]">
                                                    <option value="Black" name="color" @if(isset($product_color) && in_array("Black",$product_color) == true) selected @endif>Black</option>
                                                    <option value="Grey" name="color" @if(isset($product_color) && in_array("Grey",$product_color) == true) selected @endif>Grey</option>
                                                    <option value="White" name="color" @if(isset($product_color) && in_array("White",$product_color) == true) selected @endif>White</option>
                                                    <option value="Brown" name="color" @if(isset($product_color) && in_array("Brown",$product_color) == true) selected @endif>Brown</option>
                                                    <option value="Beige" name="color" @if(isset($product_color) && in_array("Beige",$product_color) == true) selected @endif>Beige</option>
                                                    <option value="Red" name="color" @if(isset($product_color) && in_array("Red",$product_color) == true) selected @endif>Red</option>
                                                    <option value="Pink" name="color" @if(isset($product_color) && in_array("Pink",$product_color) == true) selected @endif>Pink</option>
                                                    <option value="Orange" name="color" @if(isset($product_color) && in_array("Orange",$product_color) == true) selected @endif>Orange</option>
                                                    <option value="Yellow" name="color" @if(isset($product_color) && in_array("Yellow",$product_color) == true) selected @endif>Yellow</option>
                                                    <option value="Off White" name="color" @if(isset($product_color) && in_array("Off White",$product_color) == true) selected @endif>Off White</option>
                                                    <option value="Green" name="color" @if(isset($product_color) && in_array("Green",$product_color) == true) selected @endif>Green</option>
                                                    <option value="Turquoise" name="color" @if(isset($product_color) && in_array("Turquoise",$product_color) == true) selected @endif>Turquoise</option>
                                                    <option value="Blue" name="color" @if(isset($product_color) && in_array("Blue",$product_color) == true) selected @endif>Blue</option>
                                                    <option value="Purple" name="color" @if(isset($product_color) && in_array("Purple",$product_color) == true) selected @endif>Purple</option>
                                                    <option value="Gold" name="color" @if(isset($product_color) && in_array("Gold",$product_color) == true) selected @endif>Gold</option>
                                                    <option value="Silver" name="color" @if(isset($product_color) && in_array("Silver",$product_color) == true) selected @endif>Silver</option>
                                                    <option value="Transparent" name="color" @if(isset($product_color) && in_array("Transparent",$product_color) == true) selected @endif>Transparent</option>
                                                 </select>
                                                {{--<input type="button" id="btnSelected" value="Get Selected" />--}}
                                                @if ($errors->has('color'))
                                                <span class="help-block">
                                                    <strong class="text-danger">{{ $errors->first('color') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label class="col-md-6 control-label">Price</label>
                                        <div class="col-md-6">     
                                            <input name="price" type="text" min="1" class="form-control" id="price" value="{{$product_description->price}}">
                                            @if ($errors->has('price'))
                                            <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('price') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="col-md-6 control-label">Quantity</label>
                                        <div class="col-md-6">     
                                            <input name="quantity" type="text" min="1" class="form-control" id="quantity" value="{{$product_description->quantity}}">
                                            @if ($errors->has('quantity'))
                                            <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('quantity') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-6 control-label">Is Featured?</label>
                                        <div class="col-md-6">     
                                            <label class="radio-inline"><input type="radio" name="is_featured" value="1" @if ($product_description->is_featured === "1") checked @endif >Yes</label> 
                                            <label class="radio-inline"><input type="radio" name="is_featured" value="0" @if ($product_description->is_featured === "0") checked @endif >No</label>
                                            @if ($errors->has('is_featured')) <span class="help-block"> <strong class="text-danger">{{ $errors->first('is_featured') }}</strong> </span> @endif 
                                        </div>

                                    </div> 
                                    <div class="form-group ">
                                        <label class="col-md-6 control-label">Status?</label>
                                        <div class="col-md-6">     
                                            <label class="radio-inline"><input type="radio" name="status" value="1" @if ($product_description->status === "1") checked @endif >Enable</label> 
                                            <label class="radio-inline"><input type="radio" name="status" value="0" @if ($product_description->status === "0") checked @endif >Disable</label>
                                            @if ($errors->has('status')) <span class="help-block"> <strong class="text-danger">{{ $errors->first('status') }}</strong> </span> @endif 
                                        </div>

                                    </div> 
                                    
                                    <div class="form-group ">
                                        <label class="col-md-6 control-label">Availability</label>
                                        <div class="col-md-6">     
                                            <label class="radio-inline"><input type="radio" name="is_available" value="1" @if ($product_description->availability === "1") checked @endif >Out Of Stock</label> 
                                            <label class="radio-inline"><input type="radio" name="is_available" value="0" @if ($product_description->availability === "0") checked @endif >In Stock</label>
                                            @if ($errors->has('is_available')) <span class="help-block"> <strong class="text-danger">{{ $errors->first('is_available') }}</strong> </span> @endif 
                                        </div>

                                    </div> 
                                    
                                    <div class="form-group ">
                                        <label class="col-md-6 control-label">Pre-Order</label>
                                        <div class="col-md-6">     
                                            <label class="radio-inline"><input type="radio" name="pre_order" onchange="addLaunchedDate(this)" value="1" @if ($product_description->pre_order === "1") checked @endif >Yes</label> 
                                            <label class="radio-inline"><input type="radio" name="pre_order" onchange="addLaunchedDate(this)"  value="0" @if ($product_description->pre_order === "0") checked @endif >No</label>
                                            @if ($errors->has('pre_order')) <span class="help-block"> <strong class="text-danger">{{ $errors->first('pre_order') }}</strong> </span> @endif 
                                        </div>

                                    </div> 
                                    <div id="add_date" hidden="" class="form-group @if ($errors->has('launched_date')) has-error @endif">
                                        <label class="col-md-6 control-label">Product Launched Date</label>
                                        {{--<div class="col-md-6"> --}}
                                            {{--<input name="launched_date" type="text" hidden="" class="form-control" id="launched_date" value="{{$product_description->launched_date}}">--}}
                                                {{--@if ($errors->has('launched_date'))--}}

                                            {{--<span class="help-block">--}}
                                                {{--<strong class="text-danger">{{ $errors->first('launched_date') }}</strong>--}}
                                            {{--</span>--}}
                                            {{--@endif--}}
                                        {{--</div>--}}
                                        <div class='input-group date' id='datepicker1'>
                                            <input type='text' id='launched_date'  hidden="" name="launched_date" class="form-control" value="{{$product_description->launched_date}}" />
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
                                            <select class="form-control" id="occasion" name="occasion" onclick="setOccasion(this.value)">
                                                <option value="">Select Occasion</option>
                                                
                                                  @if(count($occasion)>0)
                                                  @foreach($occasion as $key=>$o)
                                                 
                                                <option value="{{$o->id}}" @if(isset($product_occasion->occasion_id) && $product_occasion->occasion_id==$o->id) selected="selected"  @endif>{{$o->name}}</option>
                                                @endforeach
                                                @else
                                                <option value="">Select Occasion</option>
                                                
                                                @endif
                                            </select>
                                            <input type="hidden" name="occasion_id" id="occasion_id">
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="col-md-6 control-label">Hide Product</label>
                                        <div class="col-md-6">  
                                            <select class="form-control" id="hide_product" name="hide_product">
                                                <option value="3" @if(isset($product_description->hide_product) && $product_description->hide_product==3) selected="selected" @endif>Select User Type</option>
                                                <option value="0" @if(isset($product_description->hide_product) && $product_description->hide_product==0) selected="selected" @endif >Hide from Customer</option>
                                                <option value="1" @if(isset($product_description->hide_product) && $product_description->hide_product==1) selected="selected" @endif>Hide from Business</option>
                                                <option value="2" @if(isset($product_description->hide_product) && $product_description->hide_product==2) selected="selected" @endif>Hide from Both</option>
                                            </select>     
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="col-md-6 control-label">Hide Product Price</label>
                                        <div class="col-md-6">  
                                            <select class="form-control" id="hide_product_price" name="hide_product_price">
                                                <option value="3" @if(isset($product_description->hide_product) && $product_description->hide_product==3) selected="selected" @endif>Select User Type</option>
                                                <option value="0" @if(isset($product_description->hide_product_price) && $product_description->hide_product_price==0) selected="selected" @endif >Hide from Customer</option>
                                                <option value="1" @if(isset($product_description->hide_product_price) && $product_description->hide_product_price==1) selected="selected" @endif>Hide from Business</option>
                                                <option value="2" @if(isset($product_description->hide_product_price) && $product_description->hide_product_price==2) selected="selected" @endif>Hide from Both</option>
                                            </select>   
                                        </div>
                                    </div>
                                    
                                    <div class="form-group @if ($errors->has('style')) has-error @endif">
                                        <label class="col-md-6 control-label">Style</label>
                                        <div class="col-md-6">  
                                            <select class="form-control" id="occasion" name="style" id="style" onclick="setStyle(this.value)">
                                                <option>Select Style</option>
                                                @foreach($style as $s)
                                                <option value="{{$s->id}}" @if(isset($product_style->style_id) && $product_style->style_id==$s->id) selected="selected" @endif >{{$s->name}}</option>
                                                @endforeach
                                            </select>
                                            <input type="hidden" name="style_id" id="style_id">
                                        </div>
                                    </div>
                                    
                                    <div class="form-group @if ($errors->has('collection_style')) has-error @endif">
                                        <label class="col-md-6 control-label">Collection Style</label>
                                        <div class="col-md-6">  
                                            <select class="form-control" id="occasion" name="collection_style" id="collection_style" onclick="setCollectionStyle(this.value)">
                                                @if(count($collection_style)>0)
                                                <option>Select Collection Style</option>
                                                @foreach($collection_style as $c)
                                                <option value="{{$c->id}}" @if(isset($product_collection_style->collection_style_id) && $product_collection_style->collection_style_id==$c->id) selected="selected" @endif>{{$c->name}}</option>
                                                @endforeach
                                                @else
                                                   <option value="">Select Collection Style</option>
                                                @endif
                                            </select>
                                            <input type="hidden" name="collection_id" id="collection_id">
                                        </div>
                                    </div>

                                    {{--<div class="form-group @if ($errors->has('short_description')) has-error @endif">--}}
                                        {{--<label class="col-md-6 control-label">Short Description</label>--}}
                                        {{--<div class="col-md-6">     --}}
                                            {{--<input name="short_description" type="text" class="form-control" id="short_description" value="{{$product_description->short_description}}">--}}
                                            {{--@if ($errors->has('short_description'))--}}
                                            {{--<span class="help-block">--}}
                                                {{--<strong class="text-danger">{{ $errors->first('short_description') }}</strong>--}}
                                            {{--</span>--}}
                                            {{--@endif--}}
                                        {{--</div>--}}
                                    {{--</div>--}}

                                    <div class="form-group @if ($errors->has('description')) has-error @endif">
                                        <label class="col-md-6 control-label">Description</label>
                                        <div class="col-md-6">     
                                            <textarea name="description" type="text" class="form-control" id="description">{{$product_description->description}}</textarea>
                                            @if ($errors->has('description'))
                                            <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('description') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12">   
                                            <button type="submit" id="submit" class="btn btn-primary  pull-right" onclick="appendErrorMsgProduct()">Update</button>
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
        if(file_ext=='jpg'||file_ext=='JPG'||file_ext=='jpeg'||file_ext=='JPEG'||file_ext=='png'||file_ext=='PNG'|| file_ext=='GIF'||file_ext=='gif')
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
            if(file_ext=='mp4' || file_ext=='mp3' || file_ext=='m4v' || file_ext=='mpg' || file_ext=='avi' || file_ext=='fly'|| file_ext=='wmv' || file_ext=='webm' || file_ext=='ogg')
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
    function setCategory(cat)
    {
        $('#category_id').val(cat);
    }
    
    function setOccasion(occ)
    {
        $('#occasion_id').val(cat);
    }
    
    function setStyle(style)
    {
        $('#style_id').val(style);
    }
    function setCollectionStyle(cstyle)
    {
        $('#collection_id').val(cstyle);
    }

    
    
    function addLaunchedDate(status) {

        if ($(status).val() == '1') {
            $("#add_date").show();
//            $("#percentage_txt").val('');
//            $("#percentage").hide();
        }
        else if ($(status).val() == '0') {
            {
                $("#add_date").hide();
            }
        }
        else{
            $("#add_date").hide();
        }
    }

    jQuery(document).ready(function() {
  $("select .flexselect").flexselect();
});
$(function () {
            $('#color').multiselect({
                includeSelectAllOption: true
            });
                $('#rivaah').multiselect({
                    includeSelectAllOption: true
            });

            // $('#btnSelected').click(function () {
            //     var selected = $("#color option:selected");
            //     var message = "";
            //     selected.each(function () {
            //         message += $(this).text() + " " + $(this).val() + "\n";
            //     });
            //     alert(message);
            // });
        });
</script>
<script type="text/javascript" src="{{url('/')}}/public/media/backend/js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript" src="{{url('/')}}/public/media/backend/js/flexselect.js"></script>
<script type="text/javascript" src="{{url('/')}}/public/media/backend/js/liquidmetal.js"></script>
<script type="text/javascript" src="{{url('/')}}/public/media/backend/js/color-product.js"></script>


@endsection