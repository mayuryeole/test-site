<html>
    <body>Hello <?php echo e($FIRST_NAME); ?> <?php echo e($LAST_NAME); ?>,
        <br>
         Your registration has been completed successfully!
       
         You could also use your account with your email and random generated password
          
         Email: <?php echo e($EMAIL); ?>

         Password: <?php echo e($PASSWORD); ?>


        Thanks,<br><?php echo e($SITE_TITLE); ?>

    </body>
</html>