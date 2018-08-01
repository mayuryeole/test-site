<?php $__env->startSection('meta'); ?>
<title>Set Your Availability</title>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('header'); ?>
<script src="<?php echo e(url('/')); ?>/public/media/front/css/calendar.css"></script>
<style type="text/css">
    .appointment-cal{
        height: 600px !important;
    }
    .btn.submit-chat:hover {
        color: #ffffff;
    }
    label.text-danger {
        color: #ff0000;
    }
</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<section class="semi-banner" style="background-image:url('<?php echo e(url("public/media/front/img/my_appoitnments.jpg")); ?>');">
    <div class="semi-banner-caption-owner">
        <div class="container">
            <!-- <div class="semi-ban-head manage-bottm-head">
                APPOINTMENT FORM
            </div> -->
        </div>
    </div>
</section>
<section class="cust-bread">
    <div class="container">
        <ul class="clearfix">
            <li><a href="http://parasfashions.com">Home</a></li>
            <li>APPOINTMENT FORM</li>
        </ul>
    </div>
</section>
<section class="paras-artist-book">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php if(session('msg-success')): ?>
                    <div class="alert alert-success">
                        <?php echo e(session('msg-success')); ?>

                        <a style="color: black" href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                    </div>
                <?php endif; ?>
                <?php if(session('issue-profile')): ?>
                <div class="alert alert-danger">
                    <?php echo e(session('issue-profile')); ?>

                    <a style="color: black" href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                </div>
                <?php endif; ?>
                <div class="owner-booking-form">
                    <form class="cust-book-form" id='book_business_appointment' method='post' action='<?php echo e(url("get-appointment/post-book-business-appointment")); ?>'>
                        <input type="hidden" id="main_url" value="<?php echo e(url('/')); ?>/" />
                        <input type="hidden" id="expert_id" value="1"/>
                        <input type="hidden" id="mode_of_contact" value="<?php echo e('5'); ?>"/> 
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label>Name *</label>
                                    <input type="text" name="first_name" class="form-control" placeholder="First Name">
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label>Email *</label>
                                    <input type="text" name="email" class="form-control" placeholder="Email">
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label>Phone *</label>
                                    <input type="text" name="phone" class="form-control" placeholder="Phone">
                                </div>
                            </div>
                            <?php if(isset($country) && count($country)>0): ?>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label>Select your Country *</label>
                                    <select name="country" id="country" class="form-control select-drop">
                                        <option value="">Select your Country</option>
                                        <?php foreach($country as $ctry): ?>
                                            <?php if(isset($ctry->name) && $ctry->name !=''): ?>
                                        <option value="<?php echo e($ctry->name); ?>"><?php echo e($ctry->name); ?></option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <?php endif; ?>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label>Select your Facetime or Skype ID *</label>
                                    <select name="facetime_or_skype_id" id="facetime_id" class="form-control select-drop">
                                        <option value="">Select your Facetime or Skype ID</option>
                                        <option value="Skype">Skype</option>
                                        <option value="Face Time">Face Time</option>
                                        <option value="Messenger">Messenger</option> 
                                        <option value="Google Duo">Google Duo</option>  
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label>Enter your Facetime or Skype No *</label>
                                    <input type="text"  name="facetime_or_skype_name" class="form-control" placeholder="Enter your Facetime or Skype ID">
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label>Appointment Date *</label>
                                    <input type="text"  class="form-control" name="calendar"  id='calendar'  placeholder="Appointment Date">
                                </div>
                                <div class="form-group">
                                    <div id="daySelect"></div>
                                    <div>
                                        <p id="dayTimes"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label>Purpose of appointment *</label>
                                    <textarea name="purpose_of_appointment" class="form-control" placeholder="Please enter your purpose of appointment"></textarea>
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group text-center">
                                    <button type="submit" class="btn submit-chat" id="business_submit_button">Send</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('footer'); ?>
<script src="<?php echo e(url('/')); ?>/public/media/front/js/appointment/moment.js"></script>
<script src="<?php echo e(url('/')); ?>/public/media/front/js/appointment/calendar.js"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>