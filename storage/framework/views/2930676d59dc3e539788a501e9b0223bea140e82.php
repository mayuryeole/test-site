<?php $__env->startSection('meta'); ?>
<title>User Login</title>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<section class="login_blk fullHt">
	<div class="h-video">
         <video controls="false" loop autoplay>
            <source src="<?php echo e(url('/public/media/front/video/video_1.mp4')); ?>" type="video/mp4">
            <source src="<?php echo e(url('/public/media/front/video/video_1.ogg')); ?>" type="video/ogg">
            Your browser does not support the video tag.
        </video> 
    </div>
    <div class="login_form">    	
        <div class="row">  
             <?php if(session('login-error')): ?>
                <div class="alert alert-danger">
                    <?php echo e(session('login-error')); ?>

                    <a class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                </div>
                <?php endif; ?>
                <?php if(session('register-success')): ?>
                <div class="alert alert-success">
                    <?php echo e(session('register-success')); ?>

                    <a href="#" style="background-color: white" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                </div>
                <?php endif; ?>
                <?php if(session('issue-profile')): ?>
                <div class="alert alert-danger">
                    <?php echo e(session('issue-profile')); ?>

                    <a href="#" style="background-color: white" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                </div>
                <?php endif; ?>
                <?php
                Session::forget("login-error");
                Session::forget("register-success");
                Session::forget("issue-profile");
                  
                ?>
                
            <div class="col-md-6 col-sm-6 col-xs-12">
               
                <form  id="form1" class="form_login" method="POST" action="<?php echo e(url('/business-login')); ?>">
                    <?php echo csrf_field(); ?>

                    
                    <div class="loger_img"><img src="public/media/front/img/man-white.png" alt="Image"/></div>
                    <div class="top_heading">Business User Login Here</div>
                    <div class="form-group">
                        <div class="form-group">
                            <?php if(isset($_COOKIE['business_email'])): ?>
                            <input type="text" class="form-control" placeholder="Enter Email Id  " name="business_email" value="<?php echo e($_COOKIE['business_email']); ?>"/>
 
                            <?php else: ?> 
                            <input type="text" class="form-control" placeholder="Enter Email Id " name="business_email" />
 
                            <?php if($errors->has('business_email')): ?>
                            <span class="help-block">
                                <p><?php echo e($errors->first('business_email')); ?></p>
                            </span>
                            <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-group">
                            <?php if(isset($_COOKIE['business_password'])): ?>
                            <input type="password" id="business_password" placeholder="Enter Password" name="business_password" value="<?php echo e($_COOKIE['business_password']); ?>" class="form-control"/>
                            <?php else: ?> 
                            <input type="password" class="form-control" placeholder="Enter Password" name="business_password">
                            <?php if($errors->has('business_password')): ?>
                            <span class="help-block">
                                <p><?php echo e($errors->first('business_password')); ?></p>
                            </span>
                            <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="form-group clearfix">
                        <div class="check_box pull-left">
                            <label>
                                <?php if(isset($_COOKIE['business_remember_flag'])&& $_COOKIE['business_remember_flag']=='on'): ?>
                                <input type="checkbox" id="business_remember" name="business_remember" value="on" checked="checked"> Remember me
                                <?php else: ?> 
                                <input type="checkbox" name="business_remember"> Remember Me
<!--                                <a class="btn btn-link" href="<?php echo e(url('/password/reset')); ?>">Forgot Your Password?</a>-->
                                <?php endif; ?>
                            </label>
                        </div>
                        <div class="forgot_pass pull-right"><a class="" href="<?php echo e(url('/password/reset')); ?>">Forgot Your Password?</a></div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="login_btn">Submit</button>
                    </div>
                    <div class="other_login text-center clearfix">
                       
                    </div>
                   
                    <p class="create_ac_link text-center add_pad"><a href="<?php echo e(url('/register/4')); ?>">Create an Account</a></p>
                </form>
            </div>

            <div class="col-md-6 col-sm-6 col-xs-12">
                <form id="form2" class="form_login customer_form" method="POST" action="<?php echo e(url('/customer-login')); ?>">
                    <?php echo csrf_field(); ?>

                    <div class="loger_img"><img src="public/media/front/img/team-white.png" alt="Image"/></div>
                    <div class="top_heading">Customer User Login Here</div>
                    <div class="form-group">
                        <div class="form-group">
                            <?php if(isset($_COOKIE['email'])): ?>
                            <input type="text" class="form-control" placeholder="Enter Email Id" name="email" value="<?php echo e($_COOKIE['email']); ?>"/>
                                                           <!--<span style="color: orange;font-size: 10px;margin-bottom: 5px; font-style: italic" >Your verified Email-Id</span>-->
 
                            <?php else: ?> 
                            <input type="text" class="form-control" placeholder="Enter Email Id " name="email" />
                                                           <!--<span style="color: orange;font-size: 10px;margin-bottom: 5px; font-style: italic" >Your verified Email-Id</span>-->
 
                            <?php if($errors->has('email')): ?>
                            <span class="help-block">
                                <p><?php echo e($errors->first('email')); ?></p>
                            </span>
                            <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-group">
                            <?php if(isset($_COOKIE['password'])): ?>
                            <input type="password" id="password" placeholder="Enter Password" name="password" value="<?php echo e($_COOKIE['password']); ?>" class="form-control"/>
                            <?php else: ?> 
                            <input type="password" class="form-control" placeholder="Enter Password" name="password">
                            <?php if($errors->has('password')): ?>
                            <span class="help-block">
                                <p><?php echo e($errors->first('password')); ?></p>
                            </span>
                            <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="form-group clearfix">
                        <div class="check_box pull-left">
                            <label>
                                <?php if(isset($_COOKIE['remember_flag'])&& $_COOKIE['remember_flag']=='on'): ?>
                                <input type="checkbox" id="remember" name="remember" value="on" checked="checked"> Remember me
                                <?php else: ?> 
                                <input type="checkbox" name="remember"> Remember Me
<!--                                <a class="btn btn-link" href="<?php echo e(url('/password/reset')); ?>">Forgot Your Password?</a>-->
                                <?php endif; ?>
                            </label>
                        </div>
                        <div class="forgot_pass pull-right"><a class="" href="<?php echo e(url('/password/reset')); ?>">Forgot Your Password?</a></div>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="login_btn">Submit</button>
                    </div>
                    <div class="other_login text-center clearfix">
                        <a href="<?php echo e(url('/auth/facebook')); ?>"><button type="button" class="login_fb"><i class="fa fa-facebook"></i> </button></a>
                        <a href="<?php echo e(url('/auth/google')); ?>"><button type="button" class="login_fb login_gmail"><i class="fa fa-google"></i></button></a>
                        <a href="<?php echo e(url('/auth/instagram')); ?>"><button type="button" class="login_fb login_twitter"><i class="fa fa-instagram"></i> </button></a>               
                    </div>
<!--                    <div class="other_login clearfix">
                        <a href="<?php echo e(url('/auth/facebook')); ?>"><button type="button" class="login_fb"><i class="fa fa-facebook"></i> Facebook</button></a>  
                        <a href="<?php echo e(url('/auth/google')); ?>"><button type="button" class="login_fb login_gmail"><i class="fa fa-google"></i> Google+</button></a>
                        <a href="<?php echo e(url('/auth/instagram')); ?>"><button type="button" class="login_fb login_twitter"><i class="fa fa-instagram"></i> Instagram</button></a>               
                    </div>-->
                    <p class="create_ac_link text-center"><a href="<?php echo e(url('/register/3')); ?>">Create an Account</a></p>
                </form>
            </div>
        </div>
    </div>
</section>
<!--<script>
    jQuery(document).ready(function() {
        jQuery("#form1").validate({
            rules: {
                password: {
                    required: true,
                    minlength: 6,
                },
                
                email: {
                    required: true,
                    email: true
                },
            },
            messages: {
                password: {
                    required: "Please provide a password",
                    minlength: "Your password must be at least 6 characters long"
                },
               
                email: "Please enter a valid email address",
            }
        });
        
        jQuery("#form2").validate({
            rules: {
                password: {
                    required: true,
                    minlength: 6,
                },
               
                email: {
                    required: true,
                    email: true
                },
            },
            messages: {
                password: {
                    required: "Please provide a password",
                    minlength: "Your password must be at least 6 characters long"
                },
              
                email: "Please enter a valid email address",
            }
        });
    });
</script>-->
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>