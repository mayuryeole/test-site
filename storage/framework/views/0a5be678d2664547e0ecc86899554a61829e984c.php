<?php $__env->startSection("meta"); ?>

<title>Give Discount</title>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
<link rel="stylesheet" href="<?php echo e(url('/')); ?>/public/media/backend/css/bootstrap-datetimepicker.min.css">

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<div class="page-content-wrapper">
    <div class="page-content">
        <!-- BEGIN PAGE BREADCRUMB -->
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <a href="<?php echo e(url('admin/dashboard')); ?>">Dashboard</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="<?php echo e(url('admin/products-list/?stock=&category=')); ?>">Manage Products</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="javascript:void(0);">Give Discount</a>

            </li>
        </ul>

        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-gift"></i> Give Discount
                </div>
            </div>
            <div class="portlet-body form">
                <form class="form-horizontal" name="give_discount" id="give_discount" role="form" action="" method="post" enctype="multipart/form-data" >
                    <?php echo csrf_field(); ?>

                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-12">    
                                <div class="col-md-8">  
                                    <input id="product_id" type="hidden" name="product_id" value="<?php echo e($product_id); ?>">
                                    
                                    <?php /*<div class="form-group <?php if($errors->has('discount_type')): ?> has-error <?php endif; ?>">*/ ?>
                                        <?php /*<label class="col-md-6 control-label">Discount Type<sup>*</sup></label>*/ ?>
                                        <?php /*<div class="col-md-6">*/ ?>
                                            <?php /*<select class="form-control" name="discount_type">*/ ?>
                                                <?php /*<option value="price" <?php if(isset($product->discount_type) && $product->discount_type==0): ?> selected="selected" <?php endif; ?>>Price</option>*/ ?>
                                                <?php /*<option value="percent" <?php if(isset($product->discount_type) && $product->discount_type==1): ?> selected="selected" <?php endif; ?>>Percent</option>*/ ?>

                                            <?php /*</select>*/ ?>
                                            <?php /*<?php if($errors->has('discount_type')): ?> <span class="help-block"> <strong class="text-danger"><?php echo e($errors->first('discount_type')); ?></strong> </span> <?php endif; ?>*/ ?>

                                        <?php /*</div>*/ ?>

                                    <?php /*</div>*/ ?>
                                    <?php /*<div class="form-group">*/ ?>
                                        <?php /*<label class="col-md-6 control-label">Discount Type<sup>*</sup></label>*/ ?>
                                        <?php /*<div class="col-md-6">*/ ?>
                                            <?php /*<input type="text" disabled="" id="discount_type" class="form-control" name="discount_type" value="Percentage">*/ ?>
                                        <?php /*</div>*/ ?>

                                    <?php /*</div>*/ ?>
                                    
                                    <div class="form-group" id="discount_type">
                                        <label class="col-md-6 control-label">Discount Type</label>
                                        <div class="col-md-6">
                                            <div class="percent-icon">
                                                <input disabled="" name="discount_type" id="discount_type" type="text" class="form-control" value="Percentage">
                                            </div>
                                            <?php if($errors->has('discount_type')): ?>
                                                <span class="help-block">
                                            <strong class="text-danger"><?php echo e($errors->first('discount_type')); ?></strong>
                                        </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php /**/ ?>
                                    <?php /*<div class="form-group <?php if($errors->has('discount_price')): ?> has-error <?php endif; ?>">*/ ?>
                                        <?php /*<label class="col-md-6 control-label">Discount<sup>*</sup></label>*/ ?>
                                        <?php /*<div class="col-md-6">     */ ?>
                                            <?php /*<input name="discount_price" type="text" min="1" class="form-control" id="discount_price" value="<?php if(isset($product->discount_price) && $product->discount_price!=''): ?><?php echo e($product->discount_price); ?> <?php elseif(isset($product->discount_percent) && $product->discount_percent!=''): ?> <?php echo e($product->discount_percent); ?> <?php else: ?> <?php echo e(old('discount_price')); ?> <?php endif; ?>">*/ ?>
                                            <?php /*<?php if($errors->has('discount_price')): ?>*/ ?>
                                            <?php /*<span class="help-block">*/ ?>
                                                <?php /*<strong class="text-danger"><?php echo e($errors->first('discount_price')); ?></strong>*/ ?>
                                            <?php /*</span>*/ ?>
                                            <?php /*<?php endif; ?>*/ ?>
                                        <?php /*</div>*/ ?>
                                    <?php /*</div>*/ ?>
                                    <?php /*<div class="form-group">*/ ?>
                                        <?php /*<label class="col-md-6 control-label">Discount Type<sup>*</sup></label>*/ ?>

                                        <?php /*<div class="col-md-6 cust-radio">*/ ?>
                                            <?php /*<ul style="list-style-type: none;">*/ ?>
                                                <?php /*<li>*/ ?>
                                                    <?php /*<label style="padding-right: 50px"><input name="radioChange" type="radio" class="form-control"  <?php if($product->discount_type == "0"): ?> checked <?php endif; ?> onchange="hideShowTextbox(this)" value="Amount">Amount</label>*/ ?>

                                                    <?php /*<label><input name="radioChange" type="radio" class="form-control" <?php if($product->discount_type == "1"): ?> checked <?php endif; ?>  onchange="hideShowTextbox(this)" value="Percentage">Percentage</label>*/ ?>
                                                <?php /*</li>*/ ?>
                                            <?php /*</ul>*/ ?>
                                            <?php /*<?php if($errors->has('amount')): ?>*/ ?>
                                                <?php /*<span class="help-block">*/ ?>
                                            <?php /*<strong class="text-danger"><?php echo e($errors->first('amount')); ?></strong>*/ ?>
                                        <?php /*</span>*/ ?>
                                            <?php /*<?php endif; ?>*/ ?>
                                            <?php /*<?php if($errors->has('Percentage')): ?>*/ ?>
                                                <?php /*<span class="help-block">*/ ?>
                                            <?php /*<strong class="text-danger"><?php echo e($errors->first('Percentage')); ?></strong>*/ ?>
                                        <?php /*</span>*/ ?>
                                            <?php /*<?php endif; ?>*/ ?>
                                        <?php /*</div>*/ ?>

                                    <?php /*</div>*/ ?>
                                    <div class="form-group" id="percentage">
                                        <label class="col-md-6 control-label">Percentage<sup>*</sup></label>
                                        <div class="col-md-6">
                                            <div class="percent-icon">
                                                <input name="percentage" id="percentage_txt" type="text" class="form-control" value="<?php echo e($product->discount_percent); ?> ">
                                            </div>
                                            <?php if($errors->has('order_quantity')): ?>
                                                <span class="help-block">
                                            <strong class="text-danger"><?php echo e($errors->first('order_quantity')); ?></strong>
                                        </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="form-group" id="discount_type">
                                        <label class="col-md-6 control-label">Bulk Product Discount</label>
                                        <div class="col-md-6">
                                            <div class="percent-icon">
                                                <input name="bulk_discount" id="bulk_discount" type="text" class="form-control" value="<?php echo e($product->bulk_discount); ?>">
                                            </div>
                                            <?php if($errors->has('bulk_discount')): ?>
                                                <span class="help-block">
                                            <strong class="text-danger"><?php echo e($errors->first('bulk_discount')); ?></strong>
                                        </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <?php /*<div class="form-group" id="amount" style="display: none;">*/ ?>
                                        <?php /*<label class="col-md-6 control-label">Amount<sup>*</sup></label>*/ ?>

                                        <?php /*<div class="col-md-6">*/ ?>
                                            <?php /*<input name="amount" type="text" class="form-control"  id="amount_txt" value="<?php echo e($product->discount_price); ?>">*/ ?>
                                            <?php /*<?php if($errors->has('amount')): ?>*/ ?>
                                                <?php /*<span class="help-block">*/ ?>
                                            <?php /*<strong class="text-danger"><?php echo e($errors->first('amount')); ?></strong>*/ ?>
                                        <?php /*</span>*/ ?>
                                            <?php /*<?php endif; ?>*/ ?>
                                        <?php /*</div>*/ ?>

                                    <?php /*</div>*/ ?>


                                    <div class="form-group <?php if($errors->has('max_quantity')): ?> has-error <?php endif; ?>">
                                        <label class="col-md-6 control-label">Maximum Quantity<sup>*</sup></label>
                                        <div class="col-md-6"> 
                                            <?php if(isset($product->max_quantity) && $product->max_quantity!=""): ?>
                                            <input name="max_quantity" type="text" class="form-control" id="max_quantity" value="<?php echo e($product->max_quantity); ?>">
                                           <?php else: ?>
                                            <input name="max_quantity" type="text" class="form-control" id="max_quantity" value="<?php echo e(old('max_quantity',0)); ?>">
                                            <?php endif; ?>
                                            <?php if($errors->has('max_quantity')): ?>
                                            <span class="help-block">
                                                <strong class="text-danger"><?php echo e($errors->first('max_quantity')); ?></strong>
                                            </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    
                                    
                                    
                                    <div class="form-group <?php if($errors->has('discount_valid_from')): ?> has-error <?php endif; ?>">
                                        <label class="col-md-6 control-label">Discount Valid From<sup>*</sup></label>
                                        <?php /*<div class="col-md-6"> */ ?>
                                            <?php /*<?php if(isset($product->discount_valid_from) && $product->discount_valid_from!=""): ?>*/ ?>
                                            <?php /*<input name="discount_valid_from" type="text" class="form-control" id="discount_valid_from" value="<?php echo e($product->discount_valid_from); ?>">*/ ?>
                                           <?php /*<?php else: ?>*/ ?>
                                            <?php /*<input name="discount_valid_from" type="text" class="form-control" id="discount_valid_from" value="<?php echo e(old('discount_valid_from')); ?>">*/ ?>
                                            <?php /*<?php endif; ?>*/ ?>
                                            <?php /*<?php if($errors->has('discount_valid_from')): ?>*/ ?>
                                            <?php /**/ ?>
                                            <?php /*<span class="help-block">*/ ?>
                                                <?php /*<strong class="text-danger"><?php echo e($errors->first('discount_valid_from')); ?></strong>*/ ?>
                                            <?php /*</span>*/ ?>
                                            <?php /*<?php endif; ?>*/ ?>
                                        <?php /*</div>*/ ?>
                                        <div class="col-md-6">
                                        <div class='input-group date' id='datepicker1'>
                                            <?php if(isset($product->discount_valid_from) && $product->discount_valid_from!=""): ?>
                                            <input type='text' id='discount_valid_from' name="discount_valid_from" class="form-control" value="<?php echo e($product->discount_valid_from); ?>" />
                                            <?php else: ?>
                                            <input name="discount_valid_from" type="text" class="form-control" id="discount_valid_from" value="<?php echo e(old('discount_valid_from')); ?>">
                                            <?php endif; ?>
                                            <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar">
                                            </span>
                                            </span>
                                            <?php if($errors->has('discount_valid_from')): ?>
                                                <span class="help-block">
                                                <strong class="text-danger"><?php echo e($errors->first('discount_valid_from')); ?></strong>
                                                </span>
                                            <?php endif; ?>

                                        </div>
                                    </div>
                                    </div>

                                    <div class="form-group <?php if($errors->has('discount_valid_to')): ?> has-error <?php endif; ?>">
                                        <label class="col-md-6 control-label">Discount Valid To<sup>*</sup></label>
                                        <?php /*<div class="col-md-6">*/ ?>
                                            <?php /*<?php if(isset($product->discount_valid_to) && $product->discount_valid_to!=""): ?>*/ ?>
                                            <?php /*<input name="discount_valid_to" type="text" class="form-control" id="discount_valid_to" value="<?php echo e($product->discount_valid_to); ?>">*/ ?>
                                           <?php /*<?php else: ?>*/ ?>
                                            <?php /*<input name="discount_valid_to" type="text" class="form-control" id="discount_valid_to" value="<?php echo e(old('discount_valid_to')); ?>">*/ ?>
                                            <?php /*<?php endif; ?>*/ ?>
                                                <?php /*<?php if($errors->has('discount_valid_to')): ?>*/ ?>

                                            <?php /*<span class="help-block">*/ ?>
                                                <?php /*<strong class="text-danger"><?php echo e($errors->first('discount_valid_to')); ?></strong>*/ ?>
                                            <?php /*</span>*/ ?>
                                            <?php /*<?php endif; ?>*/ ?>
                                        <?php /*</div>*/ ?>
                                        <div class="col-md-6">
                                        <div class='input-group date class="col-md-6' id='datepicker2'>
                                            <?php if(isset($product->discount_valid_to) && $product->discount_valid_to!=""): ?>
                                                <input type='text' id='discount_valid_to' name="discount_valid_to" class="form-control" value="<?php echo e($product->discount_valid_to); ?>" />
                                            <?php else: ?>
                                                <input name="discount_valid_to" type="text" class="form-control" id="discount_valid_to" value="<?php echo e(old('discount_valid_to')); ?>">
                                            <?php endif; ?>
                                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                            <?php if($errors->has('discount_valid_to')): ?>
                                                <span class="help-block">
                                                <strong class="text-danger"><?php echo e($errors->first('discount_valid_to')); ?></strong>
                                                </span>
                                            <?php endif; ?>

                                        </div>
                                        </div>

                                    </div>

<?php /*<!--                                    <div class="form-group <?php if($errors->has('max_quantity')): ?> has-error <?php endif; ?>">*/ ?>
                                        <?php /*<label class="col-md-6 control-label">Maximum Quantity<sup>*</sup></label>*/ ?>
                                        <?php /*<div class="col-md-6">*/ ?>
                                            <?php /*<?php if(isset($product->max_quantity) && $product->max_quantity!=""): ?>*/ ?>
                                            <?php /*<input name="max_quantity" type="number" min="0" class="form-control" id="max_quantity" value="<?php echo e($product->max_quantity); ?>">*/ ?>
                                           <?php /*<?php else: ?>*/ ?>
                                            <?php /*<input name="max_quantity" type="number" min="0" class="form-control" id="max_quantity" value="<?php echo e(old('max_quantity')); ?>">*/ ?>
                                            <?php /*<?php endif; ?>*/ ?>
                                            <?php /*<?php if($errors->has('max_quantity')): ?>*/ ?>
                                            <?php /*<span class="help-block">*/ ?>
                                                <?php /*<strong class="text-danger"><?php echo e($errors->first('max_quantity')); ?></strong>*/ ?>
                                            <?php /*</span>*/ ?>
                                            <?php /*<?php endif; ?>*/ ?>
                                        <?php /*</div>*/ ?>
                                    <?php /*</div>-->*/ ?>

                                        <div class="form-group">
                                        <div class="col-md-12">
                                            <button type="button" id="rm-submit" class="btn btn-primary  pull-right" onclick="rmDiscount()" >Remove Discount</button>
                                            <button type="submit" id="submit" class="btn btn-primary  pull-left" onclick="appendErrorMsgDiscount()" style="margin-left:360px;">Add Discount</button>
                                        </div>
                                    </div>
                                    <input  id="ip-token" type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
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
</style>
<script>
    var d = new Date;

    $(function(){

        $("#datepicker1").datetimepicker({
            format:"yyyy/mm/dd hh:ii:ss",
            startDate:d
        });
        $("#datepicker2").datetimepicker({
            format:"yyyy/mm/dd hh:ii:ss",
            startDate:d
        });
    });

</script>
<script type="text/javascript">
    jQuery(document).ready(function() {

        <?php if($product->discount_type == '0'): ?> $("#amount").show(); <?php endif; ?>
        <?php if($product->discount_type == '1'): ?> $("#percentage").show(); <?php endif; ?>

    });

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

<script>
    function setCategory($cat)
    {
        $('#category_id').val($cat);
    }


</script>
<script>

    var proId = $('#product_id').val();


    function rmDiscount(){
        if (confirm("Do you really want to remove discount on product?"))
        {
            $.ajax({
                url: '<?php echo e(url('/admin/remove-product-discount')); ?>',
                type: "post",
                dataType: 'json',
                data: {
                    product_id: proId,
                    _token : $('ip-token').val()
                },
                success: function(response) {
                    if (response.success == "1")
                    {
                        window.location.href = window.location.href;
                    }
                    else{
                        alert(response.msg);return;
                    }

                }
            });
        }
            return false;

    }

</script>
<script type="text/javascript" src="<?php echo e(url('/')); ?>/public/media/backend/js/bootstrap-datetimepicker.min.js">
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make(config("piplmodules.back-view-layout-location"), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>