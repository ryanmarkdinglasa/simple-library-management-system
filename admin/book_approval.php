<?php
    error_reporting(E_ALL);
    session_start();
    include("include/session.php");
    include("include/header.php");
    //include("../include/function.php");
    $parentpage = "";
    $parentpage_link= "#";
    $currentpage='Approvals';
    $childpage = $page = "Approvals";
    
    $content_right='';

  ?>
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
                  <h3 class="mb-0">Approvals</h3>
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
                    <th>Book ISBN</th>
                    <th>Borrowed By</th>
                    <th>Status</th>
                    <th>Approved By</th>
                    <th>Date Approved</th>
                    <th>option</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                    try{
                      $sql = "SELECT 
                                  `book_issuance`.*,
                                  `book`.`id` AS `book_id`,
                                  `book`.`isbn` AS `book_isbn`,
                                  `book`.`title` AS `book_title`,
                                  `student`.`id` AS `student_id`,
                                  CONCAT(`student`.`lastname`, ', ', `student`.`firstname`) AS `student_name`,
                                  `book_issuance`.`approved_by`
                              FROM `book_issuance`
                              INNER JOIN `book` ON `book`.`id` = `book_issuance`.`book_id`
                              INNER JOIN `user` AS `student` ON `student`.`id` = `book_issuance`.`user_id`
                              ORDER BY `book_issuance`.`created_on` DESC
                            ";
                      $stmt = $con->prepare($sql);
                      $stmt->execute();
                      $cnt = 1;
                      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                  ?>
                 
                    <tr>
                      <td>
                          <label class="text-muted"><?php echo $cnt;?></label>
                      </td>
                      <td >
                        <?php $book_isbn=(empty($row['book_isbn']) ||$row['book_isbn']==NULL)?'':$row['book_isbn']; ?>
                        <label class="font-weight-bold"><?php echo htmlentities(short_text($book_isbn)); ?></label>
                      </td>
                      <td >
                        <?php $student_name=(empty($row['student_name']) ||$row['student_name']==NULL)?'':$row['student_name']; ?>
                        <label class="font-weight-bold"><?php echo htmlentities(short_text($student_name)); ?></label>
                      </td>

                      <td>
                        <?php    
                          $status = (empty($row['is_approve']) ||$row['is_approve']==NULL)?0:$row['is_approve'];;
                          if ($status == 1) {
                            echo '<span class="badge badge-success"> Approved </span>';
                          }
                          else if ($status == 0){
                            echo '<span class="badge badge-warning"> Pending </span>';
                          }
                          else{
                            echo '<span class="badge badge-danger"> Disapproved </span>';
                          }  
                        ?>                      
                      </td>
                       <td >
                        <?php $approved_by=(empty($row['approved_by']) ||$row['approved_by']==NULL)?' ':$row['approved_by']; ?>
                        <label class="font-weight-bold"><?php echo htmlentities(short_text($approved_by)); ?></label>
                      </td>
                      <td>
                        <span class="text-muted">
                          <?php
                            $date=(empty($row['created_on']) ||$row['created_on']==NULL)?'':$row['created_on'];
                            $created_on = isset( $date) ? htmlspecialchars(date('Y-m-d', strtotime($date)), ENT_QUOTES, 'UTF-8') : '';
                          ?>
                          <label title="<?php echo formatDate($date); ?>"> <?php echo $created_on; ?></label>
                        </span>
                      </td>
                      <td class="text-right">
                        <div class="dropdown">
                          <a class="btn btn-sm btn-icon-only bg-light rounded-circle shadow text-primary" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v"></i>
                          </a>
                          <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow py-0"> 
                            <?php 
                              if ( $status == 0){
                            ?>
                            <a class="dropdown-item" href="book_approval_controller.php?id=<?php echo $row['id'] ?>&on=0"><i class="fas fa-check text-primary " ></i> Approve</a>
                            <a class="dropdown-item" href="book_approval_controller.php?id=<?php echo $row['id'] ?>&off=1"><i class="fas fa-times text-primary "></i>Disapprove</span></a>
                            <?php 
                              } else if ( $status == 1){
                            ?>
                            <div class="d-flex align-items-center">
                                <span class="badge badge-success w-100" style="height:30px;"> Already approved </span>
                            </div>
                            <?php
                              } else{
                            ?>
                            <div class="d-flex align-items-center">
                                <span class="badge badge-danger w-100" style="height:30px;"> Already disapproved </span>
                            </div>
                            <?php
                              }
                            ?>
                          </div>
                        </div>
                      </td>
                    </tr>
                 
                  <?php $cnt = $cnt + 1;
                  } //while
                }catch(Exception $e){
                  $_SESSION['error']='Something went wrong in accessing book borrowed data.';
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
