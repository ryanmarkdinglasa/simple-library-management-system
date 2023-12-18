<?php
    session_start();
    include("include/session.php");
    $parentpage = "";
    $parentpage_link= "#";
    $currentpage='Transactions';
    $childpage = $page = "Transactions";
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
                  <h3 class="mb-0">Transactions</h3>
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
                    <th>Title</th>
                    <th>ISBN</th>
                    <th>Issued By</th>
                    <th>Penalty</th>
                    <th>Date</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                    try{
                      $stmt = $con->prepare("SELECT 
                                              `book`.`title` AS `book_title`,
                                              `book`.`isbn` AS `book_isbn`,
                                              `book_issuance`.`approved_by`AS `staff_name`,
                                              `book_issuance`.`penalty`,
                                              `book_issuance`.`created_on` AS `transaction_date`
                                            FROM `book_issuance` 
                                            INNER JOIN `book` ON `book`.`id` = `book_issuance`.`book_id`
                                            WHERE `book_issuance`.`user_id`=? AND `book_issuance`.`is_approve`=?
                                            ORDER BY `book_issuance`.`created_on` ASC");
                      $stmt->execute([$user['id'], '1']);

                      $cnt = 1;
                      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                  ?>
                    <tr>
                      <td>
                          <label class="text-muted"><?php echo $cnt;?></label>
                      </td>
                      <td >
                        <?php $book_title=(empty($row['book_title']) ||$row['book_title']==NULL)?'':$row['book_title']; ?>
                        <label class="font-weight-bold"><?php echo htmlentities(short_text($book_title)); ?></label>
                      </td>
                      <td >
                        <?php $book_isbn=(empty($row['book_isbn']) ||$row['book_isbn']==NULL)?'':$row['book_isbn']; ?>
                        <label class="font-weight-bold"><?php echo htmlentities(short_text($book_isbn)); ?></label>
                      </td>
                      <td >
                        <?php $staff_name=(empty($row['staff_name']) ||$row['staff_name']==NULL)?'None':$row['staff_name']; ?>
                        <label class="font-weight-bold"><?php echo htmlentities(short_text($staff_name)); ?></label>
                      </td>
                      <td>
                        <?php 
                            $price = (!isset($row['penalty']) || $row['penalty'] == 0) ? '0.00' : number_format($row['penalty'], 2);
                        ?>
                        <label class="font-weight-bold">&#8369; <?php echo htmlentities($price); ?></label>
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
