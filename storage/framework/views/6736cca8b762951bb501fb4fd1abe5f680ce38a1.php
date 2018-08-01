<?php $__env->startSection("meta"); ?>

<title>Add Box</title>

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
                <a href="<?php echo e(url('/admin/box-list')); ?>">Manage Box</a>
                <i class="fa fa-circle"></i>

            </li>
            <li>
                <a href="javascript:void(0);">Add Box</a>

            </li>
        </ul>
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-gift"></i> Add Box
                </div>
            </div>
            <div class="portlet-body form">
                <form class="form-horizontal" name="create_box" id="create_box" role="form" action="<?php echo e(url('/admin/box/create' )); ?>" method="post" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>

                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-12">    
                                <div class="col-md-8">

                                    <div class="form-group">
                                        <label class="col-md-6 control-label">Box Name<sup>*</sup></label>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="box_name" id="box-name" value="<?php echo e(old('box_name')); ?>">
                                            <?php if($errors->has('box_name')): ?>
                                                <span class="help-block">
                                                <strong class="text-danger"><?php echo e($errors->first('box_name')); ?></strong>
                                            </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-6 control-label">Box Weight<sup>*</sup></label>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="box_weight" id="box-weight" value="<?php echo e(old('box_weight')); ?>">
                                            <?php if($errors->has('box_weight')): ?>
                                                <span class="help-block">
                                                <strong class="text-danger"><?php echo e($errors->first('box_weight')); ?></strong>
                                            </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-6 control-label">Box Image<sup>*</sup></label>
                                        <div class="col-md-6">     
                                            <input type="file" class="form-control" name="image" multiple="true" id="image" value="<?php echo e(old('image')); ?>">
                                            <img class="ribbon-image" style="display: none" id="show_image" src="#" alt="" width="50px" height="50px"/>
                                            <?php if($errors->has('image')): ?>
                                            <span class="help-block">
                                                <strong class="text-danger"><?php echo e($errors->first('image')); ?></strong>
                                            </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-6 control-label">Status<sup>*</sup></label>

                                        <div class="col-md-6">     
                                            <select name="status" class="form-control" id="status" value="<?php echo e(old('status')); ?>" onchange="hideShowTextbox(this)">
                                                <option value="">Select Status</option>
                                                <option value="0">Free</option>
                                                <option value="1">Paid</option>
                                             </select>
                                            <?php if($errors->has('status')): ?>
                                            <span class="help-block">
                                                <strong class="text-danger"><?php echo e($errors->first('status')); ?></strong>
                                            </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <div id="order_price_div" class="form-group" style="display: none;">
                                        <label class="col-md-6 control-label">Price<sup>*</sup></label>

                                        <div class="col-md-6">
                                            <input name="price" type="text" class="form-control" id="price" value="<?php echo e(old('price')); ?>">
                                            <?php if($errors->has('price')): ?>
                                                <span class="help-block">
                                                <strong class="text-danger"><?php echo e($errors->first('price')); ?></strong>
                                            </span>
                                            <?php endif; ?>
                                        </div>

                                    </div>
                                    <div class="form-group <?php if($errors->has('description')): ?> has-error <?php endif; ?>">
                                        <label class="col-md-6 control-label">Description</label>
                                        <div class="col-md-6">
                                            <textarea name="description" type="text" class="form-control" id="description" value="<?php echo e(old('description')); ?>"></textarea>
                                            <?php if($errors->has('description')): ?>
                                                <span class="help-block">
                                                <strong class="text-danger"><?php echo e($errors->first('description')); ?></strong>
                                            </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <?php /*<div class="form-group" id="order_quantity_div" style="display: none;">*/ ?>
                                        <?php /*<label class="col-md-6 control-label">Order Quantity<sup>*</sup></label>*/ ?>
                                        <?php /*<div class="col-md-6">     */ ?>
                                            <?php /*<input name="order_quantity" id="order_quantity" type="text" class="form-control" value="<?php echo e(old('order_quantity')); ?>">*/ ?>
                                            <?php /*<?php if($errors->has('order_quantity')): ?>*/ ?>
                                            <?php /*<span class="help-block">*/ ?>
                                                <?php /*<strong class="text-danger"><?php echo e($errors->first('order_quantity')); ?></strong>*/ ?>
                                            <?php /*</span>*/ ?>
                                            <?php /*<?php endif; ?>*/ ?>
                                        <?php /*</div>*/ ?>
                                    <?php /*</div>*/ ?>

                                    <div class="form-group">
                                        <div class="col-md-12">   
                                            <button type="submit" id="btn_product" name="btn_product" class="btn btn-primary  pull-right">Create</button>
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
    $("#image").on("change", function(e) {

        var flag='0';
        var fileName = e.target.files[0].name;
        var arr_file = new Array();
        arr_file = fileName.split('.');
        var file_ext = arr_file[1];
        if(file_ext=='jpg'||file_ext=='JPG'||file_ext=='jpeg'||file_ext=='JPEG'||file_ext=='png'||file_ext=='PNG'|| file_ext=='GIF'||file_ext=='gif')
        {

            var files = e.target.files,

                filesLength = files.length;
            for (var i = 0; i < filesLength; i++) {
                var f = files[i];
                var fileReader = new FileReader();
                fileReader.onload = (function(e) {
                    var file = e.target;
                    $("#show_image").show();
                    $("#show_image").attr("src",e.target.result );



                });
                fileReader.readAsDataURL(f);
            }
        } else{
            $("#photo").val('');
            alert('Please choose valid image extension. eg : jpg | jpeg | png |gif');
            return false;
        }

    });

    function hideShowTextbox(t){

        if($(t).val() == 1){
            $("#order_price_div").show();
        }else{
            $("#order_price_div").hide();
        }
    }
</script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make(config("piplmodules.back-view-layout-location"), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>