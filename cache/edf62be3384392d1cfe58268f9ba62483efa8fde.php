<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $__env->yieldContent('title'); ?></title>
    <?php echo $__env->make('partials.styles', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
</head>

<body>
    <?php if(isset($flash)): ?>
        <?php echo $__env->make('components.flash', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php endif; ?>

    <?php echo $__env->make('partials.navigation', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <div id="content">
        <?php echo $__env->yieldContent('content'); ?>
    </div>

    <?php echo $__env->make('partials.scripts', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

</body>

</html>