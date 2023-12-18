 <?php
	error_reporting(0);
	session_start();
	include("include/conn.php");
	include("include/header.php");
	?>
	<style>
	   .content.cover {
		 border-radius: 20px;
	   }
	   body{
		background:rgb(239,241,242);
	   }
	</style>
	</head>
	<body class="">
	<!-- Main content -->
		<div class="main-content">
			<section class="py-2 pb-3 pt-6  " >
				<div class="container mt-2 pb-3 " >
					<div class="row justify-content-center " >
						<div class="col-lg-5 col-md-7" >
							<div class="card border-0 mb-0 card-4 shadow">
									<div class="card-header pb-0 text-start text-center bg-white ">
										<img src="img/favicon.jpg" width="80px" class="mb-2">
									  <h3 class="font-weight-bolder text-primary">Register</h3>
									</div>
									<form action="sign-up.php" method="POST" class="needs-validation">
										<div class="card-body ">
											<?php
												if (isset($_SESSION['error'])) {
													echo '
													<div class="alert alert-danger alert-dismissible fade show" role="alert">
													<span class="alert-text"><i class="fas fa-exclamation-circle">&nbsp</i><strong>' .$_SESSION['error'].'</strong></span>
													<button type="button" class="close" data-dismiss="alert" aria-label="Close">
													<span aria-hidden="true">&times;</span>
													</button>
												</div>';
													unset($_SESSION['error']);
												}
											?>
											<div class="mb-1">
												<label class="form-control-label text-primary mb-0">Full Name</label>
												<div class="input-group input-group-merge input-group-alternative">
													<input class="form-control" placeholder="First name" id="firstname" name="firstname" type="text" title="Enter first name" oninvalid="this.setCustomValidity('Please enter your first name.')" oninput="setCustomValidity('')" required>
													<input class="form-control" placeholder="Last name" id="lastname" name="lastname"  type="text" title="Enter last name" oninvalid="this.setCustomValidity('Please enter your last name.')" oninput="setCustomValidity('')" required>
												</div>
											</div>
											<div class="mb-1">
												<label class="form-control-label text-primary mb-0">Username</label>
												<div class="input-group input-group-merge input-group-alternative">
													<div class="input-group-prepend">
													<span class="input-group-text"><i class="fas fa-user"></i></span>
													</div>
													<input class="form-control" placeholder="Username" id="username" name="username" aria-describedby="inputGroupPrepend1" type="text" title="Enter username" oninvalid="this.setCustomValidity('Please enter your username.')" oninput="setCustomValidity('')" required>
												</div>
											</div>
											<div class="mb-0">
												<label class="form-control-label text-primary mb-0">Password</label>
												<div class="form-group">
													<div class="input-group input-group-merge input-group-alternative">
														<div class="input-group-prepend">
															<span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
														</div>
														<input class="form-control" id="password" placeholder="Password" name="password" type="password" title="Enter Password" oninvalid="this.setCustomValidity('Please enter your password.')" oninput="setCustomValidity('')" required>
														<div class="input-group-append">
															<span class="input-group-text"><i toggle="#password" class="fas fa-eye toggle-password"></i></span>
														</div>
													</div>
													
												</div>
											</div>
											
											<div class="mb-1" style="margin-top:-20px;">
												<label class="form-control-label text-primary mb-0">Age</label>
												<div class="input-group input-group-merge input-group-alternative">
													<input class="form-control" placeholder="Age" id="age" name="age"  type="number" title="Enter age" oninvalid="this.setCustomValidity('Please enter your age.')" oninput="setCustomValidity('')" required>
												</div>
											</div>
											<div class="mb-1">
												<label class="form-control-label text-primary mb-0">Phone No.</label>
												<div class="input-group input-group-merge input-group-alternative">
													<input class="form-control" placeholder="Phone Number" id="phone_no" name="phone_no" type="number" title="Enter phone number" oninvalid="this.setCustomValidity('Please enter your phone number.')" oninput="setCustomValidity('')" required>
												</div>
											</div>
											<div class="mb-1">
												<label class="form-control-label text-primary mb-0">Email</label>
												<div class="input-group input-group-merge input-group-alternative">
													<input class="form-control" placeholder="Email" id="email" name="email" type="email" title="Enter username" oninvalid="this.setCustomValidity('Please enter your email.')" oninput="setCustomValidity('')" required>
												</div>
											</div>
											<div class="mb-3">
												<label class="form-control-label text-primary mb-0">Address</label>
												<div class="input-group input-group-merge input-group-alternative">
													<input class="form-control" placeholder="Address" id="address" name="address" type="text" title="Enter address" oninvalid="this.setCustomValidity('Please enter your address.')" oninput="setCustomValidity('')" required>
												</div>
												<div class="form-text form-switch mt-0">
													<small><a href="index.php" class="text-left text-primary font-weight-bolder " for="rememberMe">Already have account?</a></small>
												</div>
											</div>
											
											<div class="text-center">
											<button type="submit" name="sign-up" value="sign-up" class="btn  btn-primary w-100 mt-0 mb-0 text-white font-weight-bolder text-primary">Sign Up</button>
											</div>
										</div>
									</form>
									<div class="card-footer text-center pt-0 px-lg-2 px-1 ">
										<center>
											<span class="text-primary color-white">
												<small  > LMS &copy; 2023</small>
											</span>
										</center>
									</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	</body>
			 <?php
			  //include("include/footer.php");
			  ?>
			 <!-- Core JS -->
			 <script src="assets/vendor/jquery/dist/jquery.min.js"></script>
			 <script src="assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
			 <script src="assets/vendor/js-cookie/js.cookie.js"></script>
			 <script src="assets/vendor/jquery.scrollbar/jquery.scrollbar.min.js"></script>
			 <script src="assets/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js"></script>
			 <!-- Optional JS -->
			 <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAq_ljbjvx9Z6BGjTAwwxdaa-_n4Mr48-E&ver=3.19.17"></script>
			 <!-- Calender JS -->
			 <script src="assets/vendor/moment/min/moment.min.js"></script>
			 <script src="assets/vendor/fullcalendar/dist/fullcalendar.min.js"></script>
			 <script src="assets/vendor/fullcalendar/dist/locale/id.js"></script>
			 <script src="assets/js/argon.js?v=1.1.0"></script>
			</div>
		</div>
	</body>
	<script type="text/javascript">
		//Responsive Checker for email
		const checkEmail = document.getElementById('username');
		checkEmail.addEventListener('change', () => {
			const emailValue = checkEmail.value;
			const emailRegex = /^[a-zA-Z0-9]+$/; // Regular expression for alphanumeric characters
			
			if (emailValue.trim() === '') {
				// Username is empty
				$("#username").css({ 
					"border" :"1px solid red",
					"color" :"red",
				});
				$("#username").fadeIn("slow");
				$("#username").focus();
				return false;
			} else if (!emailRegex.test(emailValue)) {
				// Username contains non-alphanumeric characters
				$("#username").css({ 
					"border" :"1px solid red",
					"color" :"red",
				});
				$("#username").fadeIn("slow");
				$("#username").focus();
				return false;
			} else {
				// Username is valid
				$("#username").css({ 
					"border" :"",
					"color" :"#000",
				});
				$("#username").fadeIn("slow");
			}
		});
	</script>
	<script>
		function showPass() {
		  var x = document.getElementById("password");
		  if (x.type === "password") {
			x.type = "text";
		  } else {
			x.type = "password";
		  }
		}

		$(".toggle-password").click(function() {
		  $(this).toggleClass("fa-eye fa-eye-slash");
		  var input = $($(this).attr("toggle"));
		  if (input.attr("type") == "password") {
			input.attr("type", "text");
		  } else {
			input.attr("type", "password");
		  }
		});
	</script>
	<script>
		$('.btnlogin').on('click', function() {
		  var $this = $(this);
		  $this.button('loading');
		  setTimeout(function() {
			$this.button('reset');
		  }, 8000);
		});
	</script>
 </html>
