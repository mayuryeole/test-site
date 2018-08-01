<?php $__env->startSection("meta"); ?>

<title>Create Role</title>

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
					<a href="<?php echo e(url('admin/manage-roles')); ?>">Manage Roles</a>
                                        <i class="fa fa-circle"></i>
					
				</li>
				<li>
					<a href="javascript:void(0);">Create A Role</a>
					
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
                                <i class="fa fa-gift"></i> Create A Role
                        </div>

             </div>
             <div class="portlet-body form">
              <form id="create-role" role="form" class="form-horizontal" action="<?php echo e(url('/admin/roles/create')); ?>" method="post" >
               
                <?php echo csrf_field(); ?>

                <div class="form-body">
                <div class="row">
                    <div class="col-md-12">    
                      <div class="col-md-8">     
                      <div class="form-group">
                          <label class="col-md-6 control-label">Name<sup>*</sup></label>
                       
                          <div class="col-md-6">     
                         <input name="name" type="text" class="form-control" id="name" value="<?php echo e(old('name')); ?>">
                          <?php if($errors->has('name')): ?>
                            <span class="help-block">
                                <strong class="text-danger"><?php echo e($errors->first('name')); ?></strong>
                            </span>
                            <?php endif; ?>
                        </div>
                       
                  </div>
                   
                  <div class="form-group">
                        <label class="col-md-6 control-label">Slug<sup>*</sup></label>
                         <div class="col-md-6">         
                           <input type="text" class="form-control" id="slug" name="slug" value="<?php echo e(old('slug')); ?>">
                           <?php if($errors->has('slug')): ?>
                            <span class="help-block">
                                <strong class="text-danger"><?php echo e($errors->first('slug')); ?></strong>
                            </span>
                            <?php endif; ?>
                        </div>
                  </div>
                   <div class="form-group">
                        <label class="col-md-6 control-label">Description</label>
                       
                         <div class="col-md-6">     
                            <textarea class="form-control" id="description" name="description"><?php echo e(old('description')); ?></textarea>
             
                        </div>
                  </div>
                          
                          <input type="hidden" name="level" value="1">
                
<!--                  <div class="form-group">
                        <label class="col-md-6 control-label">Level</label>
                        <div class="col-md-6">         
                                  <select class="form-control" id="level" name="level">
                                    <?php for($i=1;$i<=10;$i++): ?>
                                    <option value="<?php echo e($i); ?>" <?php if(old('level')==$i): ?> selected <?php endif; ?>>Level <?php echo e($i); ?></option>
                                    <?php endfor; ?>

                                 </select>
                         
                        </div>
                  </div>-->
                   <div class="form-group">
                         <div class="col-md-12">   
                            <button type="submit" id="submit" class="btn btn-primary  pull-right">Create Role</button>
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
        $(function () {

        });
    </script>
 <?php $__env->stopSection(); ?>
<?php echo $__env->make(config("piplmodules.back-view-layout-location"), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>