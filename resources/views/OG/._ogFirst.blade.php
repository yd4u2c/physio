me="rehab"  required class="form-control" id="exampleInputEmail1" />
          </div>
          <div class="w3-card">
            <header class="w3-container w3-blue">
              <h4>Goals</h4>
            </header>
            <div class="w3-container">
              <div class="form-group col-sm-6">
                <label for="exampleInputEmail1">Short Term Goals</label>
                <input type="text" name="short_goal"  required class="form-control" id="exampleInputEmail1" />
              </div>
              <div class="form-group col-sm-6">
                <label for="exampleInputEmail1">Long Term Goals</label>
                <input type="text" name="long_goal"  required class="form-control" id="exampleInputEmail1" />
              </div>
            </div>
          </div>
          <!--::::TREATMENT PLAN::::-->
          <div class="w3-card">
            <header class="w3-container w3-blue">
              <h4>Treatment Plan</h4>
            </header>
            <div class="w3-container">
              <div class="form-group col-sm-4">
                <label for="exampleInputEmail1">Frequency</label>
                <input type="text" name="frequency"  required class="form-control" id="exampleInputEmail1" />
              </div>
              <div class="form-group col-sm-4">
                <label for="exampleInputEmail1">Duration</label>
                <input type="text" name="duration"  required class="form-control" id="exampleInputEmail1" />
              </div>
              <div class="form-group col-sm-4">
                <label for="exampleInputEmail1">Modalities</label>
                <input type="text" name="modalities"  required class="form-control" id="exampleInputEmail1" />
              </div>

              <div class="col-sm-12">
                <div class="form-group" style="background: #fff;">
                  <p>&nbsp;</p>
                  <label for="exampleInputEmail1"><b>Posture</b></label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <input type="checkbox" name="Posture[]"  value="No Abnormality" />No Abnormality &nbsp;&nbsp;&nbsp;
                  <input type="checkbox" name="Posture[]"  value="Forward Head" />Forward Head &nbsp;&nbsp;&nbsp;
                  <input type="checkbox" name="Posture[]"  value="Genu Valgum/Varus/Recurvatum" />Genu Valgum/Varus/Recurvatum &nbsp;&nbsp;&nbsp;
                  <input type="checkbox" name="Posture[]"  value="Kyphosis" />Kyphosis &nbsp;&nbsp;&nbsp;
                  <input type="checkbox" name="Posture[]"  value="Protracted Shoulders" />Protracted Shoulders &nbsp;&nbsp;&nbsp;
                  <input type="checkbox" name="Posture[]"  value="Ankle Pronation/Supination" />Ankle Pronation/Supination &nbsp;&nbsp;&nbsp;
                  <input type="checkbox" name="Posture[]"  value="Scoliosis" />Scoliosis &nbsp;&nbsp;&nbsp;
                  <input type="checkbox" name="Posture[]"  value="Leg Length" />Leg Length &nbsp;&nbsp;&nbsp;
                  <input type="checkbox" name="Posture[]"  value="Discrepancy" />Discrepancy &nbsp;&nbsp;&nbsp;
                  <input type="checkbox" name="Posture[]"  value="Lordosis" />Lordosis &nbsp;&nbsp;&nbsp;
                  <input type="text" name="Posture[]" value="*"  placeholder="add additional Posture" /> &nbsp;&nbsp;&nbsp;
                  <p>&nbsp;</p>
                </div>
              </div>

              <input type="submit" name="Continue" class="btn btn-primary">

            </form>

          </div>
        </div>


      </div>
    </div>
    @endsection
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 