<?php $__env->startSection("meta"); ?>

<title>Update Product Image</title>

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
                <a href="<?php echo e(url('admin/products-list/?stock=&category=')); ?>">Manage Products</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="<?php echo e(url('/admin/manage-product-image')); ?>/<?php echo e($product_image->product_id); ?>">Product Image</a>
                <i class="fa fa-circle"></i>

            </li>
            <li>
                <a href="javascript:void(0);">Update Product Images</a>

            </li>
        </ul>
<?php if(session('status')): ?>
        <div class="alert alert-success">
            <?php echo e(session('status')); ?>

            <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
        </div>
        <?php endif; ?>

        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-gift"></i> Update A Product Image
                </div>

            </div>
            <div class="portlet-body form">
                <form class="form-horizontal" name="update_product_image" id="update_product_image" role="form" action="" method="post" enctype="multipart/form-data" >

                    <?php echo csrf_field(); ?>

                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-12">    
                                <div class="col-md-8">
                                    <div class="form-group <?php if($errors->has('color')): ?> has-error <?php endif; ?>">
                                        <label class="col-md-6 control-label">Select Color:<sup>*</sup></label>
                                        <div class="col-md-6">     
                                            <select name="color"  class="form-control" id="color" >
                                                <?php if(isset($product_image) && count($product_image)>0): ?>
                                                <option selected disabled value="<?php echo e($product_image->color); ?>"><?php echo e($product_image->color); ?></option>
                                                <?php endif; ?>
                                            </select>    
                                           
                                            <?php if($errors->has('color')): ?>
                                            <span class="help-block">
                                                <strong class="text-danger"><?php echo e($errors->first('color')); ?></strong>
                                            </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <div class="form-group <?php if($errors->has('photo')): ?> has-error <?php endif; ?>">
                                        <label class="col-md-6 control-label">Image<sup>*</sup></label>
                                        <div class="col-md-6">     
                                            <input name="photo[]" multiple type="file" class="form-control" id="photo">
                                            <span style="color: black; font-weight:bolder;" class="btn-vdo-mar" id="fileLen"></span>
                                            <?php if($errors->has('photo')): ?>
                                            <span class="help-block">
                                                <strong class="text-danger"><?php echo e($errors->first('photo')); ?></strong>
                                            </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <input type="hidden" id="all-imgs-cnt" value="<?php echo e($all_imgs_cnt); ?>">
                                    <input type="hidden" name="product_id" value="<?php echo e($product_image->product_id); ?>">
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
            <div class="my_image_blk">
                <div class="row">
                    <?php if(isset($multi) && count($multi) > 0): ?>
                        <div class="col-sm-12">

                            <ul class="h_my_img_listing clearfix">
                                <?php foreach($multi as $img): ?>
                                    <li>
                                        <div id="hide_img_<?php echo e($img->id); ?>">
                                            <div class="h_my_img_holder">

                                                <img src="<?php echo e(url('/storage/app/public/product/product_images/').'/'.$img->image); ?>">
                                                <span class="h_close_btn"><img src="<?php echo e(asset('/')); ?>public/media/backend/images/remove-icon-small.png"  onclick="deleteImages(<?php echo e($img->id); ?>)"></span>
                                            </div>
                                        </div>

                                    </li>
                                <?php endforeach; ?>
                            </ul>
                            <?php echo $multi->render(); ?>

                        </div>
                    <?php endif; ?>
                </div>
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
    $("#photo").change(function(e){
        $("#fileLen").show();
        var files= e.target.files;
         var gbl_count = e.target.files.length;
        var allImgsCnt = parseInt($('#all-imgs-cnt').val());
        var max = 4 - allImgsCnt;
        if(gbl_count == 0)
        {
            alert('Please select image files to upload.');
            reset_form_element($(this));
            return false;
        }

        if((gbl_count + allImgsCnt) > 4)
        {
            if(max == 0)
            {
                alert('You have already uploaded 4 image files.');
                reset_form_element($(this));
                return false;
            }
            alert('You can upload max 4 image files so select max '+ max +' image files to upload.');
            reset_form_element($(this));
            return false;
        }
        else if(gbl_count > 4)
        {
            alert('Please select max '+ '4' +' image files to upload.');
            reset_form_element($(this));
            return false;
        }
        else{
            for(var i =0; i<gbl_count; i++){
                var f = files[i];
                // alert(24);
                var file_ext = f.name.split('.').pop();
                if(file_ext=='jpg'||file_ext=='jpeg'||file_ext=='png'||file_ext=='gif')
                {
                    return true;
                }
                else{

                    alert('Please upload valid photos. eg : jpg | jpeg | png | gif');
                    reset_form_element($(this));
                    return false;
                }
            }
        }
    });
    function reset_form_element(e) {
        e.wrap('<form>').parent('form').trigger('reset');
        e.unwrap();
    }
</script>

<script>
    function setCategory($cat)
    {
        $('#category_id').val($cat);
    }

    
</script>
<script>
    function deleteImages(id)
    {
        if (confirm("Do you really want to delete this image?"))
        {
            hide_img = "#hide_img_" + id;
            $.ajax({
                url:"<?php echo e(url('/admin/product/deletedImages/delete-image')); ?>/" + id,
                method:'get',
                dataType:'json',
                success:function(data)
                {
                    if (data.success == 1)
                    {
                        $(hide_img).hide();
                        window.location.href =window.location.href
                    } else{
                        alert(data.msg);

                    }
                }

            });
        } else{
            return false;
        }
    }
</script>


<?php $__env->stopSection(); ?>
<?php echo $__env->make(config("piplmodules.back-view-layout-location"), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>