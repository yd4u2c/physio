@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">

		<div class="panel panel-primary col-sm-5">
			<div class="panel-heading">Current complaints</div>
			<div class="panel-body">

				<form method="post" action="{{ url('/paePage3') }}">
					{{ csrf_field() }}

					@if ($errors->any())
					<div class="alert alert-danger">
						@foreach ($errors->all() as $error)
						<li>{{$error}}</li>
						@endforeach
					</div>
					@endif

					<div class="form-group">
						<label for="exampleInputEmail1">What are the main concern regarding your child?</label>
					</div>

					<div class="form-group">
						<div class="checkbox">
							<label>
								<input type="checkbox" name="complain[]" value="Fine Motor (handwriting, buttoning)"> Fine Motor (handwriting, buttoning)
							</label>&nbsp;&nbsp;&nbsp;&nbsp;
							<label>
								<input type="checkbox" name="complain[]" value="mobility"> mobility
							</label>&nbsp;&nbsp;&nbsp;&nbsp;
							<label>
								<input type="checkbox" name="complain[]" value="feeding"> Feeding
							</label>&nbsp;&nbsp;&nbsp;&nbsp;
							<label>
								<input type="checkbox" name="complain[]" value="Behaviour"> Behaviour
							</label>&nbsp;&nbsp;&nbsp;&nbsp;
							<label>
								<input type="checkbox" name="complain[]" value="Gross Motor"> Gross Motor (walking, kicking a ball)
							</label>&nbsp;&nbsp;&nbsp;&nbsp;
							<label>
								<input type="checkbox" name="complain[]" value="speech"> Speech
							</label>&nbsp;&nbsp;&nbsp;&nbsp;
							<label>
								<input type="checkbox" name="complain[]" value="Language"> Language
							</label>&nbsp;&nbsp;&nbsp;&nbsp;
							<label>
								<input type="text" name="complain[]" class="form-control" placeholder="Others (Specify)">
							</label>
						</div>
					</div>

					<hr>

					<div class="checkbox">
						<label><input type="checkbox" required> I have reviewed the information provided above and I found them to be complete</label>
					</div>

					<div class="form-group">
						<label for="exampleInputEmail1">Physiotherapist (Name)</label>
						<input type="text" name="physio" value="{{ \Auth::User()->name }}" readonly required class="form-control" id="exampleInputEmail1" />
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
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 @foreach (session('flash_notification', collect())->toArray() as $message)
    @if ($message['overlay'])
        @include('flash::modal', [
            'modalClass' => 'flash-modal',
            'title'      => $message['title'],
            'body'       => $message['message']
        ])
    @else
        <div class="alert
                    alert-{{ $message['level'] }}
                    {{ $message['important'] ? 'alert-important' : '' }}"
                    role="alert"
        >
            @if ($message['important'])
                <button type="button"
                        class="close"
                        data-dismiss="alert"
                        aria-hidden="true"
                >&times;</button>
      