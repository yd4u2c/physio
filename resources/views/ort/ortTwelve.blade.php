                           <td>
                                      <textarea name="Comment[]" required="" class="form-control" placeholder="Enter comment here"></textarea>
                                  </td>
                              </tr>
                              <tr>
                                  <td>Other (e.g. sexual activity). <br>Please state this.<input type="text" name="issue[]" value="Other" style="display: none;"></td>
                                  <td>
                                      <input type="text" name="answer[]" class="form-control" required="" placeholder="enter other here">
                                  </td>
                                  <td>
                                      <textarea name="Comment[]" required="" class="form-control" placeholder="Enter comment here"></textarea>
                                  </td>
                              </tr>
                          </table>

					
					<input type="submit" name="" value="Continue" class="btn btn-primary">

				</form>

			</div>
		</div>


	</div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\physio\resources\views/occp/occThird.blade.php ENDPATH**/ ?>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             <?php $__env->startSection('content'); ?>
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
						<textarea name="explai