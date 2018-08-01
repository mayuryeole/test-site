@extends(config("piplmodules.back-view-layout-location"))

@section("meta")

<title>Manage Coupons/Promo Codes</title>

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
                Manage Coupons/Promo Codes

            </li>
        </ul>
        {{--@if (session('status'))--}}
        {{--<div class="alert alert-success">--}}
            {{--{{ session('status') }}--}}
        {{--</div>--}}
        {{--@endif--}}
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
                <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
            </div>
        @endif
        
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
                <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
            </div>
        @endif
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet box grey-cascade">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-list"></i>Manage Coupons/Promo Codes
                        </div>
                        <div class="tools">
                            <a class="collapse" href="javascript:void(0);" data-original-title="" title="">
                            </a>
                            <a class="config" data-toggle="modal" href="#portlet-config" data-original-title="" title="">
                            </a>
                            <a class="reload" href="javascript:void(0);" data-original-title="" title="">
                            </a>
                            <a class="remove" href="javascript:void(0);" data-original-title="" title="">
                            </a>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="table-toolbar">
                            @if(Auth::user()->hasPermission('create.coupon')==true || Auth::user()->isSuperadmin())
                           
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="btn-group">
                                        <a href="{{url('/admin/coupon/create')}}" id="sample_editable_1_new" class="btn green">
                                            Add New <i class="fa fa-plus"></i>
                                        </a>
                                    </div>
                                </div>

                            </div>
                            @endif
                        </div>
                        <table class="table table-striped table-bordered table-hover" id="list_categories">
                            <thead>
                                <tr>
                                    <th>
                            <div class="cust-chqs">  <p><input type="checkbox" id="select_all_delete" ><label for="select_all_delete"></label>  </p></div>
                            </th>
                            <th>Name</th>
                            <th>Code</th>
                            <th>Type</th>
                            <th>Applicable For </th>
                            <th>Amount</th>
                            <th>Percentage</th>
                            <th>Valid From</th>
                            <th>Valid To</th>
                            <th>Status</th>
                            <th>Quantity</th>
                            <th>Update</th>
                            <th>Delete</th>
                            </tr>
                            </thead>
                        </table>
                        <input type="button" onclick='javascript:deleteAll("{{url('/admin/coupon-delete-selected')}}")' name="delete" id="delete" value="Delete Selected" class="btn btn-danger">
                    </div>
                </div>



                <!-- END PAGE CONTENT INNER -->
            </div>
        </div>
        <!-- END CONTENT -->
    </div>
    <style>
        .coupon-image {
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
                        ajax: {"url":'{{url("/admin/coupons-list-data")}}', "complete":afterRequestComplete},
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
                        { data: 'name', name: 'name'},
                        { data: 'coupon_code', name: 'coupon_code'},
                        { data: 'code_type', name: 'code_type'},
                        { data: 'user_type', name: 'user_type'},
                        { data: 'amount', name: 'amount'},
                        { data: 'percentage', name: 'percentage'},
                        { data: 'coupon_valid_from', name: 'coupon_valid_from'},
                        { data: 'coupon_valid_to', name: 'coupon_valid_to'},
                        { data: 'status', name: 'status'}, { data: 'quantity', name: 'quantity'},
                        {data:   "Action",
                                render: function (data, type, row) {
                                if (type === 'display') {
                                    var uType ='';
                                    if(row.user_type == 'Customer User'){
                                        uType = '3';
                                    }
                                    else if(row.user_type == 'Business User'){
                                        uType = '4';
                                    }
                                    str="";
                                    str ='<a class="btn btn-sm btn-primary" href="{{url("/admin/update-coupon")}}/' + row.id + '">Update</a>';
                                    str += '<a  style="margin-top:10px;padding-left:17px;padding-right:17px" class="btn btn-sm btn-danger" href="{{url("/admin/manage-coupon-users")}}/' + row.id + '/' + uType + '">Send</a>';
                                    return str;
                                }
                                return data;
                                },
                                "orderable": false,
                                name: 'Action'

                        },
                        {data:   "Delete",
                                render: function (data, type, row) {

                                if (type === 'display') {

                                return '<form id="category_delete_' + row.id + '"  method="post" action="{{url("/admin/coupon")}}/' + row.id + '">{{ method_field("DELETE") }} {!! csrf_field() !!}<button onclick="confirmDelete(' + row.id + ');" class="btn btn-sm btn-danger" type="button">Delete</button></form>';
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
