@extends(config("piplmodules.back-view-layout-location"))

@section("meta")

<title>Manage Orders</title>

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
                <a href="javascript:void(0)">Manage Orders</a>
            </li>
        </ul>
        @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
            <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
        </div>
        @endif
       
        <?php
        $curr_user_type="0";
        $curr_user_type=Request::segment(3);
        ?>
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet box grey-cascade">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-list"></i>Manage Orders
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
                            @if(Auth::user()->isSuperadmin())
                            <div class="row">
                                
                                <div class="col-md-6">
                                    <select name="order" id="order" onchange="selectOrder(this.value)">
                                        
                                        <!--<option value="0">Select Order Status</option>-->
                                        <option value="1" @if($curr_user_type=='1') selected @endif>New Order</option>
                                        <option value="2"  @if($curr_user_type=='2') selected @endif>Processed Order</option>
                                        <option value="3" @if($curr_user_type=='3') selected @endif>Returned Order</option>
                                        <option value="4" @if($curr_user_type=='4') selected @endif>Cancelled Order</option>
                                        <option value="5" @if($curr_user_type=='5') selected @endif>Refund Order</option>
                                        <option value="6" @if($curr_user_type=='6') selected @endif>Completed Order</option>
                                        
                                        
                                    </select>
                                    <div class="btn-group">
                                        
                                    </div>
                                </div>

                            </div>
                            @endif
                        </div>
                        <table class="table table-striped table-bordered table-hover" id="list_products">
                            <thead>
                                <tr>
                            <th>Order Id</th>
<!--                            <th>Product Name</th>
                            <th>Product Quantity</th>
                            <th>Product Price</th>-->
                            <th>Customer/Business User</th>
                            <th>Shipping Address 1</th>
                            <th>Shipping Address 2</th>
                            <th>Shipping State</th>
                            <th>Shipping City</th>
                            <th>Order Status</th>
                            <th>Payment Status</th>
                            <th>Order Discount</th>
                            <th>Action</th>
                            
                            
                            
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
            $(function() {
                 @if((Request::segment(3)) != NULL)
                            pass_register_value = "{{url('/admin/orders-data')}}" + "/" + "{{ Request::segment(3) }}";
                            @else
                            pass_register_value = "{{url('/admin/orders-data')}}" + "/" + "' '";
                            @endif
            $('#list_products').DataTable({
            processing: true,
                    serverSide: true,
                    //bStateSave: true,
//                    ordering:false,
            ajax: {"url":pass_register_value, "complete":afterRequestComplete},
                    columnDefs: [{
                    "defaultContent": "-",
                            "targets": "_all",
                    }],
                    columns: [
                    { data: 'order_id', name: 'order_id'},
//                    { data: 'product_name', name: 'product_name'},
//                    { data: 'product_quantity', name: 'product_quantity' },
//                    { data: 'product_price', name: 'product_price' },
                    { data: 'first_name', name: 'first_name' },
                    { data: 'shipping_address1', name: 'shipping_address1' },
                    { data: 'shipping_address2', name: 'shipping_address2' },
                    { data: 'shipping_state', name: 'shipping_state' },
                    { data: 'shipping_city', name: 'shipping_city' },
                    {data:   "order_status",
                            render: function (data, type, row) {

                            if (type === 'display') {
                            $str="";
                                    $str='<select name="order_status" id="order_status" onchange="changeOrderStatus(this.value,'+row.id+');">';
                                    
                                    $str+='<option value="0">New Order</option>';
                                    $str+='<option value="1">Processed Order</option>';
                                    $str+='<option value="2">Returned Order</option>';
                                    $str+='<option value="3">Cancelled Order</option>';
                                    $str+='<option value="4">Refund Order</option>';
                                    $str+='<option value="5">Completed Order</option></select>';
                                    
                                    return $str;
                            }       
                                return data;
                            },
                           // "orderable": false,
                            name: 'order_status'

                    },
                    { data: 'payment_status',
                        render: function (data, type, row) {

                            if (type === 'display') {
                            $str="";
                                    $str='<select name="payment_status" id="payment_status" onchange="changePaymentStatus(this.value,'+row.id+');">';
                                    $str+='<option value="0">Unpaid</option>';
                                    $str+='<option value="1">Paid</option></select>';
                                    
                                    return $str;
                            }       
                                return data;
                            },
                            "orderable": false,
                    
                        name: 'payment_status' },
                    { data: 'order_discount', name: 'order_discount' },
                    {data:   "View",
                            render: function (data, type, row) {

                            if (type === 'display') {
                            $str="";
                                    $str='<a  class="btn btn-sm btn-info" href="{{url("/show/order-product")}}/' + row.id + '">View Order Details</a>';
                                    
                                    return $str;
                            }       
                                return data;
                            },
                            "orderable": false,
                            name: 'View'

                    },
                    
                    ]
            });
            
            
            });
</script>
<meta name="csrf-token" content="{{ csrf_token() }}" />

<script type="text/javascript">
    function changeOrderStatus(value,order_id){
           //alert(value); return;
 var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
            url: '{{url("/change-order-status")}}',
            type: 'POST',
            data: {_token: CSRF_TOKEN,value:value,order_id:order_id},
            dataType: 'JSON',
            success: function (response) {
              if(response.success==1)
              {
                  //console.log(response.msg);return;
//                 $("#loading").removeClass("loding-img");
//                $('#loading').html("").hide();
                alert(response.msg);return;
               // window.location.reload();
               // $('#subcategory').html(data);
              }
              else{
                  alert(response.msg);return;
              }
            }
        });
            
        }
        
        
        function changePaymentStatus(value,order_id){
            //            alert(value);
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
            url: '{{url("/change-payment-status")}}',
            type: 'POST',
            data: {_token: CSRF_TOKEN,value:value,order_id:order_id},
            dataType: 'json',
            success: function (response) {
              if(response.success==1)
              {
                  alert(response.msg);
//                 $("#loading").removeClass("loding-img");
//                $('#loading').html("").hide();
//                   alert()
                //console.log(response.msg); return;
               // window.location.href = window.location.href ;
               // $('#subcategory').html(data);
              }
              else{
                  alert(response.msg);
                  // console.log(response.msg); return;
                  //console.log(response.msg); return;
              }
            }
        });
            
        }
        function selectOrder(value){
            if(value==""){
                window.location.href = "{{ url('/admin/orders')}}/''";
            }
            if(value=="1"){
                window.location.href = "{{ url('/admin/orders')}}/1";
            }
            if(value=="2"){
                window.location.href = "{{ url('/admin/orders')}}/2";
            }
            if(value=="3"){
                window.location.href = "{{ url('/admin/orders')}}/3";
            }
            if(value=="4"){
                window.location.href = "{{ url('/admin/orders')}}/4";
            }
            if(value=="5"){
                window.location.href = "{{ url('/admin/orders')}}/5";
            }
            if(value=="6"){
                window.location.href = "{{ url('/admin/orders')}}/6";
            }
        }
    </script>
@endsection
