<?php $__env->startSection('content'); ?>
<div class="container">
	<div class="row">

		<div class="panel panel-primary col-sm-11">
			<div class="panel-heading">Add Report (Mental Helth)</div>
			<div class="panel-body">

				<?php if(Session::has('error')): ?>
				<div class="alert alert-danger">
					<?php echo e(Session::get('error')); ?>

				</div>
				<?php endif; ?>

				
				<a href="index.php">Back to Home</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="" onclick="window.print()">Print</a>
				<div style="width: 900px; border: 1px solid #000; margin: 0px auto; padding: 10px;">
					<h3 style="text-align: center;">PHYSICAL FITNESS ASSESSMENT IN PHYSIOTHERAPY DEPARTMENT FMCA</h3>

					<?php $__currentLoopData = $data2; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<div style='border: 1px solid #000; padding: 5;'>
						<p style='text-align: center;'>HISTORY OF FITNESS PROGRAM</p>
						<p>Previous participant in fitness program(s) <b><?php echo e($row->previous); ?></b><span style='margin-left: 100px;'>Duration of program <b> <?php echo e($row->duration); ?></b></span></p>
						<p>Reason(s) for stopping: <b><?php echo e($row->reason); ?></b></p>
						<p>Major reason(s) for wanting to participate in this fitness program: <b><?php echo e($row->major); ?></b></p>
						<p>Others: <b><?php echo e($row->others); ?></b></p>
						<p><b>Consent</b><br> I hereby indicate my willingness to participate in the test and exercise program and to comply with all instructions I may be given. </p>
						<p>&nbsp;</p>
						<p>Signature: ............................................ <span style='margin-left: 200px;'>Date: 24/05/2019</span></p>
						<p>&nbsp;</p>
						<p style='text-align: center'><b>EXAMINATION</b></p>
						<p>ANTHROPOMETTRIC MEASUREMENT</p>
						<p>Height (m): <b><?php echo e($row->height); ?></b></p>
						<p>Weight(Kg): <b><?php echo e($row->weight); ?></b></p>
						<p>Waist Circumference(cm): <b><?php echo e($row->waist); ?></b></p>
						<p>Hip Circumference (cm): <b><?php echo e($row->hip); ?></b></p>
						<p>Waist to Hip Ratio: <b><?php echo e($row->ratio); ?></b></p>
						<p>BMI(Kg/m<sup>2</sup>) <b> <?php echo e($row->bm); ?></b></p>
						<p>VITALS <b><?php echo e($row->vitals); ?></b></p>
						<p>BP (mmHg) <b><?php echo e($row->bp); ?></b></p>
						<p>PR(bpm) <b><?php echo e($row->pr); ?></b></p>
						<p>Maximum Heart Rate(220-age) <b><?php echo e($row->heart); ?></b></p>
						<p>NB: Target Heart Rate for Moderate Intensity= 60-65% of Max HR</p>
						<p>&nbsp;<p>
							<p style='text-align: center;'><b>OUTFITS FOR FITNESS AND PRECAUTION</b><br>
								<span>Wear appropriate outfit</span>
								<span style='margin-left: 100px;'>No food for 2 hours</span>
								<span style='margin-left: 100px;'>No caffeinated beverages</span><br>
								<span>No alcohol for 24 hours before assessment / testing</span>
								<span style='margin-left: 100px;'>No smoking for 2 hours before testing</span></p>
								<p>&nbsp;</p>
								<p>PLAN OF TREATMENT: <b><?php echo e($row->plan); ?> </b></p>
								<p>MEANS OF TREATMENT: <b><?php echo e($row->means); ?> </b></p>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</div>
						</div>

					</div>
				</div>


			</div>
		</div>
		<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Library/WebServer/Documents/physio/resources/views/fitness/fitPrint.blade.php ENDPATH**/ ?>                                                                                                                                                                                                                                                                                                                                                                                                                                                        <?php $__env->startSection('content'); ?>
<div class="container">
	<div class="row">

		<div class="panel panel-primary col-sm-4">
			<div class="panel-heading">Check Report (O&G)</div>
			<div class="panel-body">

				<?php if(Session::has('error')): ?>
				<div class="alert alert-danger">
					<?php echo e(Session::get('error')); ?>

				</div>
				<?php endif; ?>

				<form method="post" action="<?php echo e(url('printOG')); ?>">

					<?php if($errors->any()): ?>
					<div class="alert alert-danger">
						<?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<li><?php echo e($error); ?></li>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					</div>
					<?php endif; ?>
					
					<?php echo e(csrf_field()); ?>


					<select name="rec" class="form-control">
						<option value="">Select</option>
						<?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<option><?php echo e($row->rec); ?></option>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					</select>

					<input type="submit" name="" value="Continue" class="btn btn-primary">

				</form>

			</div>
		</div>


	</div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Library/WebServer/Documents/physio/resources/views/OG/ogData.blade.php ENDPATH**/ ?>                                                                                                                      