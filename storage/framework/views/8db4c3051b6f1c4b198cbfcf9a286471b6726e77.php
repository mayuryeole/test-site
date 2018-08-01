<?php $__env->startSection("meta"); ?>

<title>Create Rivaah Gallery</title>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="<?php echo e(url('/')); ?>/public/media/backend/css/style.css">
<link rel="stylesheet" href="<?php echo e(url('/')); ?>/public/media/backend/css/bootstrap-datetimepicker.min.css">
<link rel="stylesheet" href="<?php echo e(url('/')); ?>/public/media/backend/css/flexselect.css" media="screen">
<link rel="stylesheet" href="<?php echo e(url('/')); ?>/public/media/backend/css/color-product.css" media="screen">



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
                <a href="<?php echo e(url('admin/rivaah-galleries-list')); ?>">Manage Rivaah</a>
                <i class="fa fa-circle"></i>

            </li>
            <li>
                Create Rivaah Gallery

            </li>
        </ul>

        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-gift"></i> Create A Rivaah Gallery
                </div>

            </div>
            <div class="portlet-body form">
                <form class="form-horizontal" name="create_rivaah_gallery" id="create_rivaah_gallery" role="form" action="" method="post" enctype="multipart/form-data" >
                    <?php echo csrf_field(); ?>

                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-12">    
                                <div class="col-md-8">  
                                    <?php /*<div class="form-group">*/ ?>
                                        <?php /*<label class="col-md-6 control-label">Select Category<sup>*</sup></label>*/ ?>
                                        <?php /*<div class="col-md-6">  */ ?>
                                            <?php /*<select class="form-control flexselect" id="category" name="category" onclick="setCategory(this.value)">*/ ?>
                                                <?php /*<option value="">Select Category</option>*/ ?>
                                        <?php /*<?php foreach($all_category as $key=>$val): ?>*/ ?>
                                                <?php /*<option value="<?php echo e($val->id); ?>" name="category" id="category"><?php echo e($val->name); ?></option>*/ ?>
                                                <?php /*<?php endforeach; ?>                                            </select>*/ ?>
                                            <?php /*<input type='hidden' name='category_id' id='category_id'>*/ ?>
                                        <?php /*</div>*/ ?>
                                    <?php /*</div>*/ ?>
                                   
                                    <div class="form-group <?php if($errors->has('name')): ?> has-error <?php endif; ?>">
                                        <label class="col-md-6 control-label">Gallery Name<sup>*</sup></label>
                                        <div class="col-md-6">     
                                            <input name="name" type="text" class="form-control" id="name" value="<?php echo e(old('name')); ?>">
                                            <?php if($errors->has('name')): ?>
                                            <span class="help-block">
                                                <strong class="text-danger"><?php echo e($errors->first('name')); ?></strong>
                                            </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="form-group <?php if($errors->has('description')): ?> has-error <?php endif; ?>">
                                        <label class="col-md-6 control-label">Description<sup>*</sup></label>
                                        <div class="col-md-6">     
                                            <textarea rows="15" cols="10" name="description" type="text" class="form-control" id="description" value="<?php echo e(old('description')); ?>"></textarea>
                                            <?php if($errors->has('description')): ?>
                                            <span class="help-block">
                                                <strong class="text-danger"><?php echo e($errors->first('description')); ?></strong>
                                            </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                        <div class="form-group">
                                        <div class="col-md-12">   
                                            <input type="submit" class="btn btn-primary  pull-right" value="Create">
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
</style>

<script>
    function setCategory($cat)
    {
        $('#category_id').val($cat);
    }
jQuery(document).ready(function() {
    $("select .flexselect").flexselect();
  // $("#category").flexselect();
});
</script>

<script type="text/javascript" src="<?php echo e(url('/')); ?>/public/media/backend/js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript" src="<?php echo e(url('/')); ?>/public/media/backend/js/flexselect.js"></script>
<script type="text/javascript" src="<?php echo e(url('/')); ?>/public/media/backend/js/liquidmetal.js"></script>
<script type="text/javascript" src="<?php echo e(url('/')); ?>/public/media/backend/js/color-product.js"></script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make(config("piplmodules.back-view-layout-location"), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>