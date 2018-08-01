<?php $__env->startSection("meta"); ?>

<title>Create Faq</title>

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
					<a href="<?php echo e(url('admin/faqs')); ?>">Manage Faq's</a>
                                        <i class="fa fa-circle"></i>
					
				</li>
				<li>
					<a href="javascript:void(0);">Create Faq</a>
					
				</li>
                        </ul>

  
    
      <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box blue">
             <div class="portlet-title">
                        <div class="caption">
                                <i class="fa fa-gift"></i> Create Faq
                        </div>

             </div>
             <div class="portlet-body form">
                 <form class="form-horizontal" role="form" action="" method="post" id="create_faq" >
            
                 <?php echo csrf_field(); ?>

                 <div class="form-body">
                   <div class="row">
                        <div class="col-md-12">    
                        <div class="col-md-8">  
                         <div class="form-group <?php if($errors->has('question')): ?> has-error <?php endif; ?>">
                          <label class="col-md-6 control-label">Question<sup>*</sup></label>
                       
                            <div class="col-md-6">     
                           <input class="form-control" name="question" value="<?php echo e(old('question')); ?>" />
                             <?php if($errors->has('question')): ?>
                                    <span class="help-block">
                                        <strong class="text-danger"><?php echo e($errors->first('question')); ?></strong>
                                    </span>
                                <?php endif; ?>
                          </div>
                       
                      </div>
                       <div class="form-group <?php if($errors->has('answer')): ?> has-error <?php endif; ?>">
                          <label class="col-md-6 control-label">Answer<sup>*</sup></label>
                         
                            <div class="col-md-6">     
                                <textarea class="form-control" name="answer" ><?php echo e(old('answer')); ?></textarea>
                            <?php if($errors->has('answer')): ?>
                              <span class="help-block">
                                  <strong class="text-danger"><?php echo e($errors->first('answer')); ?></strong>
                              </span>
                              <?php endif; ?>
                          </div>
                       
                      </div>
                            
                   <?php if(count($tree)>0 && empty($locale)): ?>
                     <div class="form-group <?php if($errors->has('category')): ?> has-error <?php endif; ?>">
                        <label for="category" class="col-md-6 control-label">Select Category </label>
                      <div class="col-md-6">     
                        <select name="category" class="form-control">
                           <option value="0">No Category</option>
                                    <?php foreach($tree as $ls_category): ?>
                                    <option  value="<?php echo e($ls_category->id); ?>"><?php echo e($ls_category->display); ?></option>
                                    <?php endforeach; ?>
                        </select>
                            <?php if($errors->has('category')): ?>
                                <span class="help-block">
                                    <strong class="text-danger"><?php echo e($errors->first('category')); ?></strong>
                                </span>
                            <?php endif; ?>
                        </div>
                        </div>
                        <?php endif; ?>           
                      <div class="form-group">
                         <div class="col-md-12">   
                            <button type="submit" id="submit" class="btn btn-primary  pull-right">Create</button>
                         </div>
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
 <?php $__env->stopSection(); ?>
<?php echo $__env->make(config("piplmodules.back-view-layout-location"), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>