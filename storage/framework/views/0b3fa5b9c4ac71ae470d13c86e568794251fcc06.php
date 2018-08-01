<?php $__env->startSection("meta"); ?>

<title>View Appointment</title>

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
                <a href="<?php echo e(url('admin/manage-appointments')); ?>">Manage Appointment</a>
                <i class="fa fa-circle"></i>

            </li>
            <li>
                <a href="javascript:void(0);">View Appointment Detail</a>

            </li>
        </ul>
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-gift"></i> View Appointment
                </div>

            </div>
            <div class="portlet-body form">

                <div class="form-body">
                    <div class="row"> 
                        <div class="form-group clearfix ">
                            <label class="col-md-4 control-labels">Customer Name:</label>

                            <div class="col-md-8">     
                                <label class="apt-back"> <?php if(isset($appointment) && count($appointment)>0): ?> <?php if(!empty($appointment->customer->userInformation->first_name)): ?><?php echo e($appointment->customer->userInformation->first_name); ?> <?php endif; ?> <?php if(!empty($appointment->customer->userInformation->last_name)): ?> <?php echo e($appointment->customer->userInformation->last_name); ?> <?php endif; ?> <?php endif; ?></label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group clearfix ">
                            <label class="col-md-4 control-labels">Customer Email:</label>

                            <div class="col-md-8">
                                <label class="apt-back"> <?php if(isset($appointment) && count($appointment)>0): ?> <?php if(!empty($appointment->customer_email)): ?><?php echo e($appointment->customer_email); ?> <?php endif; ?> <?php endif; ?></label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group clearfix ">
                            <label class="col-md-4 control-labels">Customer Mobile No:</label>

                            <div class="col-md-8">
                                <label class="apt-back"> <?php if(isset($appointment) && count($appointment)>0): ?> <?php if(!empty($appointment->customer_phone)): ?><?php echo e($appointment->customer_phone); ?> <?php endif; ?> <?php endif; ?></label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group clearfix ">
                            <label class="col-md-4 control-labels">Customer Country:</label>
                            <div class="col-md-8">
                                <label class="apt-back"> <?php if(isset($appointment) && count($appointment)>0): ?> <?php if(!empty($appointment->customer_country)): ?><?php echo e($appointment->customer_country); ?> <?php endif; ?> <?php endif; ?></label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group clearfix">
                            <label class="col-md-4 control-label">Appointment With:</label>

                            <div class="col-md-8">     
                                <label> <?php if(isset($appointment) && count($appointment)>0): ?><?php echo e($appointment->expert->userInformation->first_name); ?> <?php endif; ?></label>
                            </div>
                        </div>  
                    </div>

                    <div class="row">
                        <div class="form-group clearfix">
                            <label class="col-md-4 control-label">Appointment Status:</label>

                            <div class="col-md-8">
                                <label>
                                    <?php if( $appointment->status==0): ?>
                                    Pending
                                    <?php elseif($appointment->status==1): ?>
                                    Scheduled
                                    <?php elseif($appointment->status==2 && $appointment->message=="Cancelled By Customer" ): ?>
                                    Cancel
                                    <?php elseif($appointment->status==2 && $appointment->message=="Rejected" ): ?>
                                    Rejected
                                    <?php elseif($appointment->status==3 ): ?>
                                    Completed
                                    <?php elseif($appointment->status==4 ): ?>
                                    Rescheduled
                                    <?php endif; ?>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group clearfix">
                            <label class="col-md-4 control-label">Appointment DateTime:</label>

                            <div class="col-md-8">
                                <label> <?php echo date('d M Y h:i a', strtotime($appointment->appointment_datetime)) ?></label>

                            </div>

                        </div>
                    </div>
                    <div class="row">  
                        <div class="form-group clearfix">
                            <label class="col-md-4 control-labels">Contact Id:</label>

                            <div class="col-md-8">     
                                <label class="apt-back"> <?php if(isset($appointment->contact_id) && $appointment->contact_id!=''): ?><?php echo e($appointment->contact_id); ?> <?php endif; ?></label>

                            </div>

                        </div> 
                    </div>         

                    <div class="row">  
                        <div class="form-group clearfix">
                            <label class="col-md-4 control-labels">Appointment Purpose:</label>

                            <div class="col-md-8">     
                                <label class="apt-back"> <?php if(isset($appointment->purpose) && $appointment->purpose!=''): ?><?php echo e($appointment->purpose); ?> <?php endif; ?></label>

                            </div>

                        </div> 
                    </div>
                </div>

            </div>


            </div>
        </div>
    </div>
<!-- </div>
 -->
<?php $__env->stopSection(); ?>

<?php echo $__env->make(config("piplmodules.back-view-layout-location"), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>