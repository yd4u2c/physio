<?php $__env->startSection('content'); ?>
<div class="container">
  <div class="row">

   <div class="panel panel-primary col-sm-10">
     <div class="panel-heading">ACUTE NEUROLOGICAL ASSESSMENT</div>
     <div class="panel-body">

      <?php if(Session::has('error')): ?>
      <div class="alert alert-danger">
       <?php echo e(Session::get('error')); ?>

     </div>
     <?php endif; ?>

     <form method="post" action="neuPage3">

       <?php if($errors->any()): ?>
       <div class="alert alert-danger">
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li><?php echo e($error); ?></li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
      <?php endif; ?>

      <?