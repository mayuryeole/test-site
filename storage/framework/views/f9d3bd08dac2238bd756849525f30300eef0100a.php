<?php $__env->startSection("meta"); ?>
<title>Contact Us</title>
<?php $__env->stopSection(); ?>

<?php $__env->startSection("content"); ?>
<script>
    function resetform() {
        document.getElementById("myform").reset();
    }

</script>
<!--CMS HEADER HERE-->
<!--<section class="cms-header" style="background-image:url(<?php echo e(url('/')); ?>/public/media/front/img/bg_cms_1.jpg);">
    <div class="container">
        <div class="cms-caption">
            <div class="cms-ban-heading">
                Contact Us
            </div>
            <div class="cms-ban-breadcrumbs">
               	<ul>
                    <li><a href="<?php echo e(url('/')); ?>">Home</a></li>
                    <li><span>>></span></li>
                    <li class="active">Contact Us</li>
                </ul>
            </div>
        </div>
    </div>
</section>-->

<section class="contact-form cms_about_us_background">
    <div class="container">
        <?php if(session('status')): ?>
        <div class="alert alert-success">
            <?php echo e(session('status')); ?>

            <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
        </div>
        <?php endif; ?>
        <div class="heading-holder">
            <div class="main_heading"><span>GET IN TOUCH</span></div>
        </div>
        <div class="row">
            <div class="contact-frm-hold clearfix">
                <div class="col-md-4 col-sm-4 col-xs-12">
                    <div class="con-info">
                        <h3>OUR OFFICE</h3>
                        <p><span class="paras-identity">Chawla’s International</span></p> 
                        <p>Unit No 20/21 , Eastern Plaza,</p> <p>Daftary Road , Malad (East),</p> <p>Mumbai - 400097.  MH, India</p>
                        <!-- <h3>OUR OFFICE</h3>
                        <p class="mgt-text"><strong>Chawlas International</strong></p>
                        <p>Unit No - 20 & 21, Eastern Plaza,</p>
                        <p><strong><?php echo e(GlobalValues::get('address')); ?></strong></p> <p><?php echo e(GlobalValues::get('street')); ?>,</p>
                        <p><?php echo e(GlobalValues::get('city')); ?>,
                        <?php echo e(GlobalValues::get('zip-code')); ?></p> -->
                        



                        <h3>Call us today</h3>
                        <p><span>Phone :</span> <?php echo e(GlobalValues::get('phone-no')); ?></p>


                        <h3>Email Us Now</h3>
                        <p><a href="javascript:void(0);"><?php echo e(GlobalValues::get('contact-email')); ?></a></p>


                    </div>
                </div>
                <div class="col-md-8 col-sm-8 col-xs-12">
                    <div class="con-info con-form">
                        <h3>Send message to us</h3>
                        <form  id="myform" method="post" enctype="multipart/form-data" name="myform">
                            <?php echo csrf_field(); ?>

                            <div class="row">
                                
                                <div class="col-md-6">
                                    <div class="form-group cont-form <?php if($errors->has('name')): ?> has-error <?php endif; ?>">
                                        <input id="name" name="name" class="form-control clear-txt" placeholder="Your Name"   value="<?php echo e(old('name',$user_data['name'])); ?>" />
                                        <?php if($errors->has('name')): ?>
                                        <span class="help-block">
                                            <strong class="text-danger"><?php echo e($errors->first('name')); ?></strong>
                                        </span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group cont-form <?php if($errors->has('email')): ?> has-error <?php endif; ?>">
                                        <input type="email" id="email" class="form-control clear-txt" name="email" placeholder="Your Email" value="<?php echo e(old('email',$user_data['email'])); ?>" />
                                        <?php if($errors->has('email')): ?>
                                        <span class="help-block">
                                            <strong class="text-danger"><?php echo e($errors->first('email')); ?></strong>
                                        </span>
                                        <?php endif; ?>
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="form-group cont-form <?php if($errors->has('phone')): ?> has-error <?php endif; ?>">
                                        <input type="tel" class="form-control clear-txt" id="phone" placeholder="Your Mobile" name="phone" value="<?php echo e(old('phone')); ?>" />
                                        <?php if($errors->has('phone')): ?>
                                        <span class="help-block">
                                            <strong class="text-danger"><?php echo e($errors->first('phone')); ?></strong>
                                        </span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <?php if(count($contact_categories) > 0): ?>
                                    <div class="form-group cont-form <?php if($errors->has('category')): ?> has-error <?php endif; ?>">
                                        <select name="category" class="form-control">
                                            <option value="">Select Enquiry Type</option>
                                            <?php foreach($contact_categories as $category): ?>
                                            <option <?php if(old('category')==$category->id): ?> selected="selected" <?php endif; ?> value="<?php echo e($category->id); ?>"><?php echo e($category->name); ?></option>
                                            <?php endforeach; ?>
                                        </select>

                                        <?php if($errors->has('category')): ?>
                                        <span class="help-block">
                                            <strong class="text-danger"><?php echo e($errors->first('category')); ?></strong>
                                        </span>
                                        <?php endif; ?>

                                    </div>

                                    <?php endif; ?>
                                </div>     
                                <div class="col-md-12">
                                    <div class="form-group cont-form <?php if($errors->has('subject')): ?> has-error <?php endif; ?>">
                                        <input type="text" class="form-control clear-txt" id="subject" name="subject" value="<?php echo e(old('subject')); ?>" placeholder="Subject "/>
                                        <?php if($errors->has('subject')): ?>
                                        <span class="help-block">
                                            <strong class="text-danger"><?php echo e($errors->first('subject')); ?></strong>
                                        </span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-md-12">


                                    <div class="form-group <?php if($errors->has('message')): ?> has-error <?php endif; ?>">
                                        <textarea  class="form-control clear-txt" id="message" name="message" placeholder="Message"><?php echo e(old('message')); ?></textarea>
                                        <?php if($errors->has('message')): ?>
                                        <span class="help-block">
                                            <strong class="text-danger"><?php echo e($errors->first('message')); ?></strong>
                                        </span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-send cont-form-btn ">Send</button>
                                        <button id="clearAll" onclick="resetform()" type="button" class="btn btn-send cont-form-btn">Clear</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="contact-map">
    <div class="map">
        <!--<iframe src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBu-916DdpKAjTmJNIgngS6HL_kDIKU0aU&callback=myMap" width="100%" height="500" frameborder="0" style="border:0" allowfullscreen></iframe>-->

        <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d121059.0344739699!2d72.857452!3d19.180874!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sin!4v1496743732962" width="100%" height="500" frameborder="0" style="border:0" allowfullscreen></iframe>
    </div>
</section>

<?php $__env->stopSection(); ?>
<?php echo $__env->make(config("piplmodules.front-view-layout-location"), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>