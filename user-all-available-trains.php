<!--Server side scripting  code to hold  user session-->
<?php
  session_start();
  include('assets/inc/config.php');
  include('assets/inc/checklogin.php');
  check_login();
  $aid=$_SESSION['user_id'];
?>
<!--End server side code-->
<!DOCTYPE html>
<html lang="en">
  <!--Head-->
    <?php include('assets/inc/head.php');?>
  <!--End Head-->
  <body>
    <div class="be-wrapper be-fixed-sidebar">
    <!--Navbar-->
      <?php include("assets/inc/navbar.php");?>
      <!--End Navbar-->
        <!--Navbar-->
      <?php include('assets/inc/sidebar.php');?>
      <!--End Sidebar-->

      <div class="be-content">
        <div class="page-head">
          <h2 class="page-head-title">Trains</h2>
          <nav aria-label="breadcrumb" role="navigation">
            <ol class="breadcrumb page-head-nav">
              <li class="breadcrumb-item"><a href="user-dashboard.php">Dashboard</a></li>
              <li class="breadcrumb-item"><a href="#">Trains</a></li>
              <li class="breadcrumb-item active">Available Trains</li>
            </ol>
          </nav>
        </div>
        <div class="main-content container-fluid">
          <div class="row">
            <div class="col-lg-12">
              <div class="card card-table">
                <div class="card-header">All Running Trains
                </div>
                <div class="card-body">
                <table class="table table-striped table-bordered table-hover table-fw-widget" id="table1">
                    <thead class="thead-dark">
                      <tr>
                        <th>Train # </th>
                        <th>Train</th>
                        <th>From</th>
                        <th>Time</th>
                        <th>Day</th>
                        <th>To</th>
                        <th>Time</th>
                        <th>Day</th>
                        <th>M</th>
                        <th>T</th>
                        <th>W</th>
                        <th>T</th>
                        <th>F</th>
                        <th>S</th>
                        <th>S</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php

                        $ret="select TRAIN.train_no, TRAIN.train_name,
                        concat(aSTATION.station_name, ' (', aSTATION.station_code, ')') as 'from', time_format(aSTATION.departure_time, '%H:%i') as departure_time, aSTATION.day as departure_day, 
                        concat(dSTATION.station_name, ' (', dSTATION.station_code, ')') as 'to', time_format(dSTATION.arrival_time, '%H:%i') as arrival_time, dSTATION.day as arrival_day,
                        TRAIN.Mon, TRAIN.Tue, TRAIN.Wed, TRAIN.Thu, TRAIN.Fri, TRAIN.Sat, TRAIN.Sun, aSTATION.train_no, dSTATION.train_no
                        from TRAIN, STATION as aSTATION, STATION as dSTATION
                        where dSTATION.train_no = TRAIN.train_no and TRAIN.train_no =  aSTATION.train_no 
                        and dSTATION.departure_time = 0 and aSTATION.arrival_time = 0;";
                        $stmt= $mysqli->prepare($ret) ;
                        $stmt->execute() ;//ok
                        $res=$stmt->get_result();
                        $cnt=1;
                        while($row=$res->fetch_object())
                      {
                      ?>
                          <tr class="odd gradeX even gradeC odd gradeA ">
                            <td><?php echo $row->train_no;?></td>
                            <td><?php echo $row->train_name;?></td>
                            <td><?php echo $row->from?></td>
                            <td><?php echo $row->departure_time;?></td>
                            <td><?php echo $row->departure_day;?></td>
                            <td><?php echo $row->to;?></td>
                            <td><?php echo $row->arrival_time;?></td>
                            <td><?php echo $row->arrival_day;?></td>
                            <td><?php echo $row->Mon == 'Y' ? '✔' : ' '?></td>
                            <td><?php echo $row->Tue == 'Y' ? '✔' : ' '?></td>
                            <td><?php echo $row->Wed == 'Y' ? '✔' : ' '?></td>
                            <td><?php echo $row->Thu == 'Y' ? '✔' : ' '?></td>
                            <td><?php echo $row->Fri == 'Y' ? '✔' : ' '?></td>
                            <td><?php echo $row->Sat == 'Y' ? '✔' : ' '?></td>
                            <td><?php echo $row->Sun == 'Y' ? '✔' : ' '?></td>
                          </tr>

                      <?php $cnt=$cnt+1; }?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            
          </div>
        </div>
      </div>
      <!--Footer-->
      <?php include('assets/inc/footer.php');?>
      <!--End Footer-->
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