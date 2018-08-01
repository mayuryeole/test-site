<?php $__env->startSection("meta"); ?>

<title>Admin Dashboard</title>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="page-content-wrapper">
    <div class="page-content">

        <!-- BEGIN PAGE BREADCRUMB -->
        <ul class="page-breadcrumb breadcrumb hide">
            <li>
                <a href="#">Home</a><i class="fa fa-circle"></i>
            </li>
            <li class="active">
                Dashboard
            </li>
        </ul>
        <!-- END PAGE BREADCRUMB -->
        <!-- BEGIN PAGE CONTENT INNER -->
        <div class="row margin-top-10">
            <?php if(Auth::user()->hasPermission('view.admin-users')==true || Auth::user()->isSuperadmin()): ?>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="dashboard-stat2">
                    <div class="display clearfix">
                        <div class="number">
                            <h3 class="font-purple-soft"><?php echo e($admin_user_count); ?></h3>
                            <small>Admin USERS</small>
                        </div> 
                        <div class="icon">
                            <i class="icon-user"></i>
                        </div>
                    </div>
                    <div class="progress-info">
                        <div class="progress">
                            <span style="width: 100%;" class="progress-bar progress-bar-success purple-soft">

                            </span>
                        </div>
                        <div class="status">
                            <div class="status-title">
                                <a href="<?php echo e(url('/admin/admin-users')); ?>"> Click Here to see more </a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            <?php if(Auth::user()->hasPermission('view.registered-users')==true || Auth::user()->isSuperadmin()): ?>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="dashboard-stat2">
                    <div class="display">

                        <div class="number">
                            <small>Customer USERS</small>

                            <br><br>
                            <div style="color: white;">
                                Total Customer Users : <?php echo e($customer_users_count); ?><br>
                                Inactive Customer Users : <?php echo e($inactive_customer_users_count); ?><br>
                                Active Customer Users : <?php echo e($active_customer_users_count); ?><br>
                                Blocked Customer Users : <?php echo e($blocked_customer_users_count); ?>

                            </div>
                        </div>
                        <div class="icon i-user">
                            <i class="icon-user"></i>
                        </div>
                    </div>
                    <div class="progress-info">
                        <div class="progress">
                            <span style="width: 100%;" class="progress-bar progress-bar-success purple-soft">

                            </span>
                        </div>
                        <div class="status">
                            <div class="status-title">
                                <a href="<?php echo e(url('/admin/manage-users')); ?>"> Click Here to see more </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <?php endif; ?>

            <?php if(Auth::user()->hasPermission('view.registered-users')==true || Auth::user()->isSuperadmin()): ?>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="dashboard-stat2">
                    <div class="display">
                        <div class="number">
                            <small>Business USERS</small>
                            <br><br>
                            <div style="color: white;">
                                Total Business Users : <?php echo e($business_users_count); ?><br> 
                                Inactive Business Users : <?php echo e($inactive_business_users_count); ?><br>
                                Active Business Users : <?php echo e($active_business_users_count); ?><br>
                                Blocked Business Users : <?php echo e($blocked_business_users_count); ?> 
                            </div>
                        </div>
                        <div class="icon bi-user">
                            <i class="icon-user"></i>
                        </div>
                    </div>
                    <div class="progress-info">
                        <div class="progress">
                            <span style="width: 100%;" class="progress-bar progress-bar-success purple-soft">

                            </span>
                        </div>
                        <div class="status">
                            <div class="status-title">
                                <a href="<?php echo e(url('/admin/manage-users')); ?>"> Click Here to see more </a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make(config("piplmodules.back-view-layout-location"), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>