<?php
    session_start();
    include("include/session.php");
    $parentpage = "";
    $parentpage_link= "#";
    $currentpage='Book';
    $childpage = $page = "Book";
    include("include/header.php");
    $content_right='';
    $content_right='<a type="button" data-toggle="modal" data-target="#modal-form" class="btn btn-round btn-icon bg-white text-primary" >
                      <span class="btn-inner--icon text-primary font-weight-bolder"><i class="fas fa-plus"></i></span>
                      <span class="btn-inner--text text-primary font-weight-bolder"> New</span>
                    </a>';
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
                    <span>Add New Book</span>
                  </div>
                  <form action="book_controller.php" role="form" method="post">
                    <div class="row">
                      <div class="col">
                        <div class="form-group mb-2">
                          <label class="form-control-label mb-0 text-white">Title </label>
                          <div class="input-group input-group-merge input-group-alternative">
                            <input id="title" name="title" class="form-control" placeholder="Title" type="text" title="Enter title" oninvalid="this.setCustomValidity('Please enter the new book title.')" oninput="setCustomValidity('')" required>
                          </div>
                        </div>
                      </div>
                      <div class="col">
                        <div class="form-group mb-2">
                          <label class="form-control-label mb-0 text-white">ISBN </label>
                          <div class="input-group input-group-merge input-group-alternative">
                            <input id="isbn" name="isbn" class="form-control" placeholder="ISBN" type="text" title="Enter isbn" oninvalid="this.setCustomValidity('Please enter the new book ISBN.')" oninput="setCustomValidity('')" required>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col">
                        <div class="form-group mb-2">
                          <label class="form-control-label mb-0 text-white">Author </label>
                          <div class="input-group input-group-merge input-group-alternative">
                            <input id="author" name="author" class="form-control" placeholder="Author" type="text" title="Enter author" oninvalid="this.setCustomValidity('Please enter the author.')" oninput="setCustomValidity('')" required>
                          </div>
                        </div>
                      </div>
                      <div class="col">
                        <div class="form-group mb-2">
                          <label class="form-control-label mb-0 text-white">Genre </label>
                          <div class="input-group input-group-merge input-group-alternative">
                            <input id="genre" name="genre" class="form-control" placeholder="Genre" type="text" title="Enter genre" oninvalid="this.setCustomValidity('Please enter the genre.')" oninput="setCustomValidity('')" required>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                 
                      <div class="col">
                        <div class="form-group mb-2">
                          <label class="form-control-label mb-0 text-white">Price </label>
                          <div class="input-group input-group-merge input-group-alternative">
                            <input id="book_price" name="book_price" class="form-control" placeholder="Price" type="number" title="Enter book's price" oninvalid="this.setCustomValidity('Please enter the price.')" oninput="setCustomValidity('')" required>
                          </div>
                        </div>
                      </div>
                      
                      <div class="col">
                        <div class="form-group mb-2">
                          <label class="form-control-label mb-0 text-white">Quantity </label>
                          <div class="input-group input-group-merge input-group-alternative">
                            <input id="quantity" name="quantity" class="form-control" placeholder="Quantity" type="number" title="Enter quantity" oninvalid="this.setCustomValidity('Please enter the quantity.')" oninput="setCustomValidity('')" required>
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
    <div class="container-fluid mt--6">
      <div class="row">
        <div class="col">
          <div class="card">
            <div class="card-header border-0">
              <div class="row">
                <div class="col-6">
                  <h3 class="mb-0">Book List</h3>
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
                    <th>Author</th>
                    <th>Price</th>
					          <th>Genre</th>
                    <th>Qty</th>
                    <th>Date</th>
                    <th>Option</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                    try{
                      $stmt = $con->prepare(" SELECT * FROM `book` ORDER BY `title` ASC ");
                      $stmt->execute();
                      $cnt = 1;
                      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                  ?>
                    <tr>
                      <td>
                          <label class="text-muted"><?php echo $cnt;?></label>
                      </td>
                      <td >
                        <?php $title=(empty($row['title']) ||$row['title']==NULL)?'':$row['title']; ?>
                        <label class="font-weight-bold"><?php echo htmlentities(short_text($title)); ?></label>
                      </td>
                      <td >
                        <?php $isbn=(empty($row['isbn']) ||$row['isbn']==NULL)?'':$row['isbn']; ?>
                        <label class="font-weight-bold"><?php echo htmlentities(short_text($isbn)); ?></label>
                      </td>
                      <td >
                        <?php $author=(empty($row['author']) ||$row['author']==NULL)?'':$row['author']; ?>
                        <label class="font-weight-bold"><?php echo htmlentities(short_text($author)); ?></label>
                      </td>
                      <td>
                        <?php 
                            $price = (!isset($row['book_price']) || $row['book_price'] == 0) ? '0.00' : number_format($row['book_price'], 2);
                        ?>
                        <label class="font-weight-bold">&#8369; <?php echo htmlentities($price); ?></label>
                      </td>
                      <td >
                        <?php $genre=(empty($row['genre']) ||$row['genre']==NULL)?'':$row['genre']; ?>
                        <label class="font-weight-bold"><?php echo htmlentities(short_text($genre)); ?></label>
                      </td>
                      <td>
                        <?php 
                            $quantity = (!isset($row['quantity']) || $row['quantity'] == 0) ? '' : ($row['quantity']);
                        ?>
                        <label class="font-weight-bold"> <?php echo htmlentities($quantity); ?></label>
                      </td>
					            <td>
                        <span class="text-muted">
                          <?php
                            $date=(empty($row['created_on']) ||$row['created_on']==NULL)?'':$row['created_on'];
                            $created_on = isset( $date) ? htmlspecialchars(created_on($date), ENT_QUOTES, 'UTF-8') : '';
                          ?>
                          <label title="<?php echo formatDate($date); ?>"> <?php echo $created_on; ?></label>
                        </span>
                      </td>
                     
                      <td class="text-left">
                      <?php 
                          if($quantity>0){
                            echo '<a class="btn btn-primary text-white btn-sm" data-id="'.$row["id"].'" type="button" data-toggle="modal" data-target="#modal-edit-form'.$row["id"].'"> Borrow </a>';
                          } else{
                            echo "<a href='#' class='btn btn-primary disabled text-white btn-sm'>Borrow</a>";
                          }
                        ?>
                      </td>
                    </tr>
                    <div class="col-md-4">
                      <div class="modal fade" id="modal-edit-form<?php echo $row['id'];?>" tabindex="-1" role="dialog" aria-labelledby="modal-edit-form" aria-hidden="true">
                        <div class="modal-dialog modal- modal-dialog-centered modal-lg" role="document">
                          <div class="modal-content">
                            <div class="modal-body p-0">
                              <div class="card bg-blue border-0 mb-0">
                                <div class="card-body px-lg-5 py-lg-5">
                                  <div class="text-center text-white font-weight-bolder form-control-label mb-4">
                                    <span>Borrow a Book</span>
                                  </div>
                                  <form role="form" method="post" action="book_controller.php">
                                    <input id="book_id" name="book_id" class="id form-control" value="<?php echo $row['id']?>"  type="hidden" required>
                                    <input id="student_id" name="student_id" class="id form-control" value="<?php echo $user['id']?>"  type="hidden" required>
                                  <div class="row">
                                    <div class="col">
                                      <div class="form-group mb-2">
                                        <label class="form-control-label mb-0 text-white">Book </label>
                                        <div class="input-group input-group-merge input-group-alternative">
                                          <input class="form-control" placeholder="Return Date" type="text" value="<?php echo $row['title'];?>"title="Enter date" oninvalid="this.setCustomValidity('Please enter the genre.')" oninput="setCustomValidity('')" readonly>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col">
                                      <div class="form-group mb-2">
                                        <label class="form-control-label mb-0 text-white">Student </label>
                                        <div class="input-group input-group-merge input-group-alternative">
                                          <input class="form-control" placeholder="Return Date" type="text" value="<?php echo $user['lastname'].', '.$user['firstname'];?>" readonly>
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
                                  <p class="mb-0"><small class="text-muted">Student can borrow a maximum of 3 per week.</small></p>
                                  <p class=""><small class="text-muted">Borrowed book that won't be returend on the said date, would have penalty.</small></p>
                                    <div class="text-right">
                                      <button type="reset" id="cancel-button<?php echo $row['id'];?>" class="btn btn-primary my-4 sp-add bg-secondary text-primary font-weight-bolder" >Cancel</button>
                                      <button type="submit" id="add" name="add" class="btn btn-primary my-4 bg-white text-primary font-weight-bolder">Save</button>
                                    </div>
                                  </form>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <script>
                          document.addEventListener("DOMContentLoaded", function () {
                            var cancelButton = document.getElementById("cancel-button<?php echo $row['id'];?>");
                            var modal = document.getElementById("modal-edit-form<?php echo $row['id'];?>");
                            cancelButton.addEventListener("click", function () {
                              $(modal).modal("hide");
                            });
                          });
                        </script>
                      </div>
                  <?php $cnt = $cnt + 1;
                  } //while
                }catch (Exception $e) {
                  $_SESSION['error'] = 'Something went wrong in accessing book data.' . $e->getMessage();
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
