<?php
  session_start();
  include('assets/inc/config.php');
  include('assets/inc/checklogin.php');
  check_login();
  $aid=$_SESSION['user_id'];

  //get details
  $pass_ticket_id=$_GET['ticket_id'];
  $pass_train_no=$_GET['train_no'];
  $pass_from=$_GET['from'];
  $pass_to=$_GET['to'];

  //fetch additional details
  $query="select P.name, P.age, P.gender, P.pnr_no, 
  P.class, P.seat_no, TK.status, TK.fare, T.train_name,
  (S2.dist - S1.dist) 'distance', S1.station_name 'from_name', S2.station_name 'to_name',
  time_format(S1.departure_time, '%H:%i') 'from_time', time_format(S2.arrival_time, '%H:%i') 'to_time',
  date_add(TS.date, interval (S1.day - 1) day) as 'from_date',
  date_add(TS.date, interval (S2.day - 1) day) as 'to_date'
  from TICKET TK, PASSENGER P, TRAIN T, STATION S1, STATION S2, TRAIN_STATUS TS
  where TK.ticket_id = ? and S1.station_code = ? and S2.station_code = ?
  and TK.ticket_id = P.ticket_id
  and T.train_no = TK.train_no and TS.train_no = TK.train_no";
  $stmt = $mysqli->prepare($query);
  $rc=$stmt->bind_param('iss', $pass_ticket_id, $pass_from, $pass_to);
  $stmt->execute();
  $res=$stmt->get_result();
  $row=$res->fetch_object();
  //...
  $pass_name = $row->name;
  $pass_age = $row->age;
  $pass_gender = $row->gender;
  $pass_pnr = $row->pnr_no;
  $pass_class = $row->class;
  $pass_seat_no = $row->seat_no;
  $pass_status = $row->status;
  $pass_fare = $row->fare;
  $pass_train_name = $row->train_name;
  $pass_from_name = $row->from_name;
  $pass_to_name = $row->to_name;
  $pass_from_time = $row->from_time;
  $pass_to_time = $row->to_time;
  $pass_from_date = $row->from_date;
  $pass_to_date = $row->to_date;
  $pass_distance = $row->distance;

  //get logged in user details
  $query="select first_name, last_name, email, mobile_no 
  from USER where username = ?";
  $stmt = $mysqli->prepare($query);
  $rc=$stmt->bind_param('s', $aid);
  $stmt->execute();
  $res=$stmt->get_result();
  $row=$res->fetch_object();
  //...
  $user_name = $row->first_name.' '.$row->last_name;
  $user_email = $row->email;
  $user_phone = $row->mobile_no;
?>
<!DOCTYPE html>
<html lang="en">
  <!--Head-->
    <?php include('assets/inc/head.php');?>
  <!--End Head-->
  <body>
    <div class="be-wrapper be-fixed-sidebar">
    <!--Nav Bar-->
      <?php include('assets/inc/navbar.php');?>
      <!--End Navbar-->
      <!--Sidebar-->
        <?php include('assets/inc/sidebar.php');?>
      <!--End Sidebar-->
      <div class="be-content">
        <div class="page-head">
          <h2 class="page-head-title">My Ticket</h2>
          <nav aria-label="breadcrumb" role="navigation">
            <ol class="breadcrumb page-head-nav">
              <li class="breadcrumb-item"><a href="#">Dashbaord</a></li>
              <li class="breadcrumb-item"><a href="#">Tickets</a></li>
              <li class="breadcrumb-item active">Print</li>
            </ol>
          </nav>
        </div>
        <div class="main-content container-fluid">
          <div class="row">
            <div class="col-lg-12">

              <div id='printReceipt' class="invoice">
                <div class="row invoice-header">
                  <div class="col-sm-7">
                    <div class="invoice-logo"></div>
                  </div>
                  <div class="col-sm-5 invoice-order"><span class="invoice-id">Train Ticket</span><span class="incoice-date">Booked by <?php echo $aid;?></span></div>
                </div>
                <div class="row invoice-data">
                  <div class="col-sm-5 invoice-person text-left">
                    <span class="h3 font-weight-bold text-dark">PNR <?php echo $pass_pnr;?></span>
                  </div>
                  <div class="col-sm-7 invoice-person"><span class="name"><span><?php echo $user_email;?></span><span><?php echo $user_phone;?></span></div>
                </div>

                <div class="row">
                  <div class="col-md-12">

                    <div class="card card-border-color card-border-color-warning">
                      <div class="card-header card-header-divider">Journey Details</div>
                      <div class="card-body">
                        <table class="table table-lg table-borderless custom-table">
                          <tbody>
                            <tr>
                              <th colspan=2 class="text-center h3"><span class="font-weight-bold"><?php echo $pass_train_name;?></span><?php echo ' (' . $pass_train_no. ')' ; ?></td>
                            </tr>
                            <tr>
                              <th class="text-center h4">FROM</th>
                              <th class="text-center h4">TO</th>
                            </tr>
                            <tr>
                              <td class="text-center h3"><?php echo $pass_from_name .' ('. $pass_from .')';?></td>
                              <td class="text-center h3"><?php echo $pass_to_name .' ('. $pass_to .')';?></td>
                            </tr>
                            <tr>
                              <td class="text-center h5 font-weight-bold"><?php echo $pass_from_date; ?></td>
                              <td class="text-center h5 font-weight-bold"><?php echo $pass_to_date; ?></td>
                            </tr>
                            <tr>
                              <td class="text-center h5 font-weight-bold"><?php echo $pass_from_time; ?></td>
                              <td class="text-center h5 font-weight-bold"><?php echo $pass_to_time; ?></td>
                            </tr>
                            <tr>
                              <td colspan=2></td>
                            </tr>
                            <tr>
                              <td class="text-center font-weight-bold h4"><?php echo $pass_class ?> <span class="<?php echo substr_count($pass_status,"WL") ? 'text-danger' : 'text-success'; ?>"><?php echo $pass_status;?></span> <?php echo $pass_seat_no;?></td>
                              <td class="text-center h4">Amount <span class="font-weight-bold">₹<?php echo $pass_fare; ?>/-</span> ✅</td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>


                    <div class="card card-border-color card-border-color-info">
                      <div class="card-header">Passenger Details</div>
                      <div class="card-body">
                        <table class="table table-md table-bordered custom-table">
                          <tbody>
                            <tr>
                              <td class="text-center h4">Name </td>
                              <td class="text-left h4"><?php echo $pass_name; ?></td>
                              <td class="text-center h4">Age</td>
                              <td class="text-left h4"><?php echo $pass_age; ?></td>
                              <td class="text-center h4">Gender</td>
                              <td class="text-left h4"><?php echo $pass_gender; ?></td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>

                  </div>
              </div>

              </div>
              <hr>
              <div class="row invoice-footer">
                  <div class="col-lg-12">
                    <button id="print" onclick="printContent('printReceipt');" class="btn btn-lg btn-space btn-primary">Print</button>
                  </div>
                </div>
            </div>
          </div>
        </div>

    <!--footer-->
    <?php include('assets/inc/footer.php');?>
    <!--end footer-->
      </div>
      
    </div>
    <script src="assets/lib/jquery/jquery.min.js" type="text/javascript"></script>
    <script src="assets/lib/perfect-scrollbar/js/perfect-scrollbar.min.js" type="text/javascript"></script>
    <script src="assets/lib/bootstrap/dist/js/bootstrap.bundle.min.js" type="text/javascript"></script>
    <script src="assets/js/app.js" type="text/javascript"></script>
    <script type="text/javascript">
      $(document).ready(function(){
      	//-initialize the javascript
      	App.init();
      });
      
    </script>
    <!--print train ticket js-->
    <script>
      function printContent(el){
        var restorepage = $('body').html();
        var printcontent = $('#' + el).clone();
        $('body').empty().html(printcontent);
        window.print();
        $('body').html(restorepage);
        }
     </script>
  </body>

</html>