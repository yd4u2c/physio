              <td><input type="text" required="" name="tAROM[]"></td>
              <td><input type="text" required="" name="tPROM[]"></td>
              <td><input type="text" required="" name="tend[]"></td>
            </tr>
            <tr>
              <td><input type="text" required="" name="issue[]" value="ER" readonly></td>
              <td><input type="text" required="" name="cAROM[]"></td>
              <td><input type="text" required="" name="cPROM[]"></td>
              <td><input type="text" required="" name="cend[]"></td>
              <td><input type="text" required="" name="tAROM[]"></td>
              <td><input type="text" required="" name="tPROM[]"></td>
              <td><input type="text" required="" name="tend[]"></td>
            </tr>
            <tr>
              <th>Elbow:</th>
              <td colspan="6"></td>
            </tr>
            <tr>
              <td>Elbow Flexion<input type="text" required="" name="issue[]" value="Elbow Flexion" style="display: none;" readonly></td>
              <td><input type="text" required="" name="cAROM[]"></td>
              <td><input type="text" required="" name="cPROM[]"></td>
              <td><input type="text" required="" name="cend[]"></td>
              <td><input type="text" required="" name="tAROM[]"></td>
              <td><input type="text" required="" name="tPROM[]"></td>
              <td><input type="text" required="" name="tend[]"></td>
            </tr>
            <tr>
              <td>Elbow Extension<input type="text" required="" name="issue[]" style="display: none;" value="Elbow Extension" readonly></td>
              <td><input type="text" required="" name="cAROM[]"></td>
              <td><input type="text" required="" name="cPROM[]"></td>
              <td><input type="text" required="" name="cend[]"></td>
              <td><input type="text" required="" name="tAROM[]"></td>
              <td><input type="text" required="" name="tPROM[]"></td>
              <td><input type="text" required="" name="tend[]"></td>
            </tr>
            <tr>
              <th>Wrist:</th>
              <td colspan="6"></td>
            </tr>
            <tr>
              <td>Wrist Flexion<input type="text" required="" name="issue[]" value="Wrist Flexion" style="display: none;" readonly></td>
              <td><input type="text" required="" name="cAROM[]"></td>
              <td><input type="text" required="" name="cPROM[]"></td>
              <td><input type="text" required="" name="cend[]"></td>
              <td><input type="text" required="" name="tAROM[]"></td>
              <td><input type="text" required="" name="tPROM[]"></td>
              <td><input type="text" required="" name="tend[]"></td>
            </tr>
            <tr>
              <td>Wrist Extension<input type="text" required="" name="issue[]" style="display: none;" value="Wrist Extension" readonly></td>
              <td><input type="text" required="" name="cAROM[]"></td>
              <td><input type="text" required="" name="cPROM[]"></td>
              <td><input type="text" required="" name="cend[]"></td>
              <td><input type="text" required="" name="tAROM[]"></td>
              <td><input type="text" required="" name="tPROM[]"></td>
              <td><input type="text" required="" name="tend[]"></td>
            </tr>
            <tr>
              <td colspan="6"><textarea class="form-control" required="" name="comments" placeholder="Enter comments here"></textarea></td>
            </tr>
          </table>

          <input type="submit" name="Continue" class="btn btn-primary">

        </form>

      </div>
    </div>


  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\physio\resources\views/ort/ortFifth.blade.php ENDPATH**/ ?>                                                                                                                                                                                   <?php $__env->startSection('content'); ?>
<div class="container">
	<div class="row">

		<div class="panel panel-primary col-sm-8">
			<div class="panel-heading">Social history, Interest and Living Environment</div>
			<div class="panel-body">

				<form method="post" action="<?php echo e(url('/paePage9')); ?>">
					<?php echo e(csrf_field()); ?>


					<?php if($errors->any()): ?>
					<div class="alert alert-danger">
						<?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<li><?php echo e($error); ?></li>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					</div>
					<?php endif; ?>

					<table class="table" border="1">
						<tr>
							<td><input type="text" name="fname" class="form-control" required placeholder="Enter Fathers name"></td>
							<td><input type="number" name="fage" class="form-control" required placeholder="Father age" min="1"></td>
							<td><input type="text" name="focc" class="form-control" required placeholder="Enter Fathers occupation"></td>
						</tr>
						<tr>
							<td><input type="text" name="mname" class="form-control" required placeholder="Enter Mother's name"></td>
							<td><input type="number" name="mage" class="form-control" required placeholder="Mother's age" min="1"></td>
							<td><input type="text" name="mocc" class="form-control" required placeholder="Enter mother's occupation"></td>
						</tr>
					</table>
					<p>&nbsp;</p>
					<div class="form-group">
						<label>Is she Adopted</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<label><input type="radio" name="adopt" value="yes"> Yes</label>
						<label><input type="radio" name="adopt" value="no"> no</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="text" name="age"  placeholder="If Yes, Input age adopted" style="width: 40%">
					</div>
					<div class="form-group">
						<label>Parents's Marital status</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" name="marry" value="married"> Married &nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" name="marry" value="living together"> living together &nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" name="marry" value="seperated"> seperated &nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" name="marry" value="divorced"> Divorced &nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" name="marry" value="Remarried"> Re-Married &nbsp;&nbsp;&nbsp;&nbsp;
					</div>
					<div class="form-group">
						<label>Who lives in the house with the child</label>
						<input type="text" name="live" class="form-control">
					</div>

					<hr>
					<div class="checkbox">
						<label><input type="checkbox"> I have reviewed the information provided above and I found them to be accurate</label>
					</div>
					<div class="form-group">
						<label for="exampleInputEmail1">Physiotherapist (Name)</label>
						<input type="text" value="<?php echo e(\Auth::User()->name); ?>" readonly required name="physio" class="form-control" id="exampleInputEmail1" />
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

<?php echo $__env->make('l