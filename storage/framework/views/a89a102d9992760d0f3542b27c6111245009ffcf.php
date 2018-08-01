<?php $__env->startSection("meta"); ?>

<title>Update City</title>

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
					<a href="<?php echo e(url('admin/cities/list')); ?>">Manage Cities</a>
                                        <i class="fa fa-circle"></i>
					
				</li>
				<li>
					<a href="javascript:void(0);">Update City</a>
					
				</li>
                        </ul>
      <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box blue">
             <div class="portlet-title">
                        <div class="caption">
                                <i class="fa fa-gift"></i> Update city
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
                            <input name="name" type="text" class="form-control" id="name" value="<?php echo e(old('name',$city_info->name)); ?>">
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
                                    <input name="iso" type="text" class="form-control" id="iso" value="<?php echo e(old('iso',$city_info->iso_code)); ?>">
                                    <?php if($errors->has('iso')): ?>
                                        <span class="help-block">
                                  <strong class="text-danger"><?php echo e($errors->first('iso')); ?></strong>
                              </span>
                                    <?php endif; ?>
                                </div>

                            </div>
                        <div class="form-group">
                          <label class="col-md-6 control-label">Select Country<sup>*</sup></label>
                       
                            <div class="col-md-6">     
                                <select name="country" id="country" onchange="getAllStates(this.value)" class="form-control">
                                    <option value="" selected="">--Select--</option>
                            <?php foreach($countries as $country): ?>
                                <option value="<?php echo e($country->id); ?>" <?php if($country->id==$city->country_id): ?> selected <?php endif; ?>><?php echo e($country->name); ?></option>
                            <?php endforeach; ?>
                            </select>
                            <?php if($errors->has('country')): ?>
                                    <span class="help-block">
                                        <strong class="text-danger"><?php echo e($errors->first('country')); ?></strong>
                                    </span>
                            <?php endif; ?>
                          </div>
                       
                      </div>
                          <div class="form-group">
                          <label class="col-md-6 control-label">Select State<sup>*</sup></label>
                       
                            <div class="col-md-6">     
                            <select name="state" id="state" class="form-control">
                               <option value="">--Select--</option>
                                <?php foreach($states as $state): ?>
                                <option value="<?php echo e($state->id); ?>" <?php if($state->id==$city->state_id): ?> selected <?php endif; ?>><?php echo e($state->name); ?></option>
                                <?php endforeach; ?>
                            </select>
                            <?php if($errors->has('state')): ?>
                                    <span class="help-block">
                                        <strong class="text-danger"><?php echo e($errors->first('state')); ?></strong>
                                    </span>
                            <?php endif; ?>
                          </div>
                       
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
        <script>
            
        function getAllStates(country_id)
        {
            if(country_id!='' && country_id!=0)
            {
                $.ajax({
                   url:"<?php echo e(url('/admin/states/getAllStates')); ?>/"+country_id,
                   method:'get',
                   success:function(data)
                   {

                        $("#state").html(data);

                   }

                });
            }
        }
 </script>
        
 <?php $__env->stopSection(); ?>
  
<?php echo $__env->make(config("piplmodules.back-view-layout-location"), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>