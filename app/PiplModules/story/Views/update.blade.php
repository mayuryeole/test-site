@extends(config("piplmodules.back-view-layout-location"))

@section("meta")
<title>Update Story Post</title>
@endsection


@section('content')
<?php
    $postId = Illuminate\Support\Facades\Request::segment(3);
?>

<div class="page-content-wrapper">
    <div class="page-content">
        <!-- BEGIN PAGE BREADCRUMB -->
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <a href="{{url('admin/dashboard')}}">Dashboard</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="{{url('admin/story')}}">Manage Story Post</a>
                <i class="fa fa-circle"></i>

            </li>
            <li>
                <a href="javascript:void(0);">Update Story Post</a>

            </li>
        </ul>



        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-gift"></i> Update Story Post
                </div>

            </div>
            <div class="portlet-body form">
                <form class="form-horizontal" name="update_story" id="update_story" role="form" action="" method="post" enctype="multipart/form-data">

                    {!! csrf_field() !!}
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-12">    
                                <div class="col-md-8">  
                                    <div class="form-group @if ($errors->has('title')) has-error @endif">
                                        <label class="col-md-6 control-label">Title<sup>*</sup></label>

                                        <div class="col-md-6">     
                                            <input class="form-control" name="title" value="{{old('title',$post->title)}}" />
                                            @if ($errors->has('title')) 
                                            <span class="help-block"> 
                                                <strong class="text-danger">{{ $errors->first('title') }}</strong> 
                                            </span>
                                            @endif
                                        </div>

                                    </div>
                                    <div class="form-group @if ($errors->has('short_description')) has-error @endif">
                                        <label class="col-md-6 control-label">Short Description <sup>*</sup></label>
                                        @if ($errors->has('question'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('short_description') }}</strong>
                                        </span>
                                        @endif
                                        <div class="col-md-6">     
                                            <textarea class="form-control" name="short_description" >{{old('short_description',$post->short_description)}}</textarea>
                                            @if ($errors->has('short_description'))
                                            <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('short_description') }}</strong>
                                            </span>
                                            @endif
                                        </div>

                                    </div>
                                    <div class="form-group @if ($errors->has('url')) has-error @endif">
                                        <label class="col-md-6 control-label">URL<sup>*</sup></label>
                                        <div class="col-md-6">     
                                            <input class="form-control" name="url" value="{{old('url',$ori_post->story_url)}}" />
                                            @if ($errors->has('url')) 
                                            <span class="help-block"> 
                                                <strong class="text-danger">{{ $errors->first('url') }}</strong> 
                                            </span>
                                            @endif
                                        </div>

                                    </div>         


                                    <div class="form-group @if ($errors->has('photo')) has-error @endif">
                                        <label class="col-md-6 control-label">Image<sup>*</sup></label>
                                        <div class="col-md-6">
                                            <div class="@if(!empty($ori_post->story_image)) input-group @endif"> @if(!empty($ori_post->story_image))<span class="input-group-addon" id="basic-addon3"><img src="{{asset('storage/app/public/story/thumbnails/'.$ori_post->story_image)}}" height="20" style="cursor:pointer" onclick="window.open('{{asset('storage / app / public / story / '.$ori_post->story_image)}}', 'Image', 'width=200,height=200,left=(' + screen.width - 200 + '),top=(' + screen.height - 200 + ')')" /></span>@endif
                                                <input type="file" class="form-control" name="photo" />
                                                @if(!empty($ori_post->story_image))<span class="input-group-addon"><a href="javascript:void(0)" title="Remove Photo" type="button" onclick="if (confirm('Are you sure to remove photo for this post?')){window.open('{{url('admin / story - post / remove - photo / '.$ori_post->id)}}', 'removePhoto', 'width=50,height=50'); }"><i class="fa fa-remove text-danger"></i></a></span>@endif </div>
                                            @if ($errors->has('photo')) <span class="help-block"> <strong class="text-danger">{{ $errors->first('photo') }}</strong> </span> @endif </div>

                                    </div>

                                    <div class="form-group @if ($errors->has('allow_comments')) has-error @endif">
                                        <label class="col-md-6 control-label">Allow comments?<sup>*</sup></label>
                                        <div class="col-md-6">     
                                            <label class="radio-inline"><input type="radio" name="allow_comments" value="1" @if(old('allow_comments',$ori_post->allow_comments)=='1') checked="checked" @endif required>Yes</label> <label class="radio-inline"><input type="radio" name="allow_comments" value="0"  @if(old('allow_comments',$ori_post->allow_comments)=='0') checked="checked" @endif>No</label>
                                            @if ($errors->has('allow_comments')) <span class="help-block"> <strong class="text-danger">{{ $errors->first('allow_comments') }}</strong> </span> @endif 
                                        </div>

                                    </div> 
                                    <div class="form-group @if ($errors->has('allow_attachments_in_comments')) has-error @endif">
                                        <label class="col-md-6 control-label">Allow attachments in comments?</label>
                                        <div class="col-md-6">     
                                            <label class="radio-inline"><input type="radio" name="allow_attachments_in_comments" value="1" @if(old('allow_attachments_in_comments',$ori_post->allow_attachments_in_comments)=='1') checked="checked" @endif>Yes</label> <label class="radio-inline"><input type="radio" name="allow_attachments_in_comments" value="0"  @if(old('allow_attachments_in_comments',$ori_post->allow_attachments_in_comments)=='0') checked="checked" @endif>No</label>
                                            @if ($errors->has('allow_attachments_in_comments')) <span class="help-block"> <strong class="text-danger">{{ $errors->first('allow_attachments_in_comments') }}</strong> </span> @endif 
                                        </div>

                                    </div> 



                                    <div class="form-group @if ($errors->has('story_status')) has-error @endif">
                                        <label class="col-md-6 control-label">Publish Status<sup>*</sup></label>
                                        <div class="col-md-6">     
                                            <label class="radio-inline"><input type="radio" name="story_status" value="1"  @if(old('story_status',$ori_post->story_status)=='1') checked="checked" @endif>Published</label> 
                                            <label class="radio-inline"><input type="radio" name="story_status" value="0" @if(old('story_status',$ori_post->story_status)=='0') checked="checked" @endif >Not Published</label>
                                            @if ($errors->has('story_status')) <span class="help-block"> <strong class="text-danger">{{ $errors->first('story_status') }}</strong> </span> @endif 
                                        </div>

                                    </div> 




                                    <div class="form-group @if ($errors->has('attachments')) has-error @endif">
                                        <label class="col-md-6 control-label">Select Images</label>
                                        <div class="col-md-6">
                                            <input type="file" class="form-control" multiple="multiple"  accept="images/*" name="attachments[]" />
                                            @if ($errors->has('attachments')) <span class="help-block"> <strong class="text-danger">{{ $errors->first('attachments') }}</strong> </span> @endif </div>

                                        @if(count($ori_post->story_attachments))
                                        <div class="form-group">
                                            <label class="col-md-6 control-label"></label>

                                            <div class="col-md-6">
                                                <div class="panel panel-default" style='margin: 10px 0px'>
                                                    <div class="panel-heading">Images</div>
                                                    <div class="panel-body">
                                                        <ul class="list-unstyled">
                                                            @foreach($ori_post->story_attachments as $key=>$attachment)
                                                            <div class="col-md-6 col-lg-6 col-sm-6 col-xs-6">
                                                                <li><a target="_blank" href="{{asset('storage/app/public/story/attachments/'.$attachment['original_name'])}}"><i class="fa fa-download"></i> {{$attachment['display_name']}}</a> 
                                                                    @php
                                                                    $name = $attachment['original_name'];
                                                                    @endphp
                                                                    <button type="button" onclick="deleteImage('{{ $postId }}','{{ $name }}')"><i class="fa fa-remove"></i>Remove</button></li>    
                                                            </div>     


                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        @endif
                                    </div>

                                    <div class="form-group @if ($errors->has('description')) has-error @endif">
                                        <label class="col-md-6 control-label">Description<sup>*</sup></label>
                                        <div class="col-md-6">   
                                            <textarea class="form-control" name="description" id="description" maxlength="300" minlength="50">{{old('description',$post->description)}}</textarea>
                                            @if ($errors->has('description')) <span class="help-block"> <strong class="text-danger">{{ $errors->first('description') }}</strong> </span> @endif
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
                    <!--</div>-->
                </form>
            </div>
        </div>
    </div>
</div>
<!--<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">-->
<!--  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>-->
<script src="{{url('/vendor/unisharp/laravel-ckeditor/ckeditor.js')}}"></script> 
<script>
                                                                        CKEDITOR.replace('description');</script>  
<script>
    function deleteImage(post_id,key)
    {
    redirectTo = '{{ url("/") }}' + '/admin/story-post/remove-attachment/' + post_id +'/'+ key;
    window.location.href = redirectTo;
    }
</script>    
@endsection