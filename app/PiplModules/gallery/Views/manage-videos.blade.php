@extends(config("piplmodules.back-view-layout-location"))

@section("meta")

<title>Manage Gallery Videos</title>

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
                <a href="javascript:void(0);">Manage Gallery Videos</a>

            </li>
        </ul>	

        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-gift"></i> Manage Gallery Videos
                </div>

            </div>
            <div class="portlet-body form">
                <form id="manage-vdo-form" class="form-horizontal" role="form" onsubmit="return frmSub()" action="" method="post" enctype="multipart/form-data" >

                    {!! csrf_field() !!}
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-12">    
                                <div class="col-md-8"> 
                                    <div>
                                        <div class="form-group">
                                   
                                                <input type='hidden' name='gallery_id' id='gallery_id' value="{{ $gallery_id }}">
                                   
                                        </div>
                                        <div>
                                        </div>
                                        <div class="form-group @if ($errors->has('videos')) has-error @endif">
                                            <label for="videos" >Upload Videos <sup>*</sup>
                                            </label>

                                            <input  id="input-vdo" class="form-control" name="videos[]" multiple  type="file" value="{{old('videos')}}"  accept="video/*"  />
                                            <span style="color: red; font-weight:bolder;" class="btn-vdo-mar" id="fileLen"></span>
                                            @if ($errors->has('videos'))
                                            <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('videos') }}</strong>
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
                        <div class="h_my_video_list">
                            <div class="row">
                                @if(count($all_media) > 0)
                                <div class="col-sm-12">

                                    <ul class="h_my_video_listing clearfix">
                                        @foreach($all_media as $media)
                                        <li>                                          
                                            <div id="hide_vid_{{ $media->id }}"><div class="h_video_listing_holder">
                                                <div class="h_video_blk">
                                                    <video controls>
                                                        <source src="{{ url('storage/app/public/gallery/videos')}}/{{ $media->path }}" type="video/mp4">
                                                    </video>
                                                    <span class="h_close_video"><img src="{{asset('/')}}public/media/backend/images/remove-icon-small.png"  onclick="deleteVideos({{ $media->id  }})"></span>         
                                                </div>                                
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
            if(gbl_count==0)
            {
                alert("You Must Select Atleast "+ 1+" file to Upload");
                return false;
            }
            return true;
        }
    </script>
    <script>
       $(function(){

        $("#input-vdo").change(function(e){

            $("#fileLen").show();
            var files= e.target.files;
            gbl_count = e.target.files.length;
            if(gbl_count>5){
                $("#fileLen").html("You can select Max "+ 5 +" files");
            }
            else{
                if(gbl_count == 0)
                {
                    $("#fileLen").html("Make sure you select video file upto 25mb.");
                    return false;
                }

                for(var i =0; i<gbl_count; i++){
                    var f = files[i];

                    var file_ext = f.name.split('.').pop();
                    // alert(12342);
                    if(file_ext=='mp4' || file_ext=='mp3' || file_ext=='m4v' || file_ext=='mpg' || file_ext=='avi' || file_ext=='fly' || file_ext=='wmv' || file_ext=='webm' || file_ext=='ogg'  )
                    {
                    }
                    else{

                        alert('Please upload valid videos. eg : mp4 | mp3 | m4v | mpg |avi | fly | wmv | webm | ogg');
                        return false;
                    }
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
        function deleteVideos(id)
        {
        if (confirm("Do you really want to delete this video?"))
        {
        hide_img = "#hide_vid_" + id;
                $.ajax({
                url:"{{url('/admin/gallery/deletedVideo/delete-video')}}/" + id,
                        method:'get',
                        dataType:'json',
                        success:function(data)
                        {
                        if (data.success == 1)
                        {
                        $(hide_img).hide();
                        } else{
                        alert(data.msg);
                        }
                        }

                });
        } else{
        return false;
        }
//        return false;
        }
</script>
@endsection