<?php $__env->startSection('meta'); ?>
    <title>Set Your Availability</title>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('header'); ?>
    <link href="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.4.0/fullcalendar.min.css" rel="stylesheet">
    <style type="text/css">
        .avail-cal{
            height: 880px;
        }
    </style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <input type="hidden" id="main_url" value="<?php echo e(url('/')); ?>/" />
    <section class="account-setting">
        <div class="container">
            <div class="row">
                <div class="avail-cal">
                    <div class="col-md-12">
                        <div class="available-cal experts-head text-center">
                            <h3> availability for the appointments</h3>
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                                Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,
                                when an unknown printer took a galley of type and scrambled it to make a type
                                specimen book</p>
                            <div class="avail-img">
                                <?php /*<center><img src="<?php echo e(url('/')); ?>/public/media/front/img/responsive-calendar.png" alt="image" class="img-responsive avail-cal-img"></center>*/ ?>
                                <div id="error"></div>
                                <div id="calendar"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('footer'); ?>
    <script src="<?php echo e(url('/')); ?>/public/media/front/js/appointment/moment.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.4.0/fullcalendar.min.js"></script>
    <script src="<?php echo e(url('/')); ?>/public/media/front/js/availability/availability.js"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>