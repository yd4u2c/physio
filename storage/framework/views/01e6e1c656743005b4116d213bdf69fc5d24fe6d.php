<?php $__env->startSection('content'); ?>
<div class="container">
	<div class="row">

		<div class="panel panel-primary col-sm-11">
			<div class="panel-heading">HISTORY OF FITNESS PROGRAM</div>
			<div class="panel-body">

				<?php if(Session::has('error')): ?>
				<div class="alert alert-danger">
					<?php echo e(Session::get('error')); ?>

				</div>
				<?php endif; ?>

				<form method="post" action="fitPage2">

					<?php echo e(csrf_field()); ?>


					<?php if($errors->any()): ?>
					<div class="alert alert-danger">
						<?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<li><?php echo e($error); ?></li>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					</div>
					<?php endif; ?>
					
					<div class="col-md-4 form-group" >
						<label class="w3-text-black"><b>Previous participant in fitness program(s)</b></label><br/>
						&nbsp;&nbsp;<input class="w3-check" type="radio" name="previous" value="yes" >
						<label class="w3-text-black"><b>Yes</b></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

						<input class="w3-check" type="radio" name="previous" value="no">
						<label class="w3-text-black"><b>No</b></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					</div>

					<div class="col-md-4 form-group" >
						<label class="w3-text-black"><b>Duration of program</b></label>
						<input class="w3-input w3-border form-control w3-round" name="duration"  required="" type="text">
					</div>

					<div class="col-md-4 form-group" >
						<label class="w3-text-black"><b>Reason(s) for stopping</b></label>
						<input class="w3-input w3-border form-control w3-round" name="reason"  required="" type="text">
					</div>

					<div class="col-md-12" >
						<label class="w3-text-black"><b>Major reason(s) for wanting to participate in this fitness program:</b></label><br/>
						&nbsp;&nbsp;<input class="w3-check" type="radio" name="major" value="want to shed some weight">
						<label class="w3-text-black"><b> want to shed some weight </b></label>&nbsp;&nbsp;&nbsp;&nbsp;

						<input class="w3-check" type="radio" name="major" value="I want to be more fit">
						<label class="w3-text-black"><b>I want to be more fit</b></label>&nbsp;&nbsp;&nbsp;&nbsp;

						<input class="w3-check" type="radio" name="major" value="want to improve my shape">
						<label class="w3-text-black"><b> want to improve my shape</b></label>&nbsp;&nbsp;&nbsp;&nbsp;
						<input class="w3-check" type="radio" name="major" value="to regain my previous shape after child birth" >
						<label class="w3-text-black"><b>to regain my previous shape after child birth</b></label>
					</div>

					<p>&nbsp;</p>
					<div class="col-md-4 form-group" >
						<label class="w3-text-black"><b>Other reasons </b></label>
						<textarea class="w3-input w3-border form-control w3-round"  name="others" required=""></textarea>
					</div>

					<div class="col-md-12 form-group" >
						<p class="w3-text-black" style="text-align: center;" ><b>I hereby indicate my willingness to participate in the test and exercise program and to comply with all instructions I may be given. </b></p>
					</div>

					<div class="col-md-4 form-group" >
						<label class="w3-text-black" ><b>Signature</b></label>
						<input class="w3-input form-control" name="signature" readonly="" type="text">
					</div>

					<div class="col-md-4 form-group" >
						<label class="w3-text-black"><b>Date</b></label>
						<input class="w3-input form-control" type="date" name="date" required="" >
					</div>

					<div class="col-md-12 w3-text-black" ><h5 style="text-align: center;" ><b>EXAMINATION</b>&nbsp;(ANTHROPOMETTRIC MEASUREMENT)</h5>
					</div>

					<div class="col-md-2 form-group" >
						<label class="w3-text-black"><b>Height (m)</b></label>
						<input class="w3-input w3-border form-control w3-round" name="height" required="" type="text">
					</div>

					<div class="col-md-2 form-group" >
						<label class="w3-text-black"><b>Weight(Kg)</b></label>
						<input class="w3-input w3-border form-control w3-round" name="weight" required="" type="text">
					</div>

					<div class="col-md-2 form-group" >
						<label class="w3-text-black"><b>BMI(Kg/m2) </b></label>
						<input class="w3-input w3-border form-control w3-round" name="bm" required="" type="text">
					</div>

					<div class="col-md-2 form-group" >
						<label class="w3-text-black"><b>VITALS</b></label>
						<input class="w3-input w3-border form-control w3-round" name="vitals" required="" type="text">
					</div>

					<div class="col-md-2 form-group" >
						<label class="w3-text-black"><b>-BP (mmHg) </b></label>
						<input class="w3-input w3-border form-control w3-round" name="bp" required="" type="text">
					</div>

					<div class="col-md-2 form-group" >
						<label class="w3-text-black"><b>-PR(bpm) </b></label>
						<input class="w3-input w3-border form-control w3-round" type="text" name="pr" required="" >
					</div>

					<div class="col-md-3 form-group" >
						<label class="w3-text-black"><b>Waist Circumference(cm) </b></label>
						<input class="w3-input w3-border form-control w3-round" name="waist" required="" type="num" required="" >
					</div>
					<div class="col-md-3 form-group" >
						<label class="w3-text-black"><b>Hip Circumference (cm) </b></label>
						<input class="w3-input w3-border form-control w3-round" name="hip" required="" type="num" required="" >
					</div>
					<div class="col-md-3 form-group" >
						<label class="w3-text-black"><b>Waist to Hip Ratio</b></label>
						<input class="w3-input w3-border form-control w3-round" name="ratio" required="" type="num" required="" >
					</div>
					<div class="col-md-3 form-group" >
						<label class="w3-text-black"><b>Maximum Heart Rate(220-age) </b></label>
						<input class="w3-input w3-border form-control w3-round" name="heart" required="" type="num" required="" >
					</div>
					<div class="col-md-12 w3-text-black" >
						<p style="text-align: center;"  ><b>NB: Target Heart Rate for Moderate Intensity= 60-65% of Max HR</b></p>
					</div>
					<div class="col-md-12 w3-text-black" ><h5  ><b>OUTFITS FOR FITNESS AND PRECAUTION</b></h5>

					</div>
					<div class="col-md-12 w3-text-black" >
						<p style="text-align: center;"  ><b>      -   Wear appropriate outfit    -     No food for 2 hours    -    No caffeinated beverages.
							-    No alcohol for 24 hours before assessment / testing  <br>  -  No smoking for 2 hours before testing.
						</b></p>
					</div>
					<div class="col-md-6" >
						<label class="w3-text-black"><b>PLAN OF TREATMENT </b></label>
						<textarea class="w3-input w3-border form-control w3-round" name="plan" required=""></textarea>
					</div>

					<div class="col-md-6" >
						<label class="w3-text-black"><b>MEANS OF TREATMENT</b></label>
						<textarea class="w3-input w3-border form-control w3-round" name="means" required="" ></textarea>
					</div>

					<div class="col-md-12">
						<p>&nbsp;</p>
						<input type="submit" name="" value="Continue" class="btn btn-primary">
					</div>

				</form>

			</div>
		</div>


	</div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Library/WebServer/Documents/physio/resources/views/fitness/fitSecond.blade.php ENDPATH**/ ?>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             <?php $__env->startSection('content'); ?>
<div class="container">
	<div class="row">

		<div class="panel panel-primary col-sm-5">
			<div class="panel-heading">Add Report (Mental Helth)</div>
			<div class="panel-body">

				<?php if(Session::has('error')): ?>
				<div c