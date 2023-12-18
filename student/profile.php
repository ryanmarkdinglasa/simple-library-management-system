<?php
	error_reporting(E_ALL);
	session_start();
	include("include/session.php");
	include("include/header.php");
	//include("../include/function.php");
	
	//UPDATE PROFILE INFO
	if (isset($_POST['update-profile'])) {
		$password_valid =  $_POST["password_valid"];
		$username = $_POST['username'];
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		$phone_no = $_POST['phone_no'];
		$age = $_POST['age'];
		$email = $_POST['email'];
		$address = trim($_POST['address']);
		$numbersRegex = '/^[0-9]+$/';
		$digitRegex = '/^\d{10}$/';
		$address_pattern = "/^[a-zA-Z0-9\s\-\.,#]+$/";
		$result;
		//parameters
		if (empty($username) || empty($firstname) || empty($lastname)  || empty($email) || empty($age) || empty($address) || empty($phone_no)){
			
			$_SESSION['error'] = "Please fill in all fields. user:".$username. " firstname:".$firstname." lastanme:".$lastname." age:".$age." address:".$address." phone_no:".$phone_no;
			echo" <script> window.location.href='profile.php'; </script>";
			exit();
		}
		if (!preg_match("/^\S+@\S+\.\S+$/", $email)) {
			$_SESSION['error'] = "Invalid email address.";
			echo" <script> window.location.href='profile.php'; </script> ";
			exit();
		}
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$_SESSION['error'] = "Invalid email address.";
			echo" <script> window.location.href='profile.php'; </script> ";
			exit();
		}
		if (!preg_match($numbersRegex, $phone_no) || !preg_match($digitRegex, $phone_no) || substr($phone_no, 0, 1) !== "9"  || strlen($phone_no)!= 10) {
			$_SESSION['error'] = "Mobile number format is 9XX-XXX-XXXX.";
			echo" <script> window.location.href='profile.php'; </script> ";
			exit();
		}
	
		if (!preg_match('/^[a-zA-Z\s]+$/', $firstname)|| !preg_match('/^[a-zA-Z\s]+$/', $lastname) ) {
		$_SESSION['error'] = "Name should only contain letters.";
		echo" <script> window.location.href='profile.php'; </script> ";
		exit();
		}
		
		if(!preg_match('/^[a-zA-Z0-9\s\-\.,#]+$/', $address)){
			$_SESSION['error'] = "Special characters in address are not allowed.";
			echo" <script> window.location.href='profile.php'; </script> ";
			exit();
		}

		$check_username = getrecord('user', ['username'], [$username]);
		if (!empty($check_username) && ($check_username['username']!=$user['username'])) {
			$_SESSION['error'] = "Username is already taken.";
			echo" <script> window.location.href='profile.php'; </script> ";
			exit();
		}

		//validate password
		$stmt = $con->prepare("SELECT * FROM `user` WHERE `id` = ?");
		$stmt->execute([$user['id']]);
		$count = $stmt->rowCount();
		
		if ($count > 0) {
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			$user_id = $row['id'];
			if (!password_verify($password_valid, $row["password"])) {
				$_SESSION['error'] = "Password is incorrect.";
				echo" <script> window.location.href='profile.php'; </script> ";
				exit();
			}
			// Update user profile
			$field = ['id','username', 'firstname', 'lastname', 'phone_no', 'email', 'age', 'address'];
			$data = [ $user_id, $username, $firstname, $lastname, $phone_no, $email, $age,  $address];
			$result = updaterecord('user', $field, $data);
			if(!$result){
				$_SESSION['error'] = "Something went wrong in updating profile information.";
				echo" <script> window.location.href='profile.php'; </script> ";
				exit();
			}else{
				$_SESSION['success'] = "Profile updated.";
				echo" <script> window.location.href='profile.php'; </script> ";
				exit();
			}
		}//count
		else{
			$_SESSION['error'] = "Something went wrong user is not in session.";
			echo" <script> window.location.href='profile.php'; </script> ";
			exit();
		}
	}//UPDATE PROFILE INFO
 
	//UPDATE PROFILE PHOTO
	if (isset($_POST['change-photo']) && isset($_FILES['fileToUpload'])) {
		define('KB', 1024);
		define('MB', 1048576);
		define('GB', 1073741824);
		define('TB', 1099511627776);
		$imgfile = $_FILES["fileToUpload"]["name"];
		$target_dir = "img/";
		$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
		$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
		// // get the image extension
		if ($imgfile === "" || $imgfile===NULL ) {
			$_SESSION['error']='Please select and image.';
			echo" <script> window.location.href='profile.php'; </script> ";
			exit();
		}
		$extension = substr($imgfile, strlen($imgfile) - 4, strlen($imgfile));
		if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
			$_SESSION['error']='The only allowed files are JPG, PNG and JPEG.';
			echo" <script> window.location.href='profile.php'; </script> ";
			exit();
		} else {
			if ($_FILES["fileToUpload"]["size"] > 2 * MB){
				$_SESSION['error']='Image file size is more than 2 MB';
				echo" <script> window.location.href='profile.php'; </script> ";
				exit();
			}
			else{
			//rename the image file
			$imgnewfile = md5($imgfile) . uniqid() . $extension;
			// Code for move image into directory
			move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], "img/" . $imgnewfile);
			// Query for insertion data into database
			try{
				$stmt = $con->prepare("UPDATE `user` SET `image`=? WHERE `id`=?");
				$stmt->execute([$imgnewfile, $user['id']]);
			}catch(Exception $e){
				$_SESSION['error']='Sorry, the photo failed to change. try again.';
				echo" <script> window.location.href='profile.php'; </script> ";
				exit();
			} 
		  }
		}
	}//UPDATE PROFILE PHOTO

  // password admin : $2y$10$biOI1T7.vdq0kgCOmv6vC.ndpob2oi26QqCmWg4wcxrJV9K8FR8Qu
	if (isset($_POST['change-pass'])) {
		$password = trim($_POST["password"]);
		$newpassword = trim($_POST["newpassword"]);
		$confirmpassword = trim($_POST["confirmpassword"]);
		$passwordhash = password_hash($password, PASSWORD_DEFAULT);
		$newpasswordhash = password_hash($newpassword, PASSWORD_DEFAULT);
		
		if(!password_verify($password,$user['password'])){
			$_SESSION['error'] = "Current password is incorrect.";
			echo" <script> window.location.href='profile.php'; </script> ";
			exit();
		}
		if($newpassword!==$confirmpassword){
			$_SESSION['error'] = "The password entered doesn't match.";
			echo" <script> window.location.href='profile.php'; </script> ";
			exit();
		}else{
			try {
				$stmt = $con->prepare("UPDATE `user` SET `password`=?  WHERE `id`=?");
				$stmt->execute([$newpasswordhash, $user['id']]);
			} catch (Exception $e) {
				$_SESSION['error'] = 'Something went wrong in validating password. Please try again.';
				echo" <script> window.location.href='profile.php'; </script> ";
				exit();
			}
			echo" <script> window.location.href='profile.php'; </script> ";
			exit();
		} 
	}


?>
	<script>
		function userAvailability() {
		  $("#loaderIcon").show();
		  jQuery.ajax({
			url: "check_username.php",
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
	<script type="text/javascript">
    function valid() {
      if (document.chngpwd.password.value == "") {
        //alert("Old password cannot be empty.");
        $("#current-password").css({ 
			"border" :"1px solid red",
			"color" :"red",
		});
		$("#current-password").fadeIn("slow");
		$("#current-password").focus();
        return false;
      } else if (document.chngpwd.newpassword.value == "") {
        alert("New Password cannot be empty.");
        //document.chngpwd.newpassword.focus();
		$("#new-password").css({ 
			"border" :"1px solid red",
			"color" :"red",
		});
		$("#new-password").fadeIn("slow");
		$("#new-password").focus();
        return false;
      } else if (document.chngpwd.confirmpassword.value == "") {
        //alert("Repeat your new password.");
        //document.chngpwd.confirmpassword.focus();
		$("#confirm-password").css({ 
			"border" :"1px solid red",
			"color" :"red",
		});
		$("#confirm-password").fadeIn("slow");
		$("#confirm-password").focus();
        return false;
      } else if (document.chngpwd.newpassword.value != document.chngpwd.confirmpassword.value) {
        //alert("New passwords don't match.");
        //document.chngpwd.confirmpassword.focus();
		$("#confirm-password").css({ 
			"border" :"1px solid red",
			"color" :"red",
		});
		$("#confirm-password").fadeIn("slow");
		$("#confirm-password").focus();
        return false;
      }
      return true;
    }
	</script>
	<script>
		if (window.history.replaceState) {
		  window.history.replaceState(null, null, window.location.href);
		}
	</script>
	</head>
	<?php
		include("include/sidebar.php");
	?>
	<!-- Main content -->
	<div class="main-content" id="panel">
    <!-- Topnav -->
    <?php
		include("include/topnav.php"); 
		include("include/snackbar.php");
    ?>
    <!-- Header -->
    <div class="header bg-primary pb-6">
      <div class="container-fluid">
        <div class="header-body">
			<div class="row align-items-center py-4">
				<div class="col-lg-6 col-7">
				  <h6 class="h2 text-white d-inline-block mb-0">Dashboard</h6>
				  <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
					<ol class="breadcrumb breadcrumb-links breadcrumb-dark">
					  <li class="breadcrumb-item"><a href="./"><i class="fas fa-home"></i></a></li>
					  <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
					</ol>
				  </nav>
				</div>
			</div>
        </div>
      </div>
    </div>
      <!-- Page content -->
      <div class="container-fluid mt--6">
        <div class="row">
          <div class="col-xl-4 order-xl-2">
            <div class="card card-header">

              <div class="row justify-content-center" >
                <div class="col-lg-3 order-lg-2">
                  <div class="card-profile-image" >
                    <?php $userphoto = $user['image'];
                    if ($userphoto == "" || $userphoto == "NULL") :
                    ?>
                      <img src="img/default_pic.png" class="rounded-circle" style="width:150px;height:150px;border-radius:50%;hs">
                    <?php else : ?>
                      <img src="img/<?php echo $userphoto; ?>" class="rounded-circle" style="width:150px;height:150px;border-radius:50%;background:#f1f1f1;">
                    <?php endif; ?>
                  </div>
                </div>
              </div>
            <div class="card-header text-center border-0 pt-8 pt-md-4 pb-0 pb-md-4">

            </div>
            <div class="card-body pt-0">
              <div class="row">
                <div class="col">
                  <div class="card-profile-stats d-flex justify-content-center">

                  </div>
                </div>
              </div>

              <form method="post" enctype="multipart/form-data">
                <!-- Multiple -->
                <div class="custom-file">
                  <input type="file" name="fileToUpload" class="custom-file-input" id="fileToUpload" lang="id">
                  <label class="custom-file-label" for="fileToUpload">Select Files</label>
                </div>
                <div class="text-right pt-4 pt-md-4 pb-0 pb-md-4">
                  <div>
                    <button type="submit" name="change-photo" class="btn btn-sm btn-default float-right">Change Photo</button>
                  </div>
              </form>
            </div>
            </div>
          </div>
        <!---CHANGFE PASSWORD-->
        <div class="card">
            <div class="card-header">
              <h5 class="h3 mb-0">Change Password</h5>
            </div>
            <div class="card-body ">
            <form action="" method="POST" name="chngpwd" onSubmit="return valid();">
                <ul class="list-group list-group-flush list my--3">
                  <div class="col-lg-12">
                    <div class="form-group">
                      <label class="form-control-label">Current Password</label>
                      <input type="password" id='current-password' name="password" class="form-control" placeholder="Enter the current Password" title="Enter Password" oninvalid="this.setCustomValidity('Please enter your password.')" oninput="setCustomValidity('')" required>
                    </div>
                  </div>
                  <div class="col-lg-12">
                    <div class="form-group">
                      <label class="form-control-label">New Password</label>
                      <input type="password" id='new-password' name="newpassword" class="form-control" placeholder="Enter New Password" title="Enter New Password" oninvalid="this.setCustomValidity('Please enter your new password.')" oninput="setCustomValidity('')" required>
                    </div>
                  </div>
                  <div class="col-lg-12">
                    <div class="form-group">
                      <label class="form-control-label">Repeat New Password</label>
                      <input type="password" id='confirm-password' name="confirmpassword" class="form-control" placeholder="Repeat New Password" title="Repeat Enter New Password" oninvalid="this.setCustomValidity('Please repeat enter your new password.')" oninput="setCustomValidity('')" required>
                    </div>
                  </div>
                </ul>
					<div class="text-right pt-4 pt-md-4 pb-0 pb-md-4">
					  <button type="button" class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#modal-notification">Change Password</button>
					  <div class="modal fade" id="modal-notification" tabindex="-1" role="dialog" aria-labelledby="modal-notification" aria-hidden="true">
						<div class="modal-dialog modal-danger modal-dialog-centered modal-" role="document">
						  <div class="modal-content bg-gradient-green">
							<div class="modal-header">
							  <h6 class="modal-title" id="modal-title-notification">Are you sure you want to change the password?</h6>
							  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">×</span>
							  </button>
							</div>
							<div class="modal-body">
							  <div class="py-3 text-center">
								<i class="ni ni-bell-55 ni-3x"></i>
								<h4 class="heading mt-4">Terms of changing passwords</h4>
								<p>Changing your current password will change your account password on the system including the Sign-in process.
								  After successfully changing, you will automatically Sign-out of the system and can enter again using your new password.</p>
							  </div>
							</div>
							<div class="modal-footer">
							  <button type="submit" name="change-pass" class="btn btn-white ">Understand & Change Password</button>
							  <button class="btn btn-white  ml-auto" data-dismiss="modal">Cancel</button>
							</div>
						  </div>
						</div>
					  </div>
					</div>
				</div>
            </form>
        </div>
		  <!---CHANGFE PASSWORD-->
        </div>
        <div class="col-xl-8 order-xl-1">
          <div class="row">
          </div>
          <div class="card">
            <div class="card-header">
              <div class="row align-items-center">
                <div class="col-8">
                  <h3 class="mb-0">Edit profile </h3>
                </div>
                <div class="col-4 text-right">

                </div>
              </div>
            </div>
            <div class="card-body">
              <form name="dosen" method="post">
                  <h6 class="heading-small text-muted mb-4">User Information</h6>
                  <div class="pl-lg-4">
                    <div class="row">
                      <div class="col-lg-6">
                        <div class="form-group">
                          <label class="form-control-label" for="input-username">Username</label>
                          <div class="input-group input-group-merge">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                            </div>
							<?php 
							$username = isset($user['username']) ? htmlspecialchars($user['username'], ENT_QUOTES, 'UTF-8') : '';
							?>
                            <input type="text" onBlur="userAvailability()" id="username" name="username" class="form-control" placeholder="Username" value="<?php echo $username; ?>">
                            <div class="input-group-append">
                              <span class="input-group-text" id="user-availability-status1"></span>
                            </div>
                          </div>
                          <span id="user-availability-status1"></span>
                        </div>
                      </div>
					  <div class="col-lg-6">
                        <div class="form-group">
                          <label class="form-control-label" for="input-last-name">Mobile No.</label>
                          <div class="input-group input-group-merge">
                            <div class="input-group-prepend">
                              <span class="input-group-text"> +63 |</span>
                            </div>
							<?php 
							$phone_no = isset($user['phone_no']) ? htmlspecialchars($user['phone_no'], ENT_QUOTES, 'UTF-8') : '';
							?>
                            <input type="tel" id="phone_no" name="phone_no" maxlength="10" class="form-control" placeholder="Mobile No." value="<?php echo $phone_no; ?>">
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-lg-6">
                        <div class="form-group">
                          <label class="form-control-label" for="input-first-name">Full name</label>
                          <div class="input-group input-group-merge">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="fas fa-user"></i></span>
                            </div>
							<?php 
							$firstname = isset($user['firstname']) ? htmlspecialchars($user['firstname'], ENT_QUOTES, 'UTF-8') : '';
							?>
                            <input type="text" id="firstname" name="firstname" class="form-control" placeholder="First name" value="<?php echo $firstname; ?>">
                          </div>
                        </div>
                      </div>
					  <div class="col-lg-6">
                        <div class="form-group">
                          <label class="form-control-label" for="input-first-name">&nbsp;</label>
                          <div class="input-group input-group-merge">
                            <div class="input-group-prepend">
                              <span class="input-group-text"></span>
                            </div>
							<?php 
							$lastname = isset($user['lastname']) ? htmlspecialchars($user['lastname'], ENT_QUOTES, 'UTF-8') : '';
							?>
                            <input type="text" id="lastname" name="lastname" class="form-control" placeholder="Last Name" value="<?php echo $lastname; ?>">
                          </div>
                        </div>
                      </div>
                      
                    </div>
                    <div class="row">
                      <div class="col-lg-6">
                        <div class="form-group">
                          <label class="form-control-label" for="input-first-name">Age</label>
                          <div class="input-group input-group-merge">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                            </div>
							<?php 
							$age = isset($user['age']) ? htmlspecialchars($user['age'], ENT_QUOTES, 'UTF-8') : '';
							?>
                            <input class="form-control"  name="age" id="age" placeholder="Enter age" type="number" value="<?php echo $user['age']; ?>">
                          </div>

                        </div>
                      </div>
                    </div>
                  </div>
                  <hr class="my-4" />
                  <!-- Address -->
                  <h6 class="heading-small text-muted mb-4">Contact Information</h6>
				  <div class="pl-lg-4">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="form-control-label" for="input-address">Email address</label>
							<?php 
							$email = isset($user['email']) ? htmlspecialchars($user['email'], ENT_QUOTES, 'UTF-8') : '';
							?>
                          <input id="input-email" name="email" class="form-control" placeholder="current email" value="<?php echo $email; ?>" type="email">
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="pl-lg-4">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="form-control-label" for="input-address">Current address</label>
							<?php 
							$address = isset($user['address']) ? htmlspecialchars($user['address'], ENT_QUOTES, 'UTF-8') : '';
							?>
                          <input id="input-address" name="address" class="form-control" placeholder="current address" value="<?php echo $address; ?>" type="text">
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="text-right pt-4 pt-md-4 pb-0 pb-md-4">
                  <button type="button" data-toggle="modal" data-target="#modal-form" class="btn btn-sm btn-primary update-profile">Change Data</button>
                  </div>

                  <!--  -->
                  <div class="col-md-4">
                    <div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
                      <div class="modal-dialog modal- modal-dialog-centered modal-sm" role="document">
                        <div class="modal-content">
                          <div class="modal-body p-0">
                            <div class="card bg-secondary border-0 mb-0">

                              <div class="card-body px-lg-5 py-lg-5">
                                <div class="text-center text-muted mb-4">
                                  <small>Enter the password to change the data</small>
                                </div>

                                <div class="form-group">
                                  <div class="input-group input-group-merge input-group-alternative">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                    </div>
                                    <input class="form-control" name="password_valid" placeholder="Password" type="password" title="Enter Password" oninvalid="this.setCustomValidity('Please Enter your Password.')" oninput="setCustomValidity('')" required>
                                  </div>
                                </div>
                                <div class="text-center">
                                  <button type="submit" id="update-profile" name="update-profile" class=" update-profile btn btn-primary my-4 ">Change Data</button>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
              </form>
            </div>
          </div>
        </div>
      </div>
				<?php
					include("include/footer.php"); //Edit topnav on this page
				?>
				<script>
					$('.select2').select2();
				</script>
				<script src="js/app.js"></script>
				<script>
					$.fn.datepicker.defaults.format = "dd/mm/yyyy";
					$('.date_birth').datepicker({
					  format: "yyyy-mm-dd",
					  language: "id",
					  todayHighlight: true
					});
				</script>
				<script>
					$(document).on('change', '.custom-file-input', function(event) {
						$(this).next('.custom-file-label').html(event.target.files[0].name);
					})
					
					//Responsive Checker for email
					const checkEmail = document.getElementById('username');
					checkEmail.addEventListener('change', () => {
					  const emailRegex = /^[a-zA-Z0-9\s]*$/;
					  if (!emailRegex.test(checkEmail.value)) {
						$("#username").css({ 
							"border" :"1px solid red",
							"color" :"red",
						});
						$("#username").fadeIn("slow");
						$("#username").focus();
						return false;
					  }else{
						  $("#username").css({ 
							"border" :"",
							"color" :"#000",
						});
						$("#username").fadeIn("slow");
					  }
					});
					//Responsive Checker for mobile number
					const checkMobileNo = document.getElementById('phone_no');
					checkMobileNo.addEventListener('change', () => {
					  const numbersRegex = /^[0-9]+$/;
					  const digitRegex = /^\d{10}$/;
					  if (!numbersRegex.test(checkMobileNo.value) || !digitRegex.test(checkMobileNo.value) || checkMobileNo.value.charAt(0) !== "9") {
						$("#phone_no").css({ 
						  "border" :"1px solid red",
						  "color" :"red",
						});
						$("#phone_no").fadeIn("slow");
						$("#phone_no").focus();
					  } else {
						$("#phone_no").css({ 
						  "border" :"",
						  "color" :"#000",
						});
						$("#phone_no").fadeIn("slow");
					  }
					});
				</script>
				<script>
					$(document).on("click", ".update-profile",function(){
						var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
						var lettersRegex = /^[a-zA-Z\s]+$/;
						var numbersRegex = /^[0-9]+$/;
						var specialCharactersRegex = /^[a-zA-Z0-9\s]*$/;
						var digitRegex = /^\d{10}$/;	
						var zipcodeRegex = /^\d{4}$/;	
						//check Email Input
						var username=document.getElementById("username").value.trim();
						if (username==='') {
							 $("#username").css({ 
								"border" :"1px solid red",
							});
							$("#username").fadeIn("slow");
							$("#username").focus();
						   return false;
						}
						if(!specialCharactersRegex.test(username)){
							 $("#username").css({ 
								"border" :"1px solid red",
								"color" :"red",
							});
							$("#username").fadeIn("slow");
							$("#username").focus();
							return false;
						}
						//check firstname input if its blank or contains numbers
						var firstname=document.getElementById("firstname").value.trim();
						if (firstname==='') {
							 $("#firstname").css({ 
								"border" :"1px solid red",
							});
							$("#firstname").fadeIn("slow");
							$("#firstname").focus();
						   return false;
						}
						if (!lettersRegex.test(firstname)) {
							 $("#firstname").css({ 
								"border" :"1px solid red",
								"color" :"red",
							});
							$("#firstname").fadeIn("slow");
							$("#firstname").focus();
						   return false;
						}
						
						//check firstname input if its blank or contains numbers
						var middlename=document.getElementById("middlename").value.trim();
						if (middlename!=='' && !lettersRegex.test(middlename)) {
							 $("#middlename").css({ 
								"border" :"1px solid red",
								"color"  :"red",
							});
							$("#middlename").fadeIn("slow");
							$("#middlename").focus();
						   return false;
						}
						
						//check lastname input if its blank or contains numbers
						var lastname=document.getElementById("lastname").value.trim();
						if (lastname==='') {
							 $("#lastname").css({ 
								"border" :"1px solid red",
							});
							$("#lastname").fadeIn("slow");
							$("#lastname").focus();
						   return false;
						}
						if (!lettersRegex.test(lastname)) {
							 $("#lastname").css({ 
								"border" :"1px solid red",
								"color" :"red",
							});
							$("#lastname").fadeIn("slow");
							$("#lastname").focus();
						   return false;
						}

						//check contact_no input if its blank or contains letters or special characters
						var phone_no=document.getElementById("phone_no").value.trim();
						if (phone_no==='') {
							 $("#phone_no").css({ 
								"border" :"1px solid red",
							});
							$("#phone_no").fadeIn("slow");
							$("#phone_no").focus();
						   return false;
						}
						if (phone_no.charAt(0) !== "9") {
							 $("#phone_no").css({ 
								"border" :"1px solid red",
								"color" :"red",
							});
							$("#phone_no").fadeIn("slow");
							$("#phone_no").focus();
						   return false;
						}
						if (!numbersRegex.test(phone_no)) {
							 $("#phone_no").css({ 
								"border" :"1px solid red",
								"color" :"red",
							});
							$("#phone_no").fadeIn("slow");
							$("#phone_no").focus();
						   return false;
						}
						if (!digitRegex.test(phone_no)) {
							 $("#phone_no").css({ 
								"border" :"1px solid red",
								"color" :"red",
							});
							$("#phone_no").fadeIn("slow");
							$("#phone_no").focus();
						   return false;
						}
						//check birthdate input if its blank 
						var birthdate=document.getElementById("birthdate").value.trim();
						if (birthdate==='') {
							 $("#birthdate").css({ 
								"border" :"1px solid red",
							});
							$("#birthdate").fadeIn("slow");
							$("#birthdate").focus();
						   return false;
						}
						// Check if the age is above 15
						const today = new Date();
						const minAgeDate = new Date(today.getFullYear() - 15, today.getMonth(), today.getDate());
						const selectedDate = new Date(birthdate.slice(0, 4), birthdate.slice(5, 7) - 1, birthdate.slice(8, 10));
						if (selectedDate > minAgeDate) {
						  $("#birthdate").css({
							"border": "1px solid red",
						  });
						  $("#birthdate").fadeIn("slow");
						  $("#birthdate").focus();
						  return false;
						}
					});
				</script>
			</div>
		</div>
	</body>
</html>
<?// }?>