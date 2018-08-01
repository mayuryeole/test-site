<?php $__env->startSection("meta"); ?>

<title>Update Role Permissions</title>

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
					<a href="javascript:void(0);">Manage Permissions for <?php echo e($role->name); ?> Role</span></a>
					
				</li>
                        </ul>
                       
                          <!-- BEGIN SAMPLE FORM PORTLET-->
            <div class="portlet box blue">
             <div class="portlet-title">
                        <div class="caption">
                                <i class="fa fa-gift"></i> Update Role Permissions
                        </div>

             </div>
            <div class="portlet-body form">
                <form method="post" role="form" class="form-inline">
                <?php echo csrf_field(); ?>

            <div class="panel panel-default">

                <?php foreach($permissions as $key=>$permission): ?>

                <?php if(!isset($curr_model) || $curr_model <> $permission->model): ?> 

                <?php if(isset($curr_model)): ?> </div> <?php endif; ?>

                <div class="panel-heading">
                    <h4> <?php echo e($curr_model=$permission->model); ?> </h4>
                </div>
    
                <div class="panel-body">

                <?php endif; ?>
                <div class="form-group">
                    <input type="checkbox" name="permission[]" value="<?php echo e($permission->id); ?>" <?php if($role_permissions->contains($permission->id)): ?> checked <?php endif; ?> id="<?php echo e($permission->slug); ?>" /> <label for="<?php echo e($permission->slug); ?>"><?php echo e($permission->name); ?></label>
                </div>

                <?php endforeach; ?>
                 </div>
	
        <div class="form-group">
            <div class="col-md-12">   
                <button type="submit" id="submit" class="btn btn-primary  pull-right" style="margin-right:400px;">Update Role</button><br>
            </div>
          </div>
            <div class="panel-heading">
                     <div class='clear'></div>
                </div>
         
    </form>
                 </div>
</div>
</div>
</div>
<style>
    .panel-default > .panel-heading
    {
        margin-top: 5px;
    }
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make(config("piplmodules.back-view-layout-location"), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>