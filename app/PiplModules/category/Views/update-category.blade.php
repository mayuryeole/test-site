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
                <a href="javascript:void(0);">Update Category</a>

            </li>
        </ul>



        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-gift"></i> Update Category
                </div>

            </div>
            <div class="portlet-body form">
                <form class="form-horizontal" role="form" action="" method="post" enctype="multipart/form-data" id="update-cat" name="update-cat" >

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
                                    {{--<div class="form-group @if ($errors->has('about_category')) has-error @endif">--}}
                                        {{--<label class="col-md-6 control-label">About Category </label>--}}
                                        {{--<div class="col-md-6">     --}}
                                            {{--<textarea class="form-control" name="about_category" >{{old('about_category',stripslashes($category->about_category))}}</textarea>--}}
                                            {{--@if ($errors->has('about_category'))--}}
                                            {{--<span class="help-block">--}}
                                                {{--<strong class="text-danger">{{ $errors->first('about_category') }}</strong>--}}
                                            {{--</span>--}}
                                            {{--@endif--}}
                                        {{--</div>--}}
                                    {{--</div>--}}

                                    <div class="form-group @if ($errors->has('image')) has-error @endif">
                                        <label class="col-md-6 control-label">Image</label>
                                        <div class="col-md-6">
                                            <button type="button" id="add_image" onclick="getClick()">Add Image</button><br><br>
                                            <input type='file' style="display:none;" id="image" name="image">
                                            <span class="remove"></span>
                                            <div class="@if(!empty($category->image)) input-group @endif" style="position:relative;"> 
                                                
                                                @if(!empty($category->image))
                                                <div class="pip">
                                                <img id="dd" src="{{asset('storage/app/public/category/thumbnails/'.$category->image)}}" style="width:300;height:200"/>
                                                <span class="remove btn btn-primary">x</span>
                                                </div>
                                                @else 
                                                <div class="pip">
                                                    <img id="dd" src="#" style="width:300px;height:200px;display: none" />
                                                <span style="display: none" class="remove btn btn-primary">x</span>
                                                </div>
                                                @endif
                                                
                                            </div>
                                            @if ($errors->has('image')) <span class="help-block"> <strong class="text-danger">{{ $errors->first('image') }}</strong> </span> @endif 
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label class="col-md-6 control-label">Select Attributes<sup>*</sup></label>
                                        <input  type="checkbox" onclick="toggle(this);" />&nbsp;Select all
                                        @if(count($all_attributes) != 0)
                                        @if ($errors->has('attribute'))
                                        <span class="help-block">
                                            <strong class="text-danger"> {{ $errors->first('attribute') }}</strong>
                                        </span>
                                        @endif

                                        @foreach($all_attributes as $key=>$value)

                                        <div class="col-md-6">
                                            <div class="checks">
                                                <input type="checkbox"  id="{{ $value->id}}" name="attribute[]" value="{{  $value->id }}"
                                                       @foreach($category_attribute as $k=>$v)
                                                       @if($v->attribute_id == $value->id)
                                                       checked
                                                       @endif
                                                       @endforeach @if(isset($arr) && count($arr)>0 && in_array($value->name,$arr)== true) disabled="disabled" @endif>    &nbsp;&nbsp;{{ $value->name }}
                                            </div>
                                        </div>
                                        @endforeach
                                        @endif
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
    $(function() {

//    $("#add_image").on("click", function() {
//         $("#image").on("click",function(){
//         alert(12);return false;    
//        // upImg(this.id);
//         });
//
//        });
//    $("#image").change(function{
//        alert(123);return;
//    });
    });
</script>
<script>
    function toggle(source) {
        var checkboxes = document.querySelectorAll('input[type="checkbox"]');
        for (var i = 0; i < checkboxes.length; i++) {
            if (checkboxes[i] != source)
                checkboxes[i].checked = source.checked;
        }
    }
    function check_box1(s)
    {
        $('input[type="checkbox"]').click(function() {

            if ($(this).prop("checked") == false) {

                $('#select_all').attr('checked', false);

            }
        });
    }

</script>
<script>
    function getClick()
    {
        $("#image").click();
    }
    
</script> 
<script>
$(document).ready(function() {
  if (window.File && window.FileList && window.FileReader) {
    $("#image").on("change", function(e) {
        
      var fileName =  e.target.files[0].name;
        // filesLength = files.length;
//       for (var i = 0; i < filesLength; i++) {
//         var f = files[i];
//         alert(f);return;
//         var fileReader = new FileReader();
//         fileReader.onload = (function(e) {
//
//           var file = e.target;
//           $(".pip").show();
//           $("#dd").show();
//           $(".remove").show();
//           $("#dd").attr("src",file.result);
//           //alert(123);
//
// });
//         fileReader.readAsDataURL(f);
//       }
        var arr_file = new Array();
        arr_file = fileName.split('.');
        var file_ext = arr_file[1];
        if(file_ext=='jpg'||file_ext=='JPG'||file_ext=='jpeg'||file_ext=='JPEG'||file_ext=='png'||file_ext=='PNG'||file_ext=='mpeg'||file_ext=='MPEG'||file_ext=='img'||file_ext=='IMG'||file_ext=='bpg' ||file_ext=='GIF'||file_ext=='gif')
        {

            var files = e.target.files,

                filesLength = files.length;
            for (var i = 0; i < filesLength; i++) {
                var f = files[i]
                var fileReader = new FileReader();
                fileReader.onload = (function(e) {
                    var file = e.target;
                        $(".pip").show();
                        $("#dd").show();
                        $(".remove").show();
                        $("#dd").attr("src",file.result);



                });
                fileReader.readAsDataURL(f);
            }
            }
         else{
            $("#image").val('');
            alert('Please choose valid image extension. eg : jpg | jpeg | png | img | bpg | mpeg |gif');
            return false;
        }
      
    });
  } else {
    alert("Your browser doesn't support to File API")
  }
}); 

 $(".remove").click(function(){
            $(this).parent(".pip").hide();
          }); 



</script>
<style>
     .pip {
        padding: 4px;
        position: relative;
        display: inline-block;
        margin: 10px 10px 0 0;
    } 
     .remove{
        content:'x';color:red;
        position:absolute;
        top:0;
        right:0;
        padding: 2px;
        cursor:pointer;
    } 
</style>
@endsection