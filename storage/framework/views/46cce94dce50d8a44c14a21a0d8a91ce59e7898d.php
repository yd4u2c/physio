<?php $__env->startSection('content'); ?>
<div class="container">
	<div class="row">

		<div class="panel panel-primary col-sm-5">
			<div class="panel-heading">Subjective</div>
			<div class="panel-body">

				<?php if(Session::has('error')): ?>
				<div class="alert alert-danger">
					<?php echo e(Session::get('error')); ?>

				</div>
				<?php endif; ?>

				<form method="post" action="paePage2">

					<?php if($errors->any()): ?>
					<div class="alert alert-danger">
						<?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<li><?php echo e($error); ?></li>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					</div>
					<?php endif; ?>
					
					<?php echo e(csrf_field()); ?>


					<div class="form-group">
						<label for="exampleInputEmail1">Why are you seeking treatment for your child</label>
						<input type="text" name="reason" class="form-control" id="exampleInputEmail1" />
					</div>

					<div class="form-group">
						<label for="exampleInputEmail1">Has your child have any prior treatment and/or diagnostic testing for the condition stated above? &nbsp;&nbsp;&nbsp;</label>
						No<input type="radio" name="testing" id="one" class="css-checkbox" value="no" checked>&nbsp;&nbsp;&nbsp;
						Yes<input type="radio" name="testing" id="two" class="css-checkbox" value="yes">
					</div>
					<!--the drop form-->
					<div class="form-group" id="b">
						<label for="exampleInputEmail1">Specify (if yes)</label>
						<input type="text" name="specify"  class="form-control" id="exampleInputEmail1" />
						<p>&nbsp;</p>
						<textarea name="explain" placeholder="further explanation" class="form-control"></textarea>
					</div>
					<!--the drop form-->
					<div class="form-group">
						<label for="exampleInputEmail1">Date of next Doctor's appointment</label>
						<input type="date" name="appointment"  class="form-control" id="exampleInputEmail1" />
					</div>
					<div class="checkbox">
						<label><input type="checkbox" required> I have reviewed the information provided above and I found them to be accurate</label>
					</div>
					<div class="form-group">
						<label for="exampleInputEmail1">Physiotherapist (Name)</label>
						<input type="text" required value="<?php echo e(\Auth::User()->name); ?>" readonly name="physio_name" class="form-control" id="exampleInputEmail1" />
					</div>
					<p>&nbsp;</p>
					<textarea name="info" placeholder="Additional comments (Subjective history)" class="form-control"></textarea>
					<p></p>

					<input type="submit" name="" value="continue" class="btn btn-primary">

				</form>

			</div>
		</div>


	</div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\physio\resources\views/pae/paeSecond.blade.php ENDPATH**/ ?>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  <?php $__env->startSection('content'); ?>
<div class="container">
  <div class="row">

    <div class="panel panel-primary col-sm-12" style="overflow-y: scroll;">
      <div class="panel-heading">RANGE OF MOTION</div>
      <div class="panel-body">

        <?php if(Session::has('error')): ?>
        <div class="alert alert-danger">
          <?php echo e(Session::get('error')); ?>

        </div>
        <?php endif; ?>

        <form method="post" action="ortPage6">

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
              <th></th>
              <th colspan="3" style="text-align: center;">L Lower extremity</th>
              <th colspan="3" style="text-align: center;">R Lower Extremity</th>
            </tr>
            <tr>
              <td></td>
              <td>AROM</td>
              <td>PROM</td>
              <td>End Feel</td>
              <td>AROM</td>
              <td>PROM</td>
              <td>End Feel</td>
            </tr>
            <tr>
              <th>Hip:</th>
              <td colspan="6"></td>
            </tr>
            <tr>
              <td><input type="text" required name="issue[]" value="Flexion" readonly></td>
              <td><input type="text" required name="cAROM[]"></td>
              <td><input type="text" required name="cPROM[]"></td>
              <td><input type="text" required name="cend[]"></td>
              <td><input type="text" required name="tAROM[]"></td>
              <td><input type="text" required name="tPROM[]"></td>
              <td><input type="text" required name="tend[]"></td>
            </tr>
            <tr>
              <td><input type="text" required name="issue[]" value="Extension" readonly></td>
              <td><input type="text" required name="cAROM[]"></td>
              <td><input type="text" required name="cPROM[]"></td>
              <td><input type="text" required name="cend[]"></td>
              <td><input type="text" required name="tAROM[]"></td>
              <td><input type="text" required name="tPROM[]"></td>
              <td><input type="text" required name="tend[]"></td>
            </tr>
            <tr>
              <td><input type="text" required name="issue[]" value="Abduction" readonly></td>
              <td><input type="text" required name="cAROM[]"></td>
              <td><input type="text" required name="cPROM[]"></td>
              <td><input type="text" required name="cend[]"></td>
              <td><input type="text" required name="tAROM[]"></td>
              <td><input type="text" required name="tPROM[]"></td>
              <td><input type="text" required name="tend[]"></td>
            </tr>
            <tr>
              <td><input type="text" required name="issue[]" value="Adduction" readonly></td>
              <td><input type="text" required name="cAROM[]"></td>
              <td><input type="text" required name="cPROM[]"></td>
              <td><input type="text" required name="cend[]"></td>
              <td><input type="text" required name="tAROM[]"></td>
              <td><input type="text" required name="tPROM[]"></td>
              <td><input type="text" required name="tend[]"></td>
            </tr>
            <tr>
              <td><input type="text" required name="issue[]" value="IR" readonly></td>
              <td><input type="text" required name="cAROM[]"></td>
              <td><input type="text" required name="cPROM[]"></td>
              <td><input type="text" required name="cend[]"></td>
              <td><input type="text" required name="tAROM[]"></td>
              <td><input type="text" required name="tPROM[]"></td>
              <td><input type="text" required name="tend[]"></td>
            </tr>
            <tr>
              <td><input type="text" required name="issue[]" value="ER" readonly></td>
              <td><input type="text" required name="cAROM[]"></td>
              <td><input type="text" required name="cPROM[]"></td>
              <td><input type="text" required name="cend[]"></td>
              <td><input type="text" required name="tAROM[]"></td>
              <td><input type="text" required name="tPROM[]"></td>
              <td><input type="text" required name="tend[]"></td>
            </tr>
            <tr>
              <th>Knee:</th>
              <td colspan="6"></td>
            </tr>
            <tr>
              <td>Knee Flexion<input type="text" required name="issue[]" value="Knee Flexion" style="display: none;" readonly></td>
              <td><input type="text" required name="cAROM[]"></td>
              <td><input type="text" required name="cPROM[]"></td>
              <td><input type="text" required name="cend[]"></td>
              <td><input type="text" required name="tAROM[]"></td>
              <td><input type="text" required name="tPROM[]"></td>
              <td><input type="text" required name="tend[]"></td>
            </tr>
            <tr>
              <td>Knee Extension<input type="text" required name="issue[]" style="display: none;" value="Knee Extension" readonly></td>
              <td><input type="text" required name="cAROM[]"></td>
              <td><input type="text" required name="cPROM[]"></td>
              <td><input type="text" required name="cend[]"></td>
              <td><input type="text" required name="tAROM[]"></td>
              <td><input type="text" required name="tPROM[]"></td>
              <td><input type="text" required name="tend[]"></td>
            </tr>
            <tr>
              <th>Ankle:</th>
              <td colspan="6"></td>
            </tr>
            <tr>
              <td>Ankle Flexion<input type="text" required name="issue[]" value="Ankle Flexion" style="display: none;" readonly></td>
              <td><input type="text" required name="cAROM[]"></td>
              <td><input type="text" required name="cPROM[]"></td>
              <td><input type="text" required name="cend[]"></td>
              <td><input type="text" required name="tAROM[]"></td>
              <td><input type="text" required name="tPROM[]"></td>
              <td><input type="text" required name="tend[]"></td>
            </tr>
            <tr>
              <td>Ankle Extension<input type="text" required name="issue[]" style="display: none;" value="Ankle Extension" readonly></td>
              <td><input type="text" required name="cAROM[]"></td>
              <td><input type="text" required name="cPROM[]"></td>
              <td><input type="text" required name="cend[]"></td>
              <td><input type="text" required name="tAROM[]"></td>
              <td><input type="text" required name="tPROM[]"></td>
              <td><input type="text" required name="tend[]"></td>
            </tr>
            <tr>
              <td>Ankle Inversion<input type="text" required name="issue[]" value="Ankle Inversion" style="display: none;" readonly></td>
              <td><input type="text" required name="cAROM[]"></td>
              <td><input type="text" required name="cPROM[]"></td>
              <td><input type="text" required name="cend[]"></td>
              <td><input type="text" required name="tAROM[]"></td>
              <td><input type="text" required name="tPROM[]"></td>
              <td><input type="text" required name="tend[]"></td>
            </tr>
            <tr>
              <td>Ankle Eversion<input type="text" required name="issue[]" style="display: none;" value="Ankle Eversion" readonly></td>
              <td><input type="text" required name="cAROM[]"></td>
              <td><input type="text" required name="cPROM[]"></td>
              <td><input type="text" required name="cend[]"></td>
              <td><input type="text" required name="tAROM[]"></td>
              <td><input type="text" required name="tPROM[]"></td>
              <td><input type="text" required name="tend[]"></td>
            </tr>
            <tr>
              <td colspan="6"><textarea class="form-control" name="comments" placeholder="Enter comments here"></textarea></td>
            </tr>
          </table>

          <input type="submit" name="Continue" class="btn btn-primary">

        </form>

      </div>
    </div>


  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Library/WebServer/Documents/physio/resources/views/ort/ortSixth.blade.php ENDPATH**/ ?>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      