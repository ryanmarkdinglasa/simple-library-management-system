<?php
  error_reporting(0);
	session_start();
	include("include/session.php");
	$parentpage = "Account";
	$parentpage_link= "#";
	$currentpage='Staff';
	$childpage = "admin";
  include("include/header.php");
  $content_right='<a type="button" data-toggle="modal" data-target="#modal-form" class="btn btn-round btn-icon bg-white text-primary" >
                    <span class="btn-inner--icon text-primary font-weight-bolder"><i class="fas fa-plus"></i></span>
                    <span class="btn-inner--text text-primary font-weight-bolder"> New</span>
                  </a>';
  ?>
  <script>
    function userAvailability() {
      $("#loaderIcon").show();
      jQuery.ajax({
        url: "add_admin_check_username.php",
        data: 'username=' + $("#username").val(),
        type: "POST",
        success: function(data) {
          $("#user-availability-status1").html(data);
          $("#loaderIcon").hide();
        },
        error: function() {}
      });
    }
  </script>
  </head>
  <?php include("include/sidebar.php"); ?>
  <div class="main-content" id="panel">
    <?php
      include("include/topnav.php"); //Edit topnav on this page
      include("include/snackbar.php");
      include "include/breadcrumbs.php"; // Snackbar & Breadcrumbs -->
    ?>
    <div class="col-md-4">
      <div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
        <div class="modal-dialog modal- modal-dialog-centered modal-sm" role="document">
          <div class="modal-content">
            <div class="modal-body p-0">
              <div class="card bg-blue border-0 mb-0">
                <div class="card-body px-lg-5 py-lg-5">
                  <div class="text-center form-control-label mb-4 text-white">
                    <span>Add New Administrator</span>
                  </div>
                  <form action="admin_controller.php" role="form" method="post">
                    <div class="form-group mb-2">
                      <label class="form-control-label mb-0 text-white">Username </label>
                      <div class="input-group input-group-merge input-group-alternative">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-user"></i></span>
                        </div>
                        <input onBlur="userAvailability()" id="username" name="username" class="form-control" placeholder="Username" type="text" title="Enter Username" oninvalid="this.setCustomValidity('Please enter the new admin Username.')" oninput="setCustomValidity('')" required>
                        <div class="input-group-append">
                          <span class="input-group-text" id="user-availability-status1"></span>
                        </div>
                      </div>
                      <span id="user-availability-status1"></span>
                    </div>
                    <div class="form-group">
                      <label class="form-control-label mb-0 text-white">Password </label>
                      <div class="input-group input-group-merge input-group-alternative">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                        </div>
						            <?php $password=generate_password();?>
                        <input class="form-control" type="password" name="password_default" placeholder="Password" value="<?php echo $password;?>" readonly="readonly">
                      </div>
                      <small class="text-white">Default password:</small><small style="color:red;"> auto generated</small>
                    </div>
                    <div class="text-right">
									      <button type="reset" id="cancel-button" class="btn btn-primary my-4 sp-add bg-secondary text-primary font-weight-bolder" >Cancel</button>
                        <button type="submit" id="add" name="add" class="btn btn-primary my-4 sp-add bg-white text-primary font-weight-bolder" >Save</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>


    <!-- Page content -->
    <div class="container-fluid mt--6">
      <!-- Table -->
      <div class="row">
        <div class="col">
          <div class="card">
            <div class="card-header border-0">   <!-- Card header -->
              <div class="row">
                <div class="col-6">
                  <h3 class="mb-0 text-primary font-weight-bolder">Staff</h3>
                </div>
                <div class="col-6 text-right">
                  
                </div>
              </div>
            </div>
            <!-- Light table -->
            <div class="table-responsive">
                <table class="table align-items-center table-flush table-striped" id="datatable-buttons">
                <thead class="thead-light">
                  <tr>
                    <th>No.</th>
                    <th>Staff</th>
                    <th>Date Created</th>
                    <th>Email</th>
                    <th>Phone No</th>
                    <th>Address</th>
                    <th>Option</th>
                  </tr>
                </thead>
                <tbody>
                    <?php 
                      try{
                        $sql = "SELECT * FROM `user` WHERE `type`='admin' AND `username`='".$user['username']."'";
                        $query = $con->query($sql);
                        $cnt = 1;
                        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                    <tr>
                      <td class="text-muted"><?php echo ''.$cnt;?></td>
                      <td class="table-user">
                        <?php
						              $userphoto = isset($row['image']) ? htmlspecialchars($row['image'], ENT_QUOTES, 'UTF-8') : '';
                          if ($userphoto == "" || $userphoto == "NULL" || empty($userphoto)) :
                          ?>
                          <img src="img/profile.png" class="avatar rounded-circle mr-3">
                          <?php else : ?>
                          <img src="img/<?php echo $userphoto; ?>" class="avatar rounded-circle mr-3">
                        <?php endif; ?>
                        <b>
                          <?php
                            $firstname = isset($row['firstname']) ? htmlspecialchars($row['firstname'], ENT_QUOTES, 'UTF-8') : '';
                            $lastname = isset($row['lastname']) ? htmlspecialchars($row['lastname'], ENT_QUOTES, 'UTF-8') : '';
                            $name=short_text($firstname.' '.$lastname);
                            echo $name;
                          ?>
                        </b>
                      </td>

                      <td>
                        <span class="text-muted"><?php
                          $created_on = isset($row['created_on']) ? htmlspecialchars(created_on($row['created_on']), ENT_QUOTES, 'UTF-8') : '';
                          echo $created_on; ?>
                        </span>
                      </td>

                      <td>
                        <a href="mailto:<?php
                          $username = isset($row['email']) ? htmlspecialchars($row['email'], ENT_QUOTES, 'UTF-8') : '';
                          echo $username; ?>" class="font-weight-bold"><?php 
                          echo $username; ?>
                        </a>
                      </td>
                     
                      <td>
                        <span class="text-muted"><?php
                          $phone_no = isset($row['phone_no']) ? htmlspecialchars($row['phone_no'], ENT_QUOTES, 'UTF-8') : '';
                          echo $phone_no; ?>
                        </span>
                      </td>
                      <td>
                        <span class="text-muted"><?php
                          $address = isset($row['address']) ? htmlspecialchars(short_text($row['address']), ENT_QUOTES, 'UTF-8') : '';
                          echo $address; ?>
                        </span>
                      </td>
                      <td class="text-right">
                        <div class="dropdown">
                          <a class="btn btn-sm btn-icon-only bg-light rounded-circle shadow text-primary" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v"></i>
                          </a>
                          <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                            <a class="dropdown-item" href="admin_controller.php?id=<?php echo $row['id'] ?>&del=delete" onClick="return confirm('Are you sure you want to remove this staff?')"><i class="fas fa-trash text-primary "></i> Delete Account</a>
                          </div>
                        </div>
                      </td>

                    </tr>
                  <?php 
                      $cnt = $cnt + 1;
                      }//while
                    }catch(Exception $e){
                      $_SESSION['error']='Something went wrong in accessing admin data.';
                    }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <?php include("include/footer.php"); ?>
      <script>
        function toggle_select(id) {
          var X = document.getElementById(id);
          if (X.checked == true) {
            X.value = "1";
          } else {
            X.value = "0";
          }
          //var sql="update clients set calendar='" + X.value + "' where cli_ID='" + X.id + "' limit 1";
          var who = X.id;
          var chk = X.value
          //alert("Joe is still debugging: (function incomplete/database record was not updated)\n"+ sql);
          $.ajax({
            //this was the confusing part...did not know how to pass the data to the script
            url: 'as_status_admin.php',
            type: 'post',
            data: 'who=' + who + '&chk=' + chk,
            success: function(output) {
              alert('success, server says ' + output);
            },
            error: function() {
              alert('something went wrong, save failed');
            }
          });
        }
      </script>
      </div>
    </div>
  </body>
</html>
