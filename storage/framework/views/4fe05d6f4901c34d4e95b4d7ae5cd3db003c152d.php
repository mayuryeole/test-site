<?php $__env->startSection("meta"); ?>

<title>Create Coupon</title>

<?php $__env->stopSection(); ?>
<link rel="stylesheet" href="<?php echo e(url('/')); ?>/public/media/backend/css/bootstrap-datetimepicker.min.css">

<?php $__env->startSection('content'); ?>
<link rel="stylesheet" href="<?php echo e(url('public/media/backend/css/jquery-ui.css')); ?>">
<script src="<?php echo e(url('public/media/backend/js/jquery-ui.js')); ?>"></script>
<div class="page-content-wrapper">
    <div class="page-content">
        <!-- BEGIN PAGE BREADCRUMB -->
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <a href="<?php echo e(url('admin/dashboard')); ?>">Dashboard</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="<?php echo e(url('/admin/coupons-list')); ?>">Manage Coupons/Promo Codes</a>
                <i class="fa fa-circle"></i>

            </li>
            <li>
                Create Coupon/Promo Code
            </li>
        </ul>

        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-gift"></i> Create Coupon/Promo Code
                </div>
            </div>
            <div class="portlet-body form">
                <form class="form-horizontal" name="create_coupon" id="create_coupon" role="form" action="<?php echo e(url('/admin/coupon/create' )); ?>" method="post" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>

                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-12">    
                                <div class="col-md-8">

                                    <div class="form-group">
                                        <label class="col-md-6 control-label">Name<sup>*</sup></label>

                                        <div class="col-md-6">     
                                            <input name="name" type="text" class="form-control"  id="name" value="<?php echo e(old('name')); ?>">
                                            <?php if($errors->has('name')): ?>
                                            <span class="help-block">
                                                <strong class="text-danger"><?php echo e($errors->first('name')); ?></strong>
                                            </span>
                                            <?php endif; ?>
                                        </div>

                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-6 control-label">Code<sup>*</sup></label>

                                        <div class="col-md-6">     
                                            <input name="coupon_code" type="text" class="form-control"  id="coupon_code" value="<?php echo e(old('coupon_code')); ?>">
                                            <?php if($errors->has('coupon_code')): ?>
                                            <span class="help-block">
                                                <strong class="text-danger"><?php echo e($errors->first('coupon_code')); ?></strong>
                                            </span>
                                            <?php endif; ?>
                                        </div>

                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-6 control-label">Select<sup>*</sup></label>

                                        <div class="col-md-6 cust-radio">
                                            <ul style="list-style-type: none;">
                                                <li>
                                                    <label><input name="radioChange" type="radio" class="form-control"   onchange="hideShowTextbox(this)" value="Amount">Amount</label>
                                                </li>
                                                 <li>
                                                    <label><input name="radioChange" type="radio" class="form-control"   onchange="hideShowTextbox(this)" value="Percentage">Percentage</label>
                                                </li>
                                            
                                            </ul>

                                            <?php if($errors->has('amount')): ?>
                                                <span class="help-block">
                                                <strong class="text-danger"><?php echo e($errors->first('amount')); ?></strong>
                                            </span>
                                            <?php endif; ?>
                                            <?php if($errors->has('Percentage')): ?>
                                                <span class="help-block">
                                                <strong class="text-danger"><?php echo e($errors->first('Percentage')); ?></strong>
                                            </span>
                                            <?php endif; ?>


                                        </div>
                                    </div>
                                    <div class="form-group" id="percentage" style="display: none;">
                                        <label class="col-md-6 control-label">Percentage<sup>*</sup></label>
                                        <div class="col-md-6">   
                                            <div class="percent-icon">
                                            <input name="percentage" id="percentage_txt" type="text" class="form-control" value="<?php echo e(old('percentage')); ?>">
                                            </div>
                                            <?php if($errors->has('order_quantity')): ?>
                                            <span class="help-block">
                                                <strong class="text-danger"><?php echo e($errors->first('order_quantity')); ?></strong>
                                            </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="form-group" id="amount" style="display: none;">
                                        <label class="col-md-6 control-label">Amount<sup>*</sup></label>

                                        <div class="col-md-6">     
                                            <input name="amount" type="text" class="form-control"  id="amount_txt" value="<?php echo e(old('amount')); ?>">
                                            <?php if($errors->has('amount')): ?>
                                            <span class="help-block">
                                                <strong class="text-danger"><?php echo e($errors->first('amount')); ?></strong>
                                            </span>
                                            <?php endif; ?>
                                        </div>

                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-6 control-label">Minimum Purchase Amount<sup>*</sup></label>

                                        <div class="col-md-6">
                                            <input name="min_purchase_amt" id="min_purchase_amt" type="text" class="form-control"  id="name" value="<?php echo e(old('min_purchase_amt')); ?>">
                                            <?php if($errors->has('min_purchase_amt')): ?>
                                                <span class="help-block">
                                                <strong class="text-danger"><?php echo e($errors->first('min_purchase_amt')); ?></strong>
                                            </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-6 control-label">Code Type<sup>*</sup></label>
                                        <div class="col-md-6">
                                            <select class="form-control" id="code_type" name="code_type">
                                                <option value="">Select Code Type</option>
                                                <option value="0">Coupon Code</option>
                                                <option value="1">Promo Code</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-6 control-label">Applicable For<sup>*</sup></label>
                                        <div class="col-md-6">
                                            <select class="form-control" id="user_type" name="user_type">
                                                <option value="">Select User Type</option>
                                                <option value="3">Customer User</option>
                                                <option value="4">Business USer</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group" id="image">
                                        <label class="col-md-6 control-label">Image<sup>*</sup></label>
                                        <div class="col-md-6">

                                                <input id="input-img" class="form-control" name="images"  type="file" value="<?php echo e(old('images')); ?>"/>
                                                <img style="display: none;width: 50px;height: 50px" id="imagePreview"/>
                                                 <?php if($errors->has('images')): ?>
                                                    <span class="help-block">
                                                        <strong class="text-danger"><?php echo e($errors->first('images')); ?></strong>
                                                    </span>
                                                 <?php endif; ?>
                                        </div>
                                    </div>   
                                    <div class="form-group">
                                        <label class="col-md-6 control-label">Quantity<sup>*</sup></label>

                                        <div class="col-md-6">     
                                            <input name="quantity" type="text" class="form-control"  id="quantity" value="<?php echo e(old('quantity')); ?>">
                                            <?php if($errors->has('quantity')): ?>
                                            <span class="help-block">
                                                <strong class="text-danger"><?php echo e($errors->first('quantity')); ?></strong>
                                            </span>
                                            <?php endif; ?>
                                        </div>

                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-6 control-label">Valid From<sup>*</sup></label>

                                        <?php /*<div class="col-md-6">     */ ?>
                                            <?php /*<input name="valid_from" type="text" class="form-control"  id="datepicker1" value="<?php echo e(old('valid_from')); ?>">*/ ?>
                                            <?php /*<?php if($errors->has('valid_from')): ?>*/ ?>
                                            <?php /*<span class="help-block">*/ ?>
                                                <?php /*<strong class="text-danger"><?php echo e($errors->first('valid_from')); ?></strong>*/ ?>
                                            <?php /*</span>*/ ?>
                                            <?php /*<?php endif; ?>*/ ?>
                                        <?php /*</div>*/ ?>
                                        <div class="col-md-6">
                                            <div class='input-group date h-manage-inp' id='datepicker1'>
                                                <input type='text' id='valid_from' name="valid_from" class="form-control" value="<?php echo e(old('valid_from')); ?>" />
                                                <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar">
                                                </span>
                                                </span>
                                                <?php if($errors->has('valid_from')): ?>
                                                    <span class="help-block">
                                                    <strong class="text-danger"><?php echo e($errors->first('valid_from')); ?></strong>
                                                    </span>
                                                <?php endif; ?>
    
                                            </div>
                                        </div>

                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-6 control-label">Valid To<sup>*</sup></label>

                                        <?php /*<div class="col-md-6">     */ ?>
                                            <?php /*<input name="valid_to" type="text" class="form-control"  id="datepicker2" value="<?php echo e(old('valid_to')); ?>">*/ ?>
                                            <?php /*<?php if($errors->has('valid_to')): ?>*/ ?>
                                            <?php /*<span class="help-block">*/ ?>
                                                <?php /*<strong class="text-danger"><?php echo e($errors->first('valid_to')); ?></strong>*/ ?>
                                            <?php /*</span>*/ ?>
                                            <?php /*<?php endif; ?>*/ ?>
                                        <?php /*</div>*/ ?>
                                        <div class="col-md-6">
                                            <div class='input-group date h-manage-inp' id='datepicker2'>
                                                <input type='text' name="valid_to" id="valid_to" class="form-control" value="<?php echo e(old('valid_to')); ?>" />
                                                <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar">
                                                </span>
                                                </span>
                                                <?php if($errors->has('valid_to')): ?>
                                                    <span class="help-block">
                                                    <strong class="text-danger"><?php echo e($errors->first('valid_to')); ?></strong>
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-6 control-label">Status<sup>*</sup></label>

                                        <div class="col-md-6">     
                                            <select name="status" id="status" class="form-control">
                                                <option value="">--select--</option>
                                                <option value="0">Inactive</option>
                                                <option value="1">Active</option>
                                            </select>
                                        </div>

                                    </div>


                                    <div class="form-group">
                                        <label class="col-md-6 control-label">Description<sup>*</sup></label>

                                        <div class="col-md-6">     
                                            <textarea rows="5" cols="36" name="description" id="description"></textarea>
                                        </div>

                                    </div>

                                    <div class="form-group">
                                        <div class="col-md-12">   
                                            <button type="submit" id="btn_submit" name="btn_submit" class="btn btn-primary  pull-right" onclick="appendErrorMsgCoupen()">Create</button>
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
<style>
    .submit-btn{
        padding: 10px 0px 0px 18px;
    }
    .error{
        color:red;
    }


</style>
<script type="text/javascript">
    $("#input-img").on("change", function(e) {

        var flag='0';
        var fileName = e.target.files[0].name;
        var arr_file = new Array();
        arr_file = fileName.split('.');
        var file_ext = arr_file[1];
if(file_ext=='jpg'||file_ext=='JPG'||file_ext=='jpeg'||file_ext=='JPEG'||file_ext=='png'||file_ext=='PNG'||file_ext=='mpeg'||file_ext=='MPEG'||file_ext=='img'||file_ext=='IMG'||file_ext=='bpg' ||file_ext=='GIF'||file_ext=='gif')
        {

            var files = e.target.files,

          filesLength = files.length;
        for (var i = 0; i < filesLength; i++) {
          var f = files[i];
          var fileReader = new FileReader();
          fileReader.onload = (function(e) {
            var file = e.target;
             $("#imagePreview").show();
            $("#imagePreview").attr("src",e.target.result );



          });
          fileReader.readAsDataURL(f);
        }
        } else{
              $("#input-img").val('');
              alert('Please choose valid image extension. eg : jpg | jpeg | png | img | bpg | mpeg |gif');
              return false;
        }

      });

</script>
<script>
    var d = new Date();
    $(function(){
        $("#datepicker1").datetimepicker({
            use24hours: true,
            format:"yyyy/mm/dd hh:ii:ss",
            startDate:d
        });

        $("#datepicker2").datetimepicker({
            use24hours: true,
            format:"yyyy/mm/dd hh:ii:ss",
            startDate:d
        });
    });


</script>
<script type="text/javascript">
  function hideShowTextbox(t) {

        if ($(t).val() == 'Amount') {
            $("#amount").show();
            $("#percentage_txt").val('');
            $("#percentage").hide();
        }
        if ($(t).val() == 'Percentage') {
            {
                $("#percentage").show();
                $("#amount_txt").val('');
                $("#amount").hide();
            }
        }
    }

</script>
<script type="text/javascript" src="<?php echo e(url('/')); ?>/public/media/backend/js/bootstrap-datetimepicker.min.js"></script>

<?php $__env->stopSection(); ?>


<?php echo $__env->make(config("piplmodules.back-view-layout-location"), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>