<?php $__env->startSection('content'); ?>
<div class="container">
  <div class="row">

    <div class="panel panel-primary col-sm-9">
      <div class="panel-heading">*******</div>
      <div class="panel-body">

        <?php if(Session::has('error')): ?>
        <div class="alert alert-danger">
          <?php echo e(Session::get('error')); ?>

        </div>
        <?php endif; ?>

        <form method="post" action="ortPage13">

          <?php if($errors->any()): ?>
          <div class="alert alert-danger">
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </div>
          <?php endif; ?>
          
          <?php echo e(csrf_field()); ?>


          <div class="form-group col-sm-6">
            <label for="exampleInputEmail1">Physiotheraphyst Name</label>
            <input type="text" name="name" value="<?php echo e(\Auth::User()->name); ?>" readonly required class="form-control" id="exampleInputEmail1" />
          </div>

          <div class="form-group col-sm-6">
            <label for="exampleInputEmail1">Completion Date</label>
            <input type="date" name="dt"  required class="form-control" id="exampleInputEmail1" />
          </div>

          <input type="submit" name="Continue" class="btn btn-primary">

        </form>

      </div>
    </div>


  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\physio\resources\views/ort/ortThirteen.blade.php ENDPATH**/ ?>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row">

    	<div class="panel panel-primary col-sm-10">
			<div class="panel-heading">Add Report (Nuerology)</div>
			<div class="panel-body">

				<?php if(Session::has('error')): ?>
				<div class="alert alert-danger">
					<?php echo e(Session::get('error')); ?>

				</div>
				<?php endif; ?>

				<form method="post" action="neuPage1">

					<?php if($errors->any()): ?>
					<div class="alert alert-danger">
						<?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<li><?php echo e($error); ?></li>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					</div>
					<?php endif; ?>
					
					<?php echo e(csrf_field()); ?>


					<?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

					<div class="form-group">
                            <div class="col-lg-6 ">
                                <div class="form-group">
                                    <div class="input-group w3_w3layouts col-lg-12">
                                        <span class="input-group-addon" id="basic-addon1">PATIENT NAME</span>
                                        <input type="text" name="name" readonly value="<?php echo e($row->name); ?>" class="form-control" placeholder="Patient name" aria-describedby="basic-addon1" required=""/>
                                    </div>
                                </div>
                            </div>


                            <div class="col-lg-6 ">
                                <div class="form-group">
                                    <div class="input-group w3_w3layouts col-lg-12">
                                        <span class="input-group-addon" id="basic-addon1">ADDRESS</span>
                                        <input type="text" name="address" value="" class="form-control" placeholder="address" aria-describedby="basic-addon1" required="" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 ">
                                <div class="form-group">
                                    <div class="input-group w3_w3layouts col-lg-12">
                                        <span class="input-group-addon" id="basic-addon1">System Physio Number</span>
                                        <input type="text" name="sys_num" value="<?php echo e($row->sys_num); ?>" class="form-control" readonly placeholder="address" aria-describedby="basic-addon1" required="" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 ">
                                <div class="form-group">
                                    <div class="input-group w3_w3layouts col-lg-12">
                                        <span class="input-group-addon" id="basic-addon1">Diagnosis</span>
                                        <input type="text" name="diagnosis"  class="form-control" placeholder="" aria-describedby="basic-addon1" required="" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 ">
                                <div class="form-group">
                                    <div class="input-group w3_w3layouts col-lg-12">
                                        <span class="input-group-addon" id="basic-addon1">NHIS NO</span>
                                        <input type="text" name="nhis_no" value="" class="form-control" placeholder="nhs num" aria-describedby="basic-addon1" value="" required="" / >
                                        <input type="text" name="rec" value="<?php echo e(rand(111111111, 999999999)); ?>" class="form-control" placeholder="nhs num" aria-describedby="basic-addon1" value="" style="display: none;" required="" / >
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 ">
                                <div class="form-group">
                                    <div class="input-group w3_w3layouts col-lg-12">
                         