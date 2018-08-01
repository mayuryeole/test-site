<?php $__env->startSection("meta"); ?>
<title>Login to Admin panel</title>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="page-lock">
    <div class="page-body">
        <div class="lock-head">
            Admin Login Page
        </div>

        <?php if(session('login-error')): ?>
        <div class="alert alert-danger">
            <?php echo e(session('login-error')); ?>

        </div>
        <?php endif; ?>
        <?php if(session('register-success')): ?>
        <div class="alert alert-success">
            <?php echo e(session('register-success')); ?>

            <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
        </div>
        <?php endif; ?>
        <?php if(session('status')): ?>
        <div class="alert alert-success">
            <?php echo e(session('status')); ?>

            <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
        </div>
        <?php endif; ?>
        <div class="lock-body">
            <form class="lock-form pull-left" id='admin_login' name='admin_login' role="form" method="POST" action="<?php echo e(url('/login')); ?>">
                <?php echo csrf_field(); ?>


                <div class="form-group<?php echo e($errors->has('email') ? ' has-error' : ''); ?>">
                    <?php if(isset($_COOKIE['email'])): ?>
                    <input type="email"  id="email" name="email" class="form-control" value="<?php echo e($_COOKIE['email']); ?>" />
                    <?php else: ?> 
                    <input type="email" autocomplete="off" placeholder="Email" class="form-control placeholder-no-fix" name="email">

                    <?php if($errors->has('email')): ?>
                    <span class="help-block">
                        <strong><?php echo e($errors->first('email')); ?></strong>
                    </span>
                    <?php endif; ?>
                    <?php endif; ?>
                </div>

                <div class="form-group<?php echo e($errors->has('password') ? ' has-error' : ''); ?>">
                    <?php if(isset($_COOKIE['password'])): ?>
                    <input type="password" id="password" name="password" value="<?php echo e($_COOKIE['password']); ?>" class="form-control" />
                    <?php else: ?> 
                    <input type="password" autocomplete="off" placeholder="Password" class="form-control placeholder-no-fix" name="password">

                    <?php if($errors->has('password')): ?>
                    <span class="help-block">
                        <strong><?php echo e($errors->first('password')); ?></strong>
                    </span>
                    <?php endif; ?>
                    <?php endif; ?>
                </div>

                <div class="form-group">

                    <div class="checkbox">


                        <input type="checkbox" id="remember" name="remember" <?php if (isset($_COOKIE['remember_flag']) && $_COOKIE['remember_flag'] == 'on') { ?>checked="checked" <?php } ?>>
                        <label for="rm7">Remember me</label>

                        <a class="btn btn-link pull-right" href="<?php echo e(url('/admin/password/reset')); ?>">Reset Password?</a>
                    </div>
                </div>

                <div class="form-group text-center">

                    <button type="submit" class="btn btn-primary">
                        Login
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