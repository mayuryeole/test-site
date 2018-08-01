<?php $__env->startSection("meta"); ?>

<title>Update User Profile</title>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/jquery/1/jquery.min.js"></script>
<!-- Include Date Range Picker -->
<script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />

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
                <a href="<?php echo e(url('admin/manage-users')); ?>">Manage  users</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="javascript:void(0);">Update  User Profile</a>
            </li>
        </ul>
        <div class="profile-content">
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet light">
                        <div class="portlet-title tabbable-line">
                            <div class="caption caption-md">
                                <i class="icon-globe theme-font hide"></i>
                                <span class="caption-subject font-blue-madison bold uppercase">Update User Profile</span>
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
                                    <form name="update_profile"  id="update_profile" role="form" method="post" action="<?php echo e(url('/admin/update-registered-user/'.$user_info->id)); ?>">
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
                                            <label class="control-label">User Mobile</label>

                                            <input type="text" class="form-control" name="user_mobile" value="<?php echo e(old('user_mobile',$user_info->userInformation->user_mobile)); ?>">
                                            <?php if($errors->has('user_mobile')): ?>
                                            <span class="help-block">
                                                <strong><?php echo e($errors->first('user_mobile')); ?></strong>
                                            </span>
                                            <?php endif; ?>

                                        </div>
                                        <div class="form-group<?php echo e($errors->has('birth_date') ? ' has-error' : ''); ?>">
                                            <label class="control-label">Birth Date: </label>
                                            <input type="text" class="form-control"  name="birth_date" id="birth_date" value="<?php echo e(old('birth_date',$user_info->userInformation->birth_date)); ?>">
                            <?php if($errors->has('birth_date')): ?>
                            <span class="help-block">
                                <p><?php echo e($errors->first('birth_date')); ?></p>
                            </span>
                            <?php endif; ?>
                        
                    </div>
                                        <div class="form-group<?php echo e($errors->has('anniversary_date') ? ' has-error' : ''); ?>">
                                            <label class="control-label">Anniversary Date: </label>
                                            <input type="text" class="form-control"  name="anniversary_date" id="anniversary_date" value="<?php echo e(old('anniversary_date',$user_info->userInformation->anniversary_date)); ?>">
                            <?php if($errors->has('anniversary_date')): ?>
                            <span class="help-block">
                                <p><?php echo e($errors->first('anniversary_date')); ?></p>
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
                                        
                                        <?php if($user_info->userInformation->user_type==4): ?>
                                        <div class="form-group<?php echo e($errors->has('company_name') ? ' has-error' : ''); ?>">
                                            <label class="control-label">Company Name</label>

                                            <input type="text" class="form-control" name="company_name" value="<?php echo e(old('company_name',$user_info->userInformation->company_name)); ?>">
                                            <?php if($errors->has('company_name')): ?>
                                            <span class="help-block">
                                                <strong><?php echo e($errors->first('company_name')); ?></strong>
                                            </span>
                                            <?php endif; ?>

                                        </div>
                                        <div class="form-group<?php echo e($errors->has('company_type') ? ' has-error' : ''); ?>">
                                            <label class="control-label">Company Type</label>

                                            <input type="text" class="form-control" name="company_type" value="<?php echo e(old('company_type',$user_info->userInformation->company_type)); ?>">
                                            <?php if($errors->has('company_type')): ?>
                                            <span class="help-block">
                                                <strong><?php echo e($errors->first('company_type')); ?></strong>
                                            </span>
                                            <?php endif; ?>

                                        </div>
                                        
                                        <div class="form-group<?php echo e($errors->has('pan_card_number') ? ' has-error' : ''); ?>">
                                            <label class="control-label">Pan Card Number </label>
                                            <input type="text" class="form-control" name="pan_card_number" value="<?php echo e(old('pan_card_number',$user_info->userInformation->panacard_no)); ?>">
                                            <?php if($errors->has('pan_card_number')): ?>
                                            <span class="help-block">
                                                <strong><?php echo e($errors->first('pan_card_number')); ?></strong>
                                            </span>
                                            <?php endif; ?>
                                        </div>

                                        <div class="form-group<?php echo e($errors->has('addressline1') ? ' has-error' : ''); ?>">
                                            <label class="control-label">Address Line 1 </label>
                                            <input type="text" name="addressline1" class="form-control" value="<?php if(isset($user_info->userAddress->address1) && $user_info->userAddress->address1!=''): ?><?php echo e(old('addressline1',$user_info->userAddress->address1)); ?><?php endif; ?>" />
                                            <?php if($errors->has('addressline1')): ?>
                                            <span class="help-block">
                                                <p><?php echo e($errors->first('addressline1')); ?></p>
                                            </span>
                                            <?php endif; ?>
                                        </div>
                                        <div class="form-group<?php echo e($errors->has('addressline2') ? ' has-error' : ''); ?>">
                                             <label class="control-label">Address Line 2 </label>
                                            <input type="text" name="addressline2" class="form-control" value="<?php if(isset($user_info->userAddress->address2) && $user_info->userAddress->address2!=''): ?><?php echo e(old('addressline2',$user_info->userAddress->address2)); ?><?php endif; ?>" />
                                            <?php if($errors->has('addressline2')): ?>
                                            <span class="help-block">
                                                <p><?php echo e($errors->first('addressline2')); ?></p>
                                            </span>
                                            <?php endif; ?>
                                        </div>
                                        
                                        <div class="form-group<?php echo e($errors->has('gst_no') ? ' has-error' : ''); ?>">
                                            <label class="control-label">GST Number</label>

                                            <input type="text" class="form-control" name="gst_no" value="<?php echo e(old('gst_no', $user_info->userInformation->gst_no)); ?>">
                                            <?php if($errors->has('gst_no')): ?>
                                            <span class="help-block">
                                                <strong><?php echo e($errors->first('gst_no')); ?></strong>
                                            </span>
                                            <?php endif; ?>

                                        </div>
                                        
                                        <div class="form-group<?php echo e($errors->has('tax_id') ? ' has-error' : ''); ?>">
                                            <label class="control-label">Tax Number </label>

                                            <input type="text" class="form-control" name="tax_id" value="<?php if(isset($user_info->userInformation->tax_id) && $user_info->userInformation->tax_id!=''): ?><?php echo e($user_info->userInformation->tax_id); ?><?php endif; ?>">
                                            <?php if($errors->has('tax_id')): ?>
                                            <span class="help-block">
                                                <strong><?php echo e($errors->first('tax_id')); ?></strong>
                                            </span>
                                            <?php endif; ?>

                                        </div>
                                        <?php endif; ?>
<!--                                        <div class="form-group<?php echo e($errors->has('user_type') ? ' has-error' : ''); ?>">
                                            <label class="control-label">User Type<sup style='color:red;'>*</sup> </label>

                                            <select class="form-control" name="user_type" id="user_type">
                                                <option value="">--Select User Type--</option>
                                                <option value="0" <?php if($user_info->userInformation->user_type==3): ?> selected=selected <?php endif; ?>>Customer</option>
                                                <option value="1" <?php if($user_info->userInformation->user_status==4): ?> selected=selected <?php endif; ?>>Business User</option>
                                
                                            </select>
                                            <?php if($errors->has('user_type')): ?>
                                            <span class="help-block">
                                                <strong><?php echo e($errors->first('user_type')); ?></strong>
                                            </span>
                                            <?php endif; ?>

                                        </div>-->
                                        
                                        
                                        
<!--                                        <div class="form-group<?php echo e($errors->has('gender') ? ' has-error' : ''); ?>">
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

                                        </div>-->
                                        <div class="form-group<?php echo e($errors->has('about_me') ? ' has-error' : ''); ?>">
                                            <label class="control-label">About me</label>

                                            <textarea class="form-control" name="about_me"><?php echo e(old('about_me',$user_info->userInformation->about_me)); ?></textarea>

                                        </div>

                                        <div class="margiv-top-10">
                                            <input type="submit" class="btn green-haze" value="Save Changes">
                                            <a href="<?php echo e(url('admin/manage-users')); ?>" class="btn default">
                                                Cancel 
                                            </a>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane <?php if($errors->has('email') || $errors->has('confirm_email')): ?>  active <?php endif; ?>" id="tab_1_3">
                                    <form name="update_email"  id="update_email" role="form" method="POST" action="<?php echo e(url('/admin/update-registered-user-email/'.$user_info->id)); ?>">
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
                                            <a href="<?php echo e(url('admin/manage-users')); ?>" class="btn default">
                                                Cancel 
                                            </a>
                                        </div>
                                    </form>
                                </div>
                                <!-- CHANGE PASSWORD TAB -->
                                <div class="tab-pane <?php if($errors->has('current_password')|| $errors->has('new_password') || $errors->has('confirm_password') || session('password-update-fail')): ?> active <?php endif; ?>" id="tab_1_2">
                                    <form name="update_password"  id="update_password" role="form" method="POST" action="<?php echo e(url('/admin/update-registered-user-password/'.$user_info->id)); ?>">
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
                                            <a href="<?php echo e(url('admin/manage-users')); ?>" class="btn default">
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

<script>
    
    $(document).ready(function() {
//        alert(1);
            $("input#birth_date").singleDatePicker();
              
       
          });

          $.fn.singleDatePicker = function() {
                var today = new Date();
                var dd = today.getDate();
                var mm = today.getMonth()+1; //January is 0!
                alert()
                var yyyy = today.getFullYear();
                alert(yyyy);
                var user_date='';
                if(mm<0){
                user_date =  yyyy+'-0'+mm + '-' + dd ;
            }
            else{
                user_date =  yyyy+'-'+mm + '-' + dd ;
            }
                
//                alert(yyyy)
            
//            alert(birth_date);
            $(this).on("apply.daterangepicker", function(e, picker) {
              picker.element.val(picker.startDate.format(picker.locale.format));
            });
            return $(this).daterangepicker({
                locale: {
      format: 'YYYY-MM-DD'
    },
    
//            startDate: start,
        maxDate: user_date,
                 showDropdowns: true,
              singleDatePicker: true,
              autoUpdateInput: false
            });
          };



    </script>
    <script>
        $(document).ready(function() {
         $("input#anniversary_date").singleDatePicker();
     });
        $.fn.singleDatePicker = function() {
              var today = new Date();
                var dd = today.getDate();
                var mm = today.getMonth()+1; //January is 0!
                
                var yyyy = today.getFullYear();
                
                var user_anni_date='';
                if(mm<0){
                user_anni_date =  yyyy+'-0'+mm + '-' + dd ;
            }
            else{
                user_anni_date =  yyyy+'-'+mm + '-' + dd ;
            }
                
//                alert(yyyy)
            
//            alert(birth_date);
            $(this).on("apply.daterangepicker", function(e, picker) {
              picker.element.val(picker.startDate.format(picker.locale.format));
            });
            return $(this).daterangepicker({
                locale: {
      format: 'YYYY-MM-DD'
    },
    
//            startDate: start,
        maxDate:user_anni_date,
                 showDropdowns: true,
              singleDatePicker: true,
              autoUpdateInput: false
            });
          };
        </script>
   
<?php $__env->stopSection(); ?>

<?php echo $__env->make(config("piplmodules.back-view-layout-location"), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>