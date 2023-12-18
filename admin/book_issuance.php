  <?php
  	error_reporting(E_ALL);
    session_start();
    include("include/session.php");
    include("include/header.php");
    //include("../include/function.php");
    $parentpage = "";
    $parentpage_link= "#";
    $currentpage='Book Issuance';
    $childpage = $page = "Book Issuance";
    
    $content_right='';
    $content_right='<a type="button" data-toggle="modal" data-target="#modal-form" class="btn btn-round btn-icon bg-white text-primary" >
                      <span class="btn-inner--icon text-primary font-weight-bolder"><i class="fas fa-plus"></i></span>
                      <span class="btn-inner--text text-primary font-weight-bolder"> New</span>
                    </a>
                    <a type="button" data-toggle="modal" data-target="#modal-return" class="btn btn-round btn-icon bg-white text-primary" >
                      <span class="btn-inner--icon text-primary font-weight-bolder">
                      <svg  height="16" width="16" viewBox="0 0 512 512"><path d="M32 96l320 0V32c0-12.9 7.8-24.6 19.8-29.6s25.7-2.2 34.9 6.9l96 96c6 6 9.4 14.1 9.4 22.6s-3.4 16.6-9.4 22.6l-96 96c-9.2 9.2-22.9 11.9-34.9 6.9s-19.8-16.6-19.8-29.6V160L32 160c-17.7 0-32-14.3-32-32s14.3-32 32-32zM480 352c17.7 0 32 14.3 32 32s-14.3 32-32 32H160v64c0 12.9-7.8 24.6-19.8 29.6s-25.7 2.2-34.9-6.9l-96-96c-6-6-9.4-14.1-9.4-22.6s3.4-16.6 9.4-22.6l96-96c9.2-9.2 22.9-11.9 34.9-6.9s19.8 16.6 19.8 29.6l0 64H480z"/></svg></span>
                      <span class="btn-inner--text text-primary font-weight-bolder"> Return</span>
                    </a>
                    ';
  ?>
  </head>
  <?php include("include/sidebar.php"); ?>
    <div class="main-content" id="panel">
      <?php
        include("include/topnav.php"); 
        include("include/snackbar.php"); 
        include "include/breadcrumbs.php";
      ?>
    <!--ADD MODAL-->
    <div class="col-md-4">
      <div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
        <div class="modal-dialog modal- modal-dialog-centered modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-body p-0">
              <div class="card bg-blue border-0 mb-0">
                <div class="card-body px-lg-5 py-lg-5">
                  <div class="text-center form-control-label mb-4 text-white">
                    <span>Issue a Book</span>
                  </div>
                  <form action="book_issuance_controller.php" role="form" method="post">
                    <div class="row">
                      <div class="col">
                        <div class="form-group mb-2">
                          <label class="form-control-label mb-0 text-white">Book </label>
                          <div class="input-group input-group-merge input-group-alternative">
                            <select class="form-control" name="book" id="book" placeholder="Select Book" title="Enter Book" oninvalid="this.setCustomValidity('Please enter a book.')" oninput="setCustomValidity('')" required>
                              <option value="" selected>Select Book</option>
                              <?php
                                try{
                                  $query= "SELECT `id`,`title` FROM `book` WHERE `quantity`> 0 ";
                                  $stmt = $con->prepare($query);
                                  $stmt->execute();
                                  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                }catch(Exception $e){
                                    $_SESSION['error']='Something went wrong accessing book list.';
                                }
                                foreach ($result as $row) {
                                  echo"<option value=".$row['id'].">".$row['title']."</option>";
                                }
                              ?>
                            </select>
                          </div>

                        </div>
                      </div>
                      <div class="col">
                        <div class="form-group mb-2">
                          <label class="form-control-label mb-0 text-white">Student </label>
                          <div class="input-group input-group-merge input-group-alternative">
                          <select class="form-control" name="student" id="student" placeholder="Select Student" title="Enter student" oninvalid="this.setCustomValidity('Please enter a student.')" oninput="setCustomValidity('')" required>
                              <option value="" selected>Select Student</option>
                              <?php
                              try {
                                  $query = "SELECT `id`, CONCAT(`lastname`, ', ', `firstname`) AS `full_name` FROM `user` WHERE `type` = ?";
                                  $stmt = $con->prepare($query);
                                  $stmt->execute(['student']);
                                  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                  foreach ($result as $row) {
                                      echo "<option value=" . $row['id'] . ">" . htmlentities($row['full_name']) . "</option>";
                                  }
                              } catch (Exception $e) {
                                  $_SESSION['error'] = 'Something went wrong accessing student list.';
                              }
                              ?>
                          </select>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col">
                        <div class="form-group mb-2">
                          <label class="form-control-label mb-0 text-white">Return Date </label>
                          <div class="input-group input-group-merge input-group-alternative">
                            <input id="return_date" name="return_date" class="form-control" placeholder="Return Date" type="date" title="Enter date" oninvalid="this.setCustomValidity('Please enter the genre.')" oninput="setCustomValidity('')" required>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col">
                        <div class="form-group mb-2">
                          <label class="form-control-label mb-0 text-white">Return Date </label>
                          <div class="input-group input-group-merge input-group-alternative">
                            <input id="remarks" name="remarks" class="form-control" placeholder="Remarks..." type="text" title="Enter remarks" oninvalid="this.setCustomValidity('Please enter the remarks.')" oninput="setCustomValidity('')" >
                          </div>
                        </div>
                      </div>
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
    <!--END ADD MODAL-->
    <!--RETURN MODAL-->
    <div class="col-md-4">
      <div class="modal fade" id="modal-return" tabindex="-1" role="dialog" aria-labelledby="modal-return" aria-hidden="true">
        <div class="modal-dialog modal- modal-dialog-centered modal-sm" role="document">
          <div class="modal-content">
            <div class="modal-body p-0">
              <div class="card bg-blue border-0 mb-0">
                <div class="card-body px-lg-5 py-lg-5">
                  <div class="text-center form-control-label mb-4 text-white">
                    <span>Return a Book</span>
                  </div>
                  <form action="book_issuance_controller.php" role="form" method="post">
                    <div class="row">
                      <div class="col">
                        <div class="form-group mb-2">
                          <label class="form-control-label mb-0 text-white">Book </label>
                          <div class="input-group input-group-merge input-group-alternative">
                            <select class="form-control" name="return_book_id" id="return_book_id" placeholder="Select Book" title="Enter Book" oninvalid="this.setCustomValidity('Please enter a book.')" oninput="setCustomValidity('')" required>
                              <option value="" selected>Select Book</option>
                              <?php
                                try{
                                  $query= "SELECT `book`.`id`,`book`.`isbn` FROM `book_issuance`
                                  INNER JOIN `book` ON `book`.`id` = `book_issuance`.`book_id`
                                  WHERE `book_issuance`.`is_return`=?";
                                  $stmt = $con->prepare($query);
                                  $stmt->execute(['-1']);
                                  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                }catch(Exception $e){
                                    $_SESSION['error']='Something went wrong accessing book list.';
                                }
                                foreach ($result as $row) {
                                  echo"<option value=".$row['id'].">".$row['isbn'] ."</option>";
                                }
                              ?>
                            </select>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col">
                        <div class="form-group mb-2">
                          <label class="form-control-label mb-0 text-white">Student </label>
                          <div class="input-group input-group-merge input-group-alternative">
                            <select class="form-control" name="return_student_id" id="return_student_id" placeholder="Select Student" title="Enter student" oninvalid="this.setCustomValidity('Please enter a student.')" oninput="setCustomValidity('')" required>
                              <option value="" selected>Select Student</option>
                              <?php
                              try {
                                  $query = "SELECT `student`.`id`, CONCAT(`student`.`lastname`, ', ', `student`.`firstname`) AS `full_name`
                                  FROM `book_issuance`
                                  INNER JOIN `user` AS `student` ON `student`.`id` = `book_issuance`.`user_id`
                                  WHERE `student`.`type` =? AND `book_issuance`.`is_return`=?";
                                  $stmt = $con->prepare($query);
                                  $stmt->execute(['student','-1']);
                                  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                  foreach ($result as $row) {
                                      echo "<option value=" . $row['id'] . ">" . htmlentities($row['full_name']) . "</option>";
                                  }
                              } catch (Exception $e) {
                                  $_SESSION['error'] = 'Something went wrong accessing student list.';
                              }
                              ?>
                            </select>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="text-right">
									      <button type="reset" id="return-cancel-button" class="btn btn-primary my-4 sp-add bg-secondary text-primary font-weight-bolder" >Cancel</button>
                        <button type="submit" id="return" name="return" class="btn btn-primary my-4 sp-add bg-white text-primary font-weight-bolder" >Save</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <script>
        document.addEventListener("DOMContentLoaded", function () {
          var cancelButton = document.getElementById("return-cancel-button");
          var modal = document.getElementById("modal-return");
          cancelButton.addEventListener("click", function () {
            $(modal).modal("hide");
          });
        });
      </script>
    </div>
    <!--END RETURN MODAL-->
    <div class="container-fluid mt--6">
      <div class="row">
        <div class="col">
          <div class="card">
            <div class="card-header border-0">
              <div class="row">
                <div class="col-6">
                  <h3 class="mb-0">Book Issuance</h3>
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
                    <th>Book</th>
                    <th>Borrowed By</th>
                    <th>Issued Date</th>
                    <th>Return Date</th>
                    <th>Remarks</th>
                    <th>Penalty</th>
                    <th>Status</th>
                    <th>Option</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                    try{
                      $sql = "SELECT 
                                  `book_issuance`.*,
                                  `book_issuance`.`id` AS `book_issuance_id`,
                                  `book`.`id` AS `book_id`,
                                  `book`.`isbn` AS `book_isbn`,
                                  `book`.`title` AS `book_title`,
                                  `student`.`id` AS `student_id`,
                                  CONCAT(`student`.`lastname`, ', ', `student`.`firstname`) AS `student_name`,
                                  `book_issuance`.`penalty`
                              FROM `book_issuance`
                              INNER JOIN `book` ON `book`.`id` = `book_issuance`.`book_id`
                              INNER JOIN `user` AS `student` ON `student`.`id` = `book_issuance`.`user_id`
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
                      <td >
                        <?php $issue_date=(empty($row['issue_date']) ||$row['issue_date']==NULL)?'':date('Y-m-d', strtotime($row['issue_date'])); ?>
                        <label class="font-weight-bold"><?php echo htmlentities($issue_date); ?></label>
                      </td>
                      <td >
                        <?php $return_date=(empty($row['return_date']) ||$row['return_date']==NULL)?'':date('Y-m-d', strtotime($row['return_date'])); ?>
                        <label class="font-weight-bold"><?php echo htmlentities($return_date); ?></label>
                      </td>
                      <td>
                        <?php $remarks = (!isset($row['remarks']) || $row['remarks'] == NULL) ? 'None' : ($row['remarks']); ?>
                        <label class="font-weight-bold"> <?php echo htmlentities(short_text($remarks)); ?></label>
                      </td>
                      <td >
                        <?php $penalty=(empty($row['penalty']) ||$row['penalty']==NULL)?'0.00':number_format($row['penalty'], 2); ?>
                        <label class="font-weight-bold">&#8369; <?php echo htmlentities($penalty); ?></label>
                      </td>
                      <td class="text-left">
                        <?php    
                          $status = (empty($row['is_return']) ||$row['is_return']==NULL)?0:$row['is_return'];;
                          if ($status >0) echo '<span class="badge badge-success"> Returned </span>';
                          else  echo '<span class="badge badge-danger"> Not Returned </span>';
                        ?>                      
                      </td>
                      <td class="text-right">
                        <div class="dropdown">
                          <a class="btn btn-sm btn-icon-only bg-light rounded-circle shadow text-primary" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v"></i>
                          </a>
                          <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow py-0"> 
                            <?php 
                              if ( $penalty > 0){
                            ?>
                            <a class="dropdown-item" data-id="<?php echo $row['book_issuance_id'] ?>" style="color: black;" type="button" data-toggle="modal" data-target="#modal-edit-form<?php echo $row['book_issuance_id']; ?>"><svg  height="1rem" width="18" viewBox="0 0 576 512"><path d="M64 64C28.7 64 0 92.7 0 128V384c0 35.3 28.7 64 64 64H512c35.3 0 64-28.7 64-64V128c0-35.3-28.7-64-64-64H64zm64 320H64V320c35.3 0 64 28.7 64 64zM64 192V128h64c0 35.3-28.7 64-64 64zM448 384c0-35.3 28.7-64 64-64v64H448zm64-192c-35.3 0-64-28.7-64-64h64v64zM288 160a96 96 0 1 1 0 192 96 96 0 1 1 0-192z"/></svg>Pay Penalty</a>
                            <?php
                              } else{
                            ?>
                            <div class="d-flex align-items-center">
                                <span class="badge badge-danger w-100" style="height:30px;"> No Penalty </span>
                            </div>
                            <?php
                              }
                            ?>
                          </div>
                        </div>
                      </td>
                    </tr>
                    <div class="col-md-4">
                      <div class="modal fade" id="modal-edit-form<?php echo $row['book_issuance_id'];?>" tabindex="-1" role="dialog" aria-labelledby="modal-edit-form" aria-hidden="true">
                        <div class="modal-dialog modal- modal-dialog-centered modal-sm" role="document">
                          <div class="modal-content">
                            <div class="modal-body p-0">
                              <div class="card bg-blue border-0 mb-0">
                                <div class="card-body px-lg-5 py-lg-5">
                                  <div class="text-center text-white font-weight-bolder form-control-label mb-4">
                                    <span>Pay Penalty</span>
                                  </div>
                                  <form role="form" method="post" action="book_issuance_controller.php">

                                    <input id="book_issuance_id" name="book_issuance_id" class="id form-control" value="<?php echo $row['book_issuance_id']?>"  type="hidden" required>
                              
                                    <div class="form-group mb-2">
                                      <label class="form-control-label mb-0 text-white">Penlaty </label>
                                      <div class="input-group input-group-merge input-group-alternative">
                                        <input value="<?php echo htmlspecialchars($row['penalty']);?>" id="penalty" name="penalty" class="form-control" placeholder="Enter description"  readonly>
                                      </div>
                                    </div>
                                    <div class="form-group mb-2">
                                      <label class="form-control-label mb-0 text-white">Amount </label>
                                      <div class="input-group input-group-merge input-group-alternative">
                                        <input  class="form-control" id="amount" name="amount" placeholder="Enter amount" title="Enter amount"  oninvalid="this.setCustomValidity('Please enter an amount.')" oninput="setCustomValidity('')" required>
                                      </div>
                                    </div>

                                    <div class="text-right">
                                      <button type="reset" id="cancel-button<?php echo $row['book_issuance_id'];?>" class="btn btn-primary my-4 sp-add bg-secondary text-primary font-weight-bolder" >Cancel</button>
                                      <button type="submit" id="pay" name="pay" class="btn btn-primary my-4 bg-white text-primary font-weight-bolder">Save</button>
                                    </div>
                                  </form>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
								<script>
									document.addEventListener("DOMContentLoaded", function () {
										// Get a reference to the cancel button
										var cancelButton = document.getElementById("cancel-button<?php echo $row['id'];?>");

										// Get a reference to the modal
										var modal = document.getElementById("modal-edit-form<?php echo $row['id'];?>");

										// Add a click event listener to the cancel button
										cancelButton.addEventListener("click", function () {
											// Use Bootstrap's modal function to close the modal
											$(modal).modal("hide");
										});
									});
								</script>
							</div> 
                  <?php $cnt = $cnt + 1;
                  } //while
                }catch(Exception $e){
                  $_SESSION['error']='Something went wrong in accessing book issuance data.';
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
