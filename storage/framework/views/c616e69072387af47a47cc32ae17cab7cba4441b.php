<?php $__env->startSection('content'); ?>
<div class="container">
	<div class="row">

		<div class="panel panel-primary col-sm-5">
			<div class="panel-heading">Add Report (Mental Helth)</div>
			<div class="panel-body">

				<?php if(Session::has('error')): ?>
				<div class="alert alert-danger">
					<?php echo e(Session::get('error')); ?>

				</div>
				<?php endif; ?>

				<form method="post" action="menlast">

					<?php if($errors->any()): ?>
					<div class="alert alert-danger">
						<?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<li><?php echo e($error); ?></li>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					</div>
					<?php endif; ?>
					
					<?php echo e(csrf_field()); ?>


					<div class="form-group">
                            <label>Assessment environment</label>
                            <input type="text" required="" name="assessment" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Occupation being assessed</label>
                            <input type="text" required="" name="occupation" class="form-control">
                        </div>

                    <input type="hidden" name="type" value="environment">

                    <input type="submit" name="" value="Continue" class="btn btn-primary">

                </form>

            </div>
        </div>


    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\physio\resources\views/mental/menEight.blade.php ENDPATH**/ ?>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     <?php $__env->startSection('content'); ?>
<div class="container">
	<div class="row">

		<div class="panel panel-primary col-sm-5">
			<div class="panel-heading">Add Report (Mental Helth)</div>
			<div class="panel-body">

				<?php if(Session::has('error')): ?>
				<div class="alert alert-danger">
					<?php echo e(Session::get('error')); ?>

				</div>
				<?php endif; ?>

				<form method="post" action="menPage2">

					<?php if($errors->any()): ?>
					<div class="alert alert-danger">
						<?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<li><?php echo e($error); ?></li>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					</div>
					<?php endif; ?>
					
					<?php echo e(csrf_field()); ?>


					<table class="table" border="1">
                            <tr>
                                <th colspan="2">Motor skills</th>
                            </tr>
                            <tr>
                                <td>Mobilises independently<input type="text" name="question[]" value="Mobilises independently" style="display: none;"></td>
                                <td>
                                    <select class="form-control" name="answer[]">
                                        <option value="Not seen">Not seen</option>
                                        <option value="Facilitates occupational participation">Facilitates occupational participation</option>
                                        <option value="Allows occupational participation">Allows occupational participation</option>
                                        <option value="Inhibits occupational participation">Inhibits occupational participation</option>
                                        <option value="Restricts occupational participation">Restricts occupational participation</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Manipulates tools and materials easily<input type="text" name="question[]" value="Manipulates tools and materials easily" style="display: none;"></td>
                                <td>
                                    <select class="form-control" name="answer[]">
                                        <option value="Not seen">Not seen</option>
                                        <option value="Facilitates occupational participation">Facilitates occupational participation</option>
                                        <option value="Allows occupational participation">Allows occupational participation</option>
                                        <option value="Inhibits occupational participation">Inhibits occupational participation</option>
                                        <option value="Restricts occupational participation">Restricts occupational participation</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Uses appropriate strength and effort<input type="text" name="question[]" value="Uses appropriate strength and effort" style="display: none;"></td>
                                <td>
                                    <select class="form-control" name="answer[]">
                                        <option value="Not seen">Not seen</option>
                                        <option value="Facilitates occupational participation">Facilitates occupational participation</option>
                                        <option value="Allows occupational participation">Allows occupational participation</option>
                                        <option value="Inhibits occupational participation">Inhibits occupational participation</option>
                                        <option value="Restricts occupational participation">Restricts occupational participation</option>
                                    </select>
                          