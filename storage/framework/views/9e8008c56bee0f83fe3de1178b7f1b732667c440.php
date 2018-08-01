<?php $__env->startSection("meta"); ?>

<title>Create User</title>

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
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <a href="<?php echo e(url('admin/dashboard')); ?>">Dashboard</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="<?php echo e(url('admin/manage-users')); ?>">Manage Users</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="javascript:void(0)">Create New User</a>

            </li>
        </ul>

        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-gift"></i> Create User
                </div>

            </div>
            <div class="portlet-body form">
                <form class="form-horizontal"  method="post" name="create_user" id="create_user_register" >
                    <?php echo csrf_field(); ?>

                    <input type='hidden' name='user_type' id='user_type'>
                    <!--<input type='hidden' name='otp_status' id='otp_status' value="1">-->
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-12">    
                                <div class="col-md-8">   
                                    <div class="form-group <?php echo e($errors->has('user') ? ' has-error' : ''); ?>">
                                        <label class="col-md-6 control-label">Select User Type:<sup>*</sup></label>

                                        <div class="col-md-6">     
                                            <select class="form-control" name="user" id="user" onchange="selectUser(this.value)">
                                                <option value=""  >--Select--</option>
                                                <option id="Customer_user" value="3">Customer User</option>
                                                <option id="Business_user" value="4">Business User</option>
                                            </select>
                                            <!--<input type="hidden" id='' name='user_type' value="">-->
                                            <?php if($errors->has('user_type')): ?>
                                            <span class="help-block">
                                                <strong><?php echo e($errors->first('user')); ?></strong>
                                            </span>
                                            <?php endif; ?>
                                        </div>

                                    </div>
                                   
                                    <div class="form-group <?php echo e($errors->has('first_name') ? ' has-error' : ''); ?>">
                                        <label class="col-md-6 control-label">First Name:<sup>*</sup></label>

                                        <div class="col-md-6">     
                                            <input name="first_name" type="text" class="form-control" id="first_name" value="<?php echo e(old('first_name')); ?>">
                                            <?php if($errors->has('first_name')): ?>
                                            <span class="help-block">
                                                <strong><?php echo e($errors->first('first_name')); ?></strong>
                                            </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <div class="form-group <?php echo e($errors->has('last_name') ? ' has-error' : ''); ?>">
                                        <label class="col-md-6 control-label">Last Name:<sup>*</sup></label>
                                        <div class="col-md-6">         
                                            <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo e(old('last_name')); ?>">

                                            <?php if($errors->has('last_name')): ?>
                                            <span class="help-block">
                                                <strong><?php echo e($errors->first('last_name')); ?></strong>
                                            </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="form-group <?php echo e($errors->has('email') ? ' has-error' : ''); ?>">
                                        <label class="col-md-6 control-label">Email:<sup>*</sup></label>
                                        <div class="col-md-6">      
                                            <input type="email" class="form-control" id="email" name="email" value="<?php echo e(old('email')); ?>">
                                            <?php if($errors->has('email')): ?>
                                            <span class="help-block">
                                                <strong><?php echo e($errors->first('email')); ?></strong>
                                            </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="form-group <?php echo e($errors->has('password') ? ' has-error' : ''); ?>">
                                        <label class="col-md-6 control-label">Password:<sup>*</sup></label>
                                        <div class="col-md-6">    
                                            <input type="Password" class="form-control" id="password" name="password" value="<?php echo e(old('password')); ?>">
                                            <?php if($errors->has('password')): ?>
                                            <span class="help-block">
                                                <strong><?php echo e($errors->first('password')); ?></strong>
                                            </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="form-group <?php echo e($errors->has('password_confirmation') ? ' has-error' : ''); ?>">
                                        <label class="col-md-6 control-label">Confirm Password:<sup>*</sup></label>
                                        <div class="col-md-6">    
                                            <input type="Password" class="form-control" id="password_confirmation" name="password_confirmation" value="<?php echo e(old('password_confirmation')); ?>">
                                            <?php if($errors->has('password_confirmation')): ?>
                                            <span class="help-block">
                                                <strong><?php echo e($errors->first('password_confirmation')); ?></strong>
                                            </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
<!--                                    <div class="form-group <?php echo e($errors->has('gender') ? ' has-error' : ''); ?>">
                                        <label class="col-md-6 control-label">Gender <sup style='color:red;'>*</sup> </label>
                                        <div class="col-md-6">    
                                            <select class="form-control" name="gender" id="gender">
                                                <option value=""  >--Select--</option>
                                                <option value="1" <?php if(old("gender") === "1"): ?> selected <?php endif; ?>>Male</option>
                                                <option value="2" <?php if(old("gender") === "1"): ?> selected <?php endif; ?>>Female</option>

                                            </select>

                                            <?php if($errors->has('gender')): ?>
                                            <span class="help-block">
                                                <strong><?php echo e($errors->first('gender')); ?></strong>
                                            </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>-->
                                    <div class="form-group <?php echo e($errors->has('user_mobile') ? ' has-error' : ''); ?>">
                                        <label class="col-md-6 control-label">Mobile:</label>
                                        <div class="col-md-6">  
                                            <input type="text" class="form-control" id="user_mobile" name="user_mobile" value="<?php echo e(old('user_mobile')); ?>">
                                            <?php if($errors->has('user_mobile')): ?>
                                            <span class="help-block">
                                                <strong><?php echo e($errors->first('user_mobile')); ?></strong>
                                            </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>

<!--                                    <div class="form-group<?php echo e($errors->has('birth_date') ? ' has-error' : ''); ?>">
                                            <label class="col-md-6 control-label">Birth Date: </label>
                                            <div class="col-md-6">
                                            <input type="text" class="form-control"  name="birth_date" id="birth_date" value="<?php echo e(old('birth_date')); ?>">
                            <?php if($errors->has('birth_date')): ?>
                            <span class="help-block">
                                <p><?php echo e($errors->first('birth_date')); ?></p>
                            </span>
                            <?php endif; ?>
                                            </div>
                    </div>
                                        <div class="form-group<?php echo e($errors->has('anniversary_date') ? ' has-error' : ''); ?>">
                                            <label class="col-md-6 control-label">Anniversary Date: </label>
                                            <div class="col-md-6">
                                            <input type="text" class="form-control"  name="anniversary_date" id="anniversary_date" value="<?php echo e(old('birth_date')); ?>">
                            <?php if($errors->has('anniversary_date')): ?>
                            <span class="help-block">
                                <p><?php echo e($errors->first('anniversary_date')); ?></p>
                            </span>
                            <?php endif; ?>
                        
                    </div>
                                        </div>-->
                                <div class="business_user_detail" id="business_user_detail">
                                        <div class="form-group<?php echo e($errors->has('company_name') ? ' has-error' : ''); ?>">
                                            <label class="col-md-6 control-label">Company Name </label>
                                            <div class="col-md-6">
                                            <input type="text" class="form-control" name="company_name" value="<?php echo e(old('company_name')); ?>">
                                            <?php if($errors->has('company_name')): ?>
                                            <span class="help-block">
                                                <strong><?php echo e($errors->first('company_name')); ?></strong>
                                            </span>
                                            <?php endif; ?>
                                            </div>
                                        </div>
                                        <div class="form-group<?php echo e($errors->has('company_type') ? ' has-error' : ''); ?>">
                                            <label class="col-md-6 control-label">Company Type </label>
                                            <div class="col-md-6">
                                            <input type="text" class="form-control" name="company_type" value="<?php echo e(old('company_type')); ?>">
                                            <?php if($errors->has('company_type')): ?>
                                            <span class="help-block">
                                                <strong><?php echo e($errors->first('company_type')); ?></strong>
                                            </span>
                                            <?php endif; ?>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group<?php echo e($errors->has('pan_card_number') ? ' has-error' : ''); ?>">
                                            <label class="col-md-6 control-label">Pan Card Number </label>
                                            <div class="col-md-6">
                                            <input type="text" class="form-control" name="pan_card_number" value="<?php echo e(old('pan_card_number')); ?>">
                                            <?php if($errors->has('pan_card_number')): ?>
                                            <span class="help-block">
                                                <strong><?php echo e($errors->first('pan_card_number')); ?></strong>
                                            </span>
                                            <?php endif; ?>
                                            </div>
                                        </div>

                                        <div class="form-group<?php echo e($errors->has('addressline1') ? ' has-error' : ''); ?>">
                                            <label class="col-md-6 control-label">Address Line 1 </label>
                                            <div class="col-md-6">
                                            <input type="text" name="addressline1" class="form-control" value="<?php echo e(old('addressline1')); ?>" />
                                            <?php if($errors->has('addressline1')): ?>
                                            <span class="help-block">
                                                <p><?php echo e($errors->first('addressline1')); ?></p>
                                            </span>
                                            <?php endif; ?>
                                        </div>
                                        </div>
                                        <div class="form-group<?php echo e($errors->has('addressline2') ? ' has-error' : ''); ?>">
                                             <label class="col-md-6 control-label">Address Line 2 </label>
                                             <div class="col-md-6">
                                            <input type="text" name="addressline2" class="form-control" value="<?php echo e(old('addressline2')); ?>" />
                                            <?php if($errors->has('addressline2')): ?>
                                            <span class="help-block">
                                                <p><?php echo e($errors->first('addressline2')); ?></p>
                                            </span>
                                            <?php endif; ?>
                                        </div>
                                        </div>
                                        
                                        <div class="form-group<?php echo e($errors->has('gst_no') ? ' has-error' : ''); ?>">
                                            <label class="col-md-6 control-label">GST Number </label>
                                            <div class="col-md-6">
                                            <input type="text" class="form-control" name="gst_no" value="<?php echo e(old('gst_no')); ?>">
                                            <?php if($errors->has('gst_no')): ?>
                                            <span class="help-block">
                                                <strong><?php echo e($errors->first('gst_no')); ?></strong>
                                            </span>
                                            <?php endif; ?>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group<?php echo e($errors->has('tax_id') ? ' has-error' : ''); ?>">
                                            <label class="col-md-6 control-label">Tax Number </label>
                                            <div class="col-md-6">
                                            <input type="text" class="form-control" name="tax_id" value="<?php echo e(old('tax_id')); ?>">
                                            <?php if($errors->has('tax_id')): ?>
                                            <span class="help-block">
                                                <strong><?php echo e($errors->first('tax_id')); ?></strong>
                                            </span>
                                            <?php endif; ?>
                                            </div>
                                        </div>
                                </div>
                                
                                <div class="form-group">
                                    <div class="col-md-12">   
                                        <button type="submit" id="submit" class="btn btn-primary  pull-right">Create User</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

            </div>

            </form>
        </div>
    </div>
</div>
</div>

<?php $__env->stopSection(); ?>

<script>
    function selectUser(user) {
//        alert(user);
        if(user==3){
         $("#business_user_detail").hide();
            $('#user_type').val(user);
         
        }
        else if(user==4){
           $("#business_user_detail").show(); 
            $('#user_type').val(user);
        }
        else if(user==""){
         $("#business_user_detail").hide();
            $('#user_type').val(user);
         
        }
               
    }
</script>

    
   <script>
    
    $(document).ready(function() {
//        alert(1);
            $("input#birth_date").singleDatePicker();
               $("input#anniversary_date").singleDatePicker();
       
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
<?php echo $__env->make(config("piplmodules.back-view-layout-location"), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>