                          <option value="moderate assistance">moderate assistance</option>
                            <option value="maximum assistance">maximum assistance</option>
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <td>Wheel Chair use<input type="text" name="test[]" value="Wheel Chair use" readonly style="display: none;"></td>
                        <td>
                          <select name="answer[]">
                            <option value="independent">independent</option>
                            <option value="standby assist">standby assist</option>
                            <option value="contact guard assist">contact guard assist</option>
                            <option value="Minimal assistance">Minimal assistance</option>
                            <option value="moderate assistance">moderate assistance</option>
                            <option value="maximum assistance">maximum assistance</option>
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <td>Other Deviations<input type="text" name="test[]" value="Other Deviations" readonly style="display: none;"></td>
                        <td>
                          <input type="text" value="*" name="answer[]" class="form-control" placeholder="Enter other here">
                        </td>
                      </tr>
                      <tr>
                        <td colspan="2">
                          <label>Comments</label>
                          <textarea class="form-control" required="" name="comments"></textarea>
                        </td>
                      </tr>
                    </table>
                    <div class="w3-card-4">
                      <header class="w3-container w3-blue">
                        <h5>Balance</h5>
                      </header>
                      <div class="w3-container">
                        <table class="table" border="1">
                          <tr>
                            <td>Static standing<input type="text" name="test[]" value="Static standing" readonly style="display: none;"></td>
                            <td>
                              <select name="answer[]" class="form-control">
                                <option value="GOOD">GOOD</option>
                                <option value="FAIR">FAIR</option>
                                <option value="BAD">BAD</option>
                              </select>
                            </td>
                          </tr>
                          <tr>
                            <td>Static sitting<input type="text" name="test[]" value="Static sitting" readonly style="display: none;"></td>
                            <td>
                              <select name="answer[]" class="form-control">
                                <option value="GOOD">GOOD</option>
                                <option value="FAIR">FAIR</option>
                                <option value="BAD">BAD</option>
                              </select>
                            </td>
                          </tr>
                          <tr>
                            <td>Dynamic standing<input type="text" name="test[]" value="Dynamic standing" readonly style="display: none;"></td>
                            <td>
                              <select name="answer[]" class="form-control">
                                <option value="GOOD">GOOD</option>
                                <option value="FAIR">FAIR</option>
                                <option value="BAD">BAD</option>
                              </select>
                            </td>
                          </tr>
                          <tr>
                            <td>Dynamic sitting<input type="text" name="test[]" value="Dynamic sitting" readonly style="display: none;"></td>
                            <td>
                              <select name="answer[]" class="form-control">
                                <option value="GOOD">GOOD</option>
                                <option value="FAIR">FAIR</option>
                                <option value="BAD">BAD</option>
                              </select>
                            </td>
                          </tr>
                          <tr>
                            <td>Functional Reach<input type="text" name="test[]" value="Functional Reach" readonly style="display: none;"></td>
                            <td>
                              <select name="answer[]" class="form-control">
                                <option value="GOOD">GOOD</option>
                                <option value="FAIR">FAIR</option>
                                <option value="BAD">BAD</option>
                              </select>
                            </td>
                          </tr>
                          <tr>
                            <td>Single leg balance<input type="text" name="test[]" value="Single leg balance" readonly style="display: none;"></td>
                            <td>
                              <select name="answer[]" class="form-control">
                                <option value="GOOD">GOOD</option>
                                <option value="FAIR">FAIR</option>
                                <option value="BAD">BAD</option>
                              </select>
                            </td>
                          </tr>
                          <tr>
                            <td>Romberg test<input type="text" name="test[]" value="Romberg test" readonly style="display: none;"></td>
                            <td>
                              <select name="answer[]" class="form-control">
                                <option value="GOOD">GOOD</option>
                                <option value="FAIR">FAIR</option>
                                <option value="BAD">BAD</option>
                              </select>
                            </td>
                          </tr>
                          <tr>
                            <td>Other<input type="text" name="test[]" value="other" readonly style="display: none;"></td>
                            <td>
                              <input type="text" value="*" name="answer[]" class="form-control">
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
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     @extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">

        <div class="panel panel-primary col-sm-10">
            <div class="panel-heading">Add Report (ORTHOPAEDIC)</div>
            <div class="panel-body">

                @if(Session::has('error'))
                <div class="alert alert-danger">
                    {{ Session::get('error') }}
                </div>
                @endif

                <form method="post" action="ortPage3">

                    @if ($errors->any())
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                        <li>{{$error}}</li>
              