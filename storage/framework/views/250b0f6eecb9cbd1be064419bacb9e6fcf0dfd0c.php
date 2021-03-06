<?php $__env->startSection('meta'); ?>
<title>Update Email</title>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<!----------------------------------------------------Dashboard Section Start------------------------------------------------------>
<section class="dashboard-blk fullHt">
    <div class="burger-menu">
        <span class="dash_line"></span>
    </div>

    <div style="margin-top:30px" class="right-panel release-positions">
        <div style="margin-left:50px;margin-right:50px" class="cust-breadcrumbs">
            <ul>
                <li><i class="fa fa-home"></i>&nbsp;<a href="<?php echo e(url('/')); ?>">Home</a></li>
                <li><i class="fa fa-dashboard"></i>&nbsp;<a href="<?php echo e(url('/profile')); ?>">Dashboard</a></li>

            </ul>
        </div>
        <div class="dashboard-area">
            <div class="dashboard_content">
                <div class="dash_heading"><span><i class="fa fa-user"></i> Profile Information</span></div>

            </div>
            <?php if(session('password-update-fail')): ?>
            <div class="alert alert-danger">
                <?php echo e(session('password-update-fail')); ?>

                <a style="color: black" href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
            </div>
            <?php endif; ?>
            <div class="profiler_information">

                <form class=profiler_info_form" name="update_password" id="update_password" role="form" method="POST" action="<?php echo e(url('/change-password-post')); ?>">
                        <?php echo csrf_field(); ?>

                    <div class="row form-group<?php echo e($errors->has('current_password') ? ' has-error' : ''); ?>">
                        <div class="col-md-2 col-sm-3"><label>Your current Password: </label></div>
                        <div class="col-md-9 col-sm-9 col-xs-12">                            
                             <input type="password" class="form-control" id="current_password" name="current_password" value="<?php echo e(old('current_password')); ?>">
                                 <?php if($errors->has('current_password')): ?>
                                    <span class="help-block">
                                        <strong><?php echo e($errors->first('current_password')); ?></strong>
                                    </span>
                                <?php endif; ?>
                        </div>
                    </div>
                    <div class="row form-group<?php echo e($errors->has('new_password') ? ' has-error' : ''); ?>">
                        <div class="col-md-2 col-sm-3"><label>New Password:</label></div>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input type="password" class="form-control" id="new_password" name="new_password" value="<?php echo e(old('new_password')); ?>">
                                 <?php if($errors->has('new_password')): ?>
                                    <span class="help-block">
                                        <strong><?php echo e($errors->first('new_password')); ?></strong>
                                    </span>
                                <?php endif; ?>
                        </div>
                    </div>                    
                    <div class="row form-group<?php echo e($errors->has('confirm_password') ? ' has-error' : ''); ?>">
                        <div class="col-md-2 col-sm-3"><label>Confirm Password: </label></div>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" value="<?php echo e(old('confirm_password')); ?>">
                                 <?php if($errors->has('confirm_password')): ?>
                                    <span class="help-block">
                                        <strong><?php echo e($errors->first('confirm_password')); ?></strong>
                                    </span>
                                <?php endif; ?>
                        </div>
                    </div>     

                    <div class="row form-group">
                        <div class="col-sm-9 col-xs-12 col-md-offset-2">
                            <button type="submit" class="edit_profile_button">Update Password</button>

                        </div>
                    </div>

                </form>

            </div>
        </div> <!--End of Dashboard Area-->
    </div>
</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>