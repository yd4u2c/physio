<?php
}
else{
  header("Location: login.php");
}                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <?php
include("include/connect.php");
include("include/drug_inc.php");
$User = $_SESSION['User'];
$sel = $sel = "SELECT * FROM admin WHERE user='$User' ";
$res = $conn->query($sel);
if ($res->num_rows == 1) {
  $active = "welcome";
  if (isset($_POST['ct'])) {
    $Cat = $_POST['Cat'];
    $chk = "SELECT * FROM drug_category WHERE drug='$Cat'";
    $chk_res = $conn->query($chk);
    if ($chk_res->num_rows > 0) {
      $err = "<dt style='color: red;'>Category Already Exist</dt>";
    }
  }
  ?>
  <!DOCTYPE html>
  <html lang="en">
  <head>
    <title>Matrix Admin</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/bootstrap-responsive.min.css" />
    <link rel="stylesheet" href="css/uniform.css" />
    <link rel="stylesheet" href="css/select2.css" />
    <link rel="stylesheet" href="css/matrix-style.css" />
    <link rel="stylesheet" href="css/matrix-media.css" />
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>
    <script type="text/javascript">
      function show(str){
        document.getElementById('sh2').style.display = 'none';
        document.getElementById('sh1').style.display = 'block';
      }
      function show2(sign){
        document.getElementById('sh2').style.display = 'block';
        document.getElementById('sh1').style.display = 'none';
      }
    </script>
    <script>
      function isNumberKey(evt){
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
          return false;
        return true;
      }
    </script>
  </head>
  <body>

    <!--Header-part-->
    <div id="header">
      <h1><a href="dashboard.html">NHIS Admin</a></h1>
    </div>
    <!--close-Header-part--> 

    <!--top-Header-menu-->
    <div id="user-nav" class="navbar navbar-inverse">
      <ul class="nav">
        <li  class="dropdown" id="profile-messages" ><a title="" href="#" data-toggle="dropdown" data-target="#profile-messages" class="dropdown-toggle"><i class="icon icon-user"></i>  <span class="text">Welcome User</span><b class="caret"></b></a>
          <ul class="dropdown-menu">
            <li><a href="#"><i class="icon-user"></i> My Profile</a></li>
            <li class="divider"></li>
            <li><a href="#"><i class="icon-check"></i> My Tasks</a></li>
            <li class="divider"></li>
            <li><a href="include/logout.php"><i class="icon-key"></i> Log Out</a></li>
          </ul>
        </li>
        <li class="dropdown" id="menu-messages"><a href="#" data-toggle="dropdown" data-target="#menu-messages" class="dropdown-toggle"><i class="icon icon-envelope"></i> <span class="text">Messages</span> <span class="label label-important">5</span> <b class="caret"></b></a>
          <ul class="dropdown-menu">
            <li><a class="sAdd" title="" href="#"><i class="icon-plus"></i> new message</a></li>
            <li class="divider"></li>
            <li><a class="sInbox" title="" href="#"><i class="icon-envelope"></i> inbox</a></li>
            <li class="divider"></li>
            <li><a class="sOutbox" title="" href="#"><i class="icon-arrow-up"></i> outbox</a></li>
            <li class="divider"></li>
            <li><a class="sTrash" title="" href="#"><i class="icon-trash"></i> trash</a></li>
          </ul>
        </li>
        <li class=""><a title="" href="#"><i class="icon icon-cog"></i> <span class="text">Settings</span></a></li>
        <li class=""><a title="" href="include/logout.php"><i class="icon icon-share-alt"></i> <span class="text">Logout</span></a></li>
      </ul>
    </div>

    <!--start-top-serch-->
    <div id="search">
      <input type="text" placeholder="Search here..."/>
      <button type="submit" class="tip-bottom" title="Search"><i class="icon-search icon-white"></i></button>
    </div>
    <!--close-top-serch--> 

    <!--sidebar-menu-->

    <div id="sidebar"> <a href="#" class="visible-phone"><i class="icon icon-list"></i>Forms</a>
      <?php include ("include/sidebar.php");?>
    </div>
    <div id="content">
      <div id="content-header">
        <div id="breadcrumb"> <a href="welcome.php" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Drug</a> <a href="#" class="current">Add Drug</a> </div>
        <h1>Add Drug</h1>
        <div class="container-fluid"><hr>
          <div class="widget-box">
            <div class="widget-title form-inline"> <span class="icon"> <i class="icon-info-sign"></i> </span>
              <h5>Add New Drug Category</h5> 
              <label>No
                <input type="radio" class="inputbox form-control" checked="checked" name="GO" onchange="show(this.value)" value="No"></label>
                <label>Yes
                  <input type="radio" class="inputbox form-control" id="e1" onchange="show2()" name="GO" value="Yes"></label> <?php echo $err; echo $Cat2;?>
                </div>
                <div class="widget-content nopadding">
                  <form class="form-horizontal" method="POST" action="" name="basic_validate" id="basic_validate" novalidate="novalidate">
                    <div class="control-group">
                      <div id="sh2" style="display: none ;">
                        <label class="control-label">DRUG CATEGORY NAME</label>
                        <div class="controls">
                          <input type="text" name="Cat" id="required" required="required">
                          <input type="submit" name="ct" value="Add Category" class="btn btn-success">
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <div class="container-fluid"><hr>
            <div class="row-fluid">
              <div class="span12">
                <div class="widget-box">
                  <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
                    <h5>Fill in Drug details</h5> <?php echo $err1;?>
                  </div>
                  <div class="widget-content nopadding">
                    <form class="form-horizontal" method="POST" action="" name="basic_validate" id="basic_validate" novalidate="novalidate">
                      <div class="control-group">
                        <label class="control-label">Drug Category</label>
                        <div class="controls">
                          <?php
                    $query = ("SELECT * FROM drug_category"); // Run your query
                    echo '<select name="Category">'; // Open your drop down box
                  