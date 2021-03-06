@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">

		<div class="panel panel-primary col-sm-8">
			<div class="panel-heading">Add Report (Occupational Theraphy)</div>
			<div class="panel-body">

				@if(Session::has('error'))
				<div class="alert alert-danger">
					{{ Session::get('error') }}
				</div>
				@endif

				<form method="post" action="ogPage6">

					@if ($errors->any())
					<div class="alert alert-danger">
						@foreach ($errors->all() as $error)
						<li>{{$error}}</li>
						@endforeach
					</div>
					@endif
					
					{{ csrf_field() }}

					<div class="form-group">
						<label for="exampleInputEmail1">Do you have any movement restriction?</label>
						<label>Yes <input type="radio" name="movement" value="yes"></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<label>No <input type="radio" name="movement" value="No"></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<p>&nbsp;</p>
					</div>
					<div class="form-group">
						<label>If yes , please list:</label>
						<textarea class="form-control" name="list"></textarea>
					</div>
					<div class="form-group">
						<label for="exampleInputEmail1">Do you have any difficulty in breathing?</label>
						<label>Yes <input type="radio" name="breathing" value="yes"></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<label>No <input type="radio" name="breathing" value="No"></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					</div>
					<div class="form-group">
						<label for="exampleInputEmail1">Do you cough?</label>
						<label>Yes <input type="radio" name="cough" value="yes"></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<label>No <input type="radio" name="cough" value="No"></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					</div>
					<div class="form-group">
						<label for="exampleInputEmail1">Do you produce sputum?</label>
						<label>Yes <input type="radio" name="sputum" value="yes"></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<label>No <input type="radio" name="sputum" value="No"></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					</div>
					<div class="form-group">
						<label>If yes, describe.(colour, quantity, thickness, presence of blood stain):</label>
						<textarea class="form-control" name="describe"></textarea>
					</div>
					<div class="form-group">
						<input type="checkbox" required name=""> I have reviewed the information provided and information are complete
					</div>
					<div class="form-group">
						<label>Therapist Name</label>
						<input type="physio" name="physio" class="form-control" readonly value="{{ \Auth::User()->name }}">
					</div>
					<div class="form-group">
						<label>Other related information</label>
						<textarea name="info" class="form-control"></textarea>
					</div>
					<div class="form-group">
						<label>Please list all of  the medications[with specific NAME, DOSAGE , FREQUENCY and ROUTE(i.e : by mouth)] that you are currently taking [including over –the-counter, prescription, herbals and vitamins/mineral(s)]:</label>
						<textarea class="form-control" name="medications"></textarea>
					</div>

					<input type="submit" name="" value="Continue" class="btn btn-primary">

				</form>

			</div>
		</div>


	</div>
</div>
@endsection
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                