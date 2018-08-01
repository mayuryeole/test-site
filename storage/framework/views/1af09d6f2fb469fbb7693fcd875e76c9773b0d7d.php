<?php $__env->startSection("meta"); ?>

<title>Update Admin User Profile</title>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="page-content-wrapper">
    <div class="page-content">

        <!-- BEGIN PAGE BREADCRUMB -->
        <ul class="page-breadcrumb breadcrumb hide">
            <li>
                <a href="<?php echo e(url('admin/dashboard')); ?>">Home</a><i class="fa fa-circle"></i>
            </li>
            <li class="active">
                Dashboard
            </li>
        </ul>

        <!-- BEGIN PAGE BREADCRUMB -->
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <a href="<?php echo e(url('admin/dashboard')); ?>">Dashboard</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="<?php echo e(url('admin/admin-users')); ?>">Manage Admin users</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="javascript:void(0);">Update Admin User Profile</a>
            </li>
        </ul>
        <div class="profile-content">
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet light">
                        <div class="portlet-title tabbable-line">
                            <div class="caption caption-md">
                                <i class="icon-globe theme-font hide"></i>
                                <span class="caption-subject font-blue-madison bold uppercase">Update Admin User Profile</span>
                            </div>
                            <ul class="nav nav-tabs">
                                <li class="<?php if(!($errors->has('email') || $errors->has('confirm_email')|| $errors->has('current_password')|| $errors->has('new_password') || $errors->has('confirm_password') || session('password-update-fail'))): ?> active <?php endif; ?>">
                                    <a href="#tab_1_1" data-toggle="tab">Personal Information</a>
                                </li>
                                <li class="<?php if($errors->has('email') || $errors->has('confirm_email')): ?> active <?php endif; ?>">
                                    <a href="#tab_1_3" data-toggle="tab">Change Email</a>
                                </li>
                                <li class="<?php if($errors->has('current_password')|| $errors->has('new_password') || $errors->has('confirm_password') || session('password-update-fail')!=''): ?> active <?php endif; ?>">
                                    <a href="#tab_1_2" data-toggle="tab">Change Password</a>
                                </li>

                            </ul>
                        </div>
                        <?php if(session('profile-updated')): ?>
                        <div class="alert alert-success">
                            <?php echo e(session('profile-updated')); ?>

                            <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                        </div>
                        
                        <?php endif; ?>
                        <?php if(session('password-update-fail')): ?>
                        <div class="alert alert-danger">
                            <?php echo e(session('password-update-fail')); ?>

                        </div>
                        <?php endif; ?>
                        <div class="portlet-body">
                            <div class="tab-content">
                                <!-- PERSONAL INFO TAB -->
                                <div class="tab-pane <?php if(!($errors->has('email') || $errors->has('confirm_email')|| $errors->has('current_password')|| $errors->has('new_password') || $errors->has('confirm_password') || session('password-update-fail'))): ?> active <?php endif; ?>" id="tab_1_1">
                                    <form name="update_profile"  id="update_profile" role="form" method="POST" action="<?php echo e(url('/admin/update-admin-user/'.$user_info->id)); ?>">
                                        <?php echo csrf_field(); ?>

                                        <div class="form-group<?php echo e($errors->has('first_name') ? ' has-error' : ''); ?>">
                                            <label class="control-label">First Name <sup style='color:red;'>*</sup></label>

                                            <input type="text" class="form-control" name="first_name" value="<?php echo e(old('first_name',$user_info->userInformation->first_name)); ?>">
                                            <?php if($errors->has('first_name')): ?>
                                            <span class="help-block">
                                                <strong><?php echo e($errors->first('first_name')); ?></strong>
                                            </span>
                                            <?php endif; ?>

                                        </div>

                                        <div class="form-group<?php echo e($errors->has('last_name') ? ' has-error' : ''); ?>">
                                            <label class="control-label">Last Name <sup style='color:red;'>*</sup></label>

                                            <input type="text" class="form-control" name="last_name" value="<?php echo e(old('last_name',$user_info->userInformation->last_name)); ?>">
                                            <?php if($errors->has('last_name')): ?>
                                            <span class="help-block">
                                                <strong><?php echo e($errors->first('last_name')); ?></strong>
                                            </span>
                                            <?php endif; ?>

                                        </div>

                                        <div class="form-group<?php echo e($errors->has('user_mobile') ? ' has-error' : ''); ?>">
                                            <label class="control-label">Mobile No.<sup style='color:red;'>*</sup></label>

                                            <input type="text" class="form-control" name="user_mobile" value="<?php echo e(old('user_mobile',$user_info->userInformation->user_mobile)); ?>">
                                            <?php if($errors->has('user_mobile')): ?>
                                            <span class="help-block">
                                                <strong><?php echo e($errors->first('user_mobile')); ?></strong>
                                            </span>
                                            <?php endif; ?>

                                        </div>
                                        
                                        <div class="form-group<?php echo e($errors->has('gender') ? ' has-error' : ''); ?>">
                                            <label class="control-label">Gender <sup style='color:red;'>*</sup> </label>

                                            <select class="form-control" name="gender" id="gender">
                                                <option value=""  >--Select--</option>
                                                <option value="1" <?php if($user_info->userInformation->gender==1): ?> selected=selected <?php endif; ?> >Male</option>
                                                <option value="2" <?php if($user_info->userInformation->gender==2): ?> selected=selected <?php endif; ?> >Female</option>

                                            </select>
                                            <?php if($errors->has('gender')): ?>
                                            <span class="help-block">
                                                <strong><?php echo e($errors->first('gender')); ?></strong>
                                            </span>
                                            <?php endif; ?>

                                        </div>
                                         <div class="form-group<?php echo e($errors->has('user_status') ? ' has-error' : ''); ?>">
                                            <label class="control-label">Status<sup style='color:red;'>*</sup> </label>

                                            <select class="form-control" name="user_status" id="user_status">
                                                <option value="">--Select Status--</option>
                                                <option value="0" <?php if($user_info->userInformation->user_status==0): ?> selected=selected <?php endif; ?>>Inactive</option>
                                                <option value="1" <?php if($user_info->userInformation->user_status==1): ?> selected=selected <?php endif; ?>>Active</option>
                                                <option value="2" <?php if($user_info->userInformation->user_status==2): ?> selected=selected <?php endif; ?>>Blocked</option>

                                            </select>
                                            <?php if($errors->has('user_status')): ?>
                                            <span class="help-block">
                                                <strong><?php echo e($errors->first('user_status')); ?></strong>
                                            </span>
                                            <?php endif; ?>

                                        </div>
                                      
                                         <div class="form-group<?php echo e($errors->has('gender') ? ' has-error' : ''); ?>">
                                            <label class="control-label">Role <sup style='color:red;'>*</sup> </label>

                                         <select class="form-control" id="role" name="role" >
                                            <?php foreach($roles as $role): ?>
                                                <option value="<?php echo e($role->id); ?>" <?php if($user_info->hasRole($role->slug)): ?> selected <?php endif; ?>><?php echo e($role->name); ?></option>
                                            <?php endforeach; ?>
                                            </select>
                                            <?php if($errors->has('role')): ?>
                                                            <span class="help-block">
                                                                <strong><?php echo e($errors->first('role')); ?></strong>
                                                            </span>
                                                <?php endif; ?>
                                         </div>       
                                        <div class="form-group<?php echo e($errors->has('about_me') ? ' has-error' : ''); ?>">
                                            <label class="control-label">About me</label>

                                            <textarea class="form-control" name="about_me"><?php echo e(old('about_me',$user_info->userInformation->about_me)); ?></textarea>

                                        </div>

                                        <div class="margiv-top-10">
                                            <input type="submit" class="btn green-haze" value="Save Changes">
                                            <a href="<?php echo e(url('/admin/admin-users')); ?>" class="btn default">
                                                Cancel 
                                            </a>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane <?php if($errors->has('email') || $errors->has('confirm_email')): ?>  active <?php endif; ?>" id="tab_1_3">
                                    <form name="update_email"  id="update_email" role="form" method="POST" action="<?php echo e(url('/admin/update-admin-user-email/'.$user_info->id)); ?>">
                                        <?php echo csrf_field(); ?>

                                        <div class="form-group">
                                            <label class="control-label">Current Email: </label>
                                            <label class="control-label"><?php echo e($user_info->email); ?></label>
                                        </div>
                                        <div class="form-group<?php echo e($errors->has('email') ? ' has-error' : ''); ?>">
                                            <label class="control-label">New Email</label>

                                            <input type="text" class="form-control" id="email" name="email" value="<?php echo e(old('email')); ?>">
                                            <?php if($errors->has('email')): ?>
                                            <span class="help-block">
                                                <strong><?php echo e($errors->first('email')); ?></strong>
                                            </span>
                                            <?php endif; ?>

                                        </div>
                                        <div class="form-group<?php echo e($errors->has('confirm_email') ? ' has-error' : ''); ?>">
                                            <label class="control-label">Confirm Email</label>
                                            <input type="text" class="form-control" id="confirm_email" name="confirm_email" value="<?php echo e(old('confirm_email')); ?>">
                                            <?php if($errors->has('confirm_email')): ?>
                                            <span class="help-block">
                                                <strong><?php echo e($errors->first('confirm_email')); ?></strong>
                                            </span>
                                            <?php endif; ?>

                                        </div>
                                        <div class="margiv-top-10">
                                            <input type="submit" class="btn green-haze" value="Change Email">
                                            <a href="<?php echo e(url('/admin/admin-users')); ?>" class="btn default">
                                                Cancel 
                                            </a>
                                        </div>
                                    </form>
                                </div>
                                <!-- CHANGE PASSWORD TAB -->
                                <div class="tab-pane <?php if($errors->has('current_password')|| $errors->has('new_password') || $errors->has('confirm_password') || session('password-update-fail')): ?> active <?php endif; ?>" id="tab_1_2">
                                    <form name="update_password"  id="update_password" role="form" method="POST" action="<?php echo e(url('/admin/update-admin-user-password/'.$user_info->id)); ?>">
                                        <?php echo csrf_field(); ?>


                                      
                                        <div class="form-group<?php echo e($errors->has('new_password') ? ' has-error' : ''); ?>">
                                            <label class="control-label">New Password</label>

                                            <input type="password" class="form-control" id="new_password" name="new_password" value="<?php echo e(old('new_password')); ?>">
                                            <?php if($errors->has('new_password')): ?>
                                            <span class="help-block">
                                                <strong><?php echo e($errors->first('new_password')); ?></strong>
                                            </span>
                                            <?php endif; ?>
                                        </div>
                                        <div class="form-group<?php echo e($errors->has('confirm_password') ? ' has-error' : ''); ?>">
                                            <label class="control-label">Confirm Password</label>
                                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" value="<?php echo e(old('confirm_password')); ?>">
                                            <?php if($errors->has('confirm_password')): ?>
                                            <span class="help-block">
                                                <strong><?php echo e($errors->first('confirm_password')); ?></strong>
                                            </span>
                                            <?php endif; ?>

                                        </div>
                                        <div class="margiv-top-10">
                                            <input type="submit" class="btn green-haze" value="Change Password">
                                            <a href="<?php echo e(url('/admin/admin-users')); ?>" class="btn default">
                                                Cancel 
                                            </a>
                                        </div>
                                    </form>
                                </div>

                                <!-- END CHANGE PASSWORD TAB -->
                                <!-- PRIVACY SETTINGS TAB -->

                                <!-- END PRIVACY SETTINGS TAB -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END PAGE CONTENT INNER -->
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make(config("piplmodules.back-view-layout-location"), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>