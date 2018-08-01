<?php $__env->startSection('meta'); ?>
<title>User Registration</title>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<!-------------------------------------------------------REGISTRATION START------------------------------------------------------>
<section class="registration_blk fullHt">
	<div class="h-video">
         <video controls="false" loop autoplay>
            <source src="<?php echo e(url('/public/media/front/video/video_1.mp4')); ?>" type="video/mp4">
            <source src="<?php echo e(url('/public/media/front/video/video_1.ogg')); ?>" type="video/ogg">
            Your browser does not support the video tag.
        </video> 
    </div>
    <div class="container login_form">
        <form class="form_login" name="register_normal" id="register_normal" role="form" method="POST" action="<?php echo e(url('/register')); ?>">
            <?php echo csrf_field(); ?>

            <input type='hidden' name='user_type' id='user_type' value="<?php echo e($user_type); ?>">
            <input  type='hidden' name='country_flag' id='country_flag' value="<?php echo e($flag); ?>">
            <div class="top_heading">
                Sign Up
                <span>welcome to <strong>Paras Fashions</strong> sign-up form! <br />
                    Please fill in these boxes so we can get started...</span>
        
                <span style="font-style: italic">If you already have an account?<a href="<?php echo e(url('/login')); ?>">Click Here!</a></span>
            </div>
            <?php if(session('otp-error')): ?>
            <div class="alert alert-danger">
                <?php echo e(session('otp-error')); ?>

                <a class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
            </div>
            <?php endif; ?>
            <div class="form-group">
                <div class="form-group<?php echo e($errors->has('first_name') ? ' has-error' : ''); ?>">
                    <input type="text" class="form-control" placeholder="First Name" name="first_name" value="<?php echo e(old('first_name')); ?>" />
                    <?php if($errors->has('first_name')): ?>
                    <span class="help-block">
                        <p><?php echo e($errors->first('first_name')); ?></p>
                    </span>
                    <?php endif; ?>
                </div>
            </div>
            <div class="form-group">
                <div class="form-group<?php echo e($errors->has('last_name') ? ' has-error' : ''); ?>">
                    <input type="text" class="form-control" placeholder="Last Name" name="last_name" value="<?php echo e(old('last_name')); ?>" />
                    <?php if($errors->has('last_name')): ?>
                    <span class="help-block">
                        <p><?php echo e($errors->first('last_name')); ?></p>
                    </span>
                    <?php endif; ?>
                </div>
            </div>
            <div class="form-group relative manage-stat stat-msg-manage <?php echo e($errors->has('email') ? ' has-error' : ''); ?>">
                <input title="Verification will be sent on this email. This will be used as your Username." type="email" class="form-control" placeholder="Enter Email Id" id="email" name="email" value="<?php echo e(old('email')); ?>" />
                
                <?php if($errors->has('email')): ?>
                <span class="help-block">
                    <p><?php echo e($errors->first('email')); ?></p>
                </span>
                <?php endif; ?>
            </div>
            <div class="form-group relative manage-stat stat-msg-manage <?php echo e($errors->has('password') ? ' has-error' : ''); ?>">
                <input type="password" title="Password should contain at least 6 characters." id="password" name="password" class="form-control" placeholder="Enter Password"  />
                <label class="show_pass"><input type="checkbox" onchange="document.getElementById('password').type = this.checked ? 'text' : 'password'"> <i class="fa fa-eye"></i></label>
                <?php if($errors->has('password')): ?>
                <span class="help-block">
                    <p><?php echo e($errors->first('password')); ?></p>
                </span>
                <?php endif; ?>
            </div>
            <div class="form-group relative manage-stat stat-msg-manage<?php echo e($errors->has('password_confirmation') ? ' has-error' : ''); ?>">
                <input type="password" title="Click on eye-image to see your entered password." class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password"/>
                <label class="show_pass"><input type="checkbox" onchange="document.getElementById('password_confirmation').type = this.checked ? 'text' : 'password'"> <i class="fa fa-eye"></i></label>
               <?php if($errors->has('password_confirmation')): ?>
                <span class="help-block">
                    <p><?php echo e($errors->first('password_confirmation')); ?></p>
                </span>
                <?php endif; ?>

                
            </div>
<?php /*<!--                <div class="form-group relative">*/ ?>
                    <?php /*<div class="form-group <?php echo e($errors->has('gender') ? ' has-error' : ''); ?>">*/ ?>
                        <?php /*<select class="form-control" name="gender" id="gender">*/ ?>
                            <?php /*<option value="" >Select Gender</option>*/ ?>
                            <?php /*<option value="1"  <?php if(old("gender") === "1"): ?> selected <?php endif; ?>>Male</option>*/ ?>
                            <?php /*<option value="2" <?php if(old("gender") === "2"): ?> selected <?php endif; ?>>Female</option>*/ ?>
                        <?php /*</select>*/ ?>
                        <?php /*<?php if($errors->has('gender')): ?>*/ ?>
                        <?php /*<span class="help-block">*/ ?>
                            <?php /*<p><?php echo e($errors->first('gender')); ?></p>*/ ?>
                        <?php /*</span>*/ ?>
                        <?php /*<?php endif; ?>*/ ?>
                        <?php /*<span class="drop_icon"><i class="fa fa-angle-down"></i></span>*/ ?>
                    <?php /*</div>*/ ?>
                <?php /*</div>-->*/ ?>
                <div class="form-group relative">
                    <div class="form-group<?php echo e($errors->has('user_country') ? ' has-error' : ''); ?>">
                        <?php $countries = App\PiplModules\admin\Models\Country::all(); ?>
                        <select name="user_country" id="user_country" class="form-control">
                        <!--<select name="user_country" id="user_country" class="form-control" >-->

                            <option value="">Select Your Location</option> 
                            <?php foreach($countries as $country): ?>
                            <option value="<?php echo e($country->id); ?>" <?php if(old('country')==$country->id): ?> selected <?php endif; ?>><?php echo e($country->name); ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?php if($errors->has('user_country')): ?>
                        <span class="help-block">
                            <p><?php echo e($errors->first('user_country')); ?></p>
                        </span>
                        <?php endif; ?>
                        <span class="drop_icon"><i class="fa fa-angle-down"></i></span>
                    </div>
                </div>

                <div class="form-group relative">
                    <div class="form-group <?php echo e($errors->has('user_mobile') ? ' has-error' : ''); ?>">
                        <input type="tel" title="OTP will be sent on this mobile number for Verification (India only)." class="form-control" placeholder="Enter Mobile No." id="user_mobile" name="user_mobile" value="<?php echo e(old('user_mobile')); ?>" />
                        <?php if($errors->has('user_mobile')): ?>
                        <span class="help-block">
                            <p><?php echo e($errors->first('user_mobile')); ?></p>
                        </span>
                        <?php endif; ?>
                        <span style="color:orange;font-size: 14px;display:none; " id="no_mobile" name="no_mobile" >Please enter mobile number</span>
                    </div>
                </div>

                <?php if($user_type ==4): ?>
                <div class="business_user_fild">
                    <div class="form-group<?php echo e($errors->has('company_name') ? ' has-error' : ''); ?>">
                        <input type="text" name="company_name" class="form-control" placeholder="Company Name" value="<?php echo e(old('company_name')); ?>" />
                        <?php if($errors->has('company_name')): ?>
                        <span class="help-block">
                            <p><?php echo e($errors->first('company_name')); ?></p>
                        </span>
                        <?php endif; ?>
                    </div>
                    <div class="form-group<?php echo e($errors->has('company_type') ? ' has-error' : ''); ?>">
                        <input type="text" class="form-control" name="company_type" placeholder="Company Type" value="<?php echo e(old('company_type')); ?>" />
                        <?php if($errors->has('company_type')): ?>
                        <span class="help-block">
                            <p><?php echo e($errors->first('company_type')); ?></p>
                        </span>
                        <?php endif; ?>
                    </div>
                    
                    <div class="form-group<?php echo e($errors->has('addressline1') ? ' has-error' : ''); ?>">
                        <input type="text" name="addressline1" class="form-control" placeholder="Address Line 1" value="<?php echo e(old('addressline1')); ?>" />
                        <?php if($errors->has('addressline1')): ?>
                        <span class="help-block">
                            <p><?php echo e($errors->first('addressline1')); ?></p>
                        </span>
                        <?php endif; ?>
                    </div>

                    <div class="form-group<?php echo e($errors->has('addressline2') ? ' has-error' : ''); ?>">
                        <input type="text" name="addressline2" class="form-control" placeholder="Address Line 2" value="<?php echo e(old('addressline2')); ?>" />
                        <?php if($errors->has('addressline2')): ?>
                        <span class="help-block">
                            <p><?php echo e($errors->first('addressline2')); ?></p>
                        </span>
                        <?php endif; ?>
                    </div>
                    <div class="form-group<?php echo e($errors->has('pancard_no') ? ' has-error' : ''); ?>">
                        <input type="text" name="pancard_no" class="form-control" placeholder="Pan Card No" value="<?php echo e(old('pancard_no')); ?>" />
                        <?php if($errors->has('pancard_no')): ?>
                        <span class="help-block">
                            <p><?php echo e($errors->first('pancard_no')); ?></p>
                        </span>
                        <?php endif; ?>
                    </div>
                    <div class="form-group<?php echo e($errors->has('gst_no') ? ' has-error' : ''); ?>">
                        <input type="text" class="form-control" name="gst_no" placeholder="GST No" value="<?php echo e(old('gst_no')); ?>" />
                        <?php if($errors->has('gst_no')): ?>
                        <span class="help-block">
                            <p><?php echo e($errors->first('gst_no')); ?></p>
                        </span>
                        <?php endif; ?>
                    </div>
                    <div class="form-group<?php echo e($errors->has('tax_id') ? ' has-error' : ''); ?>">
                        <input type="text" name="tax_id" class="form-control" placeholder="Tax Id" value="<?php echo e(old('tax_id')); ?>" />
                        <?php if($errors->has('tax_id')): ?>
                        <span class="help-block">
                            <p><?php echo e($errors->first('tax_id')); ?></p>
                        </span>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>
                <button type="submit" class="login_btn" id="btn_register">
                    Register
                </button>
                <img id="btn_loader" style="display:none;" src="<?php echo e(url('public/media/front/images/loader.gif')); ?>">
                </form> 
    </div>
    <?php /*<div class="registration_images_block">*/ ?>
        <?php /*<ul class="text-center">*/ ?>
            <?php /*<li><img src="<?php echo e(url('/')); ?>/public/media/front/img/icon1.png" alt="image"/></li>                        */ ?>
            <?php /*<li><img src="<?php echo e(url('/')); ?>/public/media/front/img/icon2.jpg" alt="image"/></li>*/ ?>
            <?php /*<li><img src="<?php echo e(url('/')); ?>/public/media/front/img/icon4.jpg" alt="image"/></li>*/ ?>
            <?php /*<li><img src="<?php echo e(url('/')); ?>/public/media/front/img/icon4.png" alt="image"/></li>*/ ?>
            <?php /*<li><img src="<?php echo e(url('/')); ?>/public/media/front/img/icon3.jpg" alt="image"/></li>                        */ ?>
        <?php /*</ul>*/ ?>
    <?php /*</div>      */ ?>
</section>

<script>
    
    function validateMobile(id)
    {
        
    }
</script>    
<?php $__env->stopSection(); ?>
    
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>