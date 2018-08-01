<?php $__env->startSection("meta"); ?>

    <title>View Artist Appointment</title>

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
                    <a href="<?php echo e(url('admin/manage-artist-appointments')); ?>">Manage Artist Appointments</a>
                    <i class="fa fa-circle"></i>

                </li>
                <li>
                    <a href="javascript:void(0);">View Artist Appointment</a>

                </li>
            </ul>



            <!-- BEGIN SAMPLE FORM PORTLET-->
            <div class="portlet box blue">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-gift"></i> View Artist Appointment
                    </div>

                </div>
                <div class="portlet-body form">
                    <form class="form-horizontal cust-lable-manage" role="form" action="" method="post" >

                        <?php echo csrf_field(); ?>

                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Customer Name:</label>

                                        <div class="col-md-8">
                                            <label class="control-label"><?php echo e($ArtistAppointment->first_name.' '.$ArtistAppointment->last_name); ?></label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Artist Name:</label>
                                        <div class="col-md-8">
                                            <label class="control-label"><?php echo e($ArtistAppointment->getArtist->first_name.' '.$ArtistAppointment->getArtist->last_name); ?></label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Customer Email Id:</label>

                                        <div class="col-md-8">
                                            <label class="control-label"><?php echo e($ArtistAppointment->email); ?></label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Customer Mobile No:</label>

                                        <div class="col-md-8">
                                            <label class="control-label"><?php echo e($ArtistAppointment->mobile); ?></label>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Customer Country:</label>

                                        <div class="col-md-8">
                                            <label class="control-label"><?php echo e($ArtistAppointment->country); ?></label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Service Name:</label>
                                        <div class="col-md-8">
                                            <label class="control-label"><?php echo e($ArtistAppointment->service_name); ?></label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Service Price:</label>
                                        <div class="col-md-8">
                                            <label class="control-label"><?php echo e($ArtistAppointment->service_price); ?></label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Date:</label>
                                        <div class="col-md-8">
                                            <label class="control-label"><?php echo e($ArtistAppointment->date); ?></label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Description:</label>
                                        <div class="col-md-8 h-manage-description">
                                            <label class="control-label"><?php echo e($ArtistAppointment->description); ?></label>
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