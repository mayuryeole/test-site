@extends(config("piplmodules.back-view-layout-location"))

@section("meta")

<title>Manage Product As Gifts</title>

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
                <a href="javascript:void(0)">Manage Product As Gifts</a>

            </li>
        </ul>
        @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
        @endif
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet box grey-cascade">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-list"></i>Manage Product As Gifts
                        </div>
                        <div class="tools">
                            <a class="collapse" href="javascript:;" data-original-title="" title="">
                            </a>
                            <a class="config" data-toggle="modal" href="#portlet-config" data-original-title="" title="">
                            </a>
                            <a class="reload" href="javascript:;" data-original-title="" title="">
                            </a>
                            <a class="remove" href="javascript:;" data-original-title="" title="">
                            </a>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="table-toolbar">
                            <div class="row">
                                <div class="col-md-6">
                                </div>

                            </div>
                        </div>
                        <table class="table table-striped table-bordered table-hover" id="list_categories">
                            <thead>
                                <tr>
                                    <th>
                            <div class="cust-chqs">  <p><input type="checkbox" id="select_all_delete" ><label for="select_all_delete"></label>  </p></div>
                            </th>
                            <th>Receiver Name</th>
                            <th>Sender Name</th>
                            <th>Receiver Number</th>
                            <th>Surprise Status</th>
                            <th>Gift Text</th>
                            <th>Gift Video</th>
                            <th>Gift Audio</th>
                            <th>Delete</th>
                            </tr>
                            </thead>
                        </table>
                        <input type="button" onclick='javascript:deleteAll("{{url('/admin/gift-delete-selected')}}")' name="delete" id="delete" value="Delete Selected" class="btn btn-danger">
                    </div>
                </div>



                <!-- END PAGE CONTENT INNER -->
            </div>
        </div>
        <!-- END CONTENT -->
    </div>
    <style>
        .gift-image {
            border: 1px solid #cccccc;
            border-radius: 50%;
            height: 60px;
            width: 60px;
        }
    </style>
    <script>
                $(function() {
                $('#list_categories').DataTable({
                processing: true,
                        serverSide: true,
                        ajax: {"url":'{{url("/admin/gifts-list-data")}}', "complete":afterRequestComplete},
                        columnDefs: [{
                        "defaultContent": "-",
                                "targets": "_all"
                        }],
                        columns: [
                        {data:   "id",
                                render: function (data, type, row) {

                                if (type === 'display') {

                                return '<div class="cust-chqs">  <p> <input class="checkboxes" type="checkbox"  id="delete' + row.order_number + '" name="delete' + row.order_number + '" value="' + row.order_number + '"><label for="delete' + row.order_number + '"></label> </p></div>';
                                }
                                return data;
                                },
                                "orderable": false,
                        },
                        { data: 'receiver_name', name: 'receiver_name'},
                        { data: 'sender_name', name: 'sender_name'},
                        { data: 'receiver_mobile_number', name: 'receiver_mobile_number'},
                        { data: 'surprise_status', name: 'surprise_status'},
                        { data: 'gift_text', name: 'gift_text'},
                        { data: 'gift_video', name: 'gift_video'},
                        { data: 'gift_audio', name: 'gift_audio'},
                        {data:   "Delete",
                                render: function (data, type, row) {

                                if (type === 'display') {

                                return '<form id="category_delete_' + row.order_number + '"  method="post" action="{{url("/admin/gift")}}/' + row.order_number + '">{{ method_field("DELETE") }} {!! csrf_field() !!}<button onclick="confirmDelete(' + row.order_number + ');" class="btn btn-sm btn-danger" type="button">Delete</button></form>';
                                }
                                return data;
                                },
                                "orderable": false,
                                name: 'Delete'

                        }


                        ]
                });
                });
                function confirmDelete(id)
                {
                if (confirm("Do you really want to delete this category?"))
                {
                $("#category_delete_" + id).submit();
                }
                return false;
                }
    </script>
    @endsection
