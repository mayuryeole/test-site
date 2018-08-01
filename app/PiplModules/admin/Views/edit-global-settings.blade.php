@extends(config("piplmodules.back-view-layout-location"))

@section("meta")

    <title>Update Global setting Info</title>

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
                    <a href="{{url('admin/global-settings')}}">Manage Global settings </a>
                    <i class="fa fa-circle"></i>

                </li>
                <li>
                    <a href="javascript:void(0);">Update Global setting value</a>

                </li>
            </ul>
            <!-- BEGIN SAMPLE FORM PORTLET-->
            <div class="portlet box blue">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-gift"></i> Update Global setting parameter value
                    </div>

                </div>
                <div class="portlet-body form">
                    <form id="update-global-settings-form" role="form" class="form-horizontal"
                          action="{{url('/admin/update-global-setting/'.$setting->id)}}" method="post"
                          enctype="multipart/form-data">
                        {!! csrf_field() !!}
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-8">
                                        <div class="form-group {{ $errors->has('value') ? ' has-error' : '' }}">
                                            <label class="col-md-6 control-label"
                                                   for="{{$setting->slug}}"> {{$setting->name}}<sup>*</sup></label>

                                            <div class="col-md-6">
                                                @if(in_array("image",explode("|",$setting->validate)))
                                                    <input name="value" type="file" class="form-control"
                                                           id="{{$setting->slug}}">
                                                @elseif ($setting->id=='20')
                                                    <select class='form-control' name='value' id='value'>
                                                        <option value='Y-m-d H:m:s'>Y-m-d H:m:s</option>
                                                        <option value='Y/m/d H:m:s'>Y-m-d H:m:s</option>
                                                        <option value='d-m-Y H:m:s'>d-m-Y H:m:s</option>
                                                        <option value='d/m/Y H:m:s'>d/m/Y H:m:s</option>
                                                        <option value='m/d/Y H:m:s'>m/d/Y H:m:s</option>
                                                        <option value='m-d-Y H:m:s'>m-d-Y H:m:s</option>
                                                        <option value='Y-m-d'>Y-m-d</option>
                                                        <option value='Y/m/d'>Y/m/d</option>
                                                        <option value='d-m-Y'>d-m-Y</option>
                                                        <option value='d/m/Y'>d/m/Y</option>
                                                        <option value='m/d/Y'>m/d/Y</option>
                                                        <option value='m-d-Y'>m-d-Y</option>
                                                    </select>
                                                @elseif($setting->id=='18' && (in_array("mimes",explode("|",$setting->validate))))

                                                    <select class="form-control" name="banner_type" id="banner_type"
                                                            onclick="selectBanner(this.value)">
                                                        <option value="">Select Banner</option>
                                                        <option value="1"
                                                                @if($setting->banner_status=="1") selected="selected" @endif>
                                                            Banner Video
                                                        </option>
                                                        <option value="2"
                                                                @if($setting->banner_status=="2") selected="selected" @endif>
                                                            Banner Image
                                                        </option>
                                                    </select>
                                                    <br>
                                                    <input title="select image of jpg,jpeg,png or gif"
                                                           name="banner_image" type="file" class="form-control"
                                                           id="{{$setting->slug}}" style="display: none">
                                                        @if ($errors->has('banner_image'))
                                                            <span class="help-block">
                                                                    <strong>{{ $errors->first('banner_image') }}</strong>
                                                            </span>
                                                        @endif
                                                    <input title="select video of mp4" name="banner_video" type="file"
                                                           class="form-control" id="{{$setting->slug}}"
                                                           style="display: none">
                                                       @if ($errors->has('banner_video'))
                                                            <span class="help-block">
                                                            <strong>{{ $errors->first('banner_video') }}</strong>
                                                            </span>
                                                       @endif
                                                @else
                                                    <input name="value" type="text" class="form-control"
                                                           id="{{$setting->slug}}"
                                                           value="{{old('value',$setting->value)}}">
                                                @endif
                                                @if ($errors->has('value'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('value') }}</strong>
                                                    </span>
                                                @endif
                                            </div>

                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <button type="submit" id="submit" class="btn btn-primary  pull-right">
                                                    Update
                                                </button>
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
        function selectBanner(value) {
           var html =  $("label[class='text-danger']").hide();
//        alert(value);
            if (value == "1") {
                $("input[name='banner_video']").show();
                $("input[name='banner_image']").hide();

            }
            else if (value == 2) {
                $("input[name='banner_image']").show();
                $("input[name='banner_video']").hide();
            }
            else {
                $("input[name='banner_image']").hide();
                $("input[name='banner_video']").hide();
            }
        }
    </script>
    <script type="text/javascript">
        $("input[name='banner_image']").on("change", function (e) {

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
                        $("#imagePreview").show();
                        $("#imagePreview").attr("src", e.target.result);


                    });
                    fileReader.readAsDataURL(f);
                }
            } else {
                $("input[name='banner_image']").val('');
                alert('Please choose valid image extension. eg : jpg | jpeg | png |gif');
                return false;
            }

        });

    </script>
    <script>
        $("input[name='banner_video']").change(function (e) {

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
                    $("input[name='banner_video']").val('');
                    alert('Please choose valid videos. eg : mp4 | mp3 | m4v | mpg |avi | fly | wmv | webm | ogg');
                    return false;
                }
            }
        });
    </script>
@endsection