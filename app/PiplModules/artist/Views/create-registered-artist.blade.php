@extends(config("piplmodules.back-view-layout-location"))

@section("meta")

    <title>Create artist</title>

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
                    <a href="javascript:void(0)">Create artist</a>

                </li>
            </ul>

            <div class="portlet box blue">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-gift"></i> Create artist
                    </div>

                </div>
                <div class="portlet-body form">
                    <form id="create-artist" name="create-artist" role="form" class="form-horizontal"
                          enctype="multipart/form-data" onsubmit="return chkServies()" method="post">

                        {!! csrf_field() !!}
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-8">
                                        <div class="form-group {{ $errors->has('first_name') ? ' has-error' : '' }}">
                                            <label class="col-md-4 control-label">First Name:<sup>*</sup></label>

                                            <div class="col-md-8">
                                                <input name="first_name" type="text" class="form-control"
                                                       id="first_name" value="{{old('first_name')}}">
                                                @if ($errors->has('first_name'))
                                                    <span class="help-block">
                                                <strong>{{ $errors->first('first_name') }}</strong>
                                            </span>
                                                @endif
                                            </div>

                                        </div>

                                        <div class="form-group {{ $errors->has('last_name') ? ' has-error' : '' }}">
                                            <label class="col-md-4 control-label">Last Name:<sup>*</sup></label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" id="last_name" name="last_name"
                                                       value="{{old('last_name')}}">

                                                @if ($errors->has('last_name'))
                                                    <span class="help-block">
                                                <strong>{{ $errors->first('last_name') }}</strong>
                                            </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group {{ $errors->has('description') ? ' has-error' : '' }}">
                                            <label class="col-md-4 control-label">Description:<sup>*</sup></label>
                                            <div class="col-md-8">
                                                <textarea type="text" class="form-control" id="description"
                                                          name="description" value="{{old('description')}}"></textarea>
                                                @if ($errors->has('description'))
                                                    <span class="help-block">
                                                <strong>{{ $errors->first('description') }}</strong>
                                            </span>
                                                @endif
                                            </div>
                                        </div>


                                        <div class="form-group {{ $errors->has('artist_email') ? ' has-error' : '' }}">
                                            <label class="col-md-4 control-label">Email Id:<sup>*</sup></label>
                                            <div class="col-md-8">
                                                <input type="email" class="form-control" id="artist_email"
                                                       name="artist_email" value="{{old('artist_email')}}">

                                                @if ($errors->has('artist_email'))
                                                    <span class="help-block">
                                                <strong>{{ $errors->first('artist_email') }}</strong>
                                            </span>
                                                @endif
                                            </div>
                                        </div>


                                        <div class="form-group {{ $errors->has('number') ? ' has-error' : '' }}">
                                            <label class="col-md-4 control-label">Mobile Number:<sup>*</sup></label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" id="number" name="number"
                                                       value="{{old('number')}}">

                                                @if ($errors->has('number'))
                                                    <span class="help-block">
                                                <strong>{{ $errors->first('number') }}</strong>
                                            </span>
                                                @endif
                                            </div>
                                        </div>


                                        <div class="form-group {{ $errors->has('youtube_link') ? ' has-error' : '' }}">
                                            <label class="col-md-4 control-label">Youtube Link:<sup>*</sup></label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" id="youtube_link"
                                                       name="youtube_link" value="{{old('youtube_link')}}">
                                                @if ($errors->has('youtube_link'))
                                                    <span class="help-block">
                                                <strong>{{ $errors->first('youtube_link') }}</strong>
                                            </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group {{ $errors->has('facebook_id') ? ' has-error' : '' }}">
                                            <label class="col-md-4 control-label">Facebook Id:<sup>*</sup></label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" id="facebook_id"
                                                       name="facebook_id" value="{{old('facebook_id')}}">
                                                @if ($errors->has('facebook_id'))
                                                    <span class="help-block">
                                                <strong>{{ $errors->first('facebook_id') }}</strong>
                                            </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group {{ $errors->has('instagram_id') ? ' has-error' : '' }}">
                                            <label class="col-md-4 control-label">Instagram Id:<sup>*</sup></label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" id="instagram_id"
                                                       name="instagram_id" value="{{old('instagram_id')}}">
                                                @if ($errors->has('instagram_id'))
                                                    <span class="help-block">
                                                <strong>{{ $errors->first('instagram_id') }}</strong>
                                            </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group {{ $errors->has('linkedin_id') ? ' has-error' : '' }}">
                                            <label class="col-md-4 control-label">Linked In Id:<sup>*</sup></label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" id="linkedin_id"
                                                       name="linkedin_id" value="{{old('linkedin_id')}}">
                                                @if ($errors->has('linkedin_id'))
                                                    <span class="help-block">
                                                <strong>{{ $errors->first('linkedin_id') }}</strong>
                                            </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group {{ $errors->has('twitter_id') ? ' has-error' : '' }}">
                                            <label class="col-md-4 control-label">Twitter Id:<sup>*</sup></label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" id="twitter_id"
                                                       name="twitter_id" value="{{old('twitter_id')}}">
                                                @if ($errors->has('twitter_id'))
                                                    <span class="help-block">
                                                <strong>{{ $errors->first('twitter_id') }}</strong>
                                            </span>
                                                @endif
                                            </div>
                                        </div>


                                        <div class="form-group {{ $errors->has('services') ? ' has-error' : '' }}">
                                            <label class="col-md-4 control-label">Service Prices:<sup>*</sup></label>
                                            <div class="col-md-8 harsh-manage-label-block">
                                                <div class="row">
                                                <?php
                                                $services = array("Photographers", "Videography", "Bridal Styling & Makeup", "Bridal Styling & Hair", "Beautician", "Tent & Decorators", "Florists", "Caterers", "Music & Choreographers", "Bridal & Groom Wear", "Wedding Band", "Boutique Services", "Cakes", "Mehandi artist", "DJ", "Priest Services", "Invitations & Print Services", "Event Management Company", "Wedding Accommodations", "Honeymoon Planners", "Fashion Accessories", "Transportation Vehicles", "Travel Agency");
                                                foreach ($services as $key => $val) {
                                                ?>
                                                <div class="col-md-6">
                                                    <label><?php echo $val ?></label>
                                                    <input class="fonrm-control ip-services-cls" type="text"
                                                           name="entered_<?php echo $val ?>">
                                                    <input type="hidden" name="services[]" value="<?php echo $val; ?>">
                                                </div>

                                                <?php
                                                }
                                                ?>
                                                <div id="div-err-services" style="display: none; width:400px"
                                                     class="help-block col-md-12">
                                                    <p style="font-size: 14px" class="text-danger"
                                                       id="err-services"></p>
                                                </div>
                                                @if ($errors->has('services'))
                                                    <span class="help-block">
                                                <strong id="err-services">{{ $errors->first('services') }}</strong>
                                            </span>
                                                @endif
                                            </div>
                                        </div>
                                        </div>


                                        <div class="form-group {{ $errors->has('profile_image') ? ' has-error' : '' }}">
                                            <label class="col-md-4 control-label">Profile Image:<sup>*</sup></label>
                                            <div class="col-md-8">
                                                <input id="artist-prof-img" type="file" class="form-control ip-img-cls"
                                                       name="profile_image" value="{{old('profile_image')}}">
                                                <img style="display: none;width: 50px;height: 50px"
                                                     id="artist-prof-img-view"/>
                                                @if ($errors->has('profile_image'))
                                                    <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('profile_image') }}</strong>
                                            </span>
                                                @endif

                                            </div>

                                        </div>

                                        <div class="form-group {{ $errors->has('country_flag') ? ' has-error' : '' }}">
                                            <label class="col-md-4 control-label">Country Flag:<sup>*</sup></label>
                                            <div class="col-md-8">
                                                <input type="file" class="form-control ip-img-cls"
                                                       id="artist-country-flag" name="country_flag"
                                                       value="{{old('country_flag')}}">
                                                <img style="display: none;width: 50px;height: 50px"
                                                     id="artist-country-flag-view"/>
                                                @if ($errors->has('country_flag'))
                                                    <span class="help-block">
                                                <strong>{{ $errors->first('country_flag') }}</strong>
                                            </span>
                                                @endif
                                            </div>
                                        </div>


                                        <div class="form-group {{ $errors->has('images') ? ' has-error' : '' }}">
                                            <label class="col-md-4 control-label">Multiple Images:<sup>*</sup></label>
                                            <div class="col-md-8">
                                                <input type="file" class="form-control" name="images[]" multiple>
                                                @if ($errors->has('images'))
                                                    <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('images') }}</strong>
                                            </span>
                                                @endif

                                            </div>

                                        </div>

                                        <div class="form-group @if ($errors->has('video')) has-error @endif">
                                            <label class="col-md-4 control-label">Video<sup>*</sup></label>
                                            <div class="col-md-8">
                                                <input name="video" type="file" class="form-control" id="video"
                                                       value="{{old('video')}}">
                                                <span style="color: white;font-weight:bolder;display: none"
                                                      class="btn-vdo-mar" id="fileLen"></span>
                                                @if ($errors->has('video'))
                                                    <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('video') }}</strong>
                                            </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-4"></div>
                                            <div class="col-md-8">
                                                <button type="submit" id="submit" class="btn btn-primary">Create artist</button>
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
    <script type="text/javascript">
        $(".ip-img-cls").on("change", function (e) {
            var elId = $(this).attr('id');
            // console.log(elId);
            var flag = '0';
            var fileName = e.target.files[0].name;
            var arr_file = new Array();
            arr_file = fileName.split('.');
            var file_ext = arr_file[1];
            if (file_ext == 'jpg' || file_ext == 'JPG' || file_ext == 'jpeg' || file_ext == 'JPEG' || file_ext == 'png' || file_ext == 'PNG' || file_ext == 'mpeg' || file_ext == 'MPEG' || file_ext == 'img' || file_ext == 'IMG' || file_ext == 'bpg' || file_ext == 'GIF' || file_ext == 'gif') {

                var files = e.target.files,

                    filesLength = files.length;
                for (var i = 0; i < filesLength; i++) {
                    var f = files[i];
                    var fileReader = new FileReader();
                    fileReader.onload = (function (e) {
                        var file = e.target;
                        $("#" + elId + "-view").show();
                        $("#" + elId + "-view").attr("src", e.target.result);


                    });
                    fileReader.readAsDataURL(f);
                }
            } else {
                $("#" + elId).val('');
                alert('Please choose valid image extension. eg : jpg | jpeg | png |gif');
                return false;
            }

        });

    </script>
    <script>
        $("#product_clip").change(function (e) {

            $("#fileLen").show();
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
                    $("#product_clip").val('');
                    alert('Please upload valid videos. eg : mp4 | mp3 | m4v | mpg |avi | fly | wmv | webm | ogg');
                    return false;
                }
            }
        });


    </script>
    <script>
        function chkServies() {

            var atLeastOneFilled = false;
            $(".ip-services-cls").each(function (index, field) {

                if ($(field).val() !== '')
                    atLeastOneFilled = true;
            });
            if (atLeastOneFilled == false) {
                $('#div-err-services').show();
                $('#err-services').html("Please enter atleast one services price value");
            }
            else {
                $('#div-err-services').hide();
            }
            return atLeastOneFilled;
        }


    </script>

@endsection