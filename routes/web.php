th>
            </tr>
            <tr>
              <td><input type="text" name="test[]" value="Valgus Test" readonly></td>
              <td>
                <select name="answer[]">
                  <option value="+ve">+ve</option>
                  <option value="-ve">-ve</option>
                </select>
              </td>
            </tr>
            <tr>
              <td><input type="text" name="test[]" value="Varus Test" readonly></td>
              <td>
                <select name="answer[]">
                  <option value="+ve">+ve</option>
                  <option value="-ve">-ve</option>
                </select>
              </td>
            </tr>
            <tr>
              <td><input type="text" name="test[]" value="Tinel Test" readonly></td>
              <td>
                <select name="answer[]">
                  <option value="+ve">+ve</option>
                  <option value="-ve">-ve</option>
                </select>
              </td>
            </tr>
            <tr>
              <th colspan="2">Hand and Wrist</th>
            </tr>
            <tr>
              <td><input type="text" name="test[]" value="Tinel’s Test" readonly></td>
              <td>
                <select name="answer[]">
                  <option value="+ve">+ve</option>
                  <option value="-ve">-ve</option>
                </select>
              </td>
            </tr>
            <tr>
              <td><input type="text" name="test[]" value="Reverse Phalen’s Test" readonly></td>
              <td>
                <select name="answer[]">
                  <option value="+ve">+ve</option>
                  <option value="-ve">-ve</option>
                </select>
              </td>
            </tr>
            <tr>
              <td><input type="text" name="test[]" value="Compression Test" readonly></td>
              <td>
                <select name="answer[]">
                  <option value="+ve">+ve</option>
                  <option value="-ve">-ve</option>
                </select>
              </td>
            </tr>
            <tr>
              <th colspan="2">Hip</th>
            </tr>
            <tr>
              <td><input type="text" name="test[]" value="Faber’s Test" readonly></td>
              <td>
                <select name="answer[]">
                  <option value="+ve">+ve</option>
                  <option value="-ve">-ve</option>
                </select>
              </td>
            </tr>
            <tr>
              <td><input type="text" name="test[]" value="Ely’s Test" readonly></td>
              <td>
                <select name="answer[]">
                  <option value="+ve">+ve</option>
                  <option value="-ve">-ve</option>
                </select>
              </td>
            </tr>
            <tr>
              <td><input type="text" name="test[]" value="Gaeslen Test" readonly></td>
              <td>
                <select name="answer[]">
                  <option value="+ve">+ve</option>
                  <option value="-ve">-ve</option>
                </select>
              </td>
            </tr>
            <tr>
              <th colspan="2">Knee</th>
            </tr>
            <tr>
              <td><input type="text" name="test[]" value="Valgus Test" readonly></td>
              <td>
                <select name="answer[]">
                  <option value="+ve">+ve</option>
                  <option value="-ve">-ve</option>
                </select>
              </td>
            </tr>
            <tr>
              <td><input type="text" name="test[]" value="Varus Test" readonly></td>
              <td>
                <select name="answer[]">
                  <option value="+ve">+ve</option>
                  <option value="-ve">-ve</option>
                </select>
              </td>
            </tr>
            <tr>
              <td><input type="text" name="test[]" value="Anterior Drawal Test" readonly></td>
              <td>
                <select name="answer[]">
                  <option value="+ve">+ve</option>
                  <option value="-ve">-ve</option>
                </select>
              </td>
            </tr>
            <tr>
              <td><input type="text" name="test[]" value="Posterior Drawal Test" readonly></td>
              <td>
                <select name="answer[]">
                  <option value="+ve">+ve</option>
                  <option value="-ve">-ve</option>
                </select>
              </td>
            </tr>
            <tr>
              <td><input type="text" name="test[]" value="Patella Grind Test" readonly></td>
              <td>
                <select name="answer[]">
                  <option value="+ve">+ve</option>
                  <option value="-ve">-ve</option>
                </select>
              </td>
            </tr>
            <tr>
              <th colspan="2">Ankle and foot</th>
            </tr>
            <tr>
              <td><input type="text" name="test[]" value="Talar Tilt Test" readonly></td>
              <td>
                <select name="answer[]">
                  <option value="+ve">+ve</option>
                  <option value="-ve">-ve</option>
                </select>
              </td>
            </tr>
            <tr>
              <td><input type="text" name="test[]" value="Anterior Drawal Test" readonly></td>
              <td>
                <select name="answer[]">
                  <option value="+ve">+ve</option>
                  <option value="-ve">-ve</option>
                </select>
              </td>
            </tr>
            <tr>
              <td><input type="text" name="test[]" value="External Rotator Test" readonly></td>
              <td>
                <select name="answer[]">
                  <option value="+ve">+ve</option>
                  <option value="-ve">-ve</option>
                </select>
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\physio\resources\views/ort/ortEight.blade.php ENDPATH**/ ?>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <?php $__env->startSection('content'); ?>
<div class="container">
  <div class="row">

    <div class="panel panel-primary col-sm-5">
      <div class="panel-heading">*******</div>
      <div class="panel-body">

        <?php if(Session::has('error')): ?>
        <div class="alert alert-danger">
          <?php echo e(Session::get('error')); ?>

        </div>
        <?php endif; ?>

        <form method="post" action="ortPage10">

          <?php if($errors->any()): ?>
          <div class="alert alert-danger">
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li><?php echo e($error); ?></li>
   