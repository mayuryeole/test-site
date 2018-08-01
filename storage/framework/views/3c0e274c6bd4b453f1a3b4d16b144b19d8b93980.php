<?php $__env->startSection("meta"); ?>

<title>Add Gift Card</title>

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
                <a href="<?php echo e(url('/admin/gift-card-list')); ?>">Manage Gift Card</a>
                <i class="fa fa-circle"></i>

            </li>
            <li>
                <a href="javascript:void(0);">Add Gift Card</a>

            </li>
        </ul>

        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-gift"></i> Add Gift Card
                </div>
            </div>
            <div class="portlet-body form">
                <form class="form-horizontal" name="create_gift_card" id="create_gift_card" role="form" action="<?php echo e(url('/admin/giftcard/create' )); ?>" method="post" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>

                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-12">    
                                <div class="col-md-8">

                                    <div class="form-group">
                                        <label class="col-md-6 control-label">Card Name<sup>*</sup></label>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="card_name" id="card-name" value="<?php echo e(old('card_name')); ?>">
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
                                            <input type="file" class="form-control" name="image" onchange="readURL(this);" id="image" value="<?php echo e(old('image')); ?>">
                                            <img class="paper-image" style="display: none;margin-top: 10px" id="show_image" src="#" alt="" width="50px" height="50px"/>
                                            <?php if($errors->has('image')): ?>
                                            <span class="help-block">
                                                <strong class="text-danger"><?php echo e($errors->first('image')); ?></strong>
                                            </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="form-group" id="order_price_div">
                                        <label class="col-md-6 control-label">Minimum Price<sup>*</sup></label>

                                        <div class="col-md-6" >
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
                                            <textarea name="description" type="text" class="form-control" id="description"><?php echo e(old('description')); ?></textarea>
                                            <?php if($errors->has('description')): ?>
                                                <span class="help-block">
                                                <strong class="text-danger"><?php echo e($errors->first('description')); ?></strong>
                                            </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12">   
                                            <button type="submit" id="btn_gift_card" name="btn_gift_card" class="btn btn-primary  pull-right">Create</button>
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