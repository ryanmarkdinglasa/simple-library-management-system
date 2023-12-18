<?php
    session_start();
    include("include/session.php");
    $parentpage = "";
    $parentpage_link= "#";
    $currentpage='Notifications';
    $childpage = $page = "Notifications";
    include("include/header.php");
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
                  <h3 class="mb-0">Notifications</h3>
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
                    <th>Description</th>
                    <th>Book ISBN</th>
                    <th>Status</th>
                    <th>Date</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                    try{
                      $stmt = $con->prepare("SELECT `notification`.`description`,`book`.`isbn` AS `book_isbn`,`notification`.`status`,`notification`.`created_on`
                      FROM `notification`
                      INNER JOIN `book_issuance` ON `book_issuance`.`id` = `notification`.`issuance_id`
                      INNER JOIN `book` ON `book`.`id` = `book_issuance`.`book_id`
                      WHERE `notification`.`user_id`=?");
                      $stmt->execute([$user['id']]);
                      $cnt = 1;
                      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                  ?>
                    <tr>
                      <td>
                          <label class="text-muted"><?php echo $cnt;?></label>
                      </td>
                      <td >
                        <?php $description=(empty($row['description']) ||$row['description']==NULL)?'':$row['description']; ?>
                        <label class="font-weight-bold"><?php echo htmlentities(short_text($description)); ?></label>
                      </td>
                      <td >
                        <?php $book_isbn=(empty($row['book_isbn']) ||$row['book_isbn']==NULL)?' ':$row['book_isbn']; ?>
                        <label class="font-weight-bold"><?php echo htmlentities(short_text($book_isbn)); ?></label>
                      </td>
                      <td class="text-left">
                        <?php    
                          $status = (empty($row['status']) ||$row['status']==NULL)?0:$row['status'];;
                          if ($status >0) echo '<span class="badge badge-success"> Read </span>';
                          else  echo '<span class="badge badge-danger"> Unread </span>';
                        ?>                      
                      </td>
					            <td>
                        <span class="text-muted">
                          <?php
                            $date=(empty($row['transaction_date']) ||$row['transaction_date']==NULL)?'':$row['transaction_date'];
                            $created_on = isset( $date) ? htmlspecialchars(created_on($date), ENT_QUOTES, 'UTF-8') : '';
                          ?>
                          <label title="<?php echo formatDate($date); ?>"> <?php echo $created_on; ?></label>
                        </span>
                      </td>
                    </tr>
                  <?php $cnt = $cnt + 1;
                  } //while
                }catch(Exception $e){
                  $_SESSION['error']='Something went wrong in accessing user transactions.';
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
