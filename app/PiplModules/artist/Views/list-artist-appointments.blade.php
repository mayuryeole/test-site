@extends(config("piplmodules.back-view-layout-location"))

@section("meta")

    <title>Manage Artist Appointments</title>

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
                    <a href="javascript:void(0)">Artist Appointments</a>

                </li>
            </ul>
            @if (session('update-user-status'))
                <div class="alert alert-success">
                    {{ session('update-user-status') }}
                    <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                </div>
            @endif

            @if (session('delete-user-status'))
                <div class="alert alert-success">
                    {{ session('delete-user-status') }}
                    <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                </div>

            @endif
            <div class="row">
                <div class="col-md-12">
                    <!-- BEGIN EXAMPLE TABLE PORTLET-->
                    <div class="portlet box grey-cascade">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-list"></i>Manage Artist Appointments
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
                                @if(Auth::user()->hasPermission('create.box')==true || Auth::user()->isSuperadmin())

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="btn-group">
                                                <a href="{{url('/admin/box/create')}}" id="sample_editable_1_new" class="btn green">
                                                    Add New <i class="fa fa-plus"></i>
                                                </a>
                                            </div>
                                        </div>

                                    </div>
                                @endif
                            </div>
                            <table class="table table-striped table-bordered table-hover" id="list_artist_app">
                                <thead>
                                <tr>
                                    <th>
                                        <div class="cust-chqs">  <p><input type="checkbox" id="select_all_delete" ><label for="select_all_delete"></label>  </p></div>
                                    </th>
                                    <th>Customer Name</th>
                                    <th>Artist Name</th>
                                    <th>View</th>
                                    <th>Delete</th>
                                </tr>
                                </thead>
                            </table>
                            <input type="button" onclick='javascript:deleteAll("{{url('/admin/delete-selected-artist-appointment')}}")' name="delete" id="delete" value="Delete Selected" class="btn btn-danger">
                        </div>
                    </div>



                    <!-- END PAGE CONTENT INNER -->
                </div>
            </div>
            <!-- END CONTENT -->
        </div>
        <style>
            .ribbon-image {
                border: 1px solid #cccccc;
                border-radius: 50%;
                height: 60px;
                width: 60px;
            }
        </style>
        <script>
            $(function() {
                $('#list_artist_app').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {"url":'{{url("/admin/list-artist-appointment-data")}}', "complete":afterRequestComplete},
                    columnDefs: [{
                        "defaultContent": "-",
                        "targets": "_all"
                    }],
                    columns: [
                        {data:   "id",
                            render: function (data, type, row) {

                                if (type === 'display') {

                                    return '<div class="cust-chqs">  <p> <input class="checkboxes" type="checkbox"  id="delete' + row.id + '" name="delete' + row.id + '" value="' + row.id + '"><label for="delete' + row.id + '"></label> </p></div>';
                                }
                                return data;
                            },
                            "orderable": false
                        },
                        { data: "customer_name", name: "customer_name", orderable: true},
                        { data: "artist_name", name: "artist_name", orderable: true},
                        {data:   "Update",
                            render: function (data, type, row) {

                                if (type === 'display') {

                                    return '<a  class="btn btn-sm btn-primary" href="{{url("/admin/artist-appointment/view")}}/' + row.id + '">Update</a>';
                                }
                                return data;
                            },
                            "orderable": false,
                            name: 'Update'

                        },
                        {data:   "Delete",
                            render: function (data, type, row) {

                                if (type === 'display') {

                                    return '<form id="category_delete_' + row.id + '"  method="post" action="{{url("/admin/delete-artist-appointment")}}/' + row.id + '">{{ method_field("DELETE") }} {!! csrf_field() !!}<button onclick="confirmDelete(' + row.id + ');" class="btn btn-sm btn-danger" type="button">Delete</button></form>';
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
                if (confirm("Do you really want to delete this box?"))
                {
                    $("#category_delete_" + id).submit();
                }
                return false;
            }
        </script>
@endsection
