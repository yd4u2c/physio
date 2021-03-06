<?php $__env->startSection('content'); ?>
<div class="container">
	<div class="row">

		<div class="panel panel-primary col-sm-5">
			<div class="panel-heading">Add a new patient</div>
			<div class="panel-body">

				<form method="post" enctype="multipart/form-data" action="<?php echo e(url('/addPatient')); ?>">
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

					<div class="form-group">
						<label>Gender</label>
						<select class="form-control" name="gender">
							<option>Male</option>
							<option>Female</option>
						</select>
					</div>

					<div class="form-group">
						<label>Passport</label>
						<input type="file" name="upload" class="form-control">
					</div>

					<input type="submit" name="submit" class="btn btn-primary">

				</form>

			</div>
		</div>


	</div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\physio\resources\views/front/newPatient.blade.php ENDPATH**/ ?>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 