 />
					</div>

				<div class="col-sm-12">
					<div class="form-group" style="margin-left: 130px;">
						<label for="exampleInputEmail1"><b>Description</b></label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" name="des"  value="Intermittent" required />Intermittent &nbsp;&nbsp;&nbsp;
						<input type="radio" name="des"  value="Constant" required />Constant &nbsp;&nbsp;&nbsp;
						<input type="radio" name="des"  value="Dull" required />Dull &nbsp;&nbsp;&nbsp;
						<input type="radio" name="des"  value="Sharp" required />Sharp &nbsp;&nbsp;&nbsp;
					</div>
					<div class="form-group">
						<label for="exampleInputEmail1"><b>Additional Symptoms</b></label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="checkbox" name="additional[]"  value="Headache" />Headache &nbsp;&nbsp;&nbsp;
						<input type="checkbox" name="additional[]"  value="Radiating pain to UEs" />Radiating pain to UEs &nbsp;&nbsp;&nbsp;
						<input type="checkbox" name="additional[]"  value="numbness" />numbness &nbsp;&nbsp;&nbsp;
						<input type="checkbox" name="additional[]"  value="tingling" />tingling &nbsp;&nbsp;&nbsp;
						<input type="checkbox" name="additional[]"  value="dizziness" />dizziness &nbsp;&nbsp;&nbsp;
						<input type="checkbox" name="additional[]"  value="vision changes" />vision changes &nbsp;&nbsp;&nbsp;
						<input type="checkbox" name="additional[]"  value="hearing changes" />hearing changes &nbsp;&nbsp;&nbsp;
						<input type="checkbox" name="additional[]"  value="loss of balance" />loss of balance &nbsp;&nbsp;&nbsp;
						<input type="checkbox" name="additional[]"  value="nausea" />nausea &nbsp;&nbsp;&nbsp;
						<input type="text" name="additional[]"  placeholder="add additional symptoms" value="*" /> &nbsp;&nbsp;&nbsp;
					</div>

					<input type="submit" name="" value="Continue" class="btn btn-primary">

				</form>

			</div>
		</div>


	</div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Library/WebServer/Documents/physio/resources/views/ort/ortSecond.blade.php ENDPATH**/ ?>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          <?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row">

    	<div class="panel panel-primary col-sm-10">
         <div class="panel-heading">DIAGNOSIS / REASON FOR REFERRAL</div>
         <div class="panel-body">

            <?php if(Session::has('error')): ?>
            <div class="alert alert-danger">
               <?php echo e(Session::get('error')); ?>

           </div>
           <?php endif; ?>

           <form method="post" action="neuPage2">

               <?php if($errors->any()): ?>
               <div class="alert alert-danger">
                  <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <li><?php echo e($error); ?></li>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </div>
              <?php endif; ?>

              <?php echo e(csrf_field()); ?>



              <div class="form-group">
                <div class="col-lg-6 ">
                    <div class="form-group">
                        <div class="input-group w3_w3layouts col-lg-12">
                            <span class=