@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">

		<div class="col-sm-2"></div>

		<div class="panel panel-primary col-sm-5">
			<div class="panel-heading">Add report</div>
			<div class="panel-body">

				@if ($errors->any())
				<div class="alert alert-danger">
					@foreach ($errors->all() as $error)
					<li>{{$error}}</li>
					@endforeach
				</div>
				@endif

				@foreach($data as $row)

				<form method="post" action="{{ url('/paePage1') }}">

					{{ csrf_field() }}

					<div class="form-group">
						<label for="exampleInputEmail1">Patient Name</label>
						<input type="text" name="name" required readonly value="{{ $row->name }}" class="form-control" id="exampleInputEmail1" />
					</div>
					<div class="form-group">
						<label for="exampleInputEmail1">Physio Number</label>
						<input type="text" name="physio"  required readonly value="{{ $row->physio }}" class="form-control" id="exampleInputEmail1" />
					</div>
					<div class="form-group">
						<label for="exampleInputEmail1">Diagnosis</label>
						<input type="text" name="diagnosis"  class="form-control" id="exampleInputEmail1" />
					</div>
					<div class="form-group">
						<label for="exampleInputEmail1">Date of birth</label>
						<input type="text" name="dob"  required readonly value="{{ $row->dob }}" class="form-control" id="exampleInputEmail1" />
					</div>

					<input type="text" name="sys_num" style="display: none;" value="{{ $row->sys_num }}" class="form-control" id="exampleInputEmail1" />
					<input type="text" name="gender" style="display: none;" value="{{ $row->gender }}" class="form-control" id="exampleInputEmail1" />
					<input type="text" name="rec" style="display: none;" value="<?php echo rand(); ?>" class="form-control" id="exampleInputEmail1" />

					@endforeach

					<input type="submit" value="continue" class="btn btn-default" name="">
				</form>

			</div>
		</div>

	</div>
</div>
@endsection
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              