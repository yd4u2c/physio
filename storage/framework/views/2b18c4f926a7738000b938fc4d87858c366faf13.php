<?php $__env->startSection('content'); ?>
<div class="container">
	<div class="row">

		<div class="panel panel-primary col-sm-6">
			<div class="panel-heading">INTERVENTION</div>
			<div class="panel-body">

				<?php if(Session::has('error')): ?>
				<div class="alert alert-danger">
					<?php echo e(Session::get('error')); ?>

				</div>
				<?php endif; ?>

				<form method="post" action="occPage7">

					<?php if($errors->any()): ?>
					<div class="alert alert-danger">
						<?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<li><?php echo e($error); ?></li>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					</div>
					<?php endif; ?>
					
					<?php echo e(csrf_field()); ?>


					<div class="form-group">
            <label>Patient/family goals</label>
            <input type="text" name="patient" required="" class="form-control">
          </div>

          <div class="form-group">
            <label>Analysis of Occupational performance</label>
            <textarea class="form-control" required="" name="analysis"></textarea>
          </div>

          <div class="form-group">
            <label>Short-term goals</label>
            <textarea class="form-control" required="" name="short_goal"></textarea>
          </div>

          <div class="form-group">
            <label>Long-term goals</label>
            <textarea class="form-control" required="" name="long_goal"></textarea>
          </div>

          <div class="form-group">
            <label>OT intervention plan</label>
            <textarea class="form-control" name="OT" required=""></textarea>
          </div>

          <div class="form-group">
            <label>Frequency/duration</label>
            <textarea class="form-control" name="frequency" required=""></textarea>
          </div>

          <div class="form-group">
            <label>Therapist’s Name</label>
            <input type="text" value="<?php echo e(\Auth::User()->name); ?>" readonly class="form-control" name="therapist" placeholder="Therapist’s name" required>
          </div>

          <input type="submit" name="" value="Continue" class="btn btn-primary">

        </form>

      </div>
    </div>


  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Library/WebServer/Documents/physio/resources/views/occp/occSeven.blade.php ENDPATH**/ ?>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      <?php $__env->startSection('content'); ?>
<div class="container">
  <div class="row">

    <div class="panel panel-primary col-sm-9">
      <div class="panel-heading">*******</div>
      <div class="panel-body">

        <?php if(Session::has('error')): ?>
        <div class="alert alert-danger">
          <?php echo e(Session::get('error')); ?>

        </div>
        <?php endif; ?>

        <form method="post" action="ortPage11">

          <?php if($errors->any()): ?>
          <div class="alert alert-danger">
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </div>
          <?php endif; ?>
          
          <?php echo e(csrf_field()); ?>


          <div class="form-group" style="background: #fff;">
            <p>&nbsp;</p>
            <label for="exampleInputEmail1"><b>Deviations</b></label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="checkbox" name="Deviations[]"  value="Decrease heel toe gait" />Decrease heel toe gait &nbsp;&nbsp;&nbsp;
            <input type="checkbox" name="Deviations[]"  value="Decrease reciprocal arm swing" />Decrease reciprocal arm swing &nbsp;&nbsp;&nbsp;
            <input type="checkbox" name="Deviations[]"  value="Decrease base of support" />Decrease base of support &nbsp;&nbsp;&nbsp;
            <input type="checkbox" name="Deviations[]"  value="Loss of balance (LOB)" />Loss of balance (LOB) &nbsp;&nbsp;&nbsp;
            <input type="checkbox" name="Deviations[]"  value="Antalgic gait" />Antalgic gait &nbsp;&nbsp;&nbsp;
            <input type="checkbox" name="Deviations[]"  value="Shuffling gait" />Shuffling gait &nbsp;&nbsp;&nbsp;
            <input type="checkbox" name="Deviations[]"  value="Waddling Cadence (Fast/Slow)" />Waddling Cadence (Fast/Slow) &nbsp;&nbsp;&nbsp;
            <input type="checkbox" name="Deviations[]"  value="Festinating" />Festinating &nbsp;&nbsp;&nbsp;
            <input type="text" name="Deviations[]" value="*"  placeholder="Enter other here" /> &nbsp;&nbsp;&nbsp;
            <p>&nbsp;</p>
          </div>

          <input type="submit" name="Continue" class="btn btn-primary">

        </form>

      </div>
    </div>


  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Library/WebServer/Documents/physio/resources/views/ort/ortEleven.blade.php ENDPATH**/ ?>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  