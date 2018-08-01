@extends(config("piplmodules.back-view-layout-location"))

@section("meta")

<title>Manage Product Attributes</title>

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
                <a href="{{url('/admin/products-list/?stock=&category=')}}">Manage Products</a>
                   <i class="fa fa-circle"></i>
           
            </li>
            <li>
                <a href="javascript:void(0)">Manage Product Attributes</a>
            </li>
        </ul>
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
                            <i class="fa fa-list"></i>Manage Product Attributes
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
                            <!--Auth::user()->hasPermission('create.categories')==true ||--> 
<!--                            @if(Auth::user()->isSuperadmin())
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="btn-group">
                                        <a href="{{url('/admin/product/create')}}" id="sample_editable_1_new" class="btn green">
                                            Add New <i class="fa fa-plus"></i>
                                        </a>
                                    </div>
                                </div>

                            </div>
                            @endif-->
                        </div>
                        <input type="hidden" name="product_id" value="{{$product_id}}">
                        <table class="table table-striped table-bordered table-hover" id="list_products">
                            <thead>
                                <tr>
<!--                                    <th>
                            <div class="cust-chqs">  <p><input type="checkbox" id="select_all_delete" ><label for="select_all_delete"></label>  </p></div>
                            </th>-->
                            <th>Id</th>
                            <th>Attribute Name</th>
                            <th>Update Attribute Values</th>
                            <!--<th>Delete</th>-->
                            </tr>
                            </thead>

                        </table>
                        <!--<input type="button" onclick='javascript:deleteAll("{{url('/admin/delete-product-selected-attributes-value')}}")' name="delete" id="delete" value="Delete Selected" class="btn btn-danger">-->  
                    </div>
                </div>
                <!-- END PAGE CONTENT INNER -->
            </div>
        </div>
        <!-- END CONTENT -->
    </div>
</div>
<script>
            $(function() {
            $('#list_products').DataTable({
            processing: true,
//                    serverSide: true,
                    ordering:false,
                    //bStateSave: true,
                    ajax: {"url":'{{url("/admin/manage-product/attributes-data")}}/{{$product_id}}', "complete":afterRequestComplete},
                    columnDefs: [{
                    "defaultContent": "-",
                            "targets": "_all",
                    }],
                    columns: [
//                    {data:   "id",
//                            render: function (data, type, row) {
//
//                            if (type === 'display') {
//
//                            return '<div class="cust-chqs">  <p> <input class="checkboxes" type="checkbox"  id="delete' + row.id + '" name="delete' + row.id + '" value="' + row.id + '"><label for="delete' + row.id + '"></label> </p></div>';
//                            }
//                            return data;
//                            },
//                            "orderable": false,
//                    },
                    { data: 'id', name: 'id'},
                    { data: 'name', name: 'name'},
                    
                    {data:   "Update",
                            render: function (data, type, row) {

                            if (type === 'display') {

                            return '<a  class="btn btn-sm btn-primary" href="{{url("/admin/manage-product/attributes-value")}}/'+ {{$product_id}} + '/' + row.attribute_id +'">Update</a>';
                            }
                            return data;
                            },
                            "orderable": false,
                            name: 'Update'

                    },
//                    {data:   "Delete",
//                            render: function (data, type, row) {
//
//                            if (type === 'display') {
//
//                            return '<form id="product_delete_' + row.id + '"  method="post" action="{{url("/admin/delete-product-attributes-value")}}/' + row.id + '">{{ method_field("DELETE") }} {!! csrf_field() !!}<button onclick="confirmDelete(' + row.id + ');" class="btn btn-sm btn-danger" type="button">Delete</button></form>';
//                            }
//                            return data;
//                            },
//                            "orderable": false,
//                            name: 'Delete'
//
//                    }

                    ]
            });
            });
            function confirmDelete(id)
            {
            if (confirm("Do you really want to delete this product?"))
            {
            $("#product_delete_" + id).submit();
            }
            return false;
            }
</script>
@endsection
