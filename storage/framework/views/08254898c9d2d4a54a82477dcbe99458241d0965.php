      <input type="radio" name="situation"  value="Caregiver" />Caregiver &nbsp;&nbsp;&nbsp;<br>
          <h4>Please choose from below if <b>caregiver is choose from above</b></h4>
          <input type="checkbox" name="living[]"  value="Able to assist with program" />Able to assist with program &nbsp;&nbsp;&nbsp;
          <input type="checkbox" name="living[]"  value="Unable to assist with program" />Unable to assist with program &nbsp;&nbsp;&nbsp;
          <input type="checkbox" name="living[]"  value="Willing to assist with program" />Willing to assist with program &nbsp;&nbsp;&nbsp;
          <input type="checkbox" name="living[]"  value="Unwilling to assist with program" />Unwilling to assist with program &nbsp;&nbsp;&nbsp;
          <p>&nbsp;</p>
      </div>
      <div class="form-group">
          <label for="exampleInputEmail1"><b>Equipment in Home</b></label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <input type="checkbox" name="home[]"  value="Walker" />Walker &nbsp;&nbsp;&nbsp;
          <input type="checkbox" name="home[]"  value="Cane" />Cane &nbsp;&nbsp;&nbsp;
          <input type="checkbox" name="home[]"  value="Wheelchair" />Wheelchair &nbsp;&nbsp;&nbsp;
          <input type="checkbox" name="home[]"  value="Bath/Shower Seat" />Bath/Shower Seat &nbsp;&nbsp;&nbsp;
          <input type="checkbox" name="home[]"  value="Grab Bars" />Grab Bars &nbsp;&nbsp;&nbsp;
          <input type="checkbox" name="home[]"  value="3-in-1 Commode" />3-in-1 Commode &nbsp;&nbsp;&nbsp;
          <input type="checkbox" name="home[]"  value="Raised Toilet Seat" />Raised Toilet Seat &nbsp;&nbsp;&nbsp;
          <input type="text" name="home[]" value="*"  placeholder="other" />
      </div>
  </div>

  <input type="submit" name="Continue" class="btn btn-primary">

</form>

</div>
</div>


</div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\physio\resources\views/ort/ortThird.blade.php ENDPATH**/ ?>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             <?php $__env->startSection('content'); ?>
<div class="container">
	<div class="row">

		<div class="panel panel-primary col-sm-10">
			<div class="panel-heading">Work/Leisure participation</div>
			<div class="panel-body">

				<?php if(Session::has('error')): ?>
				<div class="alert alert-danger">
					<?php echo e(Session::get('error')); ?>

				</div>
				<?php endif; ?>

				<form method="post" action="occPage4">

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
              <th>Work/Leisure participation</th>
              <th></th>
              <th>Comment</th>
            </tr>
            <tr>
              <td>Education (formal and informal)<input type="text" name="issue[]" value="Education (formal and informal)" style="display: none;"></td>
              <td>
                <select name="answer[]" class="form-control">
                  <option value="impaired">impaired</option>
                  <option value="not impaired">not impaired</option>
                  <option value="Not applicable">Not Applicable</option>
                </select>
              </td>
              <td>
                <textarea name="Comment[]" required="" class="form-control" placeholder="Enter comment here"></textarea>
              </td>
            </tr>
            <tr>
              <td>Work Employment/Volunteer<input type="text" name="issue[]" value="Work Employment/Volunteer" style="display: none;"></td>
              <td>
                <select name="answer[]" class="form-control">
                  <option value="impaired">impaired</option>
                  <option value="not impaired">not impaired</option>
                  <option value="Not applicable">Not Applicable</option>
                </select>
              </td>
              <td>
                <textarea name="Comment[]" required=""