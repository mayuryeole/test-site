<?php $__env->startSection("meta"); ?>

<title>Contact Request View</title>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>


<div class="page-content-wrapper">
    <div class="page-content">

        <!-- BEGIN PAGE BREADCRUMB -->
        <ul class="page-breadcrumb breadcrumb hide">
            <li>
                <a href="<?php echo e(url('admin/dashboard')); ?>">Home</a><i class="fa fa-circle"></i>
            </li>
            <li class="active">
                Dashboard
            </li>
        </ul>

        <!-- BEGIN PAGE BREADCRUMB -->
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <a href="<?php echo e(url('admin/dashboard')); ?>">Dashboard</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="<?php echo e(url('admin/contact-requests')); ?>">Contact Request</a>
                   <i class="fa fa-circle"></i>
            
            </li>
            <li>
                <a href="javascript:void(0)">View & Reply</a>
            </li>
        </ul>
        <div class="profile-content">
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet light">
                        <div class="portlet-title tabbable-line">
                            <div class="caption caption-md">
                                <i class="icon-globe theme-font hide"></i>
                                <span class="caption-subject font-blue-madison bold uppercase">Contact Request View</span>
                            </div>
                            <ul class="nav nav-tabs">
                                <li class="<?php if(!($errors->has('email') || $errors->has('subject') || $errors->has('message'))): ?> active <?php endif; ?>">
                                    <a href="#tab_1_1" data-toggle="tab">Request Details</a>
                                </li>
                                <li class="<?php if(($errors->has('email') || $errors->has('subject') || $errors->has('message'))): ?> active <?php endif; ?>">
                                    <a href="#tab_1_3" data-toggle="tab">Post A reply</a>
                                </li>
                                <li class="" id="your-replies">
                                    <a href="#tab_1_2" data-toggle="tab">Your Replies</a>
                                </li>

                            </ul>
                        </div>
                        <?php if(session('profile-updated')): ?>
                        <div class="alert alert-success">
                            <?php echo e(session('profile-updated')); ?>

                            <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                        </div>
                        <?php endif; ?>
                        <?php if(session('password-update-fail')): ?>
                        <div class="alert alert-danger">
                            <?php echo e(session('password-update-fail')); ?>

                        </div>
                        <?php endif; ?>
                        <div class="portlet-body">
                            <div class="tab-content">
                                <!-- PERSONAL INFO TAB -->
                                <div class="tab-pane <?php if(!($errors->has('email') || $errors->has('subject') || $errors->has('message'))): ?> active <?php endif; ?>" id="tab_1_1">
                                    <form class="form-horizontal">
                                        <div class="form-group row">
                                            <label class="control-label col-sm-4"><b>Name:</b></label>
                                          <div class="col-sm-5">
                                           <label class="control-label"><?php echo e($request->contact_name); ?></label>
                                          </div>  
                                        </div>
                                       <div class="form-group row">
                                            <label class="control-label col-sm-4"><b>Email:</b></label>
                                          <div class="col-sm-5">
                                           <label class="control-label"><?php echo e($request->contact_email); ?></label>
                                          </div>  
                                        </div>
                                         <div class="form-group row">
                                            <label class="control-label col-sm-4"><b>Phone:</b></label>
                                          <div class="col-sm-5">
                                           <label class="control-label"><?php echo e($request->contact_phone); ?></label>
                                          </div>  
                                         </div>
                                         <div class="form-group row">
                                            <label class="control-label col-sm-4"><b>Category:</b></label>
                                          <div class="col-sm-5">
                                           <label class="control-label"><?php if($request->category): ?> <?php echo e($request->category->translate()->name); ?> <?php else: ?> - <?php endif; ?></label>
                                          </div>  
                                         </div>
                                         <div class="form-group row">
                                            <label class="control-label col-sm-4"><b>Date:</b></label>
                                          <div class="col-sm-5">
                                           <label class="control-label"><?php echo e($request->created_at->format('d M, Y')); ?></label>
                                          </div>  
                                        </div>
                                         <div class="form-group row">
                                            <label class="control-label col-sm-4"><b>Subject:</b></label>
                                          <div class="col-sm-5">
                                           <label class="control-label"><?php echo e($request->contact_subject); ?></label>
                                          </div>  
                                        </div>
                                        <div class="form-group row">
                                            <label class="control-label col-sm-4"><b>Message:</b></label>
                                          <div class="col-sm-5">
                                           <label class="control-label h-manage-message"><?php echo e($request->contact_message); ?></label>
                                          </div>  
                                        </div>
<!--                                         <div class="form-group row">
                                            <label class="control-label col-sm-4"><b>Attachment(s):</b></label>
                                          <div class="col-sm-5">
                                           <ul class="list-inline">
                                          
                                            <?php if(!empty($request->contact_attachment)): ?>
                                                <?php foreach($request->contact_attachment as $attachment): ?>
                                                    <li><a target="new" href="<?php echo e(asset('storage/contact-requests/'.$request->reference_no.'/'.$attachment)); ?>"><i class="fa fa-download"></i> <?php echo e($attachment); ?></a></li>
                                                <?php endforeach; ?>
                                            
                                             <?php else: ?>    
                                                    No attachemnt found
                                            <?php endif; ?>
                                            </ul>
                                          </div>  
                                        </div>-->
                                     </form>   
                                </div>
                                <div class="tab-pane <?php if(($errors->has('email') || $errors->has('subject') || $errors->has('message'))): ?> active <?php endif; ?>" id="tab_1_3">
                                    <form role="form" class="form-horizontal" method="post" action="<?php echo e(url('/admin/contact-request-reply/'.$request->reference_no)); ?>" enctype="multipart/form-data">
                                        <?php echo csrf_field(); ?>

                                        <h4>Please fill below form to submit your reply</h4>
                                         <div class="form-group <?php if($errors->has('email')): ?> has-error <?php endif; ?>">
                                            <label class="control-label col-sm-4"><b>Email From:</b></label>
                                            <div class="col-sm-5">
                                              <input class="form-control" name="email" value="<?php echo e(old('email',$contact_email->value)); ?>" />
                                               <?php if($errors->has('email')): ?>
                                                <span class="help-block">
                                                    <strong class="text-danger"><?php echo e($errors->first('email')); ?></strong>
                                                </span>
                                             <?php endif; ?>
                                            </div>  
                                         </div>
                                        <div class="form-group <?php if($errors->has('subject')): ?> has-error <?php endif; ?>">
                                            <label class="control-label col-sm-4"><b>Subject:</b></label>
                                            <div class="col-sm-5">
                                              <input class="form-control" name="subject" value="<?php echo e(old('subject','Re: '.$request->contact_subject)); ?>" />
                                              <?php if($errors->has('subject')): ?>
                                                <span class="help-block">
                                                    <strong class="text-danger"><?php echo e($errors->first('subject')); ?></strong>
                             
Contact Request View

    Request Details
    Post A reply
    Your Replies

                   </span>
                                             <?php endif; ?>
                                            </div>  
                                         </div>
                                        <div class="form-group <?php if($errors->has('message')): ?> has-error <?php endif; ?>">
                                            <label class="control-label col-sm-4"><b>Message:</b></label>
                                            <div class="col-sm-5">
                                             <textarea class="form-control" name="message"><?php echo e(old('message')); ?></textarea>
                                             <?php if($errors->has('message')): ?>
                                                    <span class="help-block">
                                                        <strong class="text-danger"><?php echo e($errors->first('message')); ?></strong>
                                                    </span>
                                             <?php endif; ?>
                                            </div>  
                                        </div>
                                        <div class="form-group <?php if($errors->has('attachment')): ?> has-error <?php endif; ?>">
                                            <label class="control-label col-sm-4"><b>Attachment:</b></label>
                                            <div class="col-sm-5">
                                                <input class="form-control" name="attachment[]" multiple  type="file" value="<?php echo e(old('attachment')); ?>" />
                                                <?php if($errors->has('attachment')): ?>
                                                            <span class="help-block">
                                                                <strong class="text-danger"><?php echo e($errors->first('attachment')); ?></strong>
                                                            </span>
                                                <?php endif; ?>
        
                                            </div>  
                                        </div>
                                        <div class="form-group <?php if($errors->has('message')): ?> has-error <?php endif; ?>">
                                          <label class="control-label col-sm-4"></label>
                                            <div class="col-sm-5">
                                                <button type="submit" class="btn btn-md btn-primary">Post Reply</button>
                                             <!--<button type="button" class="btn btn-md btn-default" onclick="jQuery('#post-reply').toggle()">Cancel</button>-->
                                            </div>  
                                        </div>
                                        
                                    </form>   
                                </div>    
                               
                                <!-- CHANGE PASSWORD TAB -->
                                <div class="tab-pane" id="tab_1_2">
                                    <form role="form">
                                     <div class="pagination-pull-right"> 
                                        
                                      <?php if(count($replies)>0): ?>
                                     <div class="paginate-row"> 
                                       <?php foreach($replies as $key=>$reply): ?>
                                      <div class="paginate-reply">
                                        <div class="form-group row">
                                          <div class="col-sm-9">
                                              <label class="control-label"><?php echo e($reply->reply_email); ?> <i class="fa fa-calendar"></i> <?php echo e($reply->created_at->format('d M, Y')); ?></label>
                                          </div>  
                                        </div>
                                       <div class="form-group row">
                                           
                                          <div class="col-sm-9">
                                           <label class=""><?php echo e($reply->reply_subject); ?></label>
                                          </div>  
                                        </div>
                                        
                                          <div class="form-group row">
                                          <div class="col-sm-12">
                                           <label class="control-label h-lable-block"><?php echo $reply->reply_message; ?></label>
                                          </div>  
                                        </div>
                                       <div class="form-group row attachments">
                                            <label class="control-label col-sm-4"><b>Attachment(s):</b></label>
                                          <div class="col-sm-5">
                                           <ul class="list-inline">
                                          
                                            <?php if(!empty($reply->reply_attachment)): ?>
                                                <?php foreach($reply->reply_attachment as $attachment): ?>
                                                    <li><a target="new" href="<?php echo e(asset('storage/app/public/contact-requests/'.$request->reference_no.'/'.$attachment)); ?>"><i class="fa fa-download"></i> <?php echo e($attachment); ?></a></li>
                                                <?php endforeach; ?>
                                            
                                             <?php else: ?>    
                                                    No Attachemnt
                                            <?php endif; ?>
                                            </ul>
                                          </div>  
                                        </div>
                                      </div>  
                                       <?php endforeach; ?>
                                     </div>
                                       
                                       <?php else: ?>
                                            No message found
                                       <?php endif; ?>
                                     </div>
                                        <?php echo $replies->links(); ?>

                                    </form>
                                   
                                </div>
                                 
                                <!-- END CHANGE PASSWORD TAB -->
                                <!-- PRIVACY SETTINGS TAB -->

                                <!-- END PRIVACY SETTINGS TAB -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END PAGE CONTENT INNER -->
    </div>
</div>
<style>
    .attachments{
        border-bottom: 1px solid #ccc;
    }
</style>
<script src="<?php echo e(url('/vendor/unisharp/laravel-ckeditor/ckeditor.js')); ?>"></script>
    <script>
        CKEDITOR.replace( 'message' );
        
        
        
        <?php if(isset($_REQUEST['page'])): ?>
            
            $(function(){
                $("#your-replies a").click();
            
            });
        
    <?php endif; ?>
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make(config("piplmodules.back-view-layout-location"), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>