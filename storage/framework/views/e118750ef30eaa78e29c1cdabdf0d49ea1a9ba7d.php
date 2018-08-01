<?php $__env->startSection("meta"); ?>

<title>Manage Orders</title>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="page-content-wrapper">
    <div class="page-content">
        <!-- BEGIN PAGE BREADCRUMB -->
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <a href="<?php echo e(url('admin/dashboard')); ?>">Dashboard</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="javascript:void(0)">Manage Orders</a>
            </li>
        </ul>
        <?php if(session('status')): ?>
        <div class="alert alert-success">
            <?php echo e(session('status')); ?>

            <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
        </div>
        <?php endif; ?>
       
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
                            <?php if(Auth::user()->isSuperadmin()): ?>
                            <div class="row">
                                
                                <div class="col-md-6">
                                    <select name="order" id="order" onchange="selectOrder(this.value)">
                                        
                                        <option value="0" <?php if($curr_user_type=='1'): ?> selected <?php endif; ?>>Select Order Status</option>
                                        <option value="1" <?php if($curr_user_type=='1'): ?> selected <?php endif; ?>>New Order</option>
                                        <option value="2"  <?php if($curr_user_type=='2'): ?> selected <?php endif; ?>>Accepted Order</option>
                                        <option value="3" <?php if($curr_user_type=='3'): ?> selected <?php endif; ?>>Dispatched Order</option>
                                        <option value="4" <?php if($curr_user_type=='4'): ?> selected <?php endif; ?>>Cancelled Order</option>
                                        <option value="5" <?php if($curr_user_type=='5'): ?> selected <?php endif; ?>>Refund Order</option>
                                        <option value="6" <?php if($curr_user_type=='6'): ?> selected <?php endif; ?>>Completed Order</option>
                                    </select>
                                    <div class="btn-group">
                                        
                                    </div>
                                </div>

                            </div>
                            <?php endif; ?>
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
                 <?php if((Request::segment(3)) != NULL): ?>
                            pass_register_value = "<?php echo e(url('/admin/orders-data')); ?>" + "/" + "<?php echo e(Request::segment(3)); ?>";
                            <?php else: ?>
                            pass_register_value = "<?php echo e(url('/admin/orders-data')); ?>" + "/" + "' '";
                            <?php endif; ?>
            $('#list_products').DataTable({
            processing: true,
                    serverSide: true,
                    //bStateSave: true,
//                    ordering:false,
            ajax: {"url":pass_register_value, "complete":afterRequestComplete},
                    columnDefs: [{
                    "defaultContent": "-",
                            "targets": "_all"
                    }],
                    columns: [
                    { data: 'id', name: 'id'},
                    { data: 'first_name', name: 'first_name' },
                    { data: 'shipping_address1', name: 'shipping_address1' },
                    { data: 'shipping_state', name: 'shipping_state' },
                    { data: 'shipping_city', name: 'shipping_city' },
                    {data:   "order_status",
                            render: function (data, type, row) {

                            if (type === 'display') {
                                $status = row.order_status;
                            $str="";
                                    $str='<select name="order_status" id="order_status" onchange="changeOrderStatus(this.value,'+row.id+');">';
                                    
                                    $str+='<option value="0" <?php if($status=="1"): ?> selected <?php endif; ?>>New Order</option>';
                                    $str+='<option value="1" <?php if($status=="2"): ?> selected <?php endif; ?>>Accepted Order</option>';
                                    $str+='<option value="2" <?php if($status=="3"): ?> selected <?php endif; ?>>Dispatched Order</option>';
                                    $str+='<option value="3" <?php if($status=="4"): ?> selected <?php endif; ?>>Cancelled Order</option>';
                                    $str+='<option value="4" <?php if($status=="5"): ?> selected <?php endif; ?>>Refund Order</option>';
                                    $str+='<option value="5" <?php if($status=="6"): ?> selected <?php endif; ?>>Completed Order</option></select>';

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
                                $status = row.payment_status;
                            $str="";
                                    $str='<select name="payment_status" id="payment_status" onchange="changePaymentStatus(this.value,'+row.id+');">';
                                    $str+='<option <?php if($status=="0"): ?> selected <?php endif; ?> value="0">Unpaid</option>';
                                    $str+='<option <?php if($status=="1"): ?> selected <?php endif; ?> value="1">Paid</option></select>';

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
                                    $str='<a  class="btn btn-sm btn-info" href="<?php echo e(url("/show/order-product")); ?>/' + row.id + '">View Order Details</a>';
                                    
                                    return $str;
                            }       
                                return data;
                            },
                            "orderable": false,
                            name: 'View'

                    }
                    
                    ]
            });
            
            
            });
</script>
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>" />

<script type="text/javascript">
    function changeOrderStatus(value,order_id){
        console.log(value);

            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
            url: '<?php echo e(url("/change-order-status")); ?>',
            type: 'get',
            data: {
                _token: CSRF_TOKEN,
                value:value,
                order_id:order_id
            },
            dataType: 'JSON',
            success: function (response)
            {
              if(response.success==1)
              {
                  if(value == '2')
                  {
                      // var link = document.createElement('a');
                      // link.href = url('http://www.parasfashions.com/Online-Labels/');
                      // link.download = response.link;
                      // link.dispatchEvent(new MouseEvent('click'));
                      path  = javascript_site_path + 'order/get-order-label/' + id;
                      location.href = path;
                      // window.location.href = url(response.link);
                  }
                alert(response.msg);
                window.location.href = window.location.href;
               // window.location.reload();
               // $('#subcategory').html(data);
              }
              else{
                  alert(response.msg);
              }
            }
        });
            
        }
        
        
        function changePaymentStatus(value,order_id)
        {
            //            alert(value);
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
            url: '<?php echo e(url("/change-payment-status")); ?>',
            type: 'POST',
            data: {
                    _token: CSRF_TOKEN,
                    value:value,
                    order_id:order_id
                    },
            dataType: 'json',
            success: function (response) {
              if(response.success==1)
              {
//                 $("#loading").removeClass("loding-img");
//                $('#loading').html("").hide();
//                   alert()
                //console.log(response.msg); return;
               // $('#subcategory').html(data);
              }
              else{
                  alert(response.msg);
                  window.location.href = window.location.href;
                  // console.log(response.msg); return;
                  //console.log(response.msg); return;
              }
            }
        });

        }
        function selectOrder(value){
            if(value=="0"){
                window.location.href = "<?php echo e(url('/admin/orders')); ?>/0";
            }
            if(value=="1"){
                window.location.href = "<?php echo e(url('/admin/orders')); ?>/1";
            }
            if(value=="2"){
                window.location.href = "<?php echo e(url('/admin/orders')); ?>/2";
            }
            if(value=="3"){
                window.location.href = "<?php echo e(url('/admin/orders')); ?>/3";
            }
            if(value=="4"){
                window.location.href = "<?php echo e(url('/admin/orders')); ?>/4";
            }
            if(value=="5"){
                window.location.href = "<?php echo e(url('/admin/orders')); ?>/5";
            }
            if(value=="6"){
                window.location.href = "<?php echo e(url('/admin/orders')); ?>/6";
            }
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make(config("piplmodules.back-view-layout-location"), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>