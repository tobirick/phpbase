<?php $__env->startSection('title', 'Testsite'); ?>

<?php $__env->startSection('content'); ?>
    <p>Testsite</p>
    <p>ID: <?php echo e($id); ?></p>
    <p>Text: <?php echo e($text); ?></p>  
<?php $__env->stopSection(); ?>
<?php echo $__env->make('partials.layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>