@extends(config("piplmodules.back-view-layout-location"))

@section("meta")
    {{--{{ dd($attribute) }}--}}
    <title>Update Category Attributes</title>
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
                    <a href="{{url('admin/categories-list')}}">Manage Category</a>
                    <i class="fa fa-circle"></i>

                </li>
                <li>
                    <a href="{{url('/admin/manage-category-attributes/'.$category_id)}}">Manage Category Attributes</a>
                    <i class="fa fa-circle"></i>

                </li>
                <li>
                    <a href="javascript:void(0);">Update Category Attributes</a>

                </li>
            </ul>
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                    <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                </div>
        @endif

        <!-- BEGIN SAMPLE FORM PORTLET-->
            <div class="portlet box blue">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-gift"></i> Update Category Attributes
                    </div>

                </div>
                <div class="portlet-body form">
                    <form class="" name="update_category_attributes" id="update_category_attributes" role="form" action=""
                          method="post">

                        {!! csrf_field() !!}

                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-4">
                                        @if ($errors->has('value'))
                                            <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('value') }}</strong>
                                            </span>
                                        @endif
                                        {{--</div>--}}
                                        {{--</div>--}}
                                        @php $cnt = 0;@endphp
                                        @if(isset($attr_values) && count($attr_values)>0)
                                            @foreach($attr_values as $attr)
                                                <div style="margin-top:10px"
                                                     class="input-group control-group after-add-more">

                                                    <input id="{{ $attr->id }}" type="text" name="value[]"
                                                           class="form-control" placeholder="Enter Name Here"
                                                           @if(isset($attr->value) && $attr->value!='') value="{{ $attr->value }}" @endif>
                                                    @if($cnt >0)
                                                    <div class="input-group-btn">

                                                        <button class="btn btn-danger remove" type="button"><i
                                                                    class="glyphicon glyphicon-remove"></i> Remove
                                                        </button>

                                                    </div>
                                                    @endif
                                                    @if ($errors->has('value'))
                                                        <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('value') }}</strong>
                                            </span>
                                                    @endif
                                                </div>
                                            @php $cnt++;@endphp
                                            @endforeach
                                        @else
                                            <div style="margin-top:10px"
                                                 class="input-group control-group after-add-more">

                                                <input type="text" name="value[]" class="form-control"
                                                       placeholder="Enter Name Here">
                                                @if ($errors->has('value'))
                                                    <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('value') }}</strong>
                                            </span>
                                                @endif
                                            </div>
                                        @endif
                                            <div id="append-here">
                                            </div>
                                            <div class="input-group-btn">

                                                <button class="btn btn-success add-more" type="button"><i
                                                            class="glyphicon glyphicon-plus"></i> Add
                                                </button>

                                            </div>
                                        <input type='hidden' name='attribute_id' value="{{$attr_name->attribute_id}}">
                                        <input type='hidden' name='category_id' value="{{$category_id}}">
                                            <input type='hidden' name='category_attr_id' value="{{$attribute->id}}">

                                        <div class="form-group" style="margin-top:10px">
                                            <div class="col-md-12">
                                                <button type="submit" id="submit" class="btn btn-primary  pull-right">
                                                    Update Category Attribute Values
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
    <div style="margin-top:10px" class="input-group control-group after-add-more" id="append-id">

        <div class="form-group control-group input-group" style="margin-top:10px">

            <input type="text" name="value[]" class="form-control" placeholder="Enter Name Here">

            <div class="input-group-btn">

                <button class="btn btn-danger remove" type="button"><i class="glyphicon glyphicon-remove"></i> Remove
                </button>

            </div>

        </div>

    </div>
    <style>
        .submit-btn {
            padding: 10px 0px 0px 18px;
        }
    </style>
    <script>
        function toggle(source) {
            var checkboxes = document.querySelectorAll('input[type="checkbox"]');
            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i] != source)
                    checkboxes[i].checked = source.checked;
            }
        }

        function check_box1(s) {
            $('input[type="checkbox"]').click(function () {

                if ($(this).prop("checked") == false) {

                    $('#select_all').attr('checked', false);

                }
            });
        }

    </script>
    <script>
        function setCategory($cat) {
            $('#category_id').val($cat);
        }


    </script>
    <script type="text/javascript">


        $(document).ready(function () {

            $("#append-id").hide();
            $(".add-more").click(function () {

                // var html = $(".copy").html();
                //
                // $(".after-add-more").last().after(html);
                var html = $("#append-id").html();
                //$(".after-add-more").last().after(html);
                $("#append-here").append(html);


            });


            $("body").on("click", ".remove", function () {

                $(this).parents(".control-group").remove();

            });


        });


    </script>
@endsection