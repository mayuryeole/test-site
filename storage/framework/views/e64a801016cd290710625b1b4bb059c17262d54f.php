 <?php $__env->startSection('meta'); ?>
    <title>Permission Denied Page</title>
 <?php $__env->stopSection(); ?>
 
<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Permission Denied</div>

                <div class="panel-body">
                    Sorry for this, You seeing this page because the action you want to perform require a permission for same. Please contact with site administrator.<br><br>
					<?php if(Auth::User()->userInformation->user_type=='1'): ?>	
					   <a href="<?php echo e(url('/admin/dashboard')); ?>" class="btn btn-primary">Back</a><br>
				   </a>
				   <?php endif; ?>
				   <?php if(Auth::User()->userInformation->user_type!='1'): ?>	
					   <a href="<?php echo e(url('/')); ?>" class="btn btn-primary">Back</a><br>
				   </a>
				   <?php endif; ?>
					<img src="<?php echo e(url('public/media/front/images/denied.gif')); ?>" title="Permission Denied">
                </div>
				
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.permission_app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>