                                 <div class="input-group w3_w3layouts col-lg-12">
                                        <span class="input-group-addon" id="basic-addon1">STAFF SIGNATURE</span>
                                        <input type="text" name="signature" class="form-control" value="{{ \Auth::User()->name }}" placeholder="" readonly="" aria-describedby="basic-addon1" required="" / >
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 ">
                                <div class="form-group">
                                    <div class="input-group w3_w3layouts col-lg-12">
                                        <span class="input-group-addon" id="basic-addon1">DATE</span>
                                        <input type="text" name="date" class="form-control"  value="{{ date('d/m/Y') }}" aria-describedby="basic-addon1" required="" readonly / >
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 ">
                                <div class="form-group">
                                    <div class="input-group w3_w3layouts col-lg-12">
                                        <span class="input-group-addon" id="basic-addon1">TIME</span>
                                        <input type="text" name="time" class="form-control" value="{{ date('h:i:sa') }}" aria-describedby="basic-addon1" required="" readonly / >
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 ">
                                <div class="form-group">
                                    <div class="input-group w3_w3layouts col-lg-12">
                                        <span class="input-group-addon" id="basic-addon1">PRINT NAME</span>
                                        <input type="text" name="print" class="form-control" style="text-transform: uppercase;" placeholder="print name" " aria-describedby="basic-addon1" required="" / >
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 ">
                                <div class="form-group">
                                    <div class="input-group w3_w3layouts col-lg-12">
                                        <span class="input-group-addon" id="basic-addon1">DESIGNATION</span>
                                        <input type="text" name="designation" class="form-control" placeholder="designation" aria-describedby="basic-addon1" required="" / >
                                    </div>
                                </div>
                            </div>

					<input type="submit" name="" value="continue" class="btn btn-primary">

				</form>

			</div>
		</div>


    </div>
</div>
@endsection
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             @extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">

   <div class="panel panel-primary col-sm-10">
     <div class="panel-heading">SUMMARY OF PROBLEM COMPLICATION</div>
     <div class="panel-body">

      @if(Session::has('error'))
      <div class="alert alert-danger">
       {{ Session::get('error') }}
     </div>
     @endif

     <form method="post" action="neuPage4">

       @if ($errors->any())
       <div class="alert alert-danger">
        @foreach ($errors->all() as $error)
        <li>{{$error}}</li>
        @endforeach
      </div>
      @endif

      {{ csrf_field() }}

      
      <div class="form-group">

        <div class="col-lg-6 ">
          <div class="form-group">
            <div class="form-check">
             <label class="form-check-label" for="exampleRadios1">At risk of respiratory complications</label>&nbsp;&nbsp;
             <input class="form-check-input" type="radio" name="respiratory" id="exampleRadios1" value="Yes" checked>
             <label class="form-check-label" for="exampleRadios1">Yes</label>&nbsp;
             <input class="form-check-input" type="radio" name="respiratory" id="exampleRadios1" value="no" checked>
             <label class="form-check-label" for="exampleRadios1">No</label>
           </div>
         </div>
       </div>
       <div class="col-lg-6 ">
        <div class="form-group">
          <div class="form-check">
           <label class="form-check-label" for="exampleRadios1">At risk of abnormal muscle tone and contractures</label>&nbsp;&nbsp;
           <input class="form-check-input" type="radio" name="muscle_tone" id="exampleRadios1" value="yes" checked>
           <label class="form-check-label" for="exampleRadios1">Yes</label>&nbsp;
           <input class="form-check-input" type="radio" name="muscle_tone" id="exampleRadios1" value="no" checked>
           <label class="form-check-label" for="exampleRadios1">No</label>
         </div>
       </div>
     </div>
     <div class="col-lg-6 ">
      <div class="form-group">
        <div class="form-check">
         <label class="form-check-label" for="exampleRadios1">At risk of shoulder pain</label>&nbsp;&nbsp;
         <input class="form-check-input" type="radio" name="shoulder" id="exampleRadios1" value="yes" checked>
         <label class="form-check-label" for="exampleRadios1">Yes</label>&nbsp;
         <input class="form-check-input" type="radio" name="shoulder" id="exampleRadios1" value="no" checked>
         <label class="form-check-label" for="exampleRadios1">No</label>
       </div>
     </div>
   </div>
   <div class="col-lg-6 ">
    <div class="form-group">
      <div class="form-check">
       <label class="form-check-label" for="exampleRadios1"> sitting balance</label>&nbsp;&nbsp;
       <input class="form-check-input" type="radio" name="sitting" id="exampleRadi