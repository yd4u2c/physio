NDITION</option> -->
                                            <option value="consent to exam obtained">CONSENT TO EXAM OBTAINED</option>
                                            <option value="unable to consent">UNABLE TO CONSENT</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 ">
                                <div class="form-group">
                                    <div class="input-group w3_w3layouts col-lg-12">
                                        <span class="input-group-addon" id="basic-addon1">STAFF SIGNATURE</span>
                                        <input type="text" name="signature" class="form-control" value="<?php echo e(\Auth::User()->name); ?>" placeholder="" readonly="" aria-describedby="basic-addon1" required="" / >
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 ">
                                <div class="form-group">
                                    <div class="input-group w3_w3layouts col-lg-12">
                                        <span class="input-group-addon" id="basic-addon1">DATE</span>
                                        <input type="text" name="date" class="form-control"  value="<?php echo e(date('d/m/Y')); ?>" aria-describedby="basic-addon1" required="" readonly / >
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 ">
                                <div class="form-group">
                                    <div class="input-group w3_w3layouts col-lg-12">
                                        <span class="input-group-addon" id="basic-addon1">TIME</span>
                                        <input type="text" name="time" class="form-control" value="<?php echo e(date('h:i:sa')); ?>" aria-describedby="basic-addon1" required="" readonly / >
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 ">
                                <div class="form-group">
                                    <div class="input-group w3_w3layouts col-lg-12">
                                        <span class="input-group-addon" id="basic-addon1">PRINT NAME</span>
                                        <input type="text" name="print" class="form-control" style="text-transform: uppercase;" placeholder="print name" " aria-describedby="basic-addon1" required="" / >
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 ">
                                <div class="form-group">
                                    <div class="input-group w3_w3layouts col-lg-12">
                                        <span class="input-group-addon" id="basic-addon1">DESIGNATION</span>
                                        <input type="text" name="designation" class="form-control" placeholder="designation" aria-describedby="basic-addon1" required="" / >
                                    </div>
                                </div>
                            </div>

					<input type="submit" name="" value="continue" class="btn btn-primary">

				</form>

			</div>
		</div>


    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\physio\resources\views/neu/neuFirst.blade.php ENDPATH**/ ?>                                                                                                                                                                                                                                              <?php if(\Auth::User()->type == 0): ?>

<?php Session::put('user_type', 'Front Desk') ?> 

<li><a href="<?php echo e(url('/newPatient')); ?>">Add new patient</a></li>
<li><a href="<?php echo e(url('/allPatient')); ?>">All patient</a></li>

<?php elseif(\Auth::User()->type == 1): ?>

<?php Session::put('user_type', 'Paediatrics') ?>

<li><a href="<?php echo e(url('/addPae')); ?>">Add report</a></li>
<li><a href="<?php echo e(url('/chkpaeReport')); ?>">Check report</a></li>

<?php elseif(\Auth::User()->type == 2): ?>

<?php Session::put('user_type', 'Neurology') ?>

<li><a href="<?php echo e(url('/addNeu')); ?>">Add report</a></li>
<li><a href="<?php echo e(url('/chkneuReport')); ?>">Check report</a></li>

<?php elseif(\Auth::User()->type == 3): ?>

<?php Session::put('user_type', 'Occupational') ?>

<li><a href="<?php echo e(url('/addOccp')); ?>">Add report</a></li>
<li><a href="<?php echo e(url('/addMental')); ?>">Mental Health (Add report)</a></li>
<li><a href="<?php echo e(url('/chkOccReport')); ?>">Check report</a></li>

<?php elseif(\Auth::User()->type == 4): ?>

<?php Session::put('user_type', 'ORTHOPAEDIC') ?>

<li><a href="<?php echo e(url('/addOrt')); ?>">Add report</a></li>
<li><a href="<?php echo e(url('/chkortReport')); ?>">Check report</a></li>

<?php elseif(\Auth::User()->type == 5): ?>

<?php Session::put('user_type', 'FITNESS') ?>

<li><a href="<?php echo e(url('/addFit')); ?>">Add report</a></li>

<?php elseif(\Auth::User()->type == 6): ?>

<?php Session::put('user_type', 'Woman Health (O & G)') ?>

<li><a href="<?php echo e(url('/addOG')); ?>">Add report</a></li>
<li><a href="<?php echo e(url('/chkogReport')); ?>">Check report</a></li>

<?php elseif(\Auth::User()->type == 7): ?>

<?php Session::put('user_type', 'ICT Departmrnt') ?>

<li><a href="<?php echo e(url('/user')); ?>">User(s)</a></li>

<?php endif; ?>




<?php /**PATH C:\xampp\htdocs\physio\resources\views/layouts/menu.blade.php ENDPATH**/ ?>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <?php $__env->startSection('content'); ?>
<div class="container">
	<div class="row">

		<div class="panel panel-primary col-sm-10">
			<div class="panel-heading">Instrumental ADL Status</div>
			<div class="panel-body">

				<?php if(Session::has('error')): ?>
				<div class="alert alert-danger">
					<?php echo e(Session::get('error')); ?>

				</div>
				<?php endif; ?>

				<form method="post" action="occPage3">

					<?php if($errors->any()): ?>
					<div class="alert alert-