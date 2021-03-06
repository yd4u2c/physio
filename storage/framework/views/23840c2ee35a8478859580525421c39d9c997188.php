b>Motor skills</b></td>

									<?php $__currentLoopData = $data6; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<td><?php echo e($row->question); ?></td>
									<td><?php echo e($row->answer); ?></td>
								</tr>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

								<tr></tr>

								<tr>
									<td rowspan='4'><b>Environment</b></td>

									<?php $__currentLoopData = $data7; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<td><?php echo e($row->question); ?></td>
									<td><?php echo e($row->answer); ?></td>
								</tr>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


							</table>
						</div>
					</div>
				</div>
			</div>
		</div>


	</div>
</div>

<style type="text/css">
    @media  print {
      #printPageButton {
        display: none;
      }
    }

</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Library/WebServer/Documents/physio/resources/views/mental/menPrint.blade.php ENDPATH**/ ?>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          <?php $__env->startSection('content'); ?>
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
              <td>Knee Extension<input type="text" required name="issue[]" sty