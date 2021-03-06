<?php $__env->startSection('content'); ?>
<div class="container">
	<div class="row">

		<div class="panel panel-primary col-sm-4">
			<div class="panel-heading">Check Report </div>
			<div class="panel-body">

				<?php if(Session::has('error')): ?>
				<div class="alert alert-danger">
					<?php echo e(Session::get('error')); ?>

				</div>
				<?php endif; ?>

				<form method="post" action="<?php echo e(url('chkortData')); ?>">

					<?php if($errors->any()): ?>
					<div class="alert alert-danger">
						<?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<li><?php echo e($error); ?></li>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					</div>
					<?php endif; ?>
					
					<?php echo e(csrf_field()); ?>


					<div class="form-group">
						<label>Eneter System Physio Number</label>
						<input type="text" name="num" class="form-control">
					</div>

					<input type="submit" name="" value="Continue" class="btn btn-primary">

				</form>

			</div>
		</div>


	</div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Library/WebServer/Documents/physio/resources/views/ort/chkReport.blade.php ENDPATH**/ ?>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <?php $__env->startSection('content'); ?>
<div class="container">
	<div class="row">

		<div class="panel panel-primary col-sm-10">
			<div class="panel-heading" id="printPageButton">PRINT OCCUPATIONAL THERAPHY</div>
			<div class="panel-body">

				
        <!-- Page Content Holder -->
        <div id="content w3-light-grey">
          <!-- top-bar -->
          <button onclick="window.print()" id="printPageButton">Print</button>
          <div style="background: #fff; margin-left: 30px; width: 700px; border: 1px solid #000;">
            <p>&nbsp;</p>
            <h3 class="text-center">FEDERAL MEDICAL CENTRE, ABEOKUTA</h3>
            <h4 class="text-center">OCCUPATIONAL THERAPY UNIT</h4>
            <h6 class="text-center">Occupational Therapy Initial Assessment</h6>


            <table class="table" border="1">
              <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <tr>
                <th>Name</th>
                <td><?php echo e($row->name); ?></td>
              </tr>
              <tr>
                <th>Date of Birth</th>
                <td><?php echo e($row->dob); ?></td>
              </tr>
              <tr>
                <th>Treatment Dx</th>
                <td> <?php echo e($row->treatment); ?> </td>
              </tr>
              <tr>
                <th>Past Medical/surgical Hx</th>
                <td><?php echo e($row->history); ?></td>
              </tr>
              <tr>
                <th>Medications</th>
                <td><?php echo e($row->medication); ?></td>
              </tr>
              <tr>
                <th>Date of Initial Assessment</th>
                <td><?php echo e($row->dt); ?></td>
              </tr>
              <tr>
                <th>Occupational Profile</th>
                <td><?php echo e($row->occupational); ?></td>
              </tr>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </table>


            <p>&nbsp;</p>
            <table class="table" border="1">
              <tr>
                <th colspan="3" class="text-center">Activities of Daily living(ADL Status)</th>
              </tr>
              <tr>
                <th></th>
                <th></th>
                <th>Comment</th>
              </tr>

                <?php $__currentLoopData = $data2; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                <th><?php echo e($row->issue); ?></th>
                <td><?php echo e($row->answer); ?></td>
                <td><?php echo e($row->comment); ?></td>
              </tr>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </table>
            <p>&nbsp;</p>
            <table class="table" border="1">
              <tr>
                <th colspan="3" class="text-center">Instrumental ADL Status</th>
              </tr>
              <tr>
                <th></th>
                <th></th>
                <th>Comment</th>
              </tr>
              
              <?php $__currentLoopData = $data3; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                <th><?php echo e($row->issue); ?></th>
                <td><?php echo e($row->answer); ?></td>
                <td><?php echo e($row->comment); ?></td>
              </tr>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

               </table>
              <p>&nbsp;</p>
              <table class="table" border="1">
                <tr>
                  <th colspan="3" class="text-center">Work/Leisure participation</th>
                </tr>
                <tr>
                  <th></th>
                  <th></th>
                  <th>Comment</th>
                </tr>
                
<?php $__currentLoopData = $data4; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                <th><?php echo e($row->issue); ?></th>
                <td><?php echo e($row->answer); ?></td>
                <td><?php echo e($row->comment); ?></td>
              </tr>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                  </table>
                <p>&nbsp;</p>
                <table class="table" border="1">
                  <tr>
                    <th colspan="3" class="text-center">Client Factors</th>
                  </tr>
                  <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th>Comment</th>
                  </tr>

                  <?php $__currentLoopData = $data5; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                <th><?php echo e($row->issue); ?></th>
                <th><?php echo e($row->tp); ?></th>
                <td><?php echo e($row->answer); ?></td>
                <td><?php echo e($row->comment); ?></td>
              </tr>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  
                    </table>
                  <p>&nbsp;</p>
                  <table class="table" border="1">
                    <tr>
                      <th colspan="3" class="text-center">Performance skills</th>
                    </tr>
                    <tr>
                      <th></th>
                      <th></th>
                      <th>Comment</th>
                    </tr>

                    <?php $__currentLoopData = $data6; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                <th><?php echo e($row->issue); ?></th>
                <td><?php echo e($row->answer); ?></td>
                <td><?php echo e($row->comment); ?></td>
              </tr>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>    

                      </table>
                    <p>&nbsp;</p>
                    <div class="container">

                      <?php $__currentLoopData = $data7; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                      <p><b>Patient/family goals: </b> <?php echo e($row->patient); ?></p>
                      <p><b>Analysis of Occupational performance: </b> <?php echo e($row->analysis); ?></p>
                      <p><b>Short-term goals: </b> <?php echo e($row->short_goal); ?></p>
                      <p><b>Long-term goals: </b> <?php echo e($row->long_goal); ?></p>
                      <p><b>OT intervention plan: </b> <?php echo e($row->OT); ?></p>
                      <p><b>Frequency/duration: </b> <?php echo e($row->frequency); ?> </p>
                      <p>&nbsp;</p>
                   