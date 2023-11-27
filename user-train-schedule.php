<?php
  session_start();
  include('assets/inc/config.php');
  include('assets/inc/checklogin.php');
  check_login();
  $aid=$_SESSION['user_id'];
  // Process form submission
  $train_no = 0;
  if(isset($_POST['Search_Train'])) {
    $train_name = $_POST['train_name'];
    $train_no = intval(substr($train_name, 0, 5));
    $train_name = substr($train_name, 6);
  }
?>
<!--End Server side scriptiing-->
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
          <h2 class="page-head-title">Train Schedule</h2>
          <nav aria-label="breadcrumb" role="navigation">
            <ol class="breadcrumb page-head-nav">
              <li class="breadcrumb-item"><a href="pass">Dashboard</a></li>
              <li class="breadcrumb-item"><a href="#">Trains</a></li>
              <li class="breadcrumb-item active">Train Schedule</li>
            </ol>
          </nav>
        </div>

        <div class="main-content container-fluid">
          <div class="row">
            <div class="col-sm-12">
              <div class="card card-table">
                <div class="card-header">Search Train</div>

                <div class="card-body">
                  <form method="POST" action="">
                    <div class="form-row m-4 col-sm-12 text-left">
                      <div class="form-group col-sm-10">
                        <select class="form-control" id="train_name" name="train_name" required>
                          <option value="">Select Train</option>
                          <?php 
                            $ret="SELECT train_no, train_name FROM TRAIN";
                            $stmt= $mysqli->prepare($ret);
                            $stmt->execute() ;
                            $res=$stmt->get_result();
                            while($row=$res->fetch_object())
                            {
                              $t_no = $row->train_no;
                              $t_name = $row->train_name;
                              $t_name = $t_no.' '.$t_name;
                              echo "<option value='$t_name'>$t_name</option>";
                            }
                          ?>
                        </select>
                      </div>
                      <div class="form-group col-sm-2 text-center">
                        <button type="submit" name="Search_Train" class="btn btn-primary px-6 py-2">Search</button>
                      </div>
                    </div>
                  </form>
                </div>

                <?php
                if(isset($_POST['Search_Train'])) {
                    $ret="select T.mon, T.tue, T.wed, T.thu, T.fri, T.sat, T.sun from TRAIN T where T.train_no = ?";
                    $stmt= $mysqli->prepare($ret) ;
                    $stmt->bind_param('i', $train_no);
                    $stmt->execute();
                    $res=$stmt->get_result();
                    $train=$res->fetch_object();
                ?>

                <div class="card-body">
                    <div class="form-row m-4 col-sm-12 text-left">
                        <div class="form-group col-sm-6">
                            <span class="h3"><?php echo $train_name ?> (<?php echo $train_no ?>)</span>
                        </div>
                    
                        <div class="form-group col-sm-6 text-right">
                            <span class="p-5 h4">
                            <span class="font-weight-bold mr-2">Runs On</span>
                            <span class="<?php echo $train->mon == 'Y' ? 'font-weight-bold text-danger' : 'font-weight-bold text-secondary' ?> mr-2">M</span>
                            <span class="<?php echo $train->tue == 'Y' ? 'font-weight-bold text-danger' : 'font-weight-bold text-secondary' ?> mr-2">T</span>
                            <span class="<?php echo $train->wed == 'Y' ? 'font-weight-bold text-danger' : 'font-weight-bold text-secondary' ?> mr-2">W</span>
                            <span class="<?php echo $train->thu == 'Y' ? 'font-weight-bold text-danger' : 'font-weight-bold text-secondary' ?> mr-2">T</span>
                            <span class="<?php echo $train->fri == 'Y' ? 'font-weight-bold text-danger' : 'font-weight-bold text-secondary' ?> mr-2">F</span>
                            <span class="<?php echo $train->sat == 'Y' ? 'font-weight-bold text-danger' : 'font-weight-bold text-secondary' ?> mr-2">S</span>
                            <span class="<?php echo $train->sun == 'Y' ? 'font-weight-bold text-danger' : 'font-weight-bold text-secondary' ?> mr-2">S</span>
                            </span>
                        </div>
                    </div>
                </div>

                <?php
                    }
                ?>

                <div class="card-body">
                <table class="table table-striped table-hover table-bordered" id="table1">
                    <thead class="thead-dark">
                      <tr>
                        <th>Station Name</th>
                        <th class="text-center">Arr Time</th>
                        <th class="text-center">Dep Time</th>
                        <th>Hault (mins)</th>
                        <th>Day</th>
                        <th>Dist (kms)</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php
                    if(isset($_POST['Search_Train'])) {
                        $ret="select 
                        S.station_code, S.station_name,
                        time_format(S.arrival_time, '%H:%i') as 'arrival_time',
                        time_format(S.departure_time, '%H:%i') as 'departure_time',
                        S.hault, S.day, S.dist
                        from TRAIN T, STATION S
                        where T.train_no = ? and T.train_no = S.train_no
                        order by S.dist ASC";

                        $stmt= $mysqli->prepare($ret) ;
                        $stmt->bind_param('i', $train_no);
                        $stmt->execute() ;
                        $res=$stmt->get_result();
                        while($row=$res->fetch_object())
                        {
                ?>
                      <tr class="odd gradeX even gradeC odd gradeA even gradeA">
                        <td><?php echo $row->station_name;?> - <?php echo $row->station_code;?></td>
                        <td class="text-center"><?php echo $row->arrival_time != '00:00' ? $row->arrival_time : '-' ;?></td>
                        <td class="text-center"><?php echo $row->departure_time != '00:00' ? $row->departure_time : '-' ;?></td>
                        <td><?php echo $row->hault;?></td>
                        <td><?php echo $row->day;?></td>
                        <td><?php echo $row->dist;?></td>
                      </tr>
                <?php
                        }
                    }
                ?>
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