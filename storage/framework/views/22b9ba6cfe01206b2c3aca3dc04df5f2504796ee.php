<?php $__env->startSection("meta"); ?>

<title>Create Admin user</title>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="page-content-wrapper">
		<div class="page-content">
                    <!-- BEGIN PAGE BREADCRUMB -->
			<ul class="page-breadcrumb breadcrumb">
				<li>
					<a href="<?php echo e(url('admin/dashboard')); ?>">Dashboard</a>
					<i class="fa fa-circle"></i>
				</li>
				<li>
					<a href="<?php echo e(url('admin/admin-users')); ?>">Manage Admin Users</a>
                                        <i class="fa fa-circle"></i>
					
				</li>
				<li>
					<a href="#">Create New User</a>
					
				</li>
                        </ul>
    <?php if(session('create-role-status')): ?>
          <div class="alert alert-success">
                <?php echo e(session('create-role-status')); ?>

                <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
          </div>
    <?php endif; ?>
    
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box blue">
             <div class="portlet-title">
                        <div class="caption">
                                <i class="fa fa-gift"></i> Create User
                        </div>

             </div>
             <div class="portlet-body form">
                 <form role="form" class="form-horizontal"  method="post" name="create_user" id="create_user" >
                  <input type='hidden' name='user_type' id='user_type' value='1'>
                <?php echo csrf_field(); ?>

                <div class="form-body">
                <div class="row">
                    <div class="col-md-12">    
                      <div class="col-md-8">     
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
                     <div class="form-group <?php echo e($errors->has('gender') ? ' has-error' : ''); ?>">
                        <label class="col-md-6 control-label">Gender <sup style='color:red;'>*</sup> </label>
                         <div class="col-md-6">    
                            <select class="form-control" name="gender" id="gender">
                             <option value="" >--Select--</option>
                             <option value="1"  <?php if(old("gender") === "1"): ?> selected <?php endif; ?>>Male</option>
                                <option value="2" <?php if(old("gender") === "2"): ?> selected <?php endif; ?>>Female</option>

                             </select>
                        
                        <?php if($errors->has('gender')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('gender')); ?></strong>
                        </span>
                        <?php endif; ?>
                         </div>
                     </div>
                  <div class="form-group <?php echo e($errors->has('user_mobile') ? ' has-error' : ''); ?>">
                        <label class="col-md-6 control-label">Mobile:<sup>*</sup></label>
                        <div class="col-md-6">  
                       <input type="text" class="form-control" id="user_mobile" name="user_mobile" value="<?php echo e(old('user_mobile')); ?>">
                        <?php if($errors->has('user_mobile')): ?>
                                 <span class="help-block">
                                    <strong><?php echo e($errors->first('user_mobile')); ?></strong>
                                 </span>
                          <?php endif; ?>
                  </div>
                  </div>
                   <div class="form-group <?php echo e($errors->has('role') ? ' has-error' : ''); ?>">
                        <label class="col-md-6 control-label">Role:<sup>*</sup></label>
                         <div class="col-md-6">  
                        <select class="form-control" name='role' id="role" >
                             <option value="" >--Select--</option>
                        <?php foreach($roles as $role): ?>
                        <?php if($role->slug!='registereduser' && $role->slug!='businessuser'): ?>
                            <option value="<?php echo e($role->id); ?>" <?php if(old("role") == $role->id): ?> selected <?php endif; ?> ><?php echo e($role->name); ?></option>
                        <?php endif; ?>
                        <?php endforeach; ?>
                        </select>

                      <?php if($errors->has('role')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('role')); ?></strong>
                        </span>
                            <?php endif; ?>
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
<?php echo $__env->make(config("piplmodules.back-view-layout-location"), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>