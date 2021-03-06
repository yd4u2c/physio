@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">

		<div class="panel panel-primary col-sm-8">
			<div class="panel-heading">Medication and Communication History</div>
			<div class="panel-body">

				<form method="post" action="{{ url('/paePage8') }}">
					{{ csrf_field() }}

					@if ($errors->any())
					<div class="alert alert-danger">
						@foreach ($errors->all() as $error)
						<li>{{$error}}</li>
						@endforeach
					</div>
					@endif

					<div class="form-group">
						<label>Please list all the medications (with specific name, dosage, frequency and route) that you are currently taking including over the counter, prescription, herbals and vitamins and minerals</label>
						<textarea class="form-control" name="medication" placeholder="Place medications here"></textarea>
					</div>

					<div class="form-group">
						<label>Please describe any communication difficulty</label>
						<textarea class="form-control" name="communication" placeholder="describe communication difficulties here"></textarea>
					</div>

					<div class="form-group">
						<label>When was the problem first noticed</label>
						<input type="date" name="date_notices" class="form-control" style="width: 50%;">
					</div>

					<div class="form-group">
						<label>Other language apart from english spoken at home</label>
						<input type="text" name="lang" class="form-control">
					</div>

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
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     