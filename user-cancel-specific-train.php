<?php
    session_start();
    include('assets/inc/config.php');
    //date_default_timezone_set('Africa /Nairobi');
    include('assets/inc/checklogin.php');
    check_login();
    $aid=$_SESSION['user_id'];

    //Get Cancel Details
    $pass_ticket_id=$_GET['ticket_id'];
    $pass_train_no=$_GET['train_no'];
    $pass_train_name=$_GET['train_name'];
    $pass_from=$_GET['from'];
    $pass_to=$_GET['to'];
    $pass_date=$_GET['date'];
    $pass_id=$_GET['pass_id'];
    $pass_fare=$_GET['fare'];
    $pass_class=$_GET['class'];
    $pass_status=$_GET['status'];

    //Get Passenger Details
    $query="select name, age, gender, pnr_no from PASSENGER where passenger_id = ?";
    $stmt = $mysqli->prepare($query);
    $rc=$stmt->bind_param('i', $pass_id);
    $stmt->execute();
    $res=$stmt->get_result();
    $row=$res->fetch_object();
    //...
    $pass_name = $row->name;
    $pass_age = $row->age;
    $pass_gender = $row->gender;
    $pass_pnr = $row->pnr_no;

    if(isset($_POST['Cancel_Train']))
    {

      //push to CANCEL table
      $query="insert into CANCEL values (?,?,?)";
      $stmt_cancel = $mysqli->prepare($query);
      $rc=$stmt_cancel->bind_param('sii', $aid, $pass_ticket_id, $pass_id);
      $stmt_cancel->execute();

      //update PASSENGER table
      $query="update PASSENGER set class=NULL and seat_no=NULL where passenger_id = ?";
      $stmt_pass = $mysqli->prepare($query);
      $rc=$stmt_pass->bind_param('i', $pass_id);
      $stmt_pass->execute();

      //update TICKET table
      $query="update TICKET set status = 'CNL' where ticket_id = ?";
      $stmt_ticket_status = $mysqli->prepare($query);
      $rc=$stmt_ticket_status->bind_param('i', $pass_ticket_id);
      $stmt_ticket_status->execute();

      //max waitlist number
      $max_waitlist_no = 0;
      //get ticket_id of GNWL1 passenger
      $ticket_id_got_confirmed = 0;
      //map of ticket_id and status
      $passStatusMap = [];

      //update Waitlist for other passengers
      $query="select T.status, T.ticket_id from TICKET T, PASSENGER P where T.ticket_id = P.ticket_id
      and T.train_no = ? and T.date = ? and P.class = ?";
      $stmt_pass_status = $mysqli->prepare($query);
      $rc=$stmt_pass_status->bind_param('sis', $pass_train_no, $pass_date, $pass_class);
      $stmt_pass_status->execute();
      $res=$stmt_pass_status->get_result();

      if(substr_count($pass_status, "CNF"))
      {
        while($row=$res->fetch_object()){
          $get_pass_status = $row->status;

          if(substr_count($get_pass_status, "GNWL")){
            $get_pass_status_no = intval(substr($get_pass_status, 4));

            if($get_pass_status_no > $max_waitlist_no){
              $max_waitlist_no = $get_pass_status_no;
            }
            if($get_pass_status_no == 1){
              $ticket_id_got_confirmed = $row->ticket_id;
              $get_pass_status = 'CNF';
            }else{
              $get_pass_status = 'GNWL'.($get_pass_status_no - 1);
            }
            $passStatusMap[$row->ticket_id] = $get_pass_status;
          }
        }
      }
      else if(substr_count($pass_status, "GNWL"))
      {
        $pass_status_no = intval(substr($pass_status, 4));

        while($row=$res->fetch_object()){
          $get_pass_status = $row->status;

          if(substr_count($get_pass_status, "GNWL")){
            $get_pass_status_no = intval(substr($get_pass_status, 4));

            if($get_pass_status_no > $max_waitlist_no){
              $max_waitlist_no = $get_pass_status_no;
            }

            if($get_pass_status_no > $pass_status_no){
              $get_pass_status = 'GNWL'.($get_pass_status_no - 1);
              $passStatusMap[$row->ticket_id] = $get_pass_status;
            }
          }
        }
      }

      //update status of all passengers
      if($max_waitlist_no != 0){
        $query = "UPDATE TICKET SET status = ? WHERE ticket_id = ?";
        $stmt_pass_status_update = $mysqli->prepare($query);
        foreach($passStatusMap as $key => $value){
          $rc = $stmt_pass_status_update->bind_param('si', $value, $key);
          $stmt_pass_status_update->execute();
        }
      }

      if($ticket_id_got_confirmed != 0){
        //allote seat to CNF passenger
        $pass_seat = "";
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
        $query="update PASSENGER set seat_no = ? where ticket_id = ?;";
        $stmt_seat_update = $mysqli->prepare($query);
        $rc=$stmt_seat_update->bind_param('sii', $pass_seat, $ticket_id_got_confirmed);
        $stmt_seat_update->execute();
      }

      //update TRAIN_STATUS table
      if($max_waitlist_no != 0)
      {
        $train_status = 'GNWL'.($max_waitlist_no - 1);
        if($max_waitlist_no == 1){
          $train_status = 'NO_AVL';
        }
        $query="update TRAIN_STATUS set " . "_" . $pass_class ." = ? where train_no = ? and date = ?";
        $stmt_train_status_update = $mysqli->prepare($query); //prepare sql and bind it later
        $rc=$stmt_train_status_update->bind_param('sis', $train_status, $pass_train_no, $pass_date);
        $stmt_train_status_update->execute();
      }
      else
      {
        $query="select _". $pass_class ." from TRAIN_STATUS where train_no = ? and date = ?";
        $stmt_train_status = $mysqli->prepare($query);
        $rc=$stmt_train_status->bind_param('is', $pass_train_no, $pass_date);
        $stmt_train_status->execute();
        $res=$stmt_train_status->get_result();
        $row=$res->fetch_object();
        $train_status = $row->{"_". $pass_class};

        if(substr_count($train_status,"AVL"))
        {
          $st_no = substr($train_status, 3);
          $train_status = 'AVL'.(intval($st_no) + 1);
        }

        $query="update TRAIN_STATUS set " . "_" . $pass_class ." = ? where train_no = ? and date = ?";
        $stmt_train_status_update = $mysqli->prepare($query); //prepare sql and bind it later
        $rc=$stmt_train_status_update->bind_param('sis', $train_status, $pass_train_no, $pass_date);
        $stmt_train_status_update->execute();
      }
      $pass_status = 'CNL';
      
      if($stmt_cancel && $stmt_pass && $stmt_ticket_status && $stmt_pass_status)
      {
        $succ = "Cancelled Successfully!";
      }
      else
      {
        $err = "Please Try Again Or Try Later";
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
          <h2 class="page-head-title">Cancel My Bookings </h2>
          <nav aria-label="breadcrumb" role="navigation">
            <ol class="breadcrumb page-head-nav">
              <li class="breadcrumb-item"><a href="user-dashboard.php">Dashboard</a></li>
              <li class="breadcrumb-item"><a href="#">Book Train</a></li>
              <li class="breadcrumb-item active">Cancel Train</li>
            </ol>
          </nav>
        </div>
            <?php if(isset($succ)) {?>
                                <!--This code for injecting an alert-->
                <script>
                            setTimeout(function () 
                            { 
                                swal("Success!","<?php echo $succ;?>","success");
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
        <div class="main-content container-fluid">
          <div class="row">
            <div class="col-md-12">

              <div class="card card-border-color card-border-color-danger">

                <div class="card-header card-header-divider">Journey Details</div>
                <div class="card-body">
                  <table class="table table-lg table-borderless custom-table">
                    <tbody>
                      <tr>
                        <th colspan=2 class="text-center h3"><?php echo $pass_train_name .' ('. $pass_train_no .')'; ?></td>
                      </tr>
                      <tr>
                        <th class="text-center h5">From Station</th>
                        <th class="text-center h5">To Station</th>
                      </tr>
                      <tr>
                        <td class="text-center font-weight-bold h4"><?php echo $pass_from;?></td>
                        <td class="text-center font-weight-bold h4"><?php echo $pass_to;?></td>
                      </tr>
                      <tr>
                        <td class="text-center h4">
                          <?php echo $pass_date; ?>
                        </td>
                        <td></td>
                      </tr>
                      <tr>
                        <td class="text-center font-weight-bold h4"><?php echo $pass_class ?> Current <span class="<?php echo substr_count($pass_status,"CNL") || substr_count($pass_status,"WL") ? 'text-danger' : 'text-success'; ?>"><?php echo $pass_status;?></span></td>
                        <td class="text-center h4"> Refund Amount <span class="font-weight-bold">₹<?php echo $pass_fare; ?>/-</span></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>

              <div class="card card-border-color card-border-color-info">
                <div class="card-header card-header-divider">Passenger Details</div>
                <div class="card-body">
                  <div class="col-sm-2 my-5 text-center p-0">
                    <span class="h4"><span class="font-weight-bold ">PNR</span> <?php echo $pass_pnr; ?></span>  
                  </div>
                  <table class="table table-md table-bordered custom-table">
                    <tbody>
                      <tr>
                        <td class="text-center h4">Name </td>
                        <td class="text-left h4 font-weight-bold"><?php echo $pass_name; ?></td>
                        <td class="text-center h4 ">Age</td>
                        <td class="text-left h4 font-weight-bold"><?php echo $pass_age; ?></td>
                        <td class="text-center h4">Gender</td>
                        <td class="text-left h4 font-weight-bold"><?php echo $pass_gender; ?></td>
                      </tr>
                    </tbody>
                  </table>

                  <div class="col-sm-6 mt-5">
                    <form method ="POST">
                      <p class="text-right">
                        <input class="btn btn-space btn-outline-danger" value ="Cancel Train" name = "Cancel_Train" type="submit">
                        <a href="./user-cancel-train.php" class="btn btn-space btn-secondary">Cancel</a>
                      </p>
                    </form>
                  </div>
                </div>
                
              </div>
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