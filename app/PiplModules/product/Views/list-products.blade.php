@extends(config("piplmodules.back-view-layout-location"))

@section("meta")

<title>Manage Products</title>

@endsection
@php
    $stockCnt ="";
    $catCnt = "";

        $getUrl = Request::fullUrl();
        $getQueryParams = explode('?',$getUrl);
        $seperateQueryParams = explode('&',$getQueryParams[1]);
        $seperateQueryParamCatValues=explode('=',$seperateQueryParams[0]);
        $seperateQueryParamStockValues=explode('=',$seperateQueryParams[1]);
        if($seperateQueryParamCatValues[0] == 'category'){
           $catCnt = $seperateQueryParamCatValues[1];
        }
        if($seperateQueryParamStockValues[0] == 'stock'){
           $stockCnt =$seperateQueryParamStockValues[1];
        }
    $categoryCnt = intval($catCnt);
@endphp
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
                <a href="javascript:void(0)">Manage Products</a>
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
                            <i class="fa fa-list"></i>Manage Products
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
                            <!--Auth::user()->hasPermission('create.categories')==true ||--> 
                            @if(Auth::user()->isSuperadmin())
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="btn-group">
                                        <a href="{{url('/admin/product/create')}}" id="sample_editable_1_new" class="btn green">
                                            Add New <i class="fa fa-plus"></i>
                                        </a>
                                    </div>
                                    <div class="btn-group">
                                        <select class="target" name="available" id="available" onchange="selectStock(this.value);">
                                            <option value="">Select Status</option>
                                            <option value="0" @if(isset($stockCnt) && $stockCnt =='0') selected="selected"@endif>In Stock</option>
                                            <option value="1" @if(isset($stockCnt) && $stockCnt =='1') selected="selected"@endif>Out Of Stock</option>
                                        </select>
                                    </div>
                                    <div class="btn-group">
                                        
                                        <select name="cat" id="cat" onchange="selectCategory(this.value);">
                                           @if(isset($category) && count($category)>0)
                                           <option value="" selected="selected">Select Category</option>
                                           @foreach($category as $c)
                                            <option value="{{$c->category_id}}" @if(isset($categoryCnt) && $categoryCnt == $c->category_id) selected="selected" @endif>{{$c->name}}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                            </div>
                            @endif
                        </div>
                        <table class="table table-striped table-bordered table-hover" id="list_products">
                            <thead>
                                <tr>
                                    <th>
                            <div class="cust-chqs">  <p><input type="checkbox" id="select_all_delete" ><label for="select_all_delete"></label>  </p></div>
                            </th>
                            <th>Id</th>
                            <th>SKU No.</th>
                            <th>Name</th>
                            <th>Category Name</th>
                            <th>Product Availability</th>
                            <th>Manage Product Images</th>
                            <th>Action</th>

                            <th>Update</th>
                            <th>Delete</th>
                            </tr>
                            </thead>
                        </table>
                        <input type="button" onclick='javascript:deleteAll("{{url('/admin/product-delete-selected')}}")' name="delete" id="delete" value="Delete Selected" class="btn btn-danger">  
                    </div>
                </div>
                <!-- END PAGE CONTENT INNER -->
            </div>
        </div>
        <!-- END CONTENT -->
    </div>
</div>
<script>
    var fullUrl = '{{ $full }}';
</script>    
<script>
function selectStock(choice)
{
    var cat =$('#cat').val();
   // alert(cat);return;
    window.location.href = "{{ url('/admin/products-list') }}?stock=" + choice + "&category=" + cat;
}
function selectCategory(choice)
{
    var stock =$('#available').val();
    window.location.href = "{{ url('/admin/products-list') }}?stock=" + stock + "&category=" + choice;
  // window.location.href = "{{ url('/admin/products-list') }}?category=" + choice;
}
</script>    
<script>

    $(function() {



    $('#list_products').DataTable({
    processing: true,
//                    serverSide: true,
            //bStateSave: true,
//                    ordering:false,
            ajax: {"url":fullUrl, "complete":afterRequestComplete},
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
                    "orderable": false,
            },
            { data: 'id', name: 'id'},
            { data: 'sku', name: 'sku'},
            { data: 'name', name: 'name'},
            { data: 'category_name', name: 'category_name', orderable:true },
            { data: 'availability', name: 'availability', orderable:true },
            {data:   "Manage Product Images",
                    render: function (data, type, row) {

                    if (type === 'display') {

                    return '<a  class="btn btn-sm btn-info" href="{{url("/admin/manage-product-image")}}/' + row.id + '">Manage Product Images</a>';
                    }
                    return data;
                    },
                    "orderable": false,
                    name: 'Manage Product Images'

            },
            {data:   "Action",
                    render: function (data, type, row) {

                    if (type === 'display') {
                    str = "";
                            str = '<a  class="btn btn-sm btn-primary" href="{{url("/admin/manage-product-attributes")}}/' + row.id + '">Manage Product Attributes</a>';
                            str += '<br><br><a  class="btn btn-sm btn-warning" href="{{url("/admin/manage-discounts")}}/' + row.id + '">Manage Discounts</a>';
                            return str;
                    }
                    return data;
                    },
                    "orderable": false,
                    name: 'Action'

            },
            {data:   "Update",
                    render: function (data, type, row) {

                    if (type === 'display') {

                    return '<a  class="btn btn-sm btn-primary" href="{{url("/admin/product/update")}}/' + row.id + '">Update</a>';
                    }
                    return data;
                    },
                    "orderable": false,
                    name: 'Update'

            },
            {data:   "Delete",
                    render: function (data, type, row) {

                    if (type === 'display') {

                    return '<form id="product_delete_' + row.id + '"  method="post" action="{{url("/admin/product/delete/")}}/' + row.id + '">{{ method_field("DELETE") }} {!! csrf_field() !!}<button onclick="confirmDelete(' + row.id + ');" class="btn btn-sm btn-danger" type="button">Delete</button></form>';
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
            if (confirm("Do you really want to delete this product?"))
            {
            $("#product_delete_" + id).submit();
            }
            return false;
            }

</script>
@endsection
