@extends(config("piplmodules.back-view-layout-location"))

@section("meta")

<title>Update Rivaah Gallery</title>

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
                <a href="{{url('admin/rivaah-galleries-list')}}">Manage Rivaah</a>
                <i class="fa fa-circle"></i>

            </li>
            <li>
                Update Rivaah

            </li>
        </ul>


        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-gift"></i> Update Rivaah Gallery
                </div>

            </div>
            <div class="portlet-body form">
                <form class="form-horizontal" name="update_rivaah_gallery" id="update_rivaah_gallery" role="form" action="" method="post" enctype="multipart/form-data" >
                    {!! csrf_field() !!}
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-12">    
                                <div class="col-md-8">  
                                    {{--<div class="form-group">--}}
                                        {{--<label class="col-md-6 control-label">Select Category</label>--}}
                                        {{--<div class="col-md-6">  --}}
                                            {{--<select class="form-control flexselect" id="category" name="category" onclick="setCategory(this.value)">--}}
                                                {{--@foreach($all_category as $key=>$val)--}}
                                                {{--<option value="{{$val->category_id}}" @if(isset($gallery->category_id) && $gallery->category_id==$val->category_id) selected="selected" @endif>{{$val->name}}</option>--}}
                                                {{--@endforeach--}}
                                            {{--</select>--}}
                                         {{--</div>--}}
                                    {{--</div>--}}
                                    <div class="form-group">
                                    <input name="old_name" type="hidden" class="form-control" id="old_name" value="{{$gallery->name}}" />
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-6 control-label">Name</label>

                                        <div class="col-md-6">     
                                            <input name="name" type="text" class="form-control" id="name" value="{{$gallery->name}}" />
                                            @if ($errors->has('name'))

                                            <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('name') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group @if ($errors->has('description')) has-error @endif">
                                        <label class="col-md-6 control-label">Description</label>
                                        <div class="col-md-6">     
                                            <textarea cols="10" rows="15" name="description" type="text" class="form-control" id="description">{{$gallery->description}}</textarea>
                                            @if ($errors->has('description'))
                                            <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('description') }}</strong>
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
    
    
     $("#launched_date").datepicker({
        minDate: "dateToday",
        numberOfMonths: 1,
        dateFormat: 'yy-m-d',
//        onClose: function(selected) {
//            $("#discount_valid_to").datepicker("option", "minDate", selected);
//        }

    });
    
    
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
    
function addColor(val){
        alert(val);
       
        
        if($("#color1").val()!=''){
            $("#add_more").show();
            
            $("#add_more").click(function(){
                $("#color2").show();
            });
        }
       
        if($("#color2").val()!=''){
//            $("#add_more").show();
              
                
            
            $("#add_more").click(function(){
                $("#color3").show();
                $("#add_more").hide();
            });
            
        }
        
        if($("#color3").val()!=''){
//            $("#add_more").show();
            
            $("#add_more").click(function(){
                $("#color4").show();
                $("#add_more").hide();
            });
            
        }
        if($("#color4").val()!=''){
//            $("#add_more").show();
            
            $("#add_more").click(function(){
                $("#color5").show();
                
            });
            
        }
    } 
    jQuery(document).ready(function() {
        $("select .flexselect").flexselect();
});


//function removeColor(val){
//    alert(val);
//    if(val=='adding_color_1'){
//        $("#adding_color_1").remove();
//            
//                $("#color1").remove();
//                $("#color1").val()="";
//                
//    }
//       else if(val=='adding_color_2'){
//        $("#adding_color_2").remove();
//            
//                $("#color2").remove();
//                 $("#color2").val()="";
//               
//        }
//     else if(val=='adding_color_3'){
//        $("#adding_color_3").remove();
//            
//                $("#color3").remove();
//                 $("#color3").val()="";
//               
//        }
//     else if(val=='adding_color_4'){
//        $("#adding_color_4").remove();
//            
//                $("#color4").remove();
//                 $("#color4").val()="";
//               
//        }
//     else if(val=='adding_color_5'){
//        $("#adding_color_5").remove();
//            
//                $("#color5").remove();
//                 $("#color5").val()="";
//               
//    }
//
//}

$(function () {
            $('#color').multiselect({
                includeSelectAllOption: true
            });
            $('#btnSelected').click(function () {
                var selected = $("#color option:selected");
                var message = "";
                selected.each(function () {
                    message += $(this).text() + " " + $(this).val() + "\n";
                });
                alert(message);
            });
        });
</script>
<script type="text/javascript" src="{{url('/')}}/public/media/backend/js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript" src="{{url('/')}}/public/media/backend/js/flexselect.js"></script>
<script type="text/javascript" src="{{url('/')}}/public/media/backend/js/liquidmetal.js"></script>
<script type="text/javascript" src="{{url('/')}}/public/media/backend/js/color-product.js"></script>


@endsection