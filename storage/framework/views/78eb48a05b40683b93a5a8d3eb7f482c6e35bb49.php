<?php $__env->startSection('content'); ?>
<div class="container">
  <div class="row">

    <div class="panel panel-primary col-sm-12" style="overflow-y: scroll;">
      <div class="panel-heading">Add Report (ORTHOPAEDIC)</div>
      <div class="panel-body">

        <?php if(Session::has('error')): ?>
        <div class="alert alert-danger">
          <?php echo e(Session::get('error')); ?>

        </div>
        <?php endif; ?>

        <form method="post" action="ortPage4">

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
              <th colspan="3" style="text-align: center;">Cervical</th>
              <th colspan="3" style="text-align: center;">Thoracic</th>
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
              <td><input type="text" required="" name="issue[]" value="Flexion" readonly></td>
              <td><input type="text" required="" name="cAROM[]"></td>
              <td><input type="text" required="" name="cPROM[]"></td>
              <td><input type="text" required="" name="cend[]"></td>
              <td><input type="text" required="" name="tAROM[]"></td>
              <td><input type="text" required="" name="tPROM[]"></td>
              <td><input type="text" required="" name="tend[]"></td>
            </tr>
            <tr>
              <td><input type="text" required="" name="issue[]" value="Extension" readonly></td>
              <td><input type="text" required="" name="cAROM[]"></td>
              <td><input type="text" required="" name="cPROM[]"></td>
              <td><input type="text" required="" name="cend[]"></td>
              <td><input type="text" required="" name="tAROM[]"></td>
              <td><input type="text" required="" name="tPROM[]"></td>
              <td><input type="text" required="" name="tend[]"></td>
            </tr>
            <tr>
              <td><input type="text" required="" name="issue[]" value="L Side Bend" readonly></td>
              <td><input type="text" required="" name="cAROM[]"></td>
              <td><input type="text" required="" name="cPROM[]"></td>
              <td><input type="text" required="" name="cend[]"></td>
              <td><input type="text" required="" name="tAROM[]"></td>
              <td><input type="text" required="" name="tPROM[]"></td>
              <td><input type="text" required="" name="tend[]"></td>
            </tr>
            <tr>
              <td><input type="text" required="" name="issue[]" value="R Side Bend" readonly></td>
              <td><input type="text" required="" name="cAROM[]"></td>
              <td><input type="text" required="" name="cPROM[]"></td>
              <td><input type="text" required="" name="cend[]"></td>
              <td><input type="text" required="" name="tAROM[]"></td>
              <td><input type="text" required="" name="tPROM[]"></td>
              <td><input type="text" required="" name="tend[]"></td>
            </tr>
            <tr>
              <td><input type="text" required="" name="issue[]" value="L Rotation" readonly></td>
              <td><input type="text" required="" name="cAROM[]"></td>
              <td><input type="text" required="" name="cPROM[]"></td>
              <td><input type="text" required="" name="cend[]"></td>
              <td><input type="text" required="" name="tAROM[]"></td>
              <td><input type="text" required="" name="tPROM[]"></td>
              <td><input type="text" required="" name="tend[]"></td>
            </tr>
            <tr>
              <td><input type="text" required="" name="issue[]" value="R Rotation" readonly></td>
              <td><input type="text" required="" name="cAROM[]"></td>
              <td><input type="text" required="" name="cPROM[]"></td>
              <td><input type="text" required="" name="cend[]"></td>
              <td><input type="text" required="" name="tAROM[]"></td>
              <td><input type="text" required="" name="tPROM[]"></td>
              <td><input type="text" required="" name="tend[]"></td>
            </tr>
            <tr>
              <td colspan="7"><textarea required="" class="form-control" name="comments" placeholder="Enter comments here"></textarea></td>
            </tr>
          </table>

          <input type="submit" name="Continue" class="btn btn-primary">

        </form>

      </div>
    </div>


  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\physio\resources\views/ort/ortForth.blade.php ENDPATH**/ ?>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              