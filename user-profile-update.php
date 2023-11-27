<?php
    session_start();
    include('assets/inc/config.php');
    include('assets/inc/checklogin.php');
    check_login();
    $aid=$_SESSION['user_id'];
    if(isset($_POST['Update_Profile']))
    {
      $user_fname=$_POST['user_fname'];
      $user_lname = $_POST['user_lname'];
      $user_phone=$_POST['user_phone'];
      $user_email=$_POST['user_email'];
      $user_gender=$_POST['user_gender'];
      $user_age=$_POST['user_age'];
      $user_city=$_POST['user_city'];
      $user_state=$_POST['user_state'];
      $user_country=$_POST['user_country'];

      $query="update USER set first_name = ?, last_name = ?, mobile_no = ?, email = ?, gender = ?, age = ?, city = ?, state = ?, country = ? where username=?";
      $stmt = $mysqli->prepare($query);
      $rc=$stmt->bind_param('sssssissss', $user_fname, $user_lname, $user_phone, $user_email, $user_gender, $user_age, $user_city, $user_state, $user_country, $aid);
      $stmt->execute();
      if($stmt)
      {
          $succ = "Your Profile Has Been Updated";
      }
      else 
      {
          $err = "Please Try Again Later";
      }
    }
?>
<!DOCTYPE html>
<html lang="en">
<!--Head-->
<?php include('assets/inc/head.php');?>
<!--End Head-->
  <body>
    <div class="be-wrapper be-fixed-sidebar ">
    <!--Navigation Bar-->
      <?php include('assets/inc/navbar.php');?>
      <!--End Navigation Bar-->

      <!--Sidebar-->
      <?php include('assets/inc/sidebar.php');?>
      <!--End Sidebar-->
      <div class="be-content">
        <div class="page-head">
          <h2 class="page-head-title">Profile </h2>
          <nav aria-label="breadcrumb" role="navigation">
            <ol class="breadcrumb page-head-nav">
              <li class="breadcrumb-item"><a href="user-dashboard.php">Dashboard</a></li>
              <li class="breadcrumb-item"><a href="#">Profile</a></li>
              <li class="breadcrumb-item active">Update Profile</li>
            </ol>
          </nav>
        </div>
            <?php if(isset($succ)) {?>
                                <!--This code for injecting an alert-->
                <script>
                            setTimeout(function () 
                            { 
                                swal("Success!","<?php echo $succ;?>!","success");
                            },
                                100);
                </script>

        <?php } ?>
        <?php if(isset($err)) {?>
        <!--This code for injecting an alert-->
                <script>
                            setTimeout(function () 
                            { 
                                swal("Failed!","<?php echo $err;?>!","Failed");
                            },
                                100);
                </script>

        <?php } ?>
        <div class="main-content container-fluid">
        <?php
            $aid=$_SESSION['user_id'];
            $ret="select * from USER where username=?";
            $stmt= $mysqli->prepare($ret) ;
            $stmt->bind_param('s',$aid);
            $stmt->execute() ;//ok
            $res=$stmt->get_result();
            $row=$res->fetch_object();
        ?>
          <div class="row">
            <div class="col-md-12">
              <div class="card card-border-color card-border-color-success">
                <div class="card-header card-header-divider">Update Your Profile<span class="card-subtitle">Fill All Details</span></div>
                <div class="card-body">
                  <form method ="POST">
                    <div class="form-group row">
                      <label class="col-12 col-sm-3 col-form-label text-sm-right" for="inputText3">First Name</label>
                      <div class="col-12 col-sm-8 col-lg-6">
                        <input class="form-control" name="user_fname" value="<?php echo $row->first_name;?>" id="inputText3" type="text">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-12 col-sm-3 col-form-label text-sm-right" for="inputText3"> Last Name</label>
                      <div class="col-12 col-sm-8 col-lg-6">
                        <input class="form-control" name="user_lname" value="<?php echo $row->last_name;?>" id="inputText3" type="text">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-12 col-sm-3 col-form-label text-sm-right" for="inputText3"> Email</label>
                      <div class="col-12 col-sm-8 col-lg-6">
                        <input class="form-control" name="user_email" value="<?php echo $row->email;?>" id="inputText3" type="text">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-12 col-sm-3 col-form-label text-sm-right" for="inputText3"> Phone No.</label>
                      <div class="col-12 col-sm-8 col-lg-6">
                        <input class="form-control" name="user_phone" value="<?php echo $row->mobile_no;?>" id="inputText3" type="text">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-12 col-sm-3 col-form-label text-sm-right" for="inputText3"> Gender</label>
                      <div class="col-12 col-sm-8 col-lg-6">
                        <select class="form-control" name="user_gender" id="inputText3" type="text">
                          <option value="<?php echo $row->gender ?>"><?php echo $row->gender ?></option>
                          <option value="M"> M </option>
                          <option value="F"> F </option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-12 col-sm-3 col-form-label text-sm-right" for="inputText3"> Age</label>
                      <div class="col-12 col-sm-8 col-lg-6">
                        <input class="form-control" name="user_age" value="<?php echo $row->age;?>" id="inputText3" type="number">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-12 col-sm-3 col-form-label text-sm-right" for="inputText3"> City</label>
                      <div class="col-12 col-sm-8 col-lg-6">
                        <input class="form-control" name="user_city" value="<?php echo $row->city;?>" id="inputText3" type="text">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-12 col-sm-3 col-form-label text-sm-right" for="inputText3"> State</label>
                      <div class="col-12 col-sm-8 col-lg-6">
                        <input class="form-control" name="user_state" value="<?php echo $row->state;?>" id="inputText3" type="text">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-12 col-sm-3 col-form-label text-sm-right" for="inputText3"> Country</label>
                      <div class="col-12 col-sm-8 col-lg-6">
                        <input class="form-control" name="user_country" value="<?php echo $row->country;?>" id="inputText3" type="text">
                      </div>
                    </div>
                    <div class="col-sm-6">
                        <p class="text-right">
                          <input class="btn btn-space btn-success" value ="Update Profile" name = "Update_Profile" type="submit">
                          <button class="btn btn-space btn-secondary">Cancel</button>
                        </p>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
        
        </div>
        <!--footer-->
        <?php include('assets/inc/footer.php');?>
        <!--EndFooter-->
      </div>

    </div>
    <script src="assets/lib/jquery/jquery.min.js" type="text/javascript"></script>
    <script src="assets/lib/perfect-scrollbar/js/perfect-scrollbar.min.js" type="text/javascript"></script>
    <script src="assets/lib/bootstrap/dist/js/bootstrap.bundle.min.js" type="text/javascript"></script>
    <script src="assets/js/app.js" type="text/javascript"></script>
    <script src="assets/lib/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
    <script src="assets/lib/jquery.nestable/jquery.nestable.js" type="text/javascript"></script>
    <script src="assets/lib/moment.js/min/moment.min.js" type="text/javascript"></script>
    <script src="assets/lib/datetimepicker/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
    <script src="assets/lib/select2/js/select2.min.js" type="text/javascript"></script>
    <script src="assets/lib/select2/js/select2.full.min.js" type="text/javascript"></script>
    <script src="assets/lib/bootstrap-slider/bootstrap-slider.min.js" type="text/javascript"></script>
    <script src="assets/lib/bs-custom-file-input/bs-custom-file-input.js" type="text/javascript"></script>
    <script type="text/javascript">
      $(document).ready(function(){
      	//-initialize the javascript
      	App.init();
      	App.formElements();
      });
    </script>
  </body>

</html>