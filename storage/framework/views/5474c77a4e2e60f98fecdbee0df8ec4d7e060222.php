<?php $__env->startSection("meta"); ?>

<title>Update Product</title>

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
                <a href="<?php echo e(url('/admin/gift-card-list')); ?>">Manage Gift Cards</a>
                <i class="fa fa-circle"></i>

            </li>
            <li>
                <a href="javascript:void(0);">Update Gift Card</a>

            </li>
        </ul>

        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-gift"></i> Update Gift Card
                </div>

            </div>
            <div class="portlet-body form">
                <form class="form-horizontal" name="update_gift_card" id="update_gift_card" role="form" action="<?php echo e(url('/admin/update-gift-card/').'/'.$gift_card_details->id); ?>" method="post" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>

                    <div class="form-body">
                        
                        <div class="row">
                            <div class="col-md-12">    
                                <div class="col-md-8">

                                    <div class="form-group">
                                        <label class="col-md-6 control-label">Card Name<sup>*</sup></label>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="card_name" id="card-name" value="<?php echo e($gift_card_details->name); ?>">
                                            <?php if($errors->has('card_name')): ?>
                                                <span class="help-block">
                                                <strong class="text-danger"><?php echo e($errors->first('card_name')); ?></strong>
                                            </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-6 control-label">Card Image<sup>*</sup></label>
                                        <div class="col-md-6">

                                            <input type="file" class="form-control" name="image" multiple="true" id="image" onchange="readURL(this);">
                                            
                                            <input type="hidden" name="old_image" value="<?php echo e($gift_card_details->image); ?>">
                                            <image <?php if(!empty($gift_card_details->image)): ?> src="<?php echo e(url("storage/app/public/gift_card_image/").'/'.$gift_card_details->image); ?>" <?php else: ?> style="display: none" <?php endif; ?> style="margin-top: 10px" class="paper-image" height="50px" width="50px">
                                            <?php if($errors->has('image')): ?>
                                            <span class="help-block">
                                                <strong class="text-danger"><?php echo e($errors->first('image')); ?></strong>
                                            </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <div class="form-group" id="order_pice_div">
                                        <label class="col-md-6 control-label">Minimum Price<sup>*</sup></label>

                                        <div class="col-md-6">
                                            <input name="price" type="text" class="form-control" id="price" value="<?php echo e($gift_card_details->price); ?>">
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
                                            <textarea name="description" type="text" class="form-control" id="description"><?php echo e($gift_card_details->description); ?></textarea>
                                            <?php if($errors->has('description')): ?>
                                                <span class="help-block">
                                                <strong class="text-danger"><?php echo e($errors->first('description')); ?></strong>
                                            </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12">   
                                            <button type="submit" id="submit" class="btn btn-primary  pull-right">Update</button>
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
    function readURL(input) {
        var ext = input.value.split('.').pop();
        switch (ext)
        {
            case 'jpg':
            case 'png':
            case 'jpeg':
            case 'JPG':
            case 'PNG':
            case 'JPEG':

                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#show_image').css("display", "block");
                        $('#show_image').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
                break;
            default:
                alert('Only this image format jpg,png,jpeg allowed !');
                input.value = '';
        }

    }
</script>


<?php $__env->stopSection(); ?>
<?php echo $__env->make(config("piplmodules.back-view-layout-location"), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>