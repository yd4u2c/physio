opadding">
              <form class="form-horizontal" method="post" action="#" name="password_validate" id="password_validate" novalidate="novalidate">
                <div class="control-group">
                  <label class="control-label">Password</label>
                  <div class="controls">
                    <input type="password" name="pwd" id="pwd" />
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label">Confirm password</label>
                  <div class="controls">
                    <input type="password" name="pwd2" id="pwd2" />
                  </div>
                </div>
                <div class="form-actions">
                  <input type="submit" value="Validate" class="btn btn-success">
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div-->
  </div>
</div>
<!--Footer-part-->
<div class="row-fluid">
  <?php include ("include/footer.php");?>
</div>
<!--end-Footer-part-->
<script src="js/jquery.min.js"></script> 
<script src="js/jquery.ui.custom.js"></script> 
<script src="js/bootstrap.min.js"></script> 
<script src="js/jquery.uniform.js"></script> 
<script src="js/select2.min.js"></script> 
<script src="js/jquery.validate.js"></script> 
<script src="js/matrix.js"></script> 
<script src="js/matrix.form_validation.js"></script>
</body>
</html>
<?php
}
else{
  header("Location: login.php");
}
                                                                      