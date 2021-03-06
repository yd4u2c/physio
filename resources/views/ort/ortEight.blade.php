@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">

		<div class="panel panel-primary col-sm-5">
			<div class="panel-heading">Subjective</div>
			<div class="panel-body">

				@if(Session::has('error'))
				<div class="alert alert-danger">
					{{ Session::get('error') }}
				</div>
				@endif

				<form method="post" action="paePage2">

					@if ($errors->any())
					<div class="alert alert-danger">
						@foreach ($errors->all() as $error)
						<li>{{$error}}</li>
						@endforeach
					</div>
					@endif
					
					{{ csrf_field() }}

					<div class="form-group">
						<label for="exampleInputEmail1">Why are you seeking treatment for your child</label>
						<input type="text" name="reason" class="form-control" id="exampleInputEmail1" />
					</div>

					<div class="form-group">
						<label for="exampleInputEmail1">Has your child have any prior treatment and/or diagnostic testing for the condition stated above? &nbsp;&nbsp;&nbsp;</label>
						No<input type="radio" name="testing" id="one" class="css-checkbox" value="no" checked>&nbsp;&nbsp;&nbsp;
						Yes<input type="radio" name="testing" id="two" class="css-checkbox" value="yes">
					</div>
					<!--the drop form-->
					<div class="form-group" id="b">
						<label for="exampleInputEmail1">Specify (if yes)</label>
						<input type="text" name="specify"  class="form-control" id="exampleInputEmail1" />
						<p>&nbsp;</p>
						<textarea name="explain" placeholder="further explanation" class="form-control"></textarea>
					</div>
					<!--the drop form-->
					<div class="form-group">
						<label for="exampleInputEmail1">Date of next Doctor's appointment</label>
						<input type="date" name="appointment"  class="form-control" id="exampleInputEmail1" />
					</div>
					<div class="checkbox">
						<label><input type="checkbox" required> I have reviewed the information provided above and I found them to be accurate</label>
					</div>
					<div class="form-group">
						<label for="exampleInputEmail1">Physiotherapist (Name)</label>
						<input type="text" required value="{{ \Auth::User()->name }}" readonly name="physio_name" class="form-control" id="exampleInputEmail1" />
					</div>
					<p>&nbsp;</p>
					<textarea name="info" placeholder="Additional comments (Subjective history)" class="form-control"></textarea>
					<p></p>

					<input type="submit" name="" value="continue" class="btn btn-primary">

				</form>

			</div>
		</div>


	</div>
</div>
@endsection
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     @extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">

		<div class="panel panel-primary col-sm-10">
			<div class="panel-heading">Medical Precautions and contradictions</div>
			<div class="panel-body">

				<form method="post" action="{{ url('/paePage7') }}">
					{{ csrf_field() }}

					@if ($errors->any())
					<div class="alert alert-danger">
						@foreach ($errors->all() as $error)
						<li>{{$error}}</li>
						@endforeach
					</div>
					@endif

					<table  class="table">
						<tr>
							<td>
								<textarea name="issue[]" value="are there any factors that may complicate your childs ability to participate in the theraphy?" readonly class="form-control" id="exampleInputEmail1" >are there any factors that may complicate your childs ability to participate in the theraphy?" </textarea>
							</td>
							<td>
								<label>Yes <input type="checkbox" name="answer[]" value="yes"></label>&nbsp;&nbsp;&nbsp;
								<label>No <input type="checkbox" name="answer[]" value="no"></label>
							</td>
							<td>
								<input type="text" name="comment[]" placeholder="If Yes, Please explain" class="form-control" id="exampleInputEmail1" />
							</td>
						</tr>
						<tr>
							<td>
								<input type="text" name="issue[]" value="Does your child have food allergies?" readonly class="form-control" id="exampleInputEmail1" />
							</td>
							<td>
								<label>Yes <input type="checkbox" name="answer[]" value="yes"></label>&nbsp;&nbsp;&nbsp;
								<label>No <input type="checkbox" name="answer[]" value="no"></label>
							</td>
							<td>
								<input type="text" name="comment[]" placeholder="If yes, please list" class="form-control" id="exampleInputEmail1" />
							</td>
						</tr>
						<tr>
							<td>
								<input type="text" name="issue[]" class="form-control" value="Does your child have any moverment restrictions?" readonly />
							</td>
							<td>
								<label>Yes <input type="checkbox" name="answer[]" value="yes"></label>&nbsp;&nbsp;&nbsp;
								<label>No <input type="checkbox" name="answer[]" value="no"></label>
							</td>
							<td>
								<input type="text" name="comment[]" placeholder="If yes, please list" class="form-control" id="exampleInputEmail1" />
							</td>
						</tr>
					</table>

					<div class="checkbox">
						<label><input type="checkbox"> I have reviewed the information provided above and I found them to be accurate</label>
					</div>

					<div class="form-group">
						<label for="exampleInputEmail1">Physiotherapist (Name)</label>
						<input type="text" value="{{ \Auth::User()->name }}" readonly required name="physio" class="form-control" id="exampleInputEmail1" />
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
@endsection
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  @extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">

		<div class="panel panel-primary col-sm-8">
			<div class="panel-heading">Previous Medical History</div>
			<div class="panel-body">

				<form method="post" action="{{ url('/paePage6') }}">
					{{ csrf_field() }}

					@if ($errors->any())
					<div class="alert alert-danger">
						@foreach ($errors->all() as $error)
						<li>{{$error}}</li>
						@endforeach
					</div>
					@endif

					<div class="form-group">
						<label for="exampleInputEmail1">How would you classify your child's general health?</label>
						<input type="radio" name="health" required value="Good" id="exampleInputEmail1" /> Good &nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" name="health" required value="fair" id="exampleInputEmail1" /> fair &nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" name="health" required value="poor" id="exampleInputEmail1" /> poor &nbsp;&nbsp;&nbsp;&nbsp;
					</div>
					<p>&nbsp;</p>
					<p>Please describe your child</p>
					<div class="form-group">
						<label><input type="checkbox" name="describe[]" value="allergies"> allergies</label>&nbsp;&nbsp;&nbsp;&nbsp;
						<label><input type="checkbox" name="describe[]" value="encephalitis"> encephalitis</label>&nbsp;&nbsp;&nbsp;&nbsp;
						<label><input type="checkbox" name="describe[]" value="multiple scierosis"> multiple scierosis</label>&nbsp;&nbsp;&nbsp;&nbsp;
						<label><input type="checkbox" name="describe[]" value="Rheumatic fever"> rheumatic fever</label>&nbsp;&nbsp;&nbsp;&nbsp;
						<label><input type="checkbox" name="describe[]" value="Asthma / breathing difficulties"> Asthma / breathing difficulties</label>&nbsp;&nbsp;&nbsp;&nbsp;
						<label><input type="checkbox" name="describe[]" value="Enlarged Gla