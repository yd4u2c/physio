   </td>
                          </tr>
                          <tr>
                            <td>Dynamic sitting<input type="text" name="test[]" value="Dynamic sitting" readonly style="display: none;"></td>
                            <td>
                              <select name="answer[]" class="form-control">
                                <option value="GOOD">GOOD</option>
                                <option value="FAIR">FAIR</option>
                                <option value="BAD">BAD</option>
                              </select>
                            </td>
                          </tr>
                          <tr>
                            <td>Functional Reach<input type="text" name="test[]" value="Functional Reach" readonly style="display: none;"></td>
                            <td>
                              <select name="answer[]" class="form-control">
                                <option value="GOOD">GOOD</option>
                                <option value="FAIR">FAIR</option>
                                <option value="BAD">BAD</option>
                              </select>
                            </td>
                          </tr>
                          <tr>
                            <td>Single leg balance<input type="text" name="test[]" value="Single leg balance" readonly style="display: none;"></td>
                            <td>
                              <select name="answer[]" class="form-control">
                                <option value="GOOD">GOOD</option>
                                <option value="FAIR">FAIR</option>
                                <option value="BAD">BAD</option>
                              </select>
                            </td>
                          </tr>
                          <tr>
                            <td>Romberg test<input type="text" name="test[]" value="Romberg test" readonly style="display: none;"></td>
                            <td>
                              <select name="answer[]" class="form-control">
                                <option value="GOOD">GOOD</option>
                                <option value="FAIR">FAIR</option>
                                <option value="BAD">BAD</option>
                              </select>
                            </td>
                          </tr>
                          <tr>
                            <td>Other<input type="text" name="test[]" value="other" readonly style="display: none;"></td>
                            <td>
                              <input type="text" value="*" name="answer[]" class="form-control">
                            </td>
                          </tr>

                        </table>

          <input type="submit" name="Continue" class="btn btn-primary">

        </form>

      </div>
    </div>


  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Library/WebServer/Documents/physio/resources/views/ort/ortTenth.blade.php ENDPATH**/ ?>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               <?php $__env->startSection('content'); ?>
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

				<form method="post" action="fitSearch">

					<?php if($errors->any()): ?>
					<div class="alert alert-danger">
						<?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<li><?php echo e($error); ?></li>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					</div>
					<?php endif; ?>
					
					<?php echo e(csrf_field()); ?>


					<div class="form-group">
						<label>Patient System number</label>
						<input type="text" name="sys_num" class="form-control">
					</div>

					<input type="submit" name="" value="Search" class="btn btn-primary">

				</form>

			</div>
		</div>


    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Library/WebServer/Documents/physio/resources/views/fitness/index.blade.php ENDPATH**/ ?>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 <?php $__env->startSection('content'); ?>
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
									<option value="Min Asst">Min Asst</option>
									<option value="Supervision">Supervision</option>
									<option value="Modified independent">modified independent</option>
									<option value="independent">independent</option>
								</select>
							</td>
							<td>
								<textarea name="Comment[]" required class="form-control" placeholder="Enter comment here"></textarea>
							</td>
						</tr>
						<tr>
							<td>Hygiene/grooming<input type="text" name="issue[]" value="Hygiene/grooming" style="display: none;"></td>
							<td>
								<select name="answer[]" class="form-control">
									<option value="Dependent">Dependent</option>
									<option value="DeMax Asst">Max Asst</option>
									<option value="Mod Asst">Mod Asst</option>
									<option value="Min Asst">Min Asst</option>
									<option value="Supervision">Supervision</option>
									<option value="Modified independent">modified independent</option>
									<option value="independent">independent</option>
								</select>
							</td>
							<td>
								<textarea name="Comment[]" required class="form-control" placeholder="Enter comment here"></textarea>
							</td>
						</tr>
						<tr>
							<td>Upper body(UB) bathing<input type="text" name="issue[]" value="Upper body(UB) bathing" style="display: none;"></td>
							<td>
								<select name="answer[]" class="form-control">
									<option value="Dependent">Dependent</option>
									<option value="DeMax Asst">Max Asst</option>
									<option value="Mod Asst">Mod Asst</option>
									<option value="Min Asst">Min Asst</option>
									<option value="Supervision">Supervision</option>
									<option value="Modified independent">modified independent</option>
									<option value="independent">independent</option>
								</select>
							</td>
							<td>
								<textarea name="Comment[]" required class="form-control" placeholder="Enter comment here"></textarea>
							</td>
						</tr>
						<tr>
							<td>Upper Body dressing<input type="text" name="issue[]" value="Upper Body dressing" style="display: none;"></td>
							<td>
								<select name="answer[]" class="form-control">
									<option value="Dependent">Dependent</option>
									<option value="DeMax Asst">Max Asst</option>
									<option value="Mod Asst">Mod Asst</option>
									<option value="Min Asst">Min Asst</option>
									<option value="Supervision">Supervision</option>
									<option value="Modified independent">modified independent</option>
									<option value="independent">independent</option>
								</select>
							</td>
							<td>
								<textarea name="Comment[]" required class="form-control" placeholder="Enter comment here"></textarea>
							</td>
						</tr>
						<tr>
							<td>Bathing/shower<input type="text" name="issue[]" value="Bathing/shower" style="display: none;"></td>
							<td>
								<select name="answer[]" class="form-control">
									<option value="Dependent">Dependent</option>
									<option value="DeMax Asst">Max Asst</option>
									<option value="Mod Asst">Mod Asst</option>
									<option value="Min Asst">Min Asst</option>
									<option value="Supervision">Supervision</option>
									<option value="Modified independent">modified independent</option>
									<option value="independent">independent</option>
								</select>
							</td>
							<td>
								<textarea name="Comment[]" required class="form-control" placeholder="Enter comment here"></textarea>
							</td>
						</tr>
						<tr>
							<td>Toilet transfer<input type="text" name="issue[]" value="Toilet transfer" style="display: none;"></td>
							<td>
								<select name="answer[]" class="form-control">
									<option value="Dependent">Dependent</option>
									<option value="DeMax Asst">Max Asst</option>
									<option value="Mod Asst">Mod Asst</option>
									<option value="Min Asst">Min Asst</option>
									<option value="Supervision">Supervision</option>
									<option value="Modified independent">modified independent</option>
									<optio