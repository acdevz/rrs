<!--Server side code to handle passenger sign up-->
<?php
	session_start();
	include('assets/inc/config.php');
		if(isset($_POST['user_register']))
		{
			$user_fname=$_POST['user_fname'];
			#$mname=$_POST['mname'];
			$user_lname=$_POST['user_lname'];
			$user_phone=$_POST['user_phone'];
			$user_addr=$_POST['user_addr'];
			$user_uname=$_POST['user_uname'];
			$user_email=$_POST['user_email'];
			$user_pwd=sha1(md5($_POST['user_pwd']));
      //sql to insert captured values
			$query="insert into USER (username, first_name, last_name, email, mobile_no, country, password) values(?,?,?,?,?,?,?)";
			$stmt = $mysqli->prepare($query);
			$rc=$stmt->bind_param('sssssss', $user_uname, $user_fname, $user_lname, $user_email, $user_phone, $user_addr, $user_pwd);
			$stmt->execute();
			/*
			*Use Sweet Alerts Instead Of This Fucked Up Javascript Alerts
			*echo"<script>alert('Successfully Created Account Proceed To Log In ');</script>";
			*/ 
			//declare a varible which will be passed to alert function
			if($stmt)
			{
				$success = "Registered Successfully! Proceed To Log In";
			}
			else {
				$err = "Please Try Again Or Try Later!";
			}
		}
?>
<!--End Server Side-->
<!DOCTYPE html>
<html lang="en">
  
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="assets/img/favicon.ico">
    <title>Online Railway Reservation System</title>
    <link rel="stylesheet" type="text/css" href="assets/lib/perfect-scrollbar/css/perfect-scrollbar.css"/>
    <link rel="stylesheet" type="text/css" href="assets/lib/material-design-icons/css/material-design-iconic-font.min.css"/>
    <link rel="stylesheet" href="assets/css/app.css" type="text/css"/>
  </head>
  <body class="be-splash-screen">
    <div class="be-wrapper be-login">
      <div class="be-content">
        <div class="main-content container-fluid">
          <div class="splash-container">
            <div class="card card-border-color card-border-color-success">
              <div class="card-header"><img class="logo-img" src="assets/img/logo-xx.png" alt="logo" width="{conf.logoWidth}" height="27"><span class="splash-description">Passenger Registration Form</span></div>
              <div class="card-body">
            
              <?php if(isset($success)) {?>
							<!--This code for injecting an alert-->
									<script>
												setTimeout(function () 
												{ 
													swal("Success!","<?php echo $success;?>","success");
												},
													100);
									</script>
					
							<?php } ?>
							<?php if(isset($err)) {?>
							<!--This code for injecting an alert-->
									<script>
												setTimeout(function () 
												{ 
													swal("Failed!","<?php echo $err;?>","Failed");
												},
													100);
									</script>
					
							<?php } ?>

              <!--Login Form-->
                <form method ="POST">
                  <div class="login-form">

                    <div class="form-group">
                      <input class="form-control" name="user_uname" type="text" placeholder="Enter Your Username" autocomplete="on" required>
                    </div>
                    <div class="form-group">
                      <input class="form-control" name="user_fname" type="text" placeholder="Enter Your First Name" autocomplete="on" required>
                    </div>
                    <div class="form-group">
                      <input class="form-control" name="user_lname" type="text" placeholder="Enter Your Last Name" autocomplete="on">
                    </div>
                    <div class="form-group">
                      <input class="form-control" name="user_email" type="email" placeholder="Enter Your Email Address" autocomplete="on" required>
                    </div>
                    <div class="form-group">
                      <input class="form-control" name="user_phone" type="text" placeholder="Enter Your Phone Number" autocomplete="on" required>
                    </div>
                    <div class="form-group">
                      <select class="form-control" name="user_addr" required>
                        <option value="">Enter Your Country</option>
                        <option value="IN">India</option>
                        <option value="OIN">Outside India</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <input class="form-control" name="user_pwd" type="password" placeholder="Password" required>
                    </div>
                    <div class="form-group row login-submit">
                      <div class="col-6"><a class="btn btn-outline-danger btn-xl" href="user-login.php">Cancel</a></div>
                      <div class="col-6"><input type = "submit" name ="user_register" class="btn btn-success btn-xl" value ="Register"></div>
                    </div>

                  </div>
                </form>
                <!--End Login-->
              </div>
            </div>
            
          </div>
        </div>
      </div>
    </div>
    <script src="assets/lib/jquery/jquery.min.js" type="text/javascript"></script>
    <script src="assets/lib/perfect-scrollbar/js/perfect-scrollbar.min.js" type="text/javascript"></script>
    <script src="assets/lib/bootstrap/dist/js/bootstrap.bundle.min.js" type="text/javascript"></script>
    <script src="assets/js/app.js" type="text/javascript"></script>
    <script src="assets/js/swal.js"></script>
    <script type="text/javascript">
      $(document).ready(function(){
      	//-initialize the javascript
      	App.init();
      });
      
    </script>
  </body>

</html>