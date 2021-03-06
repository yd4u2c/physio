@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">

		<div class="panel panel-primary col-sm-10">
			<div class="panel-heading">Pregnancy and birth History</div>
			<div class="panel-body">

				<form method="post" action="{{ url('/paePage4') }}">
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
								<input type="text" name="issue[]" value="Were there any complication during pregnancy" readonly class="form-control" id="exampleInputEmail1" />
							</td>
							<td>
								<label>Yes <input type="checkbox" name="answer[]" value="yes"></label>&nbsp;&nbsp;&nbsp;
								<label>No <input type="checkbox" name="answer[]" value="no"></label>
							</td>
							<td>
								<input type="text" name="comment[]" placeholder="If Yes, Please comment" class="form-control" id="exampleInputEmail1" />
							</td>
						</tr>
						<tr>
							<td>
								<input type="text" name="issue[]" value="was the pregnancy full term" readonly class="form-control" id="exampleInputEmail1" />
							</td>
							<td>
								<label>Yes <input type="checkbox" name="answer[]" value="yes"></label>&nbsp;&nbsp;&nbsp;
								<label>No <input type="checkbox" name="answer[]" value="no"></label>
							</td>
							<td>
								<input type="text" name="comment[]" placeholder="If no, Please comment" class="form-control" id="exampleInputEmail1" />
							</td>
						</tr>
						<tr>
							<td>
								<input type="text" name="issue[]" value="was labour and delivery normal" readonly class="form-control" id="exampleInputEmail1" />
							</td>
							<td>
								<label>Yes <input type="checkbox" name="answer[]" value="yes"></label>&nbsp;&nbsp;&nbsp;
								<label>No <input type="checkbox" name="answer[]" value="no"></label>
							</td>
							<td>
								<input type="text" name="comment[]" placeholder="If no, Please comment" class="form-control" id="exampleInputEmail1" />
							</td>
						</tr>
					</table>

					<div class="form-group">
							Birth Weight: <input type="text" name="weight" placeholder="Birth Weight" required="">
						</div>

					<div class="checkbox">
						<label><input type="checkbox"> I have reviewed the information provided above and I found them to be accurate</label>
					</div>

					<div class="form-group">
						<label for="exampleInputEmail1">Physiotherapist (Name)</label>
						<input type="text" value="{{ Auth::User()->name }}" readonly required name="physio_name" class="form-control" id="exampleInputEmail1" />
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
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             