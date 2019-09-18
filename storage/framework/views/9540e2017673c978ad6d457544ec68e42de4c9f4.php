<?php $__env->startSection('content'); ?>
<div class="container">
  <div class="row">

   <div class="panel panel-primary col-sm-10">
     <div class="panel-heading">SUMMARY OF PROBLEM COMPLICATION</div>
     <div class="panel-body">

      <?php if(Session::has('error')): ?>
      <div class="alert alert-danger">
       <?php echo e(Session::get('error')); ?>

     </div>
     <?php endif; ?>

     <form method="post" action="neuPage4">

       <?php if($errors->any()): ?>
       <div class="alert alert-danger">
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li><?php echo e($error); ?></li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
      <?php endif; ?>

      <?php echo e(csrf_field()); ?>


      
      <div class="form-group">

        <div class="col-lg-6 ">
          <div class="form-group">
            <div class="form-check">
             <label class="form-check-label" for="exampleRadios1">At risk of respiratory complications</label>&nbsp;&nbsp;
             <input class="form-check-input" type="radio" name="respiratory" id="exampleRadios1" value="Yes" checked>
             <label class="form-check-label" for="exampleRadios1">Yes</label>&nbsp;
             <input class="form-check-input" type="radio" name="respiratory" id="exampleRadios1" value="no" checked>
             <label class="form-check-label" for="exampleRadios1">No</label>
           </div>
         </div>
       </div>
       <div class="col-lg-6 ">
        <div class="form-g