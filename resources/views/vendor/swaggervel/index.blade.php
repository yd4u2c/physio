label><br>&nbsp;&nbsp;&nbsp;&nbsp;
							If yes&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <label><input type="checkbox" name="treatment[]" value="x-rays">x-rays</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<label><input type="checkbox" name="treatment[]" value="MRI">MRI</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<label><input type="checkbox" name="treatment[]" value="EMG/Nerve conduction test"> EMG/Nerve conduction test</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							Enter-other-here <input value="*" type="text" name="treatment[]">
						</div>
						<div class="form-group w3-sand">
							<label class="text-left">if yes, please explain</label>
							<textarea class="form-control" required="" name="explain"></textarea>
						</div>
					</div>
					<div class="form-group col-md-12">
						<label>Date of next Doctor’s appointment</label>
						<input type="date" name="dt" class="form-control">
					</div>
					<div class="form-group col-md-12">
						<label>I have reviewed the information provided and found it to be complete</label>
						<input type="text" readonly name="physio" value="<?php echo e(\Auth::User()->name); ?>" class="form-control">
					</div>
					<div class="form-group col-md-12">
						<label>Subjective history</label>
						<textarea class="form-control" name="info" placeholder="enter Subjective history here"></textarea>
					</div>


					<input type="submit" name="" value="Continue" class="btn btn-primary">

				</form>

			</div>
		</div>


	</div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\physio\resources\views/OG/ogSecond.blade.php ENDPATH**/ ?>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             <?php $__env->startSection('content'); ?>
<div class="container">
  <div class="row">

    <div class="panel panel-primary col-sm-10">
      <div class="panel-heading">*******</div>
      <div class="panel-body">

        <?php if(Session::has('error')): ?>
        <div class="alert alert-danger">
          <?php echo e(Session::get('error')); ?>

        </div>
        <?php endif; ?>

        