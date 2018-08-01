<?php $__env->startSection('meta'); ?>
<title>User Profile</title>
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
            <?php if(session('profile-updated')): ?>
            <div class="alert alert-success">
                <?php echo e(session('profile-updated')); ?>

                <a style="color: black" href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
            </div>
            <?php endif; ?>
            
            <?php if(session('password-update-success')): ?>
            <div class="alert alert-success">
                <?php echo e(session('password-update-success')); ?>

                <a style="color: black" href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
            </div>
            <?php endif; ?>
            <div class="profiler_information">

                <form class="profiler_info_form" name="update_profile" id="update_profile" role="form" method="POST" action="<?php echo e(url('/update-profile-post')); ?>">
                    <?php echo csrf_field(); ?>

                    <input type="hidden" name="user_id" value="<?php echo e($user_info->id); ?>">
                    <div class="row form-group<?php echo e($errors->has('first_name') ? ' has-error' : ''); ?>">
                        <div class="col-md-2 col-sm-3"><label>First Name: </label></div>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input type="text" class="form-control" name="first_name" value="<?php echo e(old('first_name',$user_info->userInformation->first_name)); ?>">
                            <?php if($errors->has('first_name')): ?>
                            <span class="help-block">
                                <p><?php echo e($errors->first('first_name')); ?></p>
                            </span>
                            <?php endif; ?>
                        </div>
                    </div>

                   
                    <div class="row form-group<?php echo e($errors->has('last_name') ? ' has-error' : ''); ?>">
                        <div class="col-md-2 col-sm-3"><label>Last Name: </label></div>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input type="text" class="form-control" name="last_name" value="<?php echo e(old('last_name',$user_info->userInformation->last_name)); ?>">
                            <?php if($errors->has('last_name')): ?>
                            <span class="help-block">
                                <p><?php echo e($errors->first('last_name')); ?></p>
                            </span>
                            <?php endif; ?>
                        </div>
                    </div>                        
                    <div class="row form-group<?php echo e($errors->has('user_mobile') ? ' has-error' : ''); ?>">
                        <div class="col-md-2 col-sm-3"><label>Mobile: </label></div>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input type="text" class="form-control" name="user_mobile" value="<?php echo e(old('user_mobile',$user_info->userInformation->user_mobile)); ?>">
                            <?php if($errors->has('user_mobile')): ?>
                            <span class="help-block">
                                <p><?php echo e($errors->first('user_mobile')); ?></p>
                            </span>
                            <?php endif; ?>
                        </div>
                    </div>             
                    <div class="row form-group">
                        <div style="display: inline-block" class="col-md-12 col-sm-9 col-xs-12 col-md-offset-2">
                            <button type="submit" class="edit_profile_button">Update Profile</button>

                        </div>
                    </div>  

                </form>

            </div>
        </div> <!--End of Dashboard Area-->
    </div>
</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>