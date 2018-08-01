@extends(config("piplmodules.back-view-layout-location"))

@section("meta")

    <title>Update artist</title>
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
                    <a href="{{url('admin/manage-artist')}}">Manage artist</a>
                    <i class="fa fa-circle"></i>

                </li>
                <li>
                    <a href="javascript:void(0);">Update artist</a>

                </li>
            </ul>


            <!-- BEGIN SAMPLE FORM PORTLET-->
            <div class="portlet box blue">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-gift"></i> Update A artist
                    </div>

                </div>
                <div class="portlet-body form">
                    <form class="form-horizontal" enctype="multipart/form-data" onsubmit="return chkServies()" role="form" action="" method="post">

                        {!! csrf_field() !!}
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-8">
                                        <div class="form-group @if ($errors->has('first_name')) has-error @endif">
                                            <label class="col-md-4 control-label">First Name:<sup>*</sup></label>

                                            <div class="col-md-8">
                                                <input name="first_name" type="text" class="form-control"
                                                       id="first_name"
                                                       value="{{old('first_name',$artist->first_name)}}">
                                                @if ($errors->has('first_name'))
                                                    <span class="help-block">
                                  <strong class="text-danger">{{ $errors->first('first_name') }}</strong>
                              </span>
                                                @endif
                                            </div>

                                        </div>

                                        <div class="form-group @if ($errors->has('last_name')) has-error @endif">
                                            <label class="col-md-4 control-label">Last Name:<sup>*</sup></label>

                                            <div class="col-md-8">
                                                <input name="last_name" type="text" class="form-control" id="last_name"
                                                       value="{{old('last_name',$artist->last_name)}}">
                                                @if ($errors->has('last_name'))
                                                    <span class="help-block">
                                                        <strong class="text-danger">{{ $errors->first('last_name') }}</strong>
                                                    </span>
                                                @endif
                                            </div>

                                        </div>

                                        <div class="form-group @if ($errors->has('email')) has-error @endif">
                                            <label class="col-md-4 control-label">Email Id:<sup>*</sup></label>

                                            <div class="col-md-8">
                                                <input name="email" type="email" class="form-control" id="email"
                                                       value="{{old('email',$artist->email)}}">
                                                @if ($errors->has('email'))
                                                    <span class="help-block">
                                                        <strong class="text-danger">{{ $errors->first('email') }}</strong>
                                                    </span>
                                                @endif
                                            </div>

                                        </div>

                                        <div class="form-group @if ($errors->has('description')) has-error @endif">
                                            <label class="col-md-4 control-label">Description:<sup>*</sup></label>
                                            <div class="col-md-8">
                                                <textarea class="form-control"
                                                          name="description">{{old('description',$artist->description)}}</textarea>
                                                @if ($errors->has('description'))
                                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('description') }}</strong>
                                    </span>
                                                @endif

                                            </div>

                                        </div>

                                        <div class="form-group @if ($errors->has('youtube_link')) has-error @endif">
                                            <label class="col-md-4 control-label">Youtube Link:<sup>*</sup></label>

                                            <div class="col-md-8">
                                                <textarea class="form-control"
                                                          name="youtube_link">{{old('youtube_link',$artist->youtube_link)}}</textarea>
                                                @if ($errors->has('youtube_link'))
                                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('youtube_link') }}</strong>
                                    </span>
                                                @endif
                                            </div>

                                        </div>
                                        <div class="form-group @if ($errors->has('facebook_id')) has-error @endif">
                                            <label class="col-md-4 control-label">Facebook Id:<sup>*</sup></label>

                                            <div class="col-md-8">
                                                <input class="form-control" name="facebook_id"
                                                       value="{{old('facebook_id',$artist->facebook_id)}}">
                                                @if ($errors->has('youtube_link'))
                                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('facebook_id') }}</strong>
                                    </span>
                                                @endif
                                            </div>

                                        </div>
                                        <div class="form-group @if ($errors->has('instagram_id')) has-error @endif">
                                            <label class="col-md-4 control-label">Instagram Id:<sup>*</sup></label>

                                            <div class="col-md-8">
                                                <input class="form-control" name="instagram_id"
                                                       value="{{old('instagram_id',$artist->instagram_id)}}">
                                                @if ($errors->has('instagram_id'))
                                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('instagram_id') }}</strong>
                                    </span>
                                                @endif
                                            </div>

                                        </div>
                                        <div class="form-group @if ($errors->has('linkedin_id')) has-error @endif">
                                            <label class="col-md-4 control-label">Linked In Id:<sup>*</sup></label>

                                            <div class="col-md-8">
                                                <input class="form-control" name="linkedin_id"
                                                       value="{{old('linkedin_id',$artist->linkedin_id)}}">
                                                @if ($errors->has('linkedin_id'))
                                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('linkedin_id') }}</strong>
                                    </span>
                                                @endif
                                            </div>

                                        </div>
                                        <div class="form-group @if ($errors->has('twitter_id')) has-error @endif">
                                            <label class="col-md-4 control-label">Twitter Id:<sup>*</sup></label>

                                            <div class="col-md-8">
                                                <input class="form-control" name="twitter_id"
                                                       value="{{old('twitter_id',$artist->twitter_id)}}">
                                                @if ($errors->has('twitter_id'))
                                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('twitter_id') }}</strong>
                                    </span>
                                                @endif
                                            </div>

                                        </div>


                                        <div class="form-group {{ $errors->has('services') ? ' has-error' : '' }}">
                                            <label class="col-md-4 control-label">Servidce Id:<sup>*</sup></label>
                                            <div class="col-md-8 harsh-manage-label-block">
                                            <div class="row">
                                                <?php
                                                $services = array("Photographers", "Videography", "Bridal Styling & Makeup", "Bridal Styling & Hair", "Beautician", "Tent & Decorators", "Florists", "Caterers", "Music & Choreographers", "Bridal & Groom Wear", "Wedding Band", "Boutique Services", "Cakes", "Mehandi artist", "DJ", "Priest Services", "Invitations & Print Services", "Event Management Company", "Wedding Accommodations", "Honeymoon Planners", "Fashion Accessories", "Transportation Vehicles", "Travel Agency");
                                                foreach ($services as $key => $val) {
                                                ?>
                                                <div class="col-md-6">
                                                    <label><?php echo $val ?></label>
                                                    <input class="form-control ip-services-cls" type="text"
                                                           name="entered_<?php echo $val ?>"
                                                           <?php  if(array_key_exists($val, $editServices)){ ?>  value="<?php  echo $editServices[$val]; ?>" <?php }?>>
                                                    <input type="hidden" name="services[]" value="<?php echo $val; ?>">
                                                </div>

                                                <?php
                                                }
                                                ?>
                                                    <span id="div-err-services" style="display: none" class="help-block">
                                                <strong class="text-danger" id="err-services">{{ $errors->first('services') }}</strong>
                                            </span>
                                                @if ($errors->has('services'))
                                                    <span class="help-block">
                                                <strong>{{ $errors->first('services') }}</strong>
                                            </span>
                                                @endif
                                            </div>
                                        </div>
                                        </div>

                                        <div class="form-group @if ($errors->has('profile_image')) has-error @endif">
                                            <label class="col-md-4 control-label">Profile Image</label>
                                            <div class="col-md-8">
                                                <input id="artist-prof-img" type="file" class="form-control ip-img-cls" name="profile_image">
                                                <img style="width: 50px;height: 50px" @if($artist->profile_image !='') src="{{ url('storage/app/public/artist').'/'.$artist->profile_image }}" @else style="display: none;" @endif id="artist-prof-img-view"/>
                                                @if ($errors->has('profile_image'))
                                                    <span class="help-block">
                                                        <strong class="text-danger">{{ $errors->first('profile_image') }}</strong>
                                                    </span>
                                                @endif
                                            </div>

                                        </div>

                                        <div class="form-group @if ($errors->has('country_flag')) has-error @endif">
                                            <label class="col-md-4 control-label">Country Flag<sup>*</sup></label>
                                            <div class="col-md-8">
                                                <input id="artist-country-flag" type="file" class="form-control ip-img-cls"  name="country_flag">
                                                <img style="width: 50px;height: 50px" @if($artist->country_flag !='') src="{{ url('storage/app/public/artist/country').'/'.$artist->country_flag }}" @else  style="display: none;" @endif id="artist-country-flag-view"/>
                                                @if ($errors->has('country_flag'))
                                                    <span class="help-block">
                                                         <strong class="text-danger">{{ $errors->first('country_flag') }}</strong>
                                                    </span>
                                                @endif
                                            </div>

                                        </div>

                                        <div class="form-group @if ($errors->has('video')) has-error @endif">
                                            <label class="col-md-4 control-label">Video<sup>*</sup></label>
                                            <div class="col-md-8">
                                                <input name="video" type="file" class="form-control" id="video"
                                                       value="{{$artist->video}}">
                                                <span style="color: white;font-weight:bolder;display: none"
                                                      class="btn-vdo-mar" id="videFileLen"></span>
                                                @if ($errors->has('video'))
                                                    <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('video') }}</strong>
                                            </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group @if ($errors->has('images')) has-error @endif">
                                            <label class="col-md-4 control-label">Multiple Images</label>
                                            <div class="col-md-8">
                                                <input id="artist-mult-imgs" type="file" class="form-control ip-img-cls" name="images[]"
                                                       multiple>
                                                @if ($errors->has('images'))
                                                    <span class="help-block">
                                                                <strong class="text-danger">{{ $errors->first('images') }}</strong>
                                                            </span>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-4"></div>
                                                <div class="col-md-8">
                                                    <button type="submit" id="submit" class="btn btn-primary" style="margin-top: 15px;">
                                                        Update
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>

                        </div>

                    </form>
                </div>
                <div class="my_image_blk">
                    <div class="row">
                        @if(count($multi) > 0)
                            <div class="col-sm-12">

                                <ul class="h_my_img_listing clearfix">
                                    @foreach($multi as $img)
                                        <li>
                                            <div id="hide_img_{{ $img->id  }}">
                                                <div class="h_my_img_holder">

                                                    <img src="{{asset('storageasset/artist/images/'.$img->path)}}">
                                                    <span class="h_close_btn"><img src="{{asset('/')}}public/media/backend/images/remove-icon-small.png"  onclick="deleteImages({{ $img->id  }})"></span>
                                                </div>
                                            </div>

                                        </li>
                                    @endforeach
                                </ul>
                                {!! $multi->render() !!}

                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
    <script>
        function deleteImages(id) {
            if (confirm("Do you really want to delete this image?")) {
                hide_img = "#hide_img_" + id;
                $.ajax({
                    url: "{{url('/admin/artist/deletedImages/delete-image')}}/" + id,
                    method: 'get',
                    dataType: 'json',
                    success: function (data) {
                        if (data.success == 1) {
                            $(hide_img).hide();
                            window.location.href = window.location.href
                        } else {
                            alert(data.msg);
                        }
                    }

                });
            } else {
                return false;
            }
//        return false;
        }
    </script>
    <script type="text/javascript">
        $(".ip-img-cls").on("change", function (e) {
            var elid = $(this).attr('id');
            // console.log(elid);return;
            var flag = '0';
            var fileName = e.target.files[0].name;
            var arr_file = new Array();
            arr_file = fileName.split('.');
            var file_ext = arr_file[1];
            if (file_ext == 'jpg' || file_ext == 'JPG' || file_ext == 'jpeg' || file_ext == 'JPEG' || file_ext == 'png' || file_ext == 'PNG' || file_ext == 'GIF' || file_ext == 'gif') {

                var files = e.target.files,

                    filesLength = files.length;
                for (var i = 0; i < filesLength; i++) {
                    var f = files[i];
                    var fileReader = new FileReader();
                    fileReader.onload = (function (e) {
                        var file = e.target;
                        $("#"+elid+"-view").show();
                        $("#"+elid+"-view").attr("src", e.target.result);


                    });
                    fileReader.readAsDataURL(f);
                }
            } else {
                $("#"+elid).val('');
                alert('Please choose valid image extension. eg : jpg | jpeg | png |gif');
                return false;
            }

        });

    </script>
    <script>
        $("#video").change(function (e) {

            $("#videFileLen").show();
            var file = e.target.files.length;
            var files = e.target.files;
            gbl_count = e.target.files.length;
            for (var i = 0; i < gbl_count; i++) {
                var f = files[i];

                var file_ext = f.name.split('.').pop();
                if (file_ext == 'mp4' || file_ext == 'mp3' || file_ext == 'm4v' || file_ext == 'mpg' || file_ext == 'avi' || file_ext == 'fly' || file_ext == 'wmv' || file_ext == 'webm' || file_ext == 'ogg') {
                    return true;
                }
                else {
                    $("#video").val('');
                    alert('Please upload valid videos. eg : mp4 | mp3 | m4v | mpg |avi | fly | wmv | webm | ogg');
                    return false;
                }
            }
        });


    </script>
    <script>
        function chkServies() {

            var atLeastOneFilled = false;
            $(".ip-services-cls").each(function(index, field) {

                if($(field).val() !== '')
                    atLeastOneFilled = true;
            });
            if(atLeastOneFilled == false){
                $('#div-err-services').show();
                $('#err-services').html("Please enter atleast one services price value");
            }
            else{
                $('#div-err-services').hide();
            }
            return atLeastOneFilled;
        }



    </script>
@endsection