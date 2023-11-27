<?php
session_start();
include('assets/inc/config.php');
include('assets/inc/checklogin.php');
check_login();
$aid = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html lang="en">
<!--Head-->
<?php include("assets/inc/head.php"); ?>
<!--End Head-->

<body>

  <div class="be-wrapper be-fixed-sidebar">

    <!--Navbar-->
    <?php include("assets/inc/navbar.php"); ?>
    <!--End Nav Bar-->

    <!--Sidebar-->
    <?php include('assets/inc/sidebar.php'); ?>
    <!--End Sidebar-->
    <div class="be-content">
      <div class="main-content container-fluid">
        <div class="row">

          <div class="col-12 col-lg-6 col-xl-4">
            <a href="user-my-bookings.php">
              <div class="widget widget-tile">
                <div class="chart sparkline"><i class="material-icons">add_shopping_cart</i></div>
                <div class="data-info">
                  <div class="desc">My Bookings</div>
                </div>
              </div>
            </a>
          </div>

          <div class="col-12 col-lg-6 col-xl-4">
            <a href="user-cancel-train.php">
              <div class="widget widget-tile">
                <div class="chart sparkline"><i class="material-icons">backspace</i></div>
                <div class="data-info">
                  <div class="desc">Cancel Ticket</div>
                </div>
              </div>
            </a>
          </div>

          <div class="col-12 col-lg-6 col-xl-4">
            <a href="user-train-schedule.php">
              <div class="widget widget-tile">
                <div class="chart sparkline"><i class="material-icons">burst_mode</i></div>
                <div class="data-info">
                  <div class="desc">Train Schedule</div>
                </div>
              </div>
            </a>
          </div>

        </div>
        <div class="row">
          <div class="col-sm-12">
            <div class="card card-table">
              <div class="card-header my-2">Upcoming Journey</div>
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
                    </tr>
                  </thead>
                  <tbody>
                    <?php

                    $ret = "select T.train_no, T.train_name, P.name passenger_name, 
                        concat(S1.station_name, ' (', S1.station_code, ')') 'from', 
                        time_format(S1.departure_time, '%H:%i') 'time',
                        concat(S2.station_name, ' (', S2.station_code, ')') 'to', TK.date
                        from PASSENGER P, TICKET TK, TRAIN T, STATION S1, STATION S2
                        where TK.username = ?
                        and P.ticket_id = TK.ticket_id 
                        and TK.train_no = T.train_no
                        and S1.train_no = T.train_no and TK.from = S1.station_code
                        and S2.train_no = T.train_no and TK.to = S2.station_code
                        and TK.date >= current_date();";
                    $stmt = $mysqli->prepare($ret);
                    $stmt->bind_param('s', $aid);
                    $stmt->execute(); //ok
                    $res = $stmt->get_result();
                    $cnt = 1;
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
                      </tr>

                    <?php $cnt = $cnt + 1;
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
              <div class="card-header my-2">Past Journey</div>
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
                    </tr>
                  </thead>
                  <tbody>
                    <?php

                    $ret = "select T.train_no, T.train_name, P.name passenger_name,
                        concat(S1.station_name, ' (', S1.station_code, ')') 'from', 
                        time_format(S1.departure_time, '%H:%i') 'time', 
                        concat(S2.station_name, ' (', S2.station_code, ')') 'to', TK.date
                        from PASSENGER P, TICKET TK, TRAIN T, STATION S1, STATION S2
                        where TK.username = ?
                        and P.ticket_id = TK.ticket_id 
                        and TK.train_no = T.train_no
                        and S1.train_no = T.train_no and TK.from = S1.station_code
                        and S2.train_no = T.train_no and TK.to = S2.station_code
                        and TK.date < current_date();";
                    $stmt = $mysqli->prepare($ret);
                    $stmt->bind_param('s', $aid);
                    $stmt->execute(); //ok
                    $res = $stmt->get_result();
                    $cnt = 1;
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
                      </tr>

                    <?php $cnt = $cnt + 1;
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
      <?php include('assets/inc/footer.php'); ?>
      <!--EndFooter-->
    </div>

  </div>

  <script src="assets/lib/jquery/jquery.min.js" type="text/javascript"></script>
  <script src="assets/lib/perfect-scrollbar/js/perfect-scrollbar.min.js" type="text/javascript"></script>
  <script src="assets/lib/bootstrap/dist/js/bootstrap.bundle.min.js" type="text/javascript"></script>
  <script src="assets/js/app.js" type="text/javascript"></script>
  <script src="assets/lib/jquery-flot/jquery.flot.js" type="text/javascript"></script>
  <script src="assets/lib/jquery-flot/jquery.flot.pie.js" type="text/javascript"></script>
  <script src="assets/lib/jquery-flot/jquery.flot.time.js" type="text/javascript"></script>
  <script src="assets/lib/jquery-flot/jquery.flot.resize.js" type="text/javascript"></script>
  <script src="assets/lib/jquery-flot/plugins/jquery.flot.orderBars.js" type="text/javascript"></script>
  <script src="assets/lib/jquery-flot/plugins/curvedLines.js" type="text/javascript"></script>
  <script src="assets/lib/jquery-flot/plugins/jquery.flot.tooltip.js" type="text/javascript"></script>
  <script src="assets/lib/jquery.sparkline/jquery.sparkline.min.js" type="text/javascript"></script>
  <script src="assets/lib/countup/countUp.min.js" type="text/javascript"></script>
  <script src="assets/lib/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
  <script src="assets/lib/jqvmap/jquery.vmap.min.js" type="text/javascript"></script>
  <script src="assets/lib/jqvmap/maps/jquery.vmap.world.js" type="text/javascript"></script>
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
    $(document).ready(function() {
      //-initialize the javascript
      App.init();
      App.dataTables();
    });
  </script>
</body>

</html>