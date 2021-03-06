
						</tr>
						<tr>
							<td>
								<input type="text" name="question[]" class="form-control" value="Toilet train" readonly>
							</td>
							<td>
								<input type="text" name="answer[]" required class="form-control" placeholder="input answer here">
							</td>
						</tr>
					</table>
					<p>&nbsp;</p>
					<p>Does your child have any of the following conditions?</p>
					<div class="form-group">
						<label><input type="checkbox" name="describe[]" value="Mostly quite"> Mostly quite</label>&nbsp;&nbsp;&nbsp;&nbsp;
						<label><input type="checkbox" name="describe[]" value="Tires easily"> Tires easily</label>&nbsp;&nbsp;&nbsp;&nbsp;
						<label><input type="checkbox" name="describe[]" value="Talks constantly"> Talks constantly</label>&nbsp;&nbsp;&nbsp;&nbsp;
						<label><input type="checkbox" name="describe[]" value="clumsy"> clumsy</label>&nbsp;&nbsp;&nbsp;&nbsp;
						<label><input type="checkbox" name="describe[]" value="happy"> happy</label>&nbsp;&nbsp;&nbsp;&nbsp;
						<label><input type="checkbox" name="describe[]" value="impulsive"> impulsive</label>&nbsp;&nbsp;&nbsp;&nbsp;
						<label><input type="checkbox" name="describe[]" value="overly active"> overly active</label>&nbsp;&nbsp;&nbsp;&nbsp;
						<label><input type="checkbox" name="describe[]" value="overreacts frequently"> Overeact frequently</label>&nbsp;&nbsp;&nbsp;&nbsp;
						<label><input type="checkbox" name="describe[]" value="shy"> shy</label>&nbsp;&nbsp;&nbsp;&nbsp;
						<label><input type="checkbox" name="describe[]" value="Restless"> restless</label>&nbsp;&nbsp;&nbsp;&nbsp;
						<label><input type="checkbox" name="describe[]" value="Craves touch"> Craves touch</label>&nbsp;&nbsp;&nbsp;&nbsp;
						<label><input type="checkbox" name="describe[]" value="Get frustrated easily"> Get frustrated easily</label>&nbsp;&nbsp;&nbsp;&nbsp;
						<label><input type="checkbox" name="describe[]" value="stubborn"> stubborn</label>&nbsp;&nbsp;&nbsp;&nbsp;
						<label><input type="checkbox" name="describe[]" value="Has temper tantrums"> Has temper tantrums</label>&nbsp;&nbsp;&nbsp;&nbsp;
						<label><input type="checkbox" name="describe[]" value="Difficulty speaking"> Difficulty speaking</label>&nbsp;&nbsp;&nbsp;&nbsp;
						<label><input type="checkbox" name="describe[]" value="Has nervours habits"> Has nervours habits</label>&nbsp;&nbsp;&nbsp;&nbsp;
						<label><input type="checkbox" name="describe[]" value="Has unusual fears"> Has unusual fears</label>&nbsp;&nbsp;&nbsp;&nbsp;
						<label><input type="checkbox" name="describe[]" value="Avoids touch"> Avoids touch</label>&nbsp;&nbsp;&nbsp;&nbsp;
						<label><input type="checkbox" name="describe[]" value="Has poor attention span"> Has poor attention span</label>&nbsp;&nbsp;&nbsp;&nbsp;
						<label><input type="checkbox" name="describe[]" value="Difficulty learning new task"> Difficulty in learning new task</label>&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="text" name="describe[]" placeholder="Enter other here">&nbsp;&nbsp;&nbsp;&nbsp;
					</div>
					<div class="checkbox">
						<label><input type="checkbox" required> I have reviewed the information provided above and I found them to be complete</label>
					</div>
					<div class="form-group">
						<label for="exampleInputEmail1">Physiotherapist (Name)</label>
						<input type="text" value="<?php echo e(Auth::User()->name); ?>" readonly name="physio" required class="form-control" id="exampleInputEmail1" />
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Library/WebServer/Documents/physio/resources/views/pae/paeFive.blade.php ENDPATH**/ ?>                                                                                                               <!doctype html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <?php if(Route::has('login')): ?>
                <div class="top-right links">
                    <?php if(auth()->guard()->check()): ?>
                        <a href="<?php echo e(url('/home')); ?>">Home</a>
                    <?php else: ?>
                        <a href="<?php echo e(route('login')); ?>">Login</a>

                        <?php if(Route::has('register')): ?>
                            <a href="<?php echo e(route('register')); ?>">Register</a>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <div class="content">
                <div class="title m-b-md">
                    Laravel
                </div>

                <div class="links">
                    <a href="https://laravel.com/docs">Docs</a>
                    <a href="https://laracasts.com">Laracasts</a>
                    <a href="https://laravel-news.com">News</a>
                    <a href="https://blog.laravel.com">Blog</a>
                    <a href="https://nova.laravel.com">Nova</a>
                    <a href="https://forge.laravel.com">Forge</a>
                    <a href="https://github.com/laravel/laravel">GitHub</a>
                </div>
            </div>
        </div>
    </body>
</html>
<?php /**PATH /Library/WebServer/Documents/physio/resources/views/welcome.blade.php ENDPATH**/ ?>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     <?php $__env->startSection('content'); ?>
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

				<form method="post" action="<?php echo e(url('chkneuData')); ?>">

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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Library/WebServer/Documents/physio/resources/views/neu/chkReport.blade.php ENDPATH**/ ?>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <?php $__env->startSection('content'); ?>
<div class="container">
	<div class="row">

		<div class="panel panel-primary col-sm-4">
			<div class="panel-heading">Check Report (O&G)</div>
			<div class="panel-body">

				<?php if(Session::has('error')): ?>
				<div class="alert alert-danger">
					<?php echo e(Session::get('error')); ?>

				</div>
				<?php endif; ?>

				<form method="post" action="<?php echo e(url('chkogData')); ?>">

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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Library/WebServer/Documents/physio/resources/views/OG/chkReport.blade.php ENDPATH**/ ?>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     <?php $__env->startSection('content'); ?>
<div class="container">
	<div class="row">

		<div class="panel panel-primary col-sm-10">
			<div class="panel-heading">Add Report (ORTHOPAEDIC)</div>
			<div class="panel-body">

				<?php if(Session::has('error')): ?>
				<div class="alert alert-danger">
					<?php echo e(Session::get('error')); ?>

				</div>
				<?php endif; ?>

				<form method="post" action="ortPage2">

					<?php if($errors->any()): ?>
					<div class="alert alert-danger">
						<?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<li><?php echo e($error); ?></li>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					</div>
					<?php endif; ?>
					
					<?php echo e(csrf_field()); ?>


					<div class="panel panel-primary  w3-card w3-sand">
						<header class="w3-container w3-blue">
							<h4>Vital sign</h4>
						</header>
						<div class="panel-body">
							<div class="form-group col-sm-4">
								<label for="exampleInputEmail1">Blood Pressure</label>
								<input type="text" name="BP" required class="form-control" id="exampleInputEmail1" />
							</div>
							<div class="form-group col-sm-4">
								<label for="exampleInputEmail1">Heart Rate</label>
								<input type="text" name="heart"  required class="form-control" id="exampleInputEmail1" />
							</div>
							<div class="form-group col-sm-4">
								<label for="exampleInputEmail1">Respiration</label>
								<input type="text" name="respiration"  required class="form-control" id="exampleInputEmail1" />
							</div>
						</div>
					</div>

					<div class="form-group col-sm-6">
						<label for="exampleInputEmail1">Chief Compliant</label>
						<input type="text" name="compliant"  placeholder="Enter compliant" required class="form-control" id="exampleInputEmail1" />
					</div>

					<div class="form-group col-sm-6">
						<label for="exampleInputEmail1">History of present injury</label>
						<input type="text" name="history" placeholder="History of present injury"  required  class="form-control" id="exampleInputEmail1" />
					</div>

				<div class="form-group col-sm-12" style="background: #fff;">
					<p>&nbsp;</p>
					<label for="exampleInputEmail1"><b>Past Medical History</b></label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="checkbox" name="medical[]"  value="Cardiac" />cardiac &nbsp;&nbsp;&nbsp;
					<input type="checkbox" name="medical[]"  value="NIDDM/IDDM" />NIDDM/IDDM &nbsp;&nbsp;&nbsp;
					<input type="checkbox" name="medical[]"  value="CVA" />CVA &nbsp;&nbsp;&nbsp;
					<input type="checkbox" name="medical[]"  value="Hypertension" />Hypertension &nbsp;&nbsp;&nbsp;
					<input type="checkbox" name="medical[]"  value="Cancer" />Cancer &nbsp;&nbsp;&nbsp;
					<input type="checkbox" name="medical[]"  value="Osteoporosis" />Osteoporosis &nbsp;&nbsp;&nbsp;
					<input type="checkbox" name="medical[]"  value="Respiratory" />Respiratory &nbsp;&nbsp;&nbsp;
					<input type="checkbox" name="medical[]"  value="Fractures" />Fractures &nbsp;&nbsp;&nbsp;
					<input type="checkbox" name="m