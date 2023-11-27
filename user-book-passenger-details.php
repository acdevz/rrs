<?php
    session_start();
    include('assets/inc/config.php');
    include('assets/inc/checklogin.php');
    check_login();
    $aid=$_SESSION['user_id'];

    //Get Train Details
    $pass_train_no=$_GET['train_no'];
    $pass_train_name=$_GET['train_name'];
    $pass_from=$_GET['from'];
    $pass_from_name=$_GET['from_name'];
    $pass_from_date=$_GET['from_date'];
    $pass_from_time=$_GET['from_time'];
    $pass_to=$_GET['to'];
    $pass_to_name=$_GET['to_name'];
    $pass_to_date=$_GET['to_date'];
    $pass_to_time=$_GET['to_time'];
    $pass_class=$_GET['class'];
    $pass_status=$_GET['status'];
    $pass_fare=$_GET['fare'];

    if(isset($_POST['Book_Train']))
    {
  
      $pass_name=$_POST['pass_name'];
      $pass_gender=$_POST['pass_gender'];
      $pass_age=$_POST['pass_age'];

      // create ticket number
      $ticket_id = rand(100000,999999);

      //update pass_status
      // get integer part of 'GNWLxx' and increment by 1
      // get integer part of 'AVLxx' and decrement by 1

      $train_status = $pass_status;
      if(substr_count($train_status,"GNWL"))
      {
        $st_no = substr($train_status, 4);
        $train_status = 'GNWL'.(intval($st_no) + 1);
        $pass_status = $train_status;
      }
      else if(substr_count($train_status,"AVL"))
      {
        $st_no = substr($train_status, 3);
        if(intval($st_no) == 1){
          $train_status = 'GNWL0';
        }
        else{
          $train_status = 'AVL'.(intval($st_no) - 1);
        }
        $pass_status = 'CNF';
      }
      //.............

      //generate seat number
      $pass_seat = '';
      if($pass_status == "CNF"){
        if($pass_class == "3A")
        {
          $pass_seat = 'B'.rand(1,3).'/'.rand(1,72);
        }
        else if($pass_class == "2A")
        {
          $pass_seat = 'A'.rand(1,3).'/'.rand(1,36);
        }
        else if($pass_class == "1A")
        {
          $pass_seat = 'F'.rand(1,2).'/'.rand(1,18);
        }
        else if($pass_class == "SL")
        {
          $pass_seat = 'S'.rand(1,5).'/'.rand(1,72);
        }
      }
      
      $query="insert into TICKET values(?,?,?, 1,?,?,?,?,?)";
      $stmt_ticket = $mysqli->prepare($query); //prepare sql and bind it later
      $rc=$stmt_ticket->bind_param('ississsd', $ticket_id, $aid, $pass_status, $pass_train_no, $pass_from, $pass_to, $pass_from_date, $pass_fare);
      $stmt_ticket->execute();

      //generate pnr
      $pass_pnr = rand(100,999).'-'.rand(1000000,9999999);

      $query="insert into PASSENGER(pnr_no, name, age, gender, username, class, seat_no, ticket_id) values(?,?,?,?,?,?,?,?)";
      $stmt_pass = $mysqli->prepare($query); //prepare sql and bind it later
      $rc=$stmt_pass->bind_param('ssissssi', $pass_pnr, $pass_name, $pass_age, $pass_gender, $aid, $pass_class, $pass_seat, $ticket_id);
      $stmt_pass->execute();

      //update train status
      $query="update TRAIN_STATUS set " . "_" . $pass_class ." = ? where train_no = ? and date = ?";
      $stmt_status = $mysqli->prepare($query); //prepare sql and bind it later
      $rc=$stmt_status->bind_param('sis', $train_status, $pass_train_no, $pass_from_date);
      $stmt_status->execute();

      if($stmt_pass && $stmt_ticket && $stmt_status)
      {
          $succ = "Please Wait! Redirecting...";
      }
      else 
      {
          $err = "Please Try Again Later.";
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
          <h2 class="page-head-title">Book Train </h2>
          <nav aria-label="breadcrumb" role="navigation">
            <ol class="breadcrumb page-head-nav">
              <li class="breadcrumb-item"><a href="user-dashboard.php">Dashboard</a></li>
              <li class="breadcrumb-item"><a href="#">Book Train</a></li>
              <li class="breadcrumb-item active">Passenger Details</li>
            </ol>
          </nav>
        </div>
            <?php if(isset($succ)) {?>
                                <!--This code for injecting an alert-->
                <script>
                            swal("Success!","<?php echo $succ;?>","success");
                            setTimeout(function () 
                            { 
                                window.location.href="./user-print-ticket.php?ticket_id=<?php echo $ticket_id;?>&train_no=<?php echo $pass_train_no;?>&from=<?php echo $pass_from;?>&to=<?php echo $pass_to;?>";
                            },
                                1000);
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

        <div class="main-content container-fluid">
          <div class="row">
            <div class="col-md-12">

              <div class="card card-border-color card-border-color-warning">
                <div class="card-header card-header-divider">Journey Details</div>
                <div class="card-body">
                  <table class="table table-lg table-borderless custom-table">
                    <tbody>
                      <tr>
                        <th colspan=2 class="text-center font-weight-bold h4"><?php echo $pass_train_name .' ('. $pass_train_no .')'; ?></td>
                      </tr>
                      <tr>
                        <th class="text-center h5">From Station</th>
                        <th class="text-center h5">To Station</th>
                      </tr>
                      <tr>
                        <td class="text-center font-weight-bold h4"><?php echo $pass_from_name .' ('. $pass_from .')';?></td>
                        <td class="text-center font-weight-bold h4"><?php echo $pass_to_name .' ('. $pass_to .')';?></td>
                      </tr>
                      <tr>
                        <td class="text-center font-weight-bold h5"><?php echo $pass_from_date; ?></td>
                        <td class="text-center h5"><?php echo $pass_to_date; ?></td>
                      </tr>
                      <tr>
                        <td class="text-center font-weight-bold h5"><?php echo $pass_from_time; ?></td>
                        <td class="text-center h5"><?php echo $pass_to_time; ?></td>
                      </tr>
                      <tr>
                        <td colspan=2></td>
                      </tr>
                      <tr>
                        <td class="text-center font-weight-bold h4"><?php echo $pass_class ?> Current <span class="<?php echo substr_count($pass_status,"WL") ? 'text-danger' : 'text-success'; ?>"><?php echo $pass_status;?></span></td>
                        <td class="text-center h4"> Total Fare  <span class="font-weight-bold">₹<?php echo $pass_fare; ?>/-</span></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>


              <div class="card card-border-color card-border-color-success">
                <div class="card-header">Passenger Details</div>
                <div class="card-body">
                  <form method ="POST">
                    <div class="form-group row">
                      <label class="col-12 col-sm-3 col-form-label text-md-right" for="inputText3"> <span class="h4">Passenger Name</span></label>
                      <div class="col-12 col-sm-8 col-lg-6">
                        <input class="form-control" name="pass_name" value="" id="inputText3" type="text" required>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-12 col-sm-3 col-form-label text-md-right" for="inputText3"> <span class="h4">Age</span></label>
                      <div class="col-12 col-sm-8 col-lg-6">
                        <input class="form-control" name="pass_age" value="" id="inputText3" type="number" required>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-12 col-sm-3 col-form-label text-md-right" for="inputText3"> <span class="h4">Gender</span></label>
                      <div class="col-12 col-sm-8 col-lg-6">
                        <select class="form-control" name="pass_gender" id="inputText3">
                          <option value=''></option>
                          <option value='M'>M</option>
                          <option value='F'>F</option>
                        </select>
                      </div>
                    </div>
                    
                    <!--End TRain  isntance-->

                    <div class="col-sm-6">
                        <p class="text-right">
                          <input class="btn btn-space btn-outline-success" value ="Book Train" name = "Book_Train" type="submit">
                          <a href="./user-book-train.php" class="btn btn-space btn-outline-danger">Cancel</a>
                        </p>
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