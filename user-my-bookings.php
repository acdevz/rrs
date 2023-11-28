<?php
session_start();
include('assets/inc/config.php');
include('assets/inc/checklogin.php');
check_login();
$aid=$_SESSION['user_id'];
?>
<!--End Server side scriptiing-->
<!DOCTYPE html>
<html lang="en">
<!--HeAD-->
  <?php include('assets/inc/head.php');?>
 <!-- end HEAD--> 
 <!--Log on to codeastro.com for more projects!-->
  <body>
    <div class="be-wrapper be-fixed-sidebar">
    <!--navbar-->
      <?php include('assets/inc/navbar.php');?>
      <!--End navbar-->
      <!--Sidebar-->
      <?php include('assets/inc/sidebar.php');?>
      <!--End Sidebar-->

      <div class="be-content">
      <div class="page-head">
          <h2 class="page-head-title ">My Bookings</h2>
          <nav aria-label="breadcrumb" role="navigation">
            <ol class="breadcrumb page-head-nav">
              <li class="breadcrumb-item"><a href="user-dashboard.php">Dashboard</a></li>
              <li class="breadcrumb-item active">My Bookings</li>
            </ol>
          </nav>
        </div>

        <div class="main-content container-fluid">
        <div class="row">
          <div class="col-sm-12">
            <div class="card card-table">
              <div class="card-header card-header-divider">Upcoming</div>
              <div class="card-body">
                <!--Start Table-->
                <table class="table table-striped table-bordered table-hover table-fw-widget" id="table1">
                  <thead class="thead-dark">
                    <tr>
                      <th>Train #</th>
                      <th>Train</th>
                      <th>Passenger Name</th>
                      <th>From</th>
                      <th>Time</th>
                      <th>To</th>
                      <th>Date</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php

                    $ret="select T.train_no, T.train_name, P.name passenger_name, 
                        concat(S1.station_name, ' (', S1.station_code, ')') 'from', 
                        time_format(S1.departure_time, '%H:%i') 'time',
                        concat(S2.station_name, ' (', S2.station_code, ')') 'to',
                        TK.date, TK.status, TK.ticket_id, TK.from 'from_code', TK.to 'to_code'
                        from PASSENGER P, TICKET TK, TRAIN T, STATION S1, STATION S2
                        where TK.username = ?
                        and P.ticket_id = TK.ticket_id 
                        and TK.train_no = T.train_no
                        and S1.train_no = T.train_no and TK.from = S1.station_code
                        and S2.train_no = T.train_no and TK.to = S2.station_code
                        and TK.date >= current_date() and TK.status != 'CNL';";
                    $stmt = $mysqli->prepare($ret);
                    $stmt->bind_param('s', $aid);
                    $stmt->execute(); //ok
                    $res = $stmt->get_result();
                    while ($row = $res->fetch_object()) {
                    ?>
                      <tr class="odd gradeX even gradeC odd gradeA ">
                        <td><?php echo $row->train_no; ?></td>
                        <td><?php echo $row->train_name; ?></td>
                        <td><?php echo $row->passenger_name; ?></td>
                        <td><?php echo $row->from ?></td>
                        <td><?php echo $row->time ?></td>
                        <td><?php echo $row->to; ?></td>
                        <td><?php echo $row->date; ?></td>
                        <td class="text-center font-weight-bold"><span class="<?php echo substr_count($row->status,"WL") ? 'text-danger' : 'text-success'; ?>"><?php echo $row->status;?></span></td>
                        <td>
                          <a href="user-print-ticket.php?ticket_id=<?php echo $row->ticket_id;?>&train_no=<?php echo $row->train_no;?>&from=<?php echo $row->from_code;?>&to=<?php echo $row->to_code;?>">
                            <button class="btn btn-info btn-md"><i class="fa fa-view"></i> View</button>
                          </a>
                        </td>
                      </tr>
                    <?php
                    } ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-sm-12">
            <div class="card card-table">
              <div class="card-header card-header-divider">Completed</div>
              <div class="card-body">
                <!--Start Table-->
                <table class="table table-striped table-bordered table-hover table-fw-widget" id="table2">
                  <thead class="thead-dark">
                    <tr>
                      <th>Train #</th>
                      <th>Train</th>
                      <th>Passenger Name</th>
                      <th>From</th>
                      <th>Time</th>
                      <th>To</th>
                      <th>Date</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php

                    $ret="select T.train_no, T.train_name, P.name passenger_name,
                        concat(S1.station_name, ' (', S1.station_code, ')') 'from', 
                        time_format(S1.departure_time, '%H:%i') 'time', 
                        concat(S2.station_name, ' (', S2.station_code, ')') 'to',
                        TK.date, TK.status, TK.ticket_id, TK.from 'from_code', TK.to 'to_code'
                        from PASSENGER P, TICKET TK, TRAIN T, STATION S1, STATION S2
                        where TK.username = ?
                        and P.ticket_id = TK.ticket_id 
                        and TK.train_no = T.train_no
                        and S1.train_no = T.train_no and TK.from = S1.station_code
                        and S2.train_no = T.train_no and TK.to = S2.station_code
                        and TK.date < current_date() and TK.status != 'CNL';";
                    $stmt = $mysqli->prepare($ret);
                    $stmt->bind_param('s', $aid);
                    $stmt->execute(); //ok
                    $res = $stmt->get_result();
                    while ($row = $res->fetch_object()) {
                    ?>
                      <tr class="odd gradeX even gradeC odd gradeA ">
                        <td><?php echo $row->train_no; ?></td>
                        <td><?php echo $row->train_name; ?></td>
                        <td><?php echo $row->passenger_name; ?></td>
                        <td><?php echo $row->from ?></td>
                        <td><?php echo $row->time ?></td>
                        <td><?php echo $row->to; ?></td>
                        <td><?php echo $row->date; ?></td>
                        <td>
                        </td>
                      </tr>
                    <?php
                    } ?>
                  </tbody>
                </table>
                <!--End Table-->
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-sm-12">
            <div class="card card-table">
              <div class="card-header card-header-divider">Cancelled</div>
              <div class="card-body">
                <!--Start Table-->
                <table class="table table-striped table-bordered table-hover table-fw-widget" id="table3">
                  <thead class="thead-dark">
                    <tr>
                      <th>Train #</th>
                      <th>Train</th>
                      <th>Passenger Name</th>
                      <th>From</th>
                      <th>Time</th>
                      <th>To</th>
                      <th>Date</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php

                    $ret="select T.train_no, T.train_name, P.name passenger_name,
                        concat(S1.station_name, ' (', S1.station_code, ')') 'from', 
                        time_format(S1.departure_time, '%H:%i') 'time', 
                        concat(S2.station_name, ' (', S2.station_code, ')') 'to',
                        TK.date, TK.status, TK.ticket_id, TK.from 'from_code', TK.to 'to_code'
                        from PASSENGER P, TICKET TK, TRAIN T, STATION S1, STATION S2
                        where TK.username = ?
                        and P.ticket_id = TK.ticket_id 
                        and TK.train_no = T.train_no
                        and S1.train_no = T.train_no and TK.from = S1.station_code
                        and S2.train_no = T.train_no and TK.to = S2.station_code
                        and TK.status = 'CNL';";
                    $stmt = $mysqli->prepare($ret);
                    $stmt->bind_param('s', $aid);
                    $stmt->execute(); //ok
                    $res = $stmt->get_result();
                    while ($row = $res->fetch_object()) {
                    ?>
                      <tr class="odd gradeX even gradeC odd gradeA ">
                        <td><?php echo $row->train_no; ?></td>
                        <td><?php echo $row->train_name; ?></td>
                        <td><?php echo $row->passenger_name; ?></td>
                        <td><?php echo $row->from ?></td>
                        <td><?php echo $row->time ?></td>
                        <td><?php echo $row->to; ?></td>
                        <td><?php echo $row->date; ?></td>
                        <td>
                        </td>
                      </tr>
                    <?php
                    } ?>
                  </tbody>
                </table>
                <!--End Table-->
              </div>
            </div>
          </div>
        </div>
         
        </div>
        <!--footer-->
        <?php include('assets/inc/footer.php');?>
        <!--End Footer-->
        </div>
     
    </div>
    <script src="assets/lib/jquery/jquery.min.js" type="text/javascript"></script>
    <script src="assets/lib/perfect-scrollbar/js/perfect-scrollbar.min.js" type="text/javascript"></script>
    <script src="assets/lib/bootstrap/dist/js/bootstrap.bundle.min.js" type="text/javascript"></script>
    <script src="assets/js/app.js" type="text/javascript"></script>
    <script src="assets/lib/datatables/datatables.net/js/jquery.dataTables.js" type="text/javascript"></script>
    <script src="assets/lib/datatables/datatables.net-bs4/js/dataTables.bootstrap4.js" type="text/javascript"></script>
    <script src="assets/lib/datatables/datatables.net-buttons/js/dataTables.buttons.min.js" type="text/javascript"></script>
    <script src="assets/lib/datatables/datatables.net-buttons/js/buttons.flash.min.js" type="text/javascript"></script>
    <script src="assets/lib/datatables/jszip/jszip.min.js" type="text/javascript"></script>
    <script src="assets/lib/datatables/pdfmake/pdfmake.min.js" type="text/javascript"></script>
    <script src="assets/lib/datatables/pdfmake/vfs_fonts.js" type="text/javascript"></script>
    <script src="assets/lib/datatables/datatables.net-buttons/js/buttons.colVis.min.js" type="text/javascript"></script>
    <script src="assets/lib/datatables/datatables.net-buttons/js/buttons.print.min.js" type="text/javascript"></script>
    <script src="assets/lib/datatables/datatables.net-buttons/js/buttons.html5.min.js" type="text/javascript"></script>
    <script src="assets/lib/datatables/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js" type="text/javascript"></script>
    <script src="assets/lib/datatables/datatables.net-responsive/js/dataTables.responsive.min.js" type="text/javascript"></script>
    <script src="assets/lib/datatables/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js" type="text/javascript"></script>
    <script type="text/javascript">
      $(document).ready(function(){
      	//-initialize the javascript
      	App.init();
      	App.dataTables();
      });
    </script>
  </body>

</html>