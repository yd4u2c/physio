ption>
                </select>
              </td>
            </tr>
            <tr>
              <td><input type="text" name="test[]" value="Varus Test" readonly></td>
              <td>
                <select name="answer[]">
                  <option value="+ve">+ve</option>
                  <option value="-ve">-ve</option>
                </select>
              </td>
            </tr>
            <tr>
              <td><input type="text" name="test[]" value="Tinel Test" readonly></td>
              <td>
                <select name="answer[]">
                  <option value="+ve">+ve</option>
                  <option value="-ve">-ve</option>
                </select>
              </td>
            </tr>
            <tr>
              <th colspan="2">Hand and Wrist</th>
            </tr>
            <tr>
              <td><input type="text" name="test[]" value="Tinel’s Test" readonly></td>
              <td>
                <select name="answer[]">
                  <option value="+ve">+ve</option>
                  <option value="-ve">-ve</option>
                </select>
              </td>
            </tr>
            <tr>
              <td><input type="text" name="test[]" value="Reverse Phalen’s Test" readonly></td>
              <td>
                <select name="answer[]">
                  <option value="+ve">+ve</option>
                  <option value="-ve">-ve</option>
                </select>
              </td>
            </tr>
            <tr>
              <td><input type="text" name="test[]" value="Compression Test" readonly></td>
              <td>
                <select name="answer[]">
                  <option value="+ve">+ve</option>
                  <option value="-ve">-ve</option>
                </select>
              </td>
            </tr>
            <tr>
              <th colspan="2">Hip</th>
            </tr>
            <tr>
              <td><input type="text" name="test[]" value="Faber’s Test" readonly></td>
              <td>
                <select name="answer[]">
                  <option value="+ve">+ve</option>
                  <option value="-ve">-ve</option>
                </select>
              </td>
            </tr>
            <tr>
              <td><input type="text" name="test[]" value="Ely’s Test" readonly></td>
              <td>
                <select name="answer[]">
                  <option value="+ve">+ve</option>
                  <option value="-ve">-ve</option>
                </select>
              </td>
            </tr>
            <tr>
              <td><input type="text" name="test[]" value="Gaeslen Test" readonly></td>
              <td>
                <select name="answer[]">
                  <option value="+ve">+ve</option>
                  <option value="-ve">-ve</option>
                </select>
              </td>
            </tr>
            <tr>
              <th colspan="2">Knee</th>
            </tr>
            <tr>
              <td><input type="text" name="test[]" value="Valgus Test" readonly></td>
              <td>
                <select name="answer[]">
                  <option value="+ve">+ve</option>
                  <option value="-ve">-ve</option>
                </select>
              </td>
            </tr>
            <tr>
              <td><input type="text" name="test[]" value="Varus Test" readonly></td>
              <td>
                <select name="answer[]">
                  <option value="+ve">+ve</option>
                  <option value="-ve">-ve</option>
                </select>
              </td>
            </tr>
            <tr>
              <td><input type="text" name="test[]" value="Anterior Drawal Test" readonly></td>
              <td>
                <select name="answer[]">
                  <option value="+ve">+ve</option>
                  <option value="-ve">-ve</option>
                </select>
              </td>
            </tr>
            <tr>
              <td><input type="text" name="test[]" value="Posterior Drawal Test" readonly></td>
              <td>
                <select name="answer[]">
                  <option value="+ve">+ve</option>
                  <option value="-ve">-ve</option>
                </select>
              </td>
            </tr>
            <tr>
              <td><input type="text" name="test[]" value="Patella Grind Test" readonly></td>
              <td>
                <select name="answer[]">
                  <option value="+ve">+ve</option>
                  <option value="-ve">-ve</option>
                </select>
              </td>
            </tr>
            <tr>
              <th colspan="2">Ankle and foot</th>
            </tr>
            <tr>
              <td><input type="text" name="test[]" value="Talar Tilt Test" readonly></td>
              <td>
                <select name="answer[]">
                  <option value="+ve">+ve</option>
                  <option value="-ve">-ve</option>
                </select>
              </td>
            </tr>
            <tr>
              <td><input type="text" name="test[]" value="Anterior Drawal Test" readonly></td>
              <td>
                <select name="answer[]">
                  <option value="+ve">+ve</option>
                  <option value="-ve">-ve</option>
                </select>
              </td>
            </tr>
            <tr>
              <td><input type="text" name="test[]" value="External Rotator Test" readonly></td>
              <td>
                <select name="answer[]">
                  <option value="+ve">+ve</option>
                  <option value="-ve">-ve</option>
                </select>
              </td>
            </tr>

          </table>

          <input type="submit" name="Continue" class="btn btn-primary">

        </form>

      </div>
    </div>


  </div>
</div>
@endsection
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              @extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">

    <div class="panel panel-primary col-sm-9">
      <div class="panel-heading">*******</div>
      <div class="panel-body">

        @if(Session::has('error'))
        <div class="alert alert-danger">
          {{ Session::get('error') }}
        </div>
        @endif

        <form method="post" action="ortPage11">

          @if ($errors->any())
          <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
            <li>{{$error}}</li>
            @endforeach
          </div>
          @endif
          
          {{ csrf_field() }}

          <div class="form-group" style="background: #fff;">
            <p>&nbsp;</p>
            <label for="exampleInputEmail1"><b>Deviations</b></label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="checkbox" name="Deviations[]"  value="Decrease heel toe gait" />Decrease heel toe gait &nbsp;&nbsp;&nbsp;
            <input type="checkbox" name="Deviations[]"  value="Decrease reciprocal arm swing" />Decrease reciprocal arm swing &nbsp;&nbsp;&nbsp;
            <input type="checkbox" name="Deviations[]"  value="Decrease base of support" />Decrease base of support &nbsp;&nbsp;&nbsp;
            <input type="checkbox" name="Deviations[]"  value="Loss of balance (LOB)" />Loss of balance (LOB) &nbsp;&nbsp;&nbsp;
            <input type="checkbox" name="Deviations[]"  value="Antalgic gait" />Antalgic gait &nbsp;&nbsp;&nbsp;
            <input type="checkbox" name="Deviations[]"  value="Shuffling gait" />Shuffling gait &nbsp;&nbsp;&nbsp;
            <input type="checkbox" name="Deviations[]"  value="Waddling Cadence (Fast/Slow)" />Waddling Cadence (Fast/Slow) &nbsp;&nbsp;&nbsp;
            <input type="checkbox" name="Deviations[]"  value="Festinating" />Festinating &nbsp;&nbsp;&nbsp;
            <input type="text" name="Deviations[]" value="*"  placeholder="Enter other here" /> &nbsp;&nbsp;&nbsp;
            <p>&nbsp;</p>
          </div>

          <input type="submit" name="Continue" class="btn btn-primary">

        </form>

      </div>
    </div>


  </div>
</div>
@endsection
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            @extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">

    <div class="panel panel-primary col-sm-12" style="overflow-y: scroll;">
      <div class="panel-heading">RANGE OF MOTION</div>
      <div class="panel-body">

        @if(Session::has('error'))
        <div class="alert alert-danger">
          {{ Session::get('error') }}
        </div>
        @endif

        <form method="post" action="ortPage5">

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
              <th></th>
              <th colspan="3" style="text-ali