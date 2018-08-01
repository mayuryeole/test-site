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
             <?php if(session('password-update-success')): ?>
               <div class="alert alert-success">
                <?php echo e(session('password-update-success')); ?>

                </div>
                <?php endif; ?>
               <?php if(session('profile-updated')): ?>
               <div class="alert alert-success">
                <?php echo e(session('profile-updated')); ?>

                </div>
                <?php endif; ?>
            <div class="profiler_information">
              
                    <form class="profiler_info_form" name="update_email" id="update_email" role="form" method="POST" action="<?php echo e(url('/change-email-post')); ?>">
                        <?php echo csrf_field(); ?>

                    <div class="row form-group">
                        <div class="col-md-2 col-sm-3"><label>Your current Email: </label></div>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input type="text"  name="old_email"class="form-control" value="<?php echo e($user_info->email); ?>" />
                      </div>
                    </div>
                    <div class="row form-group <?php echo e($errors->has('email') ? ' has-error' : ''); ?>">
                        <div class="col-md-2 col-sm-3"><label>New Email:</label></div>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input type="text" id="email" name="email" class="form-control" value="<?php echo e(old('email')); ?>" />
                            <?php if($errors->has('email')): ?>
                                    <span class="help-block">
                                        <strong><?php echo e($errors->first('email')); ?></strong>
                                    </span>
                                <?php endif; ?>
                        </div>
                    </div>                    
                    <div class="row form-group <?php echo e($errors->has('confirm_email') ? ' has-error' : ''); ?>">
                        <div class="col-md-2 col-sm-3"><label>Confirm Email: </label></div>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input type="email" class="form-control" id="confirm_email" name="confirm_email" value="<?php echo e(old('confirm_email')); ?>"/>
                             <?php if($errors->has('confirm_email')): ?>
                                    <span class="help-block">
                                        <strong><?php echo e($errors->first('confirm_email')); ?></strong>
                                    </span>
                                <?php endif; ?>
                        </div>
                    </div>     
                                         
                    <div class="row form-group">
                <div class="col-sm-9 col-xs-12 col-md-offset-2">
                    <button type="submit" class="edit_profile_button">Update Email</button>
                            
                </div>
                </div>
                        
                </form>
                
            </div>
        </div> <!--End of Dashboard Area-->
    </div>
</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>