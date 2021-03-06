<p>From whom did your child receive his additional therapy service: <b> <?php echo e($row->whom); ?> </b></p>
					<p>Additional coments on therapy service: <b> <?php echo e($row->tp_comment); ?> </b></p>
					<p>Are there any religious or cultural issues that we should be aware of regarding your child's evaluation: <b> <?php echo e($row->religious); ?> </b></p>					

					<p><h3 style='text-align: center'>PATIENT GOALS FOR THE THERAPHY</h3></p>
					<p>What goals are you hoping to have your child accomplish by partici[ating in Therapy: <b> <?php echo e($row->goal); ?> </b></p>
					<p><h3 style='text-align: center'>ADDITIONAL RELEVANT INFORMATION</h3></p>
					<p>Theraphist use only: <b> <?php echo e($row->info); ?> </b></p>

					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

				</div>
				<div class="box">
					<h3 style="text-align: center;">GUARDIAN SIGNATURE</h3>
					<span style="text-align: center; font-size: 12px;">To the best of my knowledge, I have fully informed you of the history of my child's problrm and current status.</span>
					<p>&nbsp;</p>
					<p><b>Patient Guardian's signature:............................................................. Date:.............................</b></p>
					<p>&nbsp;</p>
					<p><b>Relationship to Patient: ..............................................................</b></p>
				</div>
				<div class="box">
					<h3 style="text-align: center;">THERAPIST SIGNATURE</h3>
					<span style="text-align: center;">The information represents all significant subjective findings.<br>Please refer to the enclosed objective findings and plan of core for my assesment, treatment goals and treatment plans</span>
					<p>&nbsp;</p>
					<p><b>Therapist's signature:................................... License # ...................... Date:.............................</b></p>
					<p><b>Therapist Name: <?php echo e($row->physio_name); ?></b></p>
				</div>




			</div>
		</div>


	</div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Library/WebServer/Documents/physio/resources/views/pae/paePrint.blade.php ENDPATH**/ ?>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <?php $__env->startSection('content'); ?>
<div class="container">
	<div class="row">

		<div class="panel panel-primary col-sm-10">
			<div class="panel-heading">Activities of Daily living(ADL Status)</div>
			<div class="panel-body">

				<?php if(Session::has('error')): ?>
				<div class="alert alert-danger">
					<?php echo e(Session::get('error')); ?>

				</div>
				<?php endif; ?>

				<form method="post" action="occPage2">

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
							<th>issue</th>
							<th></th>
							<th>Comment</th>
						</tr>
						<tr>
							<td>Self-feeding<input type="text" name="issue[]" value="Self-feeding" style="display: none;"></td>
							<td>
								<select name="answer[]" class="form-control">
									<option value="Dependent">Dependent</option>
									<option value="DeMax Asst">Max Asst</option>
									<option value="Mod Asst">Mod Asst</option>
									<option value="Min Asst"