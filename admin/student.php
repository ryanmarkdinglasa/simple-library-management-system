  <?php
  	error_reporting(E_ALL);
    session_start();
    include("include/session.php");
    $parentpage = "Account";
    $parentpage_link= "#";
    $currentpage='Student';
    $childpage = "student";
    include("include/header.php");
    $content_right='';
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
        include("include/topnav.php"); 
        include("include/snackbar.php"); 
        include "include/breadcrumbs.php";
      ?>
    <div class="container-fluid mt--6">
      <div class="row">
        <div class="col">
          <div class="card">
            <div class="card-header border-0">
              <div class="row">
                <div class="col-6">
                  <h3 class="mb-0">Students</h3>
                </div>
                <div class="col-6 text-right">
                </div>
              </div>
            </div>
            <div class="table-responsive">
               <table class="table align-items-center table-flush table-striped" id="datatable-buttons">
                <thead class="thead-light">
                  <tr>
                    <th>No.</th>
                    <th>Student Name</th>
                    <th>Email</th>
                    <th>Phone No.</th>
                    <th>Address</th>
					          <th>Date Registered</th>
                    <th>Option</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                    try{
                      $stmt = $con->prepare("SELECT * FROM `user` WHERE `type` = ?");
                      $stmt->execute(['student']);
                      $cnt = 1;
                      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                  ?>
                    <tr>
                      <td>
                          <label class="text-muted"><?php echo $cnt;?></label>
                      </td>
                      <td class="table-user">
                        <?php 
                          $userphoto = isset($row['image']) ? htmlspecialchars(($row['image']), ENT_QUOTES, 'UTF-8') : '';
                          $userphoto = $row['image'];
                          if ($userphoto == "" || $userphoto == "NULL") :
                          ?>
                          <img src="img/profile.png" class="avatar rounded-circle mr-3">
                          <?php else : ?>
                          <img src="../student/img/<?php echo $userphoto; ?>" class="avatar rounded-circle mr-3">
                          <?php endif; ?>
                          <b>
                          <?php 
                           
                            $fname=(empty($row['firstname'])||$row['firstname']==NULL)?'None':$row['firstname'];
                            $lname=(empty($row['lastname'])||$row['lastname']==NULL)?'None':$row['lastname'];
                            $name =  $lname.', '. $fname.' ';
                            if (!$name == "" || !$name == "NULL") {
                              $username_short = htmlentities($name);
                              if (strlen($username_short) > 30) $username_short = substr($username_short, 0, 30) . "...";
                              echo $username_short;
                            }
                        ?>
											  </b>
                      </td>
                     
                      <td>
                        <a href="mailto:<?php 
                            $email=(empty($row['username']) || $row['username']==NULL)?'':$row['username'];
                            $username = isset($email) ? htmlspecialchars(($email), ENT_QUOTES, 'UTF-8') : '';
                            echo $username;?>" class="font-weight-bold">
                          <?php 
                            $username=short_text($username);
                            echo $username;
                          ?>
                        </a>
                      </td>
                      <td>
                        <?php
                          $phone_no=(empty($row['phone_no']) ||$row['phone_no']==NULL)?'':$row['phone_no'];
                        ?>
                        <a href="tel:<?php echo htmlentities($phone_no); ?>" class="font-weight-bold"><?php echo htmlentities($phone_no); ?></a>
                      </td>
                      <td>
                        <?php
                          $address=(empty($row['address']) ||$row['address']==NULL)?'':$row['address'];
                        ?>
                        <label class="font-weight-bold"><?php echo htmlentities(short_text($address)); ?></label>
                      </td>
					            <td>
                        <span class="text-muted">
                          <?php
                            $date=(empty($row['created_on']) ||$row['created_on']==NULL)?'':$row['created_on'];
                            $created_on = isset( $date) ? htmlspecialchars(created_on($date), ENT_QUOTES, 'UTF-8') : '';
                            
                           // echo $created_on; 
                          ?>
                          <label title="<?php echo formatDate($date); ?>"> <?php echo $created_on; ?></label>
                        </span>
                      </td>
                     
                      <td class="text-right">
                        <div class="dropdown">
                          <a class="btn btn-sm btn-icon-only bg-light rounded-circle shadow text-primary" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v"></i>
                          </a>
                          <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                            <a class="dropdown-item" href="student_controller.php?id=<?php echo $row['id'] ?>&del=delete" onClick="return confirm('Are you sure you want to remove student, <?php echo $username; ?> ?')"><i class="fas fa-trash text-primary"></i> Delete Account</a>
                          </div>
                        </div>
                      </td>
                    </tr>
                  <?php $cnt = $cnt + 1;
                  } //while
                }catch(Exception $e){
                  $_SESSION['error']='Something went wrong in accessing student data.';
                }
                ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <?php include("include/footer.php"); ?>
      </div>
    </div>
  </body>
</html>
