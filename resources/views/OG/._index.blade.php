@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">

		<div class="panel panel-primary col-sm-5">
			<div class="panel-heading">Add Report (ORTHOPAEDIC)</div>
			<div class="panel-body">

				@if(Session::has('error'))
				<div class="alert alert-danger">
					{{ Session::get('error') }}
				</div>
				@endif

				<form method="post" action="ortPage1">

					@if ($errors->any())
					<div class="alert alert-danger">
						@foreach ($errors->all() as $error)
						<li>{{$error}}</li>
						@endforeach
					</div>
					@endif
					
					{{ csrf_field() }}

@foreach($data as $row)
					<div class="form-group">
						<label for="exampleInputEmail1">Patient Name</label>
						<input type="text" name="name" required readonly value="{{ $row->name }}" class="form-control" id="exampleInputEmail1" />
					</div>

					<div class="form-group">
						<label for="exampleInputEmail1">Physio Number</label>
						<input type="text" name="physio"  readonly value="{{ $row->physio }}" class="form-control" id="exampleInputEmail1" />
					</div>

					<div class="form-group">
						<label for="exampleInputEmail1">Date of birth</label>
						<input type="text" name="dob"  required readonly value="{{ $row->dob }}" class="form-control" id="exampleInputEmail1" />
					</div>

					<div class="form-group">
						<label for="exampleInputEmail1">Date</label>
						<input type="date" name="dt"  required  class="form-control" id="exampleInputEmail1" />
					</div>

					<div class="form-group">
						<label for="exampleInputEmail1">Diagnosis</label>
						<input type="text" name="diagnosis"  placeholder="Enter Diagnosis" required class="form-control" id="exampleInputEmail1" />
					</div>

					<div class="form-group">
						<label for="exampleInputEmail1">Occupation</label>
						<input type="text" name="occupation"  placeholder="Enter Occupation" required class="form-control" id="exampleInputEmail1" />
					</div>

					<div class="form-group">
						<label for="exampleInputEmail1">Patient Goals</label>
						<input type="text" name="goals"  placeholder="Enter goals" required class="form-control" id="exampleInputEmail1" />
					</div>
					<input type="text" name="gender" style="display: none;" value="{{ $row->gender }}" class="form-control" id="exampleInputEmail1" />
					@endforeach

					<input type="submit" name="" value="Continue" class="btn btn-primary">

				</form>

			</div>
		</div>


	</div>
</div>
@endsection
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       