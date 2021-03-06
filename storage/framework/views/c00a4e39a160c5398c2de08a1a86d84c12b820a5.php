<?php $__env->startSection('content'); ?>
<div class="container">
	<div class="row">

		<div class="panel panel-primary col-sm-10">
			<div class="panel-heading">Educational History</div>
			<div class="panel-body">

				<form method="post" action="<?php echo e(url('/paePage10')); ?>">
					<?php echo e(csrf_field()); ?>


					<?php if($errors->any()): ?>
					<div class="alert alert-danger">
						<?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<li><?php echo e($error); ?></li>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					</div>
					<?php endif; ?>

					<table  class="table">
						<tr>
							<td style="min-width: 450px;">
								<input type="text" name="issue[]" value="Does your child attend school?" readonly class="form-control" id="exampleInputEmail1" />
							</td>
							<td>
								<label>Yes <input type="checkbox" name="answer[]" value="yes"></label>&nbsp;&nbsp;&nbsp;
								<label>No <input type="checkbox" name="answer[]" value="no"></label>
							</td>
							<td>
								<input type="text" name="comment[]" placeholder="If Yes, where" class="form-control" id="exampleInputEmail1" />
							</td>
						</tr>
						<tr>
							<td>
								<input type="text" name="issue[]" value="Has your child ever repeat a grade?" readonly class="form-control" id="exampleInputEmail1" />
							</td>
							<td>
								<label>Yes <input type="checkbox" name="answer[]" value="yes"></label>&nbsp;&nbsp;&nbsp;
								<label>No <input type="checkbox" name="answer[]" value="no"></label>
							</td>
							<td>
								<input type="text" name="comment[]" placeholder="If yes, what grade" class="form-control" id="exampleInputEmail1" />
							</td>
						</tr>
						<tr>
							<td>
								<input type="text" name="issue[]" class="form-control" value="Does your child have special education or therapy services in school?" readonly />
							</td>
							<td>
								<label>Yes <input type="checkbox" name="answer[]" value="yes"></label>&nbsp;&nbsp;&nbsp;
								<label>No <input type="checkbox" name="answer[]" value="no"></label>
							</td>
							<td>
								<input type="text" name="comment[]" placeholder="If yes, please list services" class="form-control" id="exampleInputEmail1" />
							</td>
						</tr>
						<tr>
							<td>
								<input type="text" name="issue[]" class="form-control" value="Has your child receive therapy anywhere else?" readonly />
							</td>
							<td>
								<label>Yes <input type="checkbox" name="answer[]" value="yes"></label>&nbsp;&nbsp;&nbsp;
								<label>No <input type="checkbox" name="answer[]" value="no"></label>
							</td>
							<td>
								<input type="text" name="comment[]" placeholder="If yes, please list services" class="form-control" id="exampleInputEmail1" />
							</td>
						</tr>
					</table>

					<div class="form-group">
						<label>What grade is your child currently in</label>
						<input type="text" name="grade" class="form-control">
					</div>

					<div class="form-group">
						<label>How often does your child have special education or therapy in school</label>
						<input type="text" name="often" class="form-control">
					</div>

					<div class="form-group">
						<label>How long does your child have special education or therapy in school</label>
						<input type="text" name="long" class="form-control">
					</div>

					<div class="form-group">
						<label>What group of special education does he belong</label>
						<input type="text" name="grp" class="form-control">
					</div>

					<div class="form-group">
						<label>Additional coments on special education</label>
						<input type="text" name="sp_comment" class="form-control">
					</div>

					<div class="form-group">
						<label>Where did your child receive his additional therapy service</label>
						<input type="text" name="tp_service" class="form-control">
					</div>

					<div class="form-group">
						<label>From whom did your child receive his additional therapy service</label>
						<input type="text" name="whom" class="form-control">
					</div>

					<div class="form-group">
						<label>Additional coments on therapy service</label>
						<input type="text" name="tp_comment" class="form-control">
					</div>

					<div class="form-group">
						<label>Are there any religious or cultural issues that we should be aware of regarding your child's evaluation?</label>
						<input type="text" name="religious" class="form-control">
					</div>

					<div class="form-group">
						<label>What goals are you hoping to have your child accomplish by partici[ating in Therapy?</label>
						<input type="text" name="goal" class="form-control">
					</div>

					<div class="checkbox">
						<label><input type="checkbox"> I have reviewed the information provided above and I found them to be accurate</label>
					</div>

					<div class="form-group">
						<label for="exampleInputEmail1">Physiotherapist (Name)</label>
						<input type="text" value="<?php echo e(\Auth::User()->name); ?>" readonly required name="physio" class="form-control" id="exampleInputEmail1" />
					</div>

					<p>&nbsp;</p>
					<textarea name="info" placeholder="Additional Related information" class="form-control"></textarea>
					<p>&nbsp;</p>

					<input type="submit" name="submit" class="btn btn-primary">

				</form>

			</div>
		</div>


	</div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Library/WebServer/Documents/physio/resources/views/pae/paeTenth.blade.php ENDPATH**/ ?>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               <?php $__env->startSection('content'); ?>
<div class="container">
	<div class="row">

		<div class="panel panel-primary col-sm-5">
			<div class="panel-heading">Add Report (Mental Helth)</div>
			<div class="panel-body">

				<?php if(Session::has('error')): ?>
				<div class="alert alert-danger">
					<?php echo e(Session::get('error')); ?>

				</div>
				<?php endif; ?>

				<form method="post" action="menPage2">

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
                            <th colspan="2">Communication and Inter - action Skills</th>
                        </tr>
                        <tr>
                            <td>Uses appropriate non-verbal expression<input type="text" name="question[]" value="Uses appropriate non-verbal expression" style="display: none;"></td>
                            <td>
                                <select class="form-control" name="answer[]">
                                    <option value="Not seen">Not seen</option>
                                    <option value="Facilitates occupational participation">Facilitates occupational participation</option>
                                    <option value="Allows occupational participation">Allows occupational participation</option>
                                    <option value="Inhibits occupational participation">Inhibits occupational participation</option>
                                    <option value="Restricts occupational participation">Restricts occupational participation</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Initiates and sustains appropriate conversation<input type="text" name="question[]" value="Initiates and sustains appropriate conversation" style="display: none;"></td>
                            <td>
                                <select class="form-control" name="answer[]">
                                    <option value="Not seen">Not seen</option>
                                    <option value="Facilitates occupational participation">Facilitates occupational participation</option>
                                    <option value="Allows occupational participation">Allows occupational participation</option>
                                    <option value="Inhibits occupational participation">Inhibits occupational participation</option>
                                    <option value="Restricts occupational participation">Restricts occupational participation</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Uses appropriate vocal expression<input type="text" name="question[]" value="Uses appropriate vocal expression" style="display: none;"></td>
                            <td>
                                <select class="form-control" name="answer[]">
                                    <option value="Not seen">Not seen</option>
                                    <option value="Facilitates occupational participation">Facilitates occupational participation</option>
                                    <option value="Allows occupational participation">Allows occupational participation</option>
                                    <option value="Inhibits occupational participation">Inhibits occupational participation</option>
                                    <option value="Restricts occupational participation">Restricts occupational participation</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Relates to and co-operates with others<input type="text" name="question[]" value="Relates to and co-operates with others" style="display: none;"></td>
                            <td>
                                <select class="form-control" name="answer[]">
                                    <option value="Not seen">Not seen</option>
                                    <option value="Facilitates occupational participation">Facilitates occupational participation</option>
                                    <option value="Allows occupational participation">Allows occupational participation</option>
                                    <option value="Inhibits occupational participation">Inhibits occupational participation</option>
                                    <option value="Restricts occupational participation">Restricts occupational participation</option>
              