<!--Start Server side code to give us and hold session-->
<?php
  session_start();
  include('assets/inc/config.php');
  include('assets/inc/checklogin.php');
  check_login();
  $aid=$_SESSION['user_id'];

  //Get user details
  $from = $to = $date = "";
  if(isset($_GET['from']) && isset($_GET['to']) && isset($_GET['date'])){
    $from = $_GET['from'];
    $to = $_GET['to'];
    $date = $_GET['date'];
  }

  // Process form submission
  if(isset($_POST['search'])) {
    $from = $_POST['from'];
    $to = $_POST['to'];
    $date = $_POST['date'];
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
          <h2 class="page-head-title">Book Train</h2>
          <nav aria-label="breadcrumb" role="navigation">
            <ol class="breadcrumb page-head-nav">
              <li class="breadcrumb-item"><a href="pass">Dashboard</a></li>
              <li class="breadcrumb-item"><a href="#">Book Train</a></li>
              <li class="breadcrumb-item active">Reserve Train</li>
            </ol>
          </nav>
        </div>

        <div class="main-content container-fluid">
          <div class="row">
            <div class="col-sm-12">
              <div class="card card-table">
                <div class="card-header">Book Your Journey</div>

                <div class="card-body">
                  <form method="POST" action="">
                    <div class="form-row m-4">
                      <div class="form-group col-md-4">
                        <label for="from">From Station</label>
                        <select class="form-control" id="from" name="from" required>
                          <option value="<?php echo $from ?>"><?php echo $from ? $from : 'From' ?></option>
                          <?php 
                            $ret="SELECT DISTINCT station_name FROM STATION order by station_name"; //sql code to get all stations
                            $stmt= $mysqli->prepare($ret);
                            $stmt->execute() ;
                            $res=$stmt->get_result();
                            while($row=$res->fetch_object())
                            {
                              $station_name = $row->station_name;
                              echo "<option value='$station_name'>$station_name</option>";
                            }
                          ?>
                        </select>
                      </div>
                      <div class="form-group col-md-4">
                        <label for="to">To Station</label>
                        <select class="form-control" id="to" name="to" required>
                          <option value="<?php echo $to ?>"><?php echo $to ? $to : 'To' ?></option>
                          <?php 
                            $res->data_seek(0);
                            while($row=$res->fetch_object())
                            {
                              $station_name = $row->station_name;
                              echo "<option value='$station_name'>$station_name</option>";
                            }
                          ?>
                        </select>
                      </div>
                      <div class="form-group col-md-4">
                        <label for="date">Date</label>
                        <input type="date" class="form-control" id="date" name="date" min="<?php echo date("Y-m-d");?>" 
                        max="<?php echo date('Y-m-d', strtotime(date("Y-m-d"). ' + 20 days'));?>" value="<?php echo $date ? $date : date("Y-m-d") ?>" required>
                      </div>
                      <div class="form-group col-md-12 text-right pr-4">
                        <button type="submit" name="search" class="btn btn-primary px-4 py-1">Search</button>
                      </div>
                    </div>
                  </form>
                </div>

                <div class="card-body">
                <table class="table table-striped table-bordered" id="table1">
                    <thead class="thead-dark">
                      <tr>
                        <th>#</th>
                        <th>Train</th>
                        <th>From</th>
                        <th>Date</th>
                        <th>Departure</th>
                        <th>To</th>
                        <th>Date</th>
                        <th>Arrival</th>
                        <th>Runs On</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php
                        /*
                        *Lets get details of available trains!!
                        */
                        $ret="select 
                        T.train_no as 'train_no',
                        T.train_name as 'name',
                        S1.station_code as 'from',
                        S1.station_name as 'from_name',
                        date_add(TS.date, interval (S1.day - 1) day) as 'from_date',
                        time_format(S1.departure_time, '%H:%i') as 'from_time',
                        S2.station_code as 'to',
                        S2.station_name as 'to_name',
                        date_add(TS.date, interval (S2.day - 1) day) as 'to_date',
                        time_format(S2.arrival_time, '%H:%i') as 'to_time',
                        TS._SL as 'status_sl',
                        round((S2.dist - S1.dist) * f_sl, 2) as 'fare_sl',
                        TS._1A as 'status_1a',
                        round((S2.dist - S1.dist) * f_1a, 2) as 'fare_1a',
                        TS._2A as 'status_2a',
                        round((S2.dist - S1.dist) * f_2a, 2) as 'fare_2a',
                        TS._3A as 'status_3a',
                        round((S2.dist - S1.dist) * f_3a, 2) as 'fare_3a',
                        T.mon, T.tue, T.wed, T.thu, T.fri, T.sat, T.sun, S1.day

                        from TRAIN T, TRAIN_STATUS TS, STATION S1, STATION S2
                        where date_add(TS.date, interval (S1.day - 1) day)=? and S1.station_name=? and S2.station_name=?
                        and (S2.dist - S1.dist) > 0
                        and T.train_no = TS.train_no
                        and S1.train_no = T.train_no and T.train_no = S2.train_no;";

                        $stmt= $mysqli->prepare($ret) ;
                        $stmt->bind_param('sss', $date, $from, $to);
                        $stmt->execute() ;
                        $res=$stmt->get_result();
                        $cnt=1;
                        while($row=$res->fetch_object())
                        {
                    ?>
                      <tr class="odd gradeX even gradeC odd gradeA even gradeA">
                        <td><?php echo $row->train_no;?></td>
                        <td><?php echo $row->name;?></td>
                        <td class="center"><?php echo $row->from;?></td>
                        <td class="center"><?php echo $row->from_date;?></td>
                        <td class="center"><?php echo $row->from_time;?></td>
                        <td class="center"><?php echo $row->to;?></td>
                        <td class="center"><?php echo $row->to_date;?></td>
                        <td class="center"><?php echo $row->to_time;?></td>
                        <td>
                          <span class="h5">
                            <span class="<?php echo $row->mon == 'Y' && $row->day == 1 || $row->sun == 'Y' && $row->day == 2 || $row->sat == 'Y' && $row->day == 3 ? 'font-weight-bold text-danger' : 'font-weight-bold text-secondary' ?> mr-1">M</span>
                            <span class="<?php echo $row->tue == 'Y' && $row->day == 1 || $row->mon == 'Y' && $row->day == 2 || $row->sun == 'Y' && $row->day == 3 ? 'font-weight-bold text-danger' : 'font-weight-bold text-secondary' ?> mr-1">T</span>
                            <span class="<?php echo $row->wed == 'Y' && $row->day == 1 || $row->tue == 'Y' && $row->day == 2 || $row->mon == 'Y' && $row->day == 3 ? 'font-weight-bold text-danger' : 'font-weight-bold text-secondary' ?> mr-1">W</span>
                            <span class="<?php echo $row->thu == 'Y' && $row->day == 1 || $row->wed == 'Y' && $row->day == 2 || $row->tue == 'Y' && $row->day == 3 ? 'font-weight-bold text-danger' : 'font-weight-bold text-secondary' ?> mr-1">T</span>
                            <span class="<?php echo $row->fri == 'Y' && $row->day == 1 || $row->thu == 'Y' && $row->day == 2 || $row->wed == 'Y' && $row->day == 3 ? 'font-weight-bold text-danger' : 'font-weight-bold text-secondary' ?> mr-1">F</span>
                            <span class="<?php echo $row->sat == 'Y' && $row->day == 1 || $row->fri == 'Y' && $row->day == 2 || $row->thu == 'Y' && $row->day == 3 ? 'font-weight-bold text-danger' : 'font-weight-bold text-secondary' ?> mr-1">S</span>
                            <span class="<?php echo $row->sun == 'Y' && $row->day == 1 || $row->sat == 'Y' && $row->day == 2 || $row->fri == 'Y' && $row->day == 3 ? 'font-weight-bold text-danger' : 'font-weight-bold text-secondary' ?> mr-1">S</span>
                          </span>
                        </td>
                      </tr>
                      <tr class="odd gradeX even gradeC odd gradeA even gradeA">
                      <td colspan="8">
                        <div class="container mx-0">
                          <div class="row">
                            <div class="col-md-2 p-0 pr-2 pb-1">
                            <?php echo
                              "<a href='user-book-passenger-details.php?train_no=$row->train_no&train_name=$row->name&from=$row->from&to=$row->to&from_name=$row->from_name&to_name=$row->to_name&from_date=$row->from_date&from_time=$row->from_time&to_date=$row->to_date&to_time=$row->to_time&class=SL&status=$row->status_sl&fare=$row->fare_sl' class='text-reset'>"
                            ?>
                              <div class="box border <?php echo substr_count($row->status_sl,"WL") || substr_count($row->status_sl,"NO_AVL") ? 'border-danger' : 'border-success'; ?>" style="background-color: rgba(<?php echo substr_count($row->status_sl,'WL') || substr_count($row->status_sl,'NO_AVL') ? '255, 221, 221, 0.25' : '180, 255, 180, 0.15' ?>);border-radius: 4px;">
                                <div class="box-content px-4 py-2">
                                  <h4 class="class-type m-0 my-1 font-weight-bold">SL</h4>
                                  <div class="d-flex justify-content-between fs-3">
                                    <div class="font-weight-bold <?php echo substr_count($row->status_sl,"WL") || substr_count($row->status_sl,"NO_AVL") ? 'text-danger' : 'text-success'; ?>"><?php echo $row->status_sl;?></div>
                                    <div>₹ <?php echo $row->fare_sl;?></div>
                                  </div>
                                </div>
                              </div>
                            </a>
                            </div>
                            <div class="col-md-2 p-0 pr-2">
                            <?php echo
                              "<a href='user-book-passenger-details.php?train_no=$row->train_no&train_name=$row->name&from=$row->from&to=$row->to&from_name=$row->from_name&to_name=$row->to_name&from_date=$row->from_date&from_time=$row->from_time&to_date=$row->to_date&to_time=$row->to_time&class=3A&status=$row->status_3a&fare=$row->fare_3a' class='text-reset'>"
                            ?>
                              <div class="box border <?php echo substr_count($row->status_3a,"WL") || substr_count($row->status_3a,"NO_AVL") ? 'border-danger' : 'border-success'; ?>" style="background-color: rgba(<?php echo substr_count($row->status_3a,'WL') || substr_count($row->status_3a,'NO_AVL') ? '255, 221, 221, 0.25' : '180, 255, 180, 0.15' ?>);border-radius: 4px;">
                                <div class="box-content px-4 py-2">
                                  <h4 class="class-type m-0 my-1 font-weight-bold">3A</h4>
                                  <div class="d-flex justify-content-between fs-3">
                                    <div class="font-weight-bold <?php echo substr_count($row->status_3a,"WL") || substr_count($row->status_3a,"NO_AVL") ? 'text-danger' : 'text-success'; ?>"><?php echo $row->status_3a;?></div>
                                    <div>₹ <?php echo $row->fare_3a;?></div>
                                  </div>
                                </div>
                              </div>
                            </a>
                            </div>
                            <div class="col-md-2 p-0 pr-2">
                            <?php echo
                              "<a href='user-book-passenger-details.php?train_no=$row->train_no&train_name=$row->name&from=$row->from&to=$row->to&from_name=$row->from_name&to_name=$row->to_name&from_date=$row->from_date&from_time=$row->from_time&to_date=$row->to_date&to_time=$row->to_time&class=2A&status=$row->status_2a&fare=$row->fare_2a' class='text-reset'>"
                            ?>
                              <div class="box border <?php echo substr_count($row->status_2a,"WL") || substr_count($row->status_2a,"NO_AVL") ? 'border-danger' : 'border-success'; ?>" style="background-color: rgba(<?php echo substr_count($row->status_2a,'WL') || substr_count($row->status_2a,'NO_AVL') ? '255, 221, 221, 0.25' : '180, 255, 180, 0.15' ?>);border-radius: 4px;">
                                <div class="box-content px-4 py-2">
                                  <h4 class="class-type m-0 my-1 font-weight-bold">2A</h4>
                                  <div class="d-flex justify-content-between fs-3">
                                    <div class="font-weight-bold <?php echo substr_count($row->status_2a,"WL") || substr_count($row->status_2a,"NO_AVL") ? 'text-danger' : 'text-success'; ?>"><?php echo $row->status_2a;?></div>
                                    <div>₹ <?php echo $row->fare_2a;?></div>
                                  </div>
                                </div>
                              </div>
                            </a>
                            </div>
                            <div class="col-md-2 p-0 pr-0">
                            <?php echo
                              "<a href='user-book-passenger-details.php?train_no=$row->train_no&train_name=$row->name&from=$row->from&to=$row->to&from_name=$row->from_name&to_name=$row->to_name&from_date=$row->from_date&from_time=$row->from_time&to_date=$row->to_date&to_time=$row->to_time&class=1A&status=$row->status_1a&fare=$row->fare_1a' class='text-reset'>"
                            ?>
                              <div class="box border <?php echo substr_count($row->status_1a,"WL") || substr_count($row->status_1a,"NO_AVL") ? 'border-danger' : 'border-success'; ?>" style="background-color: rgba(<?php echo substr_count($row->status_1a,'WL') || substr_count($row->status_1a,'NO_AVL') ? '255, 221, 221, 0.25' : '180, 255, 180, 0.15' ?>);border-radius: 4px;">
                                <div class="box-content px-4 py-2">
                                  <h4 class="class-type m-0 my-1 font-weight-bold">1A</h4>
                                  <div class="d-flex justify-content-between fs-3">
                                    <div class="font-weight-bold <?php echo substr_count($row->status_1a,"WL") || substr_count($row->status_1a,"NO_AVL") ? 'text-danger' : 'text-success'; ?>"><?php echo $row->status_1a;?></div>
                                    <div>₹ <?php echo $row->fare_1a;?></div>
                                  </div>
                                </div>
                              </div>
                            </a>
                            </div>
                          </div>
                        </div>
                      </td>
                      </tr>
                    <?php }?>
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