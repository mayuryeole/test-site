@extends(config("piplmodules.back-view-layout-location"))

@section("meta")

    <title>Manage Inventory</title>

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
                    <a href="javascript:void(0)">Manage Inventory</a>
                </li>
            </ul>
            @if (Session::get('status1'))
                <div class="alert alert-success">
                    {{ Session::get('status1') }}
                    <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                </div>
            @endif
            @if (Session::get('status2'))
                <div class="alert alert-success">
                    {{ Session::get('status2') }}
                    <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                </div>
            @endif
            @if (Session::get('status3'))
                <div class="alert alert-success">
                    {{ Session::get('status3') }}
                    <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                </div>
            @endif
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                    <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                </div>
            @endif
            <div class="row">
                <div class="col-md-12">
                    <!-- BEGIN EXAMPLE TABLE PORTLET-->
                    <div class="portlet box grey-cascade">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-list"></i>Manage Inventory
                            </div>
                            <div class="tools">
                                <a class="collapse" href="javascript:void(0);" data-original-title="" title="">
                                </a>
                                <a class="config" data-toggle="modal" href="#portlet-config" data-original-title=""
                                   title="">
                                </a>
                                <a class="reload" href="javascript:void(0);" data-original-title="" title="">
                                </a>
                                <a class="remove" href="javascript:void(0);" data-original-title="" title="">
                                </a>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="table-toolbar">
                                <!--Auth::user()->hasPermission('create.categories')==true ||-->
                                @if(Auth::user()->isSuperadmin())
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="btn-group">
                                                <a href="{{url('/admin/inventory/create-excel')}}"
                                                   id="sample_editable_1_new" class="btn green">
                                                    Export Product Data <i class="fa fa-plus"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="col-md-6">
                                            <div class="btn-group">
                                                <a href="{{url('/admin/inventory/show-product-media/')}}/{{ 0 }}"
                                                   id="see-all-images" class="btn green">
                                                    See All Images
                                                </a>
                                            </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="col-md-4">
                                                    <div class="btn-group">
                                                        <a href="{{url('/admin/inventory/show-product-media/')}}/{{ 1 }}"
                                                           id="see-all-videos" class="btn green">
                                                            See All Videos
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                                @endif
                            </div>

                            <div class="table-toolbar">
                            @if(Auth::user()->isSuperadmin())
                                    <form name="file-import" id="file-import"
                                          style="border: 4px solid #a1a1a1;margin-top: 15px;padding: 10px;"
                                          action="{{ url('/admin/inventory/import-excel') }}" class="form-horizontal"
                                          method="post" enctype="multipart/form-data">
                                        {!! csrf_field() !!}

                                        <input type="file" name="import_file"/>
                                        <br>
                                        <button class="btn btn-success green" name="submit" type="submit">Import File
                                        </button>

                                    </form>
                                    <form style="padding-top: 20px" id='frm_upload_bulk_product' enctype="multipart/form-data"
                                          action="{{ url('admin/bulk-upload/upload-product') }}" method="post"
                                          onsubmit="return formSubmit();">
                                        {!! csrf_field() !!}
                                        <div class="col-md-3">
                                            <div class="btn-group">
                                                <a href="javascript:void(0);" id="sample_editable_1_new"
                                                   class="btn green" onclick="media(0);">
                                                    Upload Images <i class="fa fa-plus"></i>
                                                </a>
                                                <input type="file" name="bulk_images[]" accept="image/*" multiple
                                                       id="bulk_images" style="display:none;">
                                                <p id='notify_images'></p>
                                            </div>

                                        </div>
                                        <div class='col-md-3'>
                                            <div class="btn-group">
                                                <a href="javascript:void(0);" id="sample_editable_1_new"
                                                   class="btn green" onclick="media(1);">
                                                    Upload Videos <i class="fa fa-plus"></i>
                                                </a>
                                                <input type="file" name="bulk_videos[]" accept="video/*"
                                                       id="bulk_videos" style="display:none;">
                                                <p id='notify_videos'></p>
                                            </div>
                                        </div>
                                        <input type='submit' name='Upload' value="Upload" id='uploadSubmit'
                                               class="btn btn-primary pull-right">
                                    </form>
                                @endif
                            </div>

                            <table class="table table-striped table-bordered table-hover" id="list_products">
                                <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Category Name</th>
                                    <th>Quantity</th>
                                    <th>Description</th>
                                    <th>Add Stock</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <!-- END PAGE CONTENT INNER -->
                </div>
            </div>
            <!-- END CONTENT -->
        </div>
    </div>
    <script>
        $(function () {
            $('#list_products').DataTable({
                processing: true,
                serverSide: true,
                //bStateSave: true,
                ajax: {"url": '{{url("/admin/inventory-list-data")}}', "complete": afterRequestComplete},
                columnDefs: [{
                    "defaultContent": "-",
                    "targets": "_all"
                }],
                columns: [

                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'category_name', name: 'category_name'},
                    {data: 'quantity', name: 'quantity'},
                    {data: 'description', name: 'description'},
                    {
                        data: "Update",
                        render: function (data, type, row) {

                            if (type === 'display') {

                                return '<a  class="btn btn-sm btn-primary" href="{{url("/admin/inventory/update")}}/' + row.id + '">Add Stock </a>';
                            }
                            return data;
                        },
                        "orderable": false,
                        name: 'Update'

                    }


                ]
            });
        });

    </script>
    <script>
        gbl_count1 = 0;
    </script>
    <script>
        function media(mediaType) {
            if (mediaType == 0) {
                $("#bulk_images").click();
            } else {
                $("#bulk_videos").click();
            }
        }

    </script>
    <script>
        $("#bulk_images").on('change', function (e) {
            var file = e.target.files.length;
            gbl_count1 = e.target.files.length;
            $("#notify_images").html(file + " Image files Selected");
            $("#uploadSubmit").removeAttr("disabled");
        });
    </script>
    <script>
        $("#bulk_videos").on('change', function (e) {
            var file = e.target.files.length;
            gbl_count1 = e.target.files.length;
            $("#notify_videos").html(file + " Video files Selected");
            $("#uploadSubmit").removeAttr("disabled");
        });
    </script>
    <script>
        $('#bulk_videos').fileValidator({
            onValidation: function (files) {
                $(this).attr('class', '');
            },
            onInvalid: function (type, file) {
                $(this).val(null);
            },
            type: 'video',
            maxSize: '25mb'
        });
    </script>
    <script>
        function formSubmit() {
            console.log(gbl_count1);
            if (gbl_count1 <= 0) {
                alert("You Must Select Atleast " + 1 + " file to Upload");
                return false;
            }
            $("#loader").show();

            return true;
        }
    </script>
    <script>
        function goToBulkMedia(id) {
            chkUrl =0;
            if(id == "see-all-videos"){
                chkUrl =1;
            }
            $.ajax({
                url: "{{  url('/admin/inventory/show-product-media') }}/"+chkUrl,
                type: "get",
                dataType: 'json',

                data: {
                    _token: $("[name=_token]").val()
                },
                success: function (response) {
                    console.log(response.msg); return;
                    // alert(response);
                    if (response.success == "1") {
                        //  console.log(123);
                        //  console.log(response.success);
                        // console(response.success);return;
                        $('#added-in-cart').show();
                        //  $('addT')
                        window.location.href = window.location.href;
                    }
                    else {
                        // console.log(111);
                        // console.log(response.msg);
                        // alert(response.msg);
                        // return;
                    }

                }
            });
        }
    </script>

@endsection
