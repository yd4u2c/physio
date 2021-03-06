<?php if(\Auth::User()->type == 0): ?>

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

<?php endif; ?>




<?php /**PATH /Library/WebServer/Documents/physio/resources/views/layouts/menu.blade.php ENDPATH**/ ?>                                                        