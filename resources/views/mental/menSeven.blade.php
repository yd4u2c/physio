@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">

		<div class="panel panel-primary col-sm-5">
			<div class="panel-heading">Add Assessment (Occupational Theraphy)</div>
			<div class="panel-body">

				@if(Session::has('error'))
				<div class="alert alert-danger">
					{{ Session::get('error') }}
				</div>
				@endif

				<form method="post" action="occPage1">

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
						<input type="text" name="physio" value="{{ $row->physio }}" readonly placeholder="Medications"  class="form-control" id="exampleInputEmail1" />
					</div>

					<div class="form-group">
						<label for="exampleInputEmail1">Date of birth</label>
						<input type="text" name="DOB"  required readonly value="{{ $row->dob }}" class="form-control" id="exampleInputEmail1" />
					</div>
					<input type="text" name="gender" style="display: none;" value="{{ $row->gender }}" class="form-control" id="exampleInputEmail1" />
					@endforeach

					<div class="form-group">
						<label for="exampleInputEmail1">Treatment Date</label>
						<input type="date" name="treatment"  required  class="form-control" id="exampleInputEmail1" />
					</div>

					<div class="form-group">
						<label for="exampleInputEmail1">Treatment Diagnosis</label>
						<textarea class="form-control" required="" name="diagnosis"></textarea>
					</div>

					<div class="form-group">
						<label for="exampleInputEmail1">Past Medical/Surgical History</label>
						<textarea class="form-control" required="" name="history"></textarea>
					</div>

					<div class="form-group">
						<label for="exampleInputEmail1">Medications</label>
						<input type="text" name="medications" placeholder="medications"  required  class="form-control" id="exampleInputEmail1" />
					</div>

					<div class="form-group">
						<label for="exampleInputEmail1">Date of Initial Assessment</label>
						<input type="date" name="dt"  placeholder="Date of Initial Assessment" required class="form-control" id="exampleInputEmail1" />
					</div>

					<div class="form-group">
						<label for="exampleInputEmail1">Occupational Profile</label>
						<textarea class="form-control" required="" name="occupational"></textarea>
					</div>

					<input type="hidden" name="rec" value="{{ rand() }}">

					<input type="submit" name="" value="Continue" class="btn btn-primary">

				</form>

			</div>
		</div>


	</div>
</div>
@endsection
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              @extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">

		<div class="panel panel-primary col-sm-10">
			<div class="panel-heading">Work/Leisure participation</div>
			<div class="panel-body">

				@if(Session::has('error'))
				<div class="alert alert-danger">
					{{ Session::get('error') }}
				</div>
				@endif

				<form method="post" action="occPage4">

					@if ($errors->any())
					<div class="alert alert-danger">
						@foreach ($errors->all() as $error)
						<li>{{$error}}</li>
						@endforeach
					</div>
					@endif
					
					{{ csrf_field() }}

					<table class="table" border="1">
            <tr>
              <th>Work/Leisure participation</th>
              <th></th>
              <th>Comment</th>
            </tr>
            <tr>
              <td>Education (formal and informal)<input type="text" name="issue[]" value="Education (formal and informal)" style="display: none;"></td>
              <td>
                <select name="answer[]" class="form-control">
                  <option value="impaired">impaired</option>
                  <option value="not impaired">not impaired</option>
                  <option value="Not applicable">Not Applicable</option>
                </select>
              </td>
              <td>
                <textarea name="Comm