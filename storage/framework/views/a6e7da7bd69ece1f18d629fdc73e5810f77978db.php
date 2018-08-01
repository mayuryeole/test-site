<?php $__env->startSection('meta'); ?>
    <title>Update Email</title>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<!----------------------------------------------------Dashboard Section Start------------------------------------------------------>
<section class="dashboard-blk fullHt">
    <div class="burger-menu">
        <span class="dash_line"></span>
    </div>

    <div style="margin-top:30px" class="right-panel">
        
        <div class="dashboard-area">
           
            <div class="profiler_information">
                <form class="profiler_info_form" role="form" method="POST" action="<?php echo e(url('/password/reset')); ?>">
                        <?php echo csrf_field(); ?>

                        <input type="hidden" name="token" value="<?php echo e($token); ?>">
                        
                    <div class="row form-group <?php echo e($errors->has('email') ? ' has-error' : ''); ?>">
                        <div class="col-md-2 col-sm-4"><label>E-Mail Address: </label></div>
                        <div class="col-md-6 col-sm-6 col-xs-8">
                            <input type="email" class="form-control" required name="email" value="<?php echo e(isset($email) ? $email : old('email')); ?>">

                                <?php if($errors->has('email')): ?>
                                    <span class="help-block">
                                        <strong><?php echo e($errors->first('email')); ?></strong>
                                    </span>
                                <?php endif; ?>
                        </div>
                    </div>
                    <div class="row form-group <?php echo e($errors->has('password') ? ' has-error' : ''); ?>">
                        <div class="col-md-2 col-sm-4"><label>Password: </label></div>
                        <div class="col-md-6 col-sm-6 col-xs-8">
                          
                                <input type="password" class="form-control" name="password">

                                <?php if($errors->has('password')): ?>
                                    <span class="help-block">
                                        <strong><?php echo e($errors->first('password')); ?></strong>
                                    </span>
                                <?php endif; ?>
                        </div>
                    </div>            
                    <div class="row form-group form-group<?php echo e($errors->has('password_confirmation') ? ' has-error' : ''); ?>">
                        <div class="col-md-2 col-sm-4"><label>Confirm Password:</div>
                        <div class="col-md-6 col-sm-6 col-xs-8">
                             <input type="password" class="form-control" name="password_confirmation">

                                <?php if($errors->has('password_confirmation')): ?>
                                    <span class="help-block">
                                        <strong><?php echo e($errors->first('password_confirmation')); ?></strong>
                                    </span>
                                <?php endif; ?>
                        </div>
                    </div>     
                                         
                    <div class="row form-group">
                <div class="col-md-12 col-sm-9 col-xs-12 col-md-offset-2">
                    <button type="submit" class="edit_profile_button">Reset Password</button>
                            
                </div>
                </div>
                        
                </form>
                
            </div>
        </div> <!--End of Dashboard Area-->
    </div>
</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>