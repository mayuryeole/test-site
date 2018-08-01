<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="img/png" href="<?php echo e(url('public/media/front/img/mor.png')); ?>" >
        <title>PARAS FASHIONS</title>
        <?php echo $__env->yieldContent('meta'); ?>
        <!------------------------------ Front css file ---------------------------------------------->
        <link href="https://fonts.googleapis.com/css?family=Cormorant+Garamond:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
        <link href="<?php echo e(url('public/media/front/css/bootstrap.min.css')); ?>" rel="stylesheet" type="text/css" />
        <link href="https://cdn.rawgit.com/davidstutz/bootstrap-multiselect/master/dist/css/bootstrap-multiselect.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo e(url('public/media/front/css/owl.carousel.min.css')); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo e(url('public/media/front/css/jquery.mCustomScrollbar.css')); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo e(url('public/media/front/css/css/owl.theme.css')); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo e(url('public/media/front/css/font-awesome.min.css')); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo e(url('public/media/front/css/si-icons.css')); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo e(url('public/media/front/css/animated.css')); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo e(url('public/media/front/css/style.css')); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo e(url('public/media/front/css/icon.css')); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo e(url('public/media/front/css/lightgallery.css')); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo e(url('public/media/front/css/main.css')); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo e(url('public/media/front/css/responsive.css')); ?>" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="<?php echo e(url('resources/demos/style.css')); ?>">
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <link href="<?php echo e(url('public/media/front/css/jquery.booklet.latest.css')); ?>" type="text/css" rel="stylesheet" media="screen, projection, tv" />
        <script>
            var javascript_site_path = '<?php echo e(url('')); ?>/';
        </script>           
    </head>
    <body>  

        <?php echo $__env->make('include/header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php echo $__env->yieldContent('header'); ?>
        <?php echo $__env->yieldContent('content'); ?>
        <?php echo $__env->yieldContent('footer'); ?>
        <?php echo $__env->make('include/footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        
        <script src="<?php echo e(url('public/media/front/js/bootstrap.min.js')); ?>"></script>
        <script src="https://cdn.rawgit.com/davidstutz/bootstrap-multiselect/master/dist/js/bootstrap-multiselect.js" type="text/javascript"></script>
        <script type="text/javascript">
            $(function () {
                $('.lstFruits').multiselect({
                    includeSelectAllOption: true,
                });
                 $('.occasion').multiselect({
                    includeSelectAllOption: true,
                    nonSelectedText: 'Occasion'
                });
                 $('.collectionStyle').multiselect({
                    includeSelectAllOption: true,
                    nonSelectedText: 'Collection'
                });
                 $('.estyle').multiselect({
                    includeSelectAllOption: true,
                    nonSelectedText: 'Style'
                });

                  $('.color').multiselect({
                    includeSelectAllOption: true,
                    nonSelectedText: 'Color'
                });

                $('#btnSelected').click(function () {
                    var selected = $("#lstFruits option:selected");
                    var message = "";
                    selected.each(function () {
                        message += $(this).text() + " " + $(this).val() + "\n";
                    });
                    alert(message);
                });
            });
            $(function () {
          $('[data-toggle="tooltip"]').tooltip()
        })
        </script>
        <script>
        var collectionStyle = [];
        var style = [];
        var color = [];
        var occasion = [];
        var price = [];
        var category = '';
        var sortBy = '';
        var selectId = '';
        var str = '';
        </script>
        <script src="<?php echo e(url('public/media/front/js/owl.carousel.min.js')); ?>"></script>
        <script src="<?php echo e(url('public/media/front/js/jquery.mCustomScrollbar.concat.min.js')); ?>"></script>
        <script src="<?php echo e(url('public/media/front/js/wow.js')); ?>"></script>
        <script src="<?php echo e(url('public/media/front/js/jquery.validate.js')); ?>"></script>
        <script src="<?php echo e(url('public/media/front/js/validation.js')); ?>"></script>
        <script src="<?php echo e(url('public/media/front/js/custom.js')); ?>"></script>
        <script src="<?php echo e(url('public/media/front/js/appointment/validate-appointment.js')); ?>"></script>
         <script src="<?php echo e(url('public/media/front/js/picturefill.min.js')); ?>"></script>
         <script src="<?php echo e(url('public/media/front/js/lightgallery-all.min.js')); ?>"></script>
         <script src="<?php echo e(url('public/media/front/js/jquery.mousewheel.min.js')); ?>"></script>
        <script> window.jQuery || document.write('<script src="<?php echo e(url('public/media/front/js/jquery-2.1.0.min.js')); ?>"><\/script>') </script>
        <script> window.jQuery || document.write('<script src="<?php echo e(url('public/media/front/js/jquery-ui.min.js')); ?>"><\/script>') </script>
        <!--JS FOR BOOKLET-->
        <script src="<?php echo e(url('public/media/front/js/jquery.easing.1.3.js')); ?>"></script>
        <script src="<?php echo e(url('public/media/front/js/wow.js')); ?>"></script>
        <script src="<?php echo e(url('public/media/front/js/jquery.booklet.latest.min.js')); ?>"></script>
        <script>
            //booklet js
            new WOW().init();
            $(function() {
                $('#mybook').booklet({
                    width:  1000,
                    height: 643
                });
            });
        </script>
        <script>
            function goHere(category_id)
            {
                window.location.href = javascript_site_path + "search-product?category=" + category_id;
            }
            function searchData(val)
            {
                window.location.href = javascript_site_path + "search-product?name=" + val;
            }
        </script>

        <script type="text/javascript">
        $(document).ready(function(){
            $('#lightgallery').lightGallery();
        });
        </script>

    </body>
</html>

