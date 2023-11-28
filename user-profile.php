<?php
session_start();
include('assets/inc/config.php');
include('assets/inc/checklogin.php');
check_login();
$aid=$_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="en">
  <!--Head-->
  <?php include('assets/inc/head.php');?>
  <!--End Head-->
  <body>
    <div class="be-wrapper be-fixed-sidebar">
      <!--Navigation Bar-->
      <?php include("assets/inc/navbar.php");?>
      <!--End Naigation Bar-->
      <!--Sidebar-->
      <?php include('assets/inc/sidebar.php');?>
      <!--End Sidebar-->

      <?php
      $aid=$_SESSION['user_id'];//Assaign session variable to passenger ID
      $ret="select * from USER where username=?";
      $stmt= $mysqli->prepare($ret) ;
      $stmt->bind_param('s',$aid);
      $stmt->execute() ;//ok
      $res=$stmt->get_result();
      $row=$res->fetch_object();
      ?>
      <!--End Server Side Script-->
      <div class="be-content">
        <div class="main-content container-fluid">
          <div class="user-profile">
            <div class="row">
              <div class="col-lg-12">
                <div class="user-display card card-border card-border-color-secondary" style="margin-top: 50px">
                    <div class="user-display-bottom">
                      <div class="user-display-avatar"><img src="assets/img/profile/defaultimg.png" alt="Avatar"></div>
                      <div class="user-display-info">
                        <div class="h3 my-1"><?php echo $row->first_name;?> <?php echo $row->last_name;?> </div>
                        <div class="h4 my-0"><?php echo $row->username;?></div>
                      </div>
                    </div>
                </div>
                <div class="user-info-list card">
                  <div class="card-header card-header-divider"><span class="h3">About Me</span></div>
                  <div class="card-body">
                    <table class="no-border no-strip mx-5 h4 col-md-6">
                      <tbody class="no-border-x no-border-y">
                        <tr>
                          <td class="icon"><span class="material-symbols-outlined">edit</span></td>
                          <td class="item">Age</td>
                          <td><?php echo $row->age ? $row->age : '-';?></td>
                        </tr>
                        <tr>
                          <td class="icon"><span class="material-symbols-outlined">person</span></td>
                          <td class="item">Gender</td>
                          <td><?php echo $row->gender ? $row->gender : '-' ;?></td>
                        </tr>
                        <tr>
                          <td class="icon"><span class="material-symbols-outlined">alternate_email</span></td>
                          <td class="item">Email</td>
                          <td><?php echo $row->email ? $row->email : '-';?></td>
                        </tr>
                        <tr>
                          <td class="icon"><span class="material-symbols-outlined">call</span></td>
                          <td class="item">Mobile</td>
                          <td><?php echo $row->mobile_no ? $row->mobile_no : '-';?></td>
                        </tr>
                        <tr>
                          <td class="icon"><span class="material-symbols-outlined">home</span></td>
                          <td class="item">City</td>
                          <td><?php echo $row->city ? $row->city : '-';?></td>
                        </tr>
                        <tr>
                          <td class="icon"></td>
                          <td class="item">State</td>
                          <td><?php echo $row->state ? $row->state : '-';?></td>
                        </tr>
                        <tr>
                          <td class="icon"></td>
                          <td class="item">Country</td>
                          <td><?php echo $row->country ? $row->country : '-';?></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <div class="card-header card-header-divider"><span class="h3"> Danger Zone</span></div>
                  <div class="card-body">
                    <table class="no-border no-strip mx-5 h4 col-md-6">
                      <tbody class="no-border-x no-border-y">
                        <tr>
                          <td class="icon"><span class="material-symbols-outlined">error</span></td>
                          <td class="item">Delete Account</td>
                          <td>
                            <button id="delete_my_account" class="btn btn-danger px-4 py-1"> Delete </span></button>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!--footer-->
        </div>
        <?php include('assets/inc/footer.php');?>
        <!--EndFooter-->
      </div>
      <script src="assets/lib/jquery/jquery.min.js" type="text/javascript"></script>
      <script src="assets/js/app.js" type="text/javascript"></script>
      <script src="assets/lib/jquery-flot/jquery.flot.js" type="text/javascript"></script>
      <script src="assets/lib/jquery-flot/jquery.flot.pie.js" type="text/javascript"></script>
      <script src="assets/lib/jquery-flot/jquery.flot.time.js" type="text/javascript"></script>
      <script src="assets/lib/jquery-flot/jquery.flot.resize.js" type="text/javascript"></script>
      <script src="assets/lib/jquery-flot/plugins/jquery.flot.orderBars.js" type="text/javascript"></script>
      <script src="assets/lib/jquery-flot/plugins/curvedLines.js" type="text/javascript"></script>
      <script src="assets/lib/jquery-flot/plugins/jquery.flot.tooltip.js" type="text/javascript"></script>
      <script src="assets/lib/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
      <script src="assets/lib/perfect-scrollbar/js/perfect-scrollbar.min.js" type="text/javascript"></script>
      <script src="assets/lib/bootstrap/dist/js/bootstrap.bundle.min.js" type="text/javascript"></script>
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
        });
        $(document).on('click', '#delete_my_account', function(e) {
            e.preventDefault();
            swal({
                title: "Are you sure?",
                text: "All your data will be lost permanently!",
                icon: "warning",
                buttons: ["Cancel", "Confirm"],
                dangerMode: true,
              })
              .then((willDelete) => {
                if (willDelete) {
                  window.location.href = "user-delete.php?username=<?php echo $aid; ?>";
                }
              });
          });
      </script>
    </body>
</html>