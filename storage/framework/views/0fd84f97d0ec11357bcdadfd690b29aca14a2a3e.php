<?php $__env->startSection('content'); ?>
<div class="container">
	<div class="row">

		<div class="panel panel-primary col-sm-5" style="border: none;">
			<div class="panel-heading" id="printPageButton">Print Card</div>
			<div class="panel-body">
				<button onclick="window.print();" id="printPageButton">Print</button>

				<div class="box" style="border: 1px solid #000; width: 420px; height: 200px; padding: 10px; text-transform: uppercase;">
					<div class="box2">
						<img src="../images/fmc.jpg" height="50" width="50">
						<h3 style="margin-top: -1px; margin-left: 50px; margin-top: -50px;"><b>FEDERAL MEDICAL CENTER</b></h3>
						<center><b>Idi-Aba, Abeokuta</b></center>
						<center>Physiotherapy Unit Card</center>
						<?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<p>Name: <b><?php echo e($row->name); ?></b> <br>
							Physio No: <b><?php echo e($row->physio); ?></b> <br>
							System No: <b><?php echo e($row->sys_num); ?></b> <br>
							Phone No: <b><?php echo e($row->phone); ?></b> 

							<img src="../images/<?php echo e($row->photo); ?>" style="height: 100px; width: 100px; float: right; margin-top: -50px;">
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

						</div>
					</div>

				</div>
			</div>


		</div>
	</div>
	<style type="text/css">
	@media  print {
		#printPageButton {
			display: none;
		}
	}

</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\physio\resources\views/front/patientprint.blade.php ENDPATH**/ ?>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     