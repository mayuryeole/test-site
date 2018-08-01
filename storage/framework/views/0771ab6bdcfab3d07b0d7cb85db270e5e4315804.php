<?php $__env->startSection("meta"); ?>
<title> Reset My Password</title>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
       <div class="page-lock">
	<div class="page-body">
		<div class="lock-head">
			 Reset My Password
		</div>
		
              <?php if(session('status')): ?>
                        <div class="alert alert-success">
                            <?php echo e(session('status')); ?>

                            <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                        </div>
                    <?php endif; ?>
               <div class="lock-body">
                      <form role="form" method="POST" action="<?php echo e(url('/password/email')); ?>">
                        <?php echo csrf_field(); ?>


                        <div class="form-group<?php echo e($errors->has('email') ? ' has-error' : ''); ?>">
                          
                                <input type="email" autocomplete="off" placeholder="Email" class="form-control placeholder-no-fix" name="email" value="<?php echo e(old('email')); ?>">

                                <?php if($errors->has('email')): ?>
                                    <span class="help-block">
                                        <strong><?php echo e($errors->first('email')); ?></strong>
                                    </span>
                                <?php endif; ?>
                          
                        </div>
                         <div class="form-group">
                             <a class="btn btn-link pull-right" href="<?php echo e(url('/admin/login')); ?>">Back To Login?</a>
                             
                            
                          
                        </div>
                        
                        <div class="form-group text-center pull-left">
                             	
                                <button type="submit" class="btn btn-primary">
                                    Send Reset Link
                                </button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make(config("piplmodules.back-view-layout-login-location"), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>