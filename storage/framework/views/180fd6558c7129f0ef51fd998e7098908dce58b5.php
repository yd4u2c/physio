<?php $__env->startSection('content'); ?>
<div class="container">
	<div class="row">

		<div class="panel panel-primary col-sm-10">
			<div class="panel-heading">Pregnancy and birth History</div>
			<div class="panel-body">

				<form method="post" action="<?php echo e(url('/paePage4')); ?>">
					<?php echo e(csrf_field()); ?>


					<?php if($errors->any()): ?>
					<div class="alert alert-danger">
						<?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<li><?php echo e($error); ?></li>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					</div>
					<?php endif; ?>

					<table  class="table">
						<tr>
							<td>
								<input type="text" name="issue[]" value="Were there any complication during pregnancy" readonly class="form-control" id="exampleInputEmail1" />
							</td>
							<td>
								<label>Yes <input type="checkbox" name="answer[]" value="yes"></label>&nbsp;&nbsp;&nbsp;
								<label>No <input type="checkbox" name="answer[]" value="no"></label>
							</td>
							<td>
								<input type="text" name="comment[]" placeholder="If Yes, Please comment" class="form-control" id="exampleInputEmail1" />
							</td>
						</tr>
						<tr>
							<td>
								<input type="text" name="issue[]" value="was the pregnancy full term" readonly class="form-control" id="exampleInputEmail1" />
							</td>
							<td>
								<label>Yes <input type="checkbox" name="answer[]" value="yes"></label>&nbsp;&nbsp;&nbsp;
								<label>No <input type="checkbox" name="answer[]" value="no"></label>
							</td>
							<td>
								<input type="text" name="comment[]" placeholder="If no, Please comment" class="form-control" id="exampleInputEmail1" />
							</td>
						</tr>
						<tr>
							<td>
								<input type="text" name="issue[]" value="was labour and delivery normal" readonly class="form-control" id="exampleInputEmail1" />
							</td>
							<td>
								<label>Yes <input type="checkbox" name="answer[]" value="yes"></label>&nbsp;&nbsp;&nbsp;
								<label>No <input type="checkbox" name="answer[]" value="no"></label>
							</td>
							<td>
								<input type="text" name="comment[]" placeholder="If no, Please comment" class="form-control" id="exampleInputEmail1" />
							</td>
						</tr>
					</table>

					<div class="form-group">
							Birth Weight: <input type="text" name="weight" placeholder="Birth Weight" required="">
						</div>

					<div class="checkbox">
						<label><input type="checkbox"> I have reviewed the information provided above and I found them to be accurate</label>
					</div>

					<div class="form-group">
						<label for="exampleInputEmail1">Physiotherapist (Name)</label>
						<input type="text" value="<?php echo e(Auth::User()->name); ?>" readonly required name="physio_name" class="form-control" id="exampleInputEmail1" />
					</div>

					<p>&nbsp;</p>
					<textarea name="info" placeholder="Other related information" class="form-control"></textarea>
					<p>&nbsp;</p>


					<input type="submit" name="submit" class="btn btn-primary">

				</form>

			</div>
		</div>


	</div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Library/WebServer/Documents/physio/resources/views/pae/paeForth.blade.php ENDPATH**/ ?>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  <?php $__env->startSection('content'); ?>
<div class="container">
	<div class="row">

		<?php if(Session::has('success')): ?>
		<div class="alert alert-success">
			<?php echo e(Session::get('success')); ?>

		</div>
		<?php endif; ?>

		<div class="panel panel-primary col-lg-12">
			<div class="panel-heading">All Patient</div>
			<div class="panel-body">

				<table class="table table-bordered">
					<tr>
						<th>Name</th>
						<th>Physio Number</th>
						<th>Patient Number</th>
						<th>Date of Birth</th>
						<th>phone</th>
						<th>Gender</th>
						<th>Passport</th>
						<th></th>
						<th>Print card</th>
					</tr>

					<?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<tr>
						<td><?php echo e($row->name); ?></td>
						<td><?php echo e($row->physio); ?></td>
						<td><?php echo e($row->sys_num); ?></td>
						<td><?php echo e($row->dob); ?></td>
						<td><?php echo e($row->phone); ?></td>
						<td><?php echo e($row->gender); ?></td>
						<td><img src="images/<?php echo e($row->photo); ?>" style="height: 100px; width: 100px;"></td>
						<td><a href="<?php echo e(url('patientEdit/'.$row->id)); ?>">Edit</a></td>
						<td><a href="<?php echo e(url('patientprint/'.$row->id)); ?>">print</a></td>
					</tr>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				</table>
				<?php echo e($data->links()); ?>


			</div>
		</div>


	</div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\physio\resources\views/front/allPatient.blade.php ENDPATH**/ ?>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               <?php $__env->startSection('content'); ?>
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
                                <th colspan="2">Motivation</th>
                            </tr>
                            <tr>
                                <td>Shows awareness of strengths & limitations<input type="text" name="question[]" value="Shows awareness of strengths & limitations" style="display: none;"></td>
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
                                <td>Shows pride/seeks challenges<input type="text" name="question[]" value="Shows pride/seeks challenges" style="display: none;"></td>
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
                                <td>Shows curiosity and demonstrates interest<input type="text" name="question[]" value="Shows curiosity and demonstrates interest" style="display: none;"></td>
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
                                <td>Identiﬁes preferences/is goal-oriented<input type="text" name="question[]" value="Identiﬁes preferences/is goal-oriented" style="display: none;"></td>
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
                        </table>

                        <input type="hidden" name="type" value="motivation">

					<input type="submit" name="" value="Continue" class="btn btn-primary">

				</form>

			</div>
		</div>


	</div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\physio\resources\views/mental/menSecond.blade.php ENDPATH**/ ?>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               <?php $__env->startSection('content'); ?>
<div class="container">
  <div class="row">

    <div class="panel panel-primary col-sm-6">
      <div class="panel-heading">*******</div>
      <div class="panel-body">

        <?php if(Session::has('error')): ?>
        <div class="alert alert-danger">
          <?php echo e(Session::get('error')); ?>

        </div>
        <?php endif; ?>

        <form method="post" action="ortPage12">

          <?php if($errors->any()): ?>
          <div class="alert alert-danger">
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </div>
          <?php endif; ?>
          
          <?php echo e(csrf_field()); ?>


          <div class="form-group">
            <label for="exampleInputEmail1">Endurance</label>
            <input type="text" class="form-control" name="endurance"  required class="form-control" id="exampleInputEmail1" />
          </div>
          <table class="table" border="1">
            <tr>
              <th colspan="2" class="text-center">Special Tests</th>
            </tr>
            <tr>
              <td><input type="text" class="form-control" name="test[]" value="Slump Test" readonly></td>
              <td>
                <select name="answer[]">
                  <option value="+ve">+ve</option>
                  <option value="-ve">-ve</option>
                </select>
              </td>
            </tr>
            <tr>
              <td><input type="text" class="form-control" name="test[]" value="Straight Leg Raise Test" readonly></td>
              <td>
                <select name="answer[]">
                  <option value="+ve">+ve</option>
                  <option value="-ve">-ve</option>
                </select>
              </td>
            </tr>
            <tr>
              <td><input type="text" class="form-control" name="test[]" value="Cram Test" readonly></td>
              <td>
                <select name="answer[]">
                  <option value="+ve">+ve</option>
                  <option value="-ve">-ve</option>
                </select>
              </td>
            </tr>
            <tr>
              <td><input type="text" class="form-control" name="test[]" value="Sign of the Buttock Test" readonly></td>
              <td>
                <select name="answer[]">
    