@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">

		<div class="panel panel-primary col-sm-8">
			<div class="panel-heading">Social history, Interest and Living Environment</div>
			<div class="panel-body">

				<form method="post" action="{{ url('/paePage9') }}">
					{{ csrf_field() }}

					@if ($errors->any())
					<div class="alert alert-danger">
						@foreach ($errors->all() as $error)
						<li>{{$error}}</li>
						@endforeach
					</div>
					@endif

					<table class="table" border="1">
						<tr>
							<td><input type="text" name="fname" class="form-control" required placeholder="Enter Fathers name"></td>
							<td><input type="number" name="fage" class="form-control" required placeholder="Father age" min="1"></td>
							<td><input type="text" name="focc" class="form-control" required placeholder="Enter Fathers occupation"></td>
						</tr>
						<tr>
							<td><input type="text" name="mname" class="form-control" required placeholder="Enter Mother's name"></td>
							<td><input type="number" name="mage" class="form-control" required placeholder="Mother's age" min="1"></td>
							<td><input type="text" name="mocc" class="form-control" required placeholder="Enter mother's occupation"></td>
						</tr>
					</table>
					<p>&nbsp;</p>
					<div class="form-group">
						<label>Is she Adopted</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<label><input type="radio" name="adopt" value="yes"> Yes</label>
						<label><input type="radio" name="adopt" value="no"> no</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="text" name="age"  placeholder="If Yes, Input age adopted" style="width: 40%">
					</div>
					<div class="form-group">
						<label>Parents's Marital status</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" name="marry" value="married"> Married &nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" name="marry" value="living together"> living together &nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" name="marry" value="seperated"> seperated &nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" name="marry" value="divorced"> Divorced &nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" name="marry" value="Remarried"> Re-Married &nbsp;&nbsp;&nbsp;&nbsp;
					</div>
					<div class="form-group">
						<label>Who lives in the house with the child</label>
						<input type="text" name="live" class="form-control">
					</div>

					<hr>
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
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         