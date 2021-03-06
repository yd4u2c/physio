@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">

		<div class="panel panel-primary col-sm-5">
			<div class="panel-heading">Add Report (Mental Helth)</div>
			<div class="panel-body">

				@if(Session::has('error'))
				<div class="alert alert-danger">
					{{ Session::get('error') }}
				</div>
				@endif

				<form method="post" action="menPage1">

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
						<label for="exampleInputEmail1">Client</label>
						<input type="text" name="name" required readonly value="{{ $row->name }}" class="form-control" id="exampleInputEmail1" />
					</div>
					<div class="form-group">
						<label for="exampleInputEmail1">Date of birth</label>
						<input type="text" name="DOB"  required readonly value="{{ $row->dob }}" class="form-control" id="exampleInputEmail1" />
					</div>
					<div class="form-group">
						<label for="exampleInputEmail1">Gender</label>
						<div class="form-group">
							<label>Male: <input type="radio" required="" name="gender" value="Male"></ins></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<label>Female: <input type="radio" required="" name="gender" value="Female"></ins></label>
						</div>
					</div>
					<div class="form-group">
						<label for="exampleInputEmail1">ID Code</label>
						<input type="text" name="code"  required  class="form-control" id="exampleInputEmail1" />
					</div>
					<div class="form-group">
						<label for="exampleInputEmail1">Ethnicity</label>
						<div class="form-group">
							<label>Yoruba: <input type="radio" required="" name="ethnicity" value="Yoruba"></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<label>Igbo: <input type="radio" required="" name="ethnicity" value="Igbo"></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<label>Hausa: <input type="radio" required="" name="ethnicity" value="Hausa"></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<input type="text" name="ethnicity2" placeholder="Enter Other ethnic here">
						</div>
					</div>
					<div class="form-group">
						<label for="exampleInputEmail1">Health Condition</label>
						<input type="text" name="health"  required  class="form-control" id="exampleInputEmail1" />
					</div>
					<div class="form-group">
						<label for="exampleInputEmail1">Name of Assesor</label>
						<input type="text" value="{{ \Auth::User()->name }}" readonly name="assesor"  required  class="form-control" id="exampleInputEmail1" />
					</div>
					<div class="form-group">
						<label for="exampleInputEmail1">Designation</label>
						<div class="form-group">
							<label>Occupational Therapist: <input required="" type="radio" name="designation" value="Occupational Therapist"></ins></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<label>OT Support staff: <input required="" type="radio" name="designation" value="OOT Support staff"></ins></label>
						</div>
					</div>
					<div class="form-group">
						<label for="exampleInputEmail1">Date of first contact</label>
						<input type="date" name="first" required class="form-control" id="exampleInputEmail1" />
					</div>
					<div class="form-group">
						<label for="exampleInputEmail1">Date of Initial Assessment</label>
						<input type="date" name="dt"  placeholder="Date of Initial Assessment" required class="form-control" id="exampleInputEmail1" />
					</div>
					<div class="form-group">
						<label for="exampleInputEmail1">Treatment Setting</label>
						<textarea required="" class="form-control" name="setting"></textarea>
					</div>

					@endforeach

					<input type="submit" name="" value="Continue" class="btn btn-primary">

				</form>

			</div>
		</div>


	</div>
</div>
@endsection
                                                                                                                                                                     @extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">

		<div class="panel panel-primary col-sm-5">
			<div class="panel-heading">Add Report (Mental Helth)</div>
			<div class="panel-body">

				@if(Session::has('error'))
				<div class="alert alert-danger">
					{{ Session::get('error') }}
				</div>
				@endif

				<form method="post" action="menlast">

					@if ($errors->any())
					<div class="alert alert-danger">
						@foreach ($errors->all() as $error)
						<li>{{$error}}</li>
						@endforeach
					</div>
					@endif
					
					{{ csrf_field() }}

					<div class="form-group">
                            <label>Assessment environment</label>
                            <input type="text" required="" name="assessment" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Occupation being assessed</label>
                            <input type="text" required="" name="occupation" class="form-control">
                        </div>

                    <input type="hidden" name="type" value="environment">

                    <input type="submit" name="" value="Continue" class="btn btn-primary">

                </form>

            </div>
        </div>


    </div>
</div>
@endsection
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     