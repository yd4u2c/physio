<?php $__env->startSection('content'); ?>
<div class="container">
	<div class="row">

		<div class="panel panel-primary col-sm-5">
			<div class="panel-heading">Add a new patient</div>
			<div class="panel-body">

				<form method="post" action="<?php echo e(url('/addPatient')); ?>">
					<?php echo e(csrf_field()); ?>


					<?php if($errors->any()): ?>
					<div class="alert alert-danger">
						<?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<li><?php echo e($error); ?></li>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					</div>
					<?php endif; ?>

					<div class="form-group">
						<label>Name</label>
						<input type="text" name="name" class="form-control">
					</div>

					<div class="form-group">
						<label>Physio number</label>
						<input type="text" name="physio" class="form-control">
					</div>


					<div class="form-group">
						<label>Date of Birth</label>
						<input type="date" name="dob" class="form-control">
					</div>


					<div class="form-group">
						<label>phone</label>
						<input type="text" name="phone" class="form-control">
					</div>

					<input type="submit" name="submit" class="btn btn-primary">

				</form>

			</div>
		</div>


	</div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Library/WebServer/Documents/physio/resources/views/front/newPatient.blade.php ENDPATH**/ ?>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           <?php $__env->startSection('content'); ?>
<div class="container">
	<div class="row">

		<div class="panel panel-primary col-sm-11">
			<div class="panel-heading"></div>
			<div class="panel-body">

				
				<?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

				<p class="text-center"><b>INITIAL EVALUATION SUBJECTIVE HISTORY WORKSHEET</b></p>
				<p>Patient Name: <?php echo e($row->name); ?> <span style="margin-left: 100px;"> Date of Birth: <?php echo e($row->dob); ?> </span> <span style="margin-left: 100px;"> Date of Eval: <?php echo e($row->created_at); ?> </span></p>

				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

				<!--SUBJECTIVE STARTS FROM HERE-->
				<?php $__currentLoopData = $data2; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<div class="box">
					<p class="text-center">SUBJECTIVE</p>
					<p>
						Why are seeking treatment for your child?: <b><?php echo e($row->reason); ?></b><br>
						<span>Has your child has any prior treatment and/in diagnostic testing for this condition? <b><?php echo e($row->testing); ?></b></span><br>
						<span>Specification of prior treatment: <b> <?php echo e($row->specify); ?></b></span><br>
						<span>Explanation of prior treatment: <b><?php echo e($row->explain); ?></b></span><br>
						<span>Date of Doctor's Next appointment <b><?php echo e($row->appointment); ?></b></span><br>
					</b>
					<p>I have reviewed the information provided and found it to be complete</p>
					<span>Subjective History: <b><?php echo e($row->info); ?></b></span><br>
					<p style="text-align: right; margin-right: 20px;"><span>Ph