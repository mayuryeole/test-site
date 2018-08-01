@extends(config("piplmodules.back-view-layout-location"))

@section("meta")

<title>Manage Gallery Images</title>

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
                <a href="{{url('admin/gallery-list')}}">Manage Gallery</a>
                <i class="fa fa-circle"></i>

            </li>
            <li>
                <a href="javascript:void(0);">Manage Gallery Images</a>

            </li>
        </ul>



        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-gift"></i> Manage Gallery Images
                </div>

            </div>
                        
            <div class="portlet-body form">
                <form  id="manage-img-form" class="form-horizontal" onsubmit="return frmSub()" role="form" action="" method="post" enctype="multipart/form-data" >

                    {!! csrf_field() !!}
                    <div class="form-body my_form">
                        <div class="row">
                            <div class="col-md-12">    
                                <div class="col-md-8"> 
                                    <div>
                                        <div class="form-group">
                                         
                                                <input type='hidden' name='gallery_id' id='gallery_id' value="{{ $gallery_id }}">
                                           
                                        </div>
                                        <div>
                                        </div>
                                        <div class="form-group @if ($errors->has('images')) has-error @endif">
                                            <label for="images" >Upload Images
                                                <sup>*</sup>
                                            </label>
                                            
                                            <input id="input-img" class="form-control" name="images[]" multiple  type="file" value="{{old('images')}}"  accept="image/*" />
                                           
                                            <span style="color: black; font-weight:bolder;" class="btn-vdo-mar" id="fileLen"></span>
                                            @if ($errors->has('images'))
                                            <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('images') }}</strong>
                                            </span>
                                            @endif
                                        </div>


                                        <div class="form-group">
                                            <div class="col-md-12">   
                                                <button type="submit" id="submit" class="btn btn-primary  pull-right">Upload</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>                                
                            </div>
                        </div>
                        <div class="my_image_blk">
                            <div class="row">
                                @if(count($all_media) > 0)
                                <div class="col-sm-12">

                                    <ul class="h_my_img_listing clearfix">
                                        @foreach($all_media as $media)
                                        <li>
                                            <div id="hide_img_{{ $media->id  }}">
                                                <div class="h_my_img_holder">

                                                    <img src="{{ url('storage/app/public/gallery/images/thumbnails/')}}/{{ $media->path }}">                                        
                                                    <span class="h_close_btn"><img src="{{asset('/')}}public/media/backend/images/remove-icon-small.png"  onclick="deleteImages({{ $media->id  }})"></span> 
                                                </div>
                                            </div>

                                        </li>  
                                        @endforeach
                                    </ul>
                                    {!! $all_media->render() !!}

                                </div>
                                @endif
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
    <script type="text/javascript">
        var gbl_count = 0;
        
        function frmSub(){
            if(gbl_count==0){
                alert("You Must Select Atleast "+ 1+" file to Upload");
                return false;
            }
            return true;
        }
    </script>
    <script>
        $(function(){

            $("#input-img").change(function(e){
                $("#fileLen").show();
                var files= e.target.files;
                gbl_count = e.target.files.length;

                if(gbl_count == 0){
                    alert('Make sure you select image file upto 5mb.');
                    return false;
                }

                for(var i =0; i<gbl_count; i++){
                        var f = files[i];
                       // alert(24);
                        var file_ext = f.name.split('.').pop();
                        if(file_ext=='jpg'||file_ext=='jpeg'||file_ext=='png'||file_ext=='gif')
                        {

                            if(f.size > 5000000){
                                gbl_count=0;
                                alert('Please upload image upto 5mb size');
                                //e.target.files = null;
                                var el = document.getElementById("manage-img-form");
                                el.reset();
                                return false;
                            }
                        }
                        else{

                            alert('Please upload valid photos. eg : jpg | jpeg | png | gif');
                            return false;
                        }
                    }


            });

        });

</script>

    <script>
                function setParentCategory($parent)
                {
                $('#parent_id').val($parent);
                }
    </script>
    <script>
        function deleteImages(id)
        {
        if (confirm("Do you really want to delete this image?"))
        {
        hide_img = "#hide_img_" + id;
                $.ajax({
                url:"{{url('/admin/gallery/deletedImages/delete-image')}}/" + id,
                        method:'get',
                        dataType:'json',
                        success:function(data)
                        {
                        if (data.success == 1)
                        {
                        $(hide_img).hide();
                        window.location.href =window.location.href
                        } else{
                        alert(data.msg);

                        }
                        }

                });
        } else{
        return false;
        }
        }
    </script>
@endsection