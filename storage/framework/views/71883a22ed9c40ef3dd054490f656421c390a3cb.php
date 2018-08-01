<?php $__env->startSection("meta"); ?>

<title>Update Country Info</title>

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
					<a href="<?php echo e(url('admin/countries/list')); ?>">Manage Countries</a>
                                        <i class="fa fa-circle"></i>
					
				</li>
				<li>
					<a href="javascript:void(0);">Update Country</a>
					
				</li>
                        </ul>

  
    
      <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box blue">
             <div class="portlet-title">
                        <div class="caption">
                                <i class="fa fa-gift"></i> Update Country Info
                        </div>

             </div>
             <div class="portlet-body form">
              <form class="form-horizontal" role="form" action="" method="post" name="update_country" id="update_country" >
            
                 <?php echo csrf_field(); ?>

                 <div class="form-body">
                   <div class="row">
                        <div class="col-md-12">    
                      <div class="col-md-8">  
                         <div class="form-group">
                          <label class="col-md-6 control-label">Name<sup>*</sup></label>
                       
                            <div class="col-md-6">     
                           <input name="name" type="text" class="form-control" id="name" value="<?php echo e(old('name',$country_info->name)); ?>">
                            <?php if($errors->has('name')): ?>
                              <span class="help-block">
                                  <strong class="text-danger"><?php echo e($errors->first('name')); ?></strong>
                              </span>
                              <?php endif; ?>
                          </div>
                          </div>
                          <div class="form-group">
                              <label class="col-md-6 control-label">ISO 2<sup>*</sup></label>

                              <div class="col-md-6">
                                  <input name="iso" type="text" class="form-control" id="iso" value="<?php echo e(old('iso',$country_info->iso_code)); ?>">
                                  <?php if($errors->has('iso')): ?>
                                      <span class="help-block">
                                  <strong class="text-danger"><?php echo e($errors->first('iso')); ?></strong>
                              </span>
                                  <?php endif; ?>
                              </div>
                          </div>
                          <div class="form-group">
                              <label class="col-md-6 control-label">Digits<sup>*</sup></label>

                              <div class="col-md-6">
                                  <input name="digit" type="text" class="form-control" id="digit" value="<?php echo e(old('digit',$country_info->digit)); ?>">
                                  <?php if($errors->has('digit')): ?>
                                      <span class="help-block">
                                  <strong class="text-danger"><?php echo e($errors->first('digit')); ?></strong>
                              </span>
                                  <?php endif; ?>
                              </div>
                          </div>
                          <div class="form-group <?php if($errors->has('pattern')): ?> has-error <?php endif; ?>">
                              <label class="col-md-6 control-label">Code Pattern<sup>*</sup></label>
                              <div class="col-md-6">
                                  <label class="radio-inline"><input type="radio" name="pattern" value="0" <?php if($country_info->pattern ==0): ?> checked <?php endif; ?>>Numeric</label>
                                  <label class="radio-inline"><input type="radio" name="pattern" value="1" <?php if($country_info->pattern ==1): ?> checked <?php endif; ?>>Alphanumeric</label><br />

                              </div>
                              <?php if($errors->has('pattern')): ?> <span class="help-block"> <strong class="text-danger"><?php echo e($errors->first('pattern')); ?></strong> </span> <?php endif; ?>

                          </div>
                          <div class="form-group">
                         <div class="col-md-12">   
                            <button type="submit" id="submit" class="btn btn-primary  pull-right">Update</button>
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
        <style>
            .submit-btn{
                padding: 10px 0px 0px 18px;
            }
        </style>
 <?php $__env->stopSection(); ?>
<?php echo $__env->make(config("piplmodules.back-view-layout-location"), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>