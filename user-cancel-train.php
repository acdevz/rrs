<?php
session_start();
include('assets/inc/config.php');
include('assets/inc/checklogin.php');
check_login();
$aid=$_SESSION['user_id'];
?>
<!--End Server side scriptiing-->
<!--Log on to codeastro.com for more projects!-->
<!DOCTYPE html>
<html lang="en">
<!--HeAD-->
  <?php include('assets/inc/head.php');?>
 <!-- end HEAD--> 
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
          <h2 class="page-head-title">Cancel Train</h2>
          <nav aria-label="breadcrumb" role="navigation">
            <ol class="breadcrumb page-head-nav">
              <li class="breadcrumb-item"><a href="pass">Dashboard</a></li>
              <li class="breadcrumb-item"><a href="#">Book Train</a></li>
              <li class="breadcrumb-item active">Cancel Booking</li>
            </ol>
          </nav>
        </div>

        <div class="main-content container-fluid">
          <div class="row">
            <div class="col-sm-12">
              <div class="card card-table">
                <div class="card-header">Cancel Your Booking                 
                </div>
                <div class="card-body">
                <table class="table table-striped table-bordered table-hover" id="table1">
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

                        $ret="select T.train_no, T.train_name, P.name pass_name, 
                        concat(S1.station_name, ' (', S1.station_code, ')') 'from', 
                        time_format(S1.departure_time, '%H:%i') 'time', 
                        concat(S2.station_name, ' (', S2.station_code, ')') 'to', TK.date,
                        TK.status, P.class, TK.fare, TK.ticket_id, P.passenger_id
                        from PASSENGER P, TICKET TK, TRAIN T, STATION S1, STATION S2
                        where TK.username = ?
                        and P.ticket_id = TK.ticket_id 
                        and TK.train_no = T.train_no
                        and S1.train_no = T.train_no and TK.from = S1.station_code
                        and S2.train_no = T.train_no and TK.to = S2.station_code
                        and TK.date >= current_date() and TK.status != 'CNL'
                        order by TK.date ASC;";
                        $stmt= $mysqli->prepare($ret) ;
                        $stmt->bind_param('s',$aid);
                        $stmt->execute() ;//ok
                        $res=$stmt->get_result();
                        $cnt=1;
                        while($row=$res->fetch_object())
                      {
                      ?>
                          <tr class="odd gradeX even gradeC odd gradeA ">
                            <td><?php echo $row->train_no;?></td>
                            <td><?php echo $row->train_name;?></td>
                            <td><?php echo $row->pass_name;?></td>
                            <td><?php echo $row->from?></td>
                            <td><?php echo $row->time?></td>
                            <td><?php echo $row->to;?></td>
                            <td><?php echo $row->date;?></td>
                            <td><span class="font-weight-bold <?php echo substr_count($row->status,"WL") || substr_count($row->status,"CNL") ? 'text-danger' : 'text-success'; ?>"><?php echo $row->status;?></span></td>
                            <td>
                              <a href="user-cancel-specific-train.php?ticket_id=<?php echo $row->ticket_id;?>&train_no=<?php echo $row->train_no;?>&train_name=<?php echo $row->train_name;?>&from=<?php echo $row->from;?>&to=<?php echo $row->to;?>&date=<?php echo $row->date;?>&pass_id=<?php echo $row->passenger_id;?>&fare=<?php echo $row->fare;?>&class=<?php echo $row->class;?>&status=<?php echo $row->status;?>" class="badge badge-danger px-4 py-2">Cancel</a>
                            </td>
                          </tr>
                      <?php $cnt=$cnt+1; }?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
         <!--footer-->
         <?php include('assets/inc/footer.php');?>
         <!--End Footer-->
        </div>
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
        // Remove search box from DataTable
        $('#table1_filter').remove();
      });
    </script>
  </body>

</html>