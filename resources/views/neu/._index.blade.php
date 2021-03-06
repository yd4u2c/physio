@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">

		<div class="panel panel-primary col-sm-6">
			<div class="panel-heading">INTERVENTION</div>
			<div class="panel-body">

				@if(Session::has('error'))
				<div class="alert alert-danger">
					{{ Session::get('error') }}
				</div>
				@endif

				<form method="post" action="occPage7">

					@if ($errors->any())
					<div class="alert alert-danger">
						@foreach ($errors->all() as $error)
						<li>{{$error}}</li>
						@endforeach
					</div>
					@endif
					
					{{ csrf_field() }}

					<div class="form-group">
            <label>Patient/family goals</label>
            <input type="text" name="patient" required="" class="form-control">
          </div>

          <div class="form-group">
            <label>Analysis of Occupational performance</label>
            <textarea class="form-control" required="" name="analysis"></textarea>
          </div>

          <div class="form-group">
            <label>Short-term goals</label>
            <textarea class="form-control" required="" name="short_goal"></textarea>
          </div>

          <div class="form-group">
            <label>Long-term goals</label>
            <textarea class="form-control" required="" name="long_goal"></textarea>
          </div>

          <div class="form-group">
            <label>OT intervention plan</label>
            <textarea class="form-control" name="OT" required=""></textarea>
          </div>

          <div class="form-group">
            <label>Frequency/duration</label>
            <textarea class="form-control" name="frequency" required=""></textarea>
          </div>

          <div class="form-group">
            <label>Therapist’s Name</label>
            <input type="text" value="{{ \Auth::User()->name }}" readonly class="form-control" name="therapist" placeholder="Therapist’s name" required>
          </div>

          <input type="submit" name="" value="Continue" class="btn btn-primary">

        </form>

      </div>
    </div>


  </div>
</div>
@endsection
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     