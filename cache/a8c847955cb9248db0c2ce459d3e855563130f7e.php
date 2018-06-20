<?php $__env->startSection('title', 'Indexsite'); ?>

<?php $__env->startSection('content'); ?>
    <p>Indexsite</p>
    <p>Share1: <?php echo e($share1); ?></p>
    <p>Share2: <?php echo e($share2); ?></p>
    <p>ID: <?php echo e($id); ?> </p>
    <p>TestVar: <?php echo e($testVar); ?></p>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('partials.layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>