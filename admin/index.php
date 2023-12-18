<?php
	session_start();
	error_reporting(E_ALL);
	include("include/session.php");
	$parentpage = "dashboard";
	$year = date('Y');
	$semester_ini = date('n');
	if ($semester_ini <= 6) $semester_ini = ($year - 1).'2';
	else $semester_ini = '1';
	include("include/header.php");
?>
	</head>
		<?php include("include/sidebar.php"); ?>
		<!-- ain content -->
		<div class="main-content" id="panel">
			<?php
				 include("include/topnav.php");
				 include("include/snackbar.php");
			?>
			<div class="header bg-primary pb-6">
			  <div class="container-fluid">
				<div class="header-body">
				  <div class="row align-items-center py-4">
					<div class="col-lg-6 col-7">
					  <h6 class="h2 text-white d-inline-block mb-0">Dashboard</h6>
					  <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
						<ol class="breadcrumb breadcrumb-links breadcrumb-dark">
						  <li class="breadcrumb-item"><a href="./"><i class="fas fa-home"></i></a></li>
						  <li class="breadcrumb-item active" aria-current="page">Dashboard
						  </li>
						</ol>
					  </nav>
					</div>
					<div class="col-lg-6 col-5 text-right">
					</div>
				  </div>
				  <!-- Card stats -->
				  <div class="row">
					<div class="col-xl-3 col-md-3  cursor-pointer" onclick="window.location.href='book.php'">
					  <button class="card card-stats bg-white w-100 text-left"  >
						<div class="card-body w-100">
						  <div class="row ">
							<div class="col">
							  	<h5 class="card-title text-uppercase mb-0  "> Book </h5>
							  	<span class="h2 font-weight-bold mb-0"> 
								<?php
									$query= "SELECT * FROM `book`";
									$stmt =$con->prepare($query);
									$stmt -> execute();
									$count =$stmt->rowCount();
									echo"".$count;
								?>
								</span>
							</div>
							<div class="col-auto">
							  <div class=" " style="">
							  	<svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" height="3rem" viewBox="0 0 640 512"><path d="M192 96a48 48 0 1 0 0-96 48 48 0 1 0 0 96zm-8 384V352h16V480c0 17.7 14.3 32 32 32s32-14.3 32-32V192h56 64 16c17.7 0 32-14.3 32-32s-14.3-32-32-32H384V64H576V256H384V224H320v48c0 26.5 21.5 48 48 48H592c26.5 0 48-21.5 48-48V48c0-26.5-21.5-48-48-48H368c-26.5 0-48 21.5-48 48v80H243.1 177.1c-33.7 0-64.9 17.7-82.3 46.6l-58.3 97c-9.1 15.1-4.2 34.8 10.9 43.9s34.8 4.2 43.9-10.9L120 256.9V480c0 17.7 14.3 32 32 32s32-14.3 32-32z"/></svg> 
							  </div>
							</div>
						  </div>
						 
						</div>
						</button>
					</div>

					<div class="col-xl-3 col-md-3  cursor-pointer" onclick="window.location.href='book_issuance.php'">
					  <button class="card card-stats bg-white w-100 text-left"  >
						<div class="card-body w-100">
						  <div class="row ">
							<div class="col">
							  	<h5 class="card-title text-uppercase mb-0  "> Issued </h5>
							  	<span class="h2 font-weight-bold mb-0"> 
								<?php
									$query= "SELECT * FROM `book_issuance`";
									$stmt =$con->prepare($query);
									$stmt -> execute();
									$count =$stmt->rowCount();
									echo"".$count;
								?>
								</span>
							</div>
							<div class="col-auto">
							  <div class=" " style="">
							  <svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" height="3rem" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M64 0C46.3 0 32 14.3 32 32V96c0 17.7 14.3 32 32 32h80v32H87c-31.6 0-58.5 23.1-63.3 54.4L1.1 364.1C.4 368.8 0 373.6 0 378.4V448c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V378.4c0-4.8-.4-9.6-1.1-14.4L488.2 214.4C483.5 183.1 456.6 160 425 160H208V128h80c17.7 0 32-14.3 32-32V32c0-17.7-14.3-32-32-32H64zM96 48H256c8.8 0 16 7.2 16 16s-7.2 16-16 16H96c-8.8 0-16-7.2-16-16s7.2-16 16-16zM64 432c0-8.8 7.2-16 16-16H432c8.8 0 16 7.2 16 16s-7.2 16-16 16H80c-8.8 0-16-7.2-16-16zm48-168a24 24 0 1 1 0-48 24 24 0 1 1 0 48zm120-24a24 24 0 1 1 -48 0 24 24 0 1 1 48 0zM160 344a24 24 0 1 1 0-48 24 24 0 1 1 0 48zM328 240a24 24 0 1 1 -48 0 24 24 0 1 1 48 0zM256 344a24 24 0 1 1 0-48 24 24 0 1 1 0 48zM424 240a24 24 0 1 1 -48 0 24 24 0 1 1 48 0zM352 344a24 24 0 1 1 0-48 24 24 0 1 1 0 48z"/></svg>
							  </div>
							</div>
						  </div>
						</div>
						</button>
					</div>

					<div class="col-xl-3 col-md-3  cursor-pointer" onclick="window.location.href='student.php'">
					  	<button class="card card-stats bg-white w-100 text-left"  >
							<div class="card-body w-100">
								<div class="row ">
									<div class="col">
										<h5 class="card-title text-uppercase mb-0  "> student </h5>
										<span class="h2 font-weight-bold mb-0"> 
											<?php
												$query= "SELECT * FROM `user` WHERE `type` = 'student'";
												$stmt =$con->prepare($query);
												$stmt -> execute();
												$count =$stmt->rowCount();
												echo"".$count;
											?>
										</span>
									</div>
									<div class="col-auto">
									<div class=" " style="">
									<svg class="svg-icon"  xmlns="http://www.w3.org/2000/svg" height="3rem" viewBox="0 0 640 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M320 32c-8.1 0-16.1 1.4-23.7 4.1L15.8 137.4C6.3 140.9 0 149.9 0 160s6.3 19.1 15.8 22.6l57.9 20.9C57.3 229.3 48 259.8 48 291.9v28.1c0 28.4-10.8 57.7-22.3 80.8c-6.5 13-13.9 25.8-22.5 37.6C0 442.7-.9 448.3 .9 453.4s6 8.9 11.2 10.2l64 16c4.2 1.1 8.7 .3 12.4-2s6.3-6.1 7.1-10.4c8.6-42.8 4.3-81.2-2.1-108.7C90.3 344.3 86 329.8 80 316.5V291.9c0-30.2 10.2-58.7 27.9-81.5c12.9-15.5 29.6-28 49.2-35.7l157-61.7c8.2-3.2 17.5 .8 20.7 9s-.8 17.5-9 20.7l-157 61.7c-12.4 4.9-23.3 12.4-32.2 21.6l159.6 57.6c7.6 2.7 15.6 4.1 23.7 4.1s16.1-1.4 23.7-4.1L624.2 182.6c9.5-3.4 15.8-12.5 15.8-22.6s-6.3-19.1-15.8-22.6L343.7 36.1C336.1 33.4 328.1 32 320 32zM128 408c0 35.3 86 72 192 72s192-36.7 192-72L496.7 262.6 354.5 314c-11.1 4-22.8 6-34.5 6s-23.5-2-34.5-6L143.3 262.6 128 408z"/></svg>
									</div>
									</div>
								</div>
							</div>
						</button>
					</div>

					<div class="col-xl-3 col-md-3  cursor-pointer" onclick="window.location.href='#'">
					  	<button class="card card-stats bg-white w-100 text-left"  >
							<div class="card-body w-100">
								<div class="row ">
									<div class="col">
										<h5 class="card-title text-uppercase mb-0  "> Staff </h5>
										<span class="h2 font-weight-bold mb-0"> 
											<?php
												$query= "SELECT * FROM `user` WHERE `type` ='admin'";
												$stmt =$con->prepare($query);
												$stmt -> execute();
												$count =$stmt->rowCount();
												echo"".$count;
											?>
										</span>
									</div>
									<div class="col-auto">
									<div class=" " style="">
										<svg  class="svg-icon" xmlns="http://www.w3.org/2000/svg" height="3rem" viewBox="0 0 640 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M144 160A80 80 0 1 0 144 0a80 80 0 1 0 0 160zm368 0A80 80 0 1 0 512 0a80 80 0 1 0 0 160zM0 298.7C0 310.4 9.6 320 21.3 320H234.7c.2 0 .4 0 .7 0c-26.6-23.5-43.3-57.8-43.3-96c0-7.6 .7-15 1.9-22.3c-13.6-6.3-28.7-9.7-44.6-9.7H106.7C47.8 192 0 239.8 0 298.7zM320 320c24 0 45.9-8.8 62.7-23.3c2.5-3.7 5.2-7.3 8-10.7c2.7-3.3 5.7-6.1 9-8.3C410 262.3 416 243.9 416 224c0-53-43-96-96-96s-96 43-96 96s43 96 96 96zm65.4 60.2c-10.3-5.9-18.1-16.2-20.8-28.2H261.3C187.7 352 128 411.7 128 485.3c0 14.7 11.9 26.7 26.7 26.7H455.2c-2.1-5.2-3.2-10.9-3.2-16.4v-3c-1.3-.7-2.7-1.5-4-2.3l-2.6 1.5c-16.8 9.7-40.5 8-54.7-9.7c-4.5-5.6-8.6-11.5-12.4-17.6l-.1-.2-.1-.2-2.4-4.1-.1-.2-.1-.2c-3.4-6.2-6.4-12.6-9-19.3c-8.2-21.2 2.2-42.6 19-52.3l2.7-1.5c0-.8 0-1.5 0-2.3s0-1.5 0-2.3l-2.7-1.5zM533.3 192H490.7c-15.9 0-31 3.5-44.6 9.7c1.3 7.2 1.9 14.7 1.9 22.3c0 17.4-3.5 33.9-9.7 49c2.5 .9 4.9 2 7.1 3.3l2.6 1.5c1.3-.8 2.6-1.6 4-2.3v-3c0-19.4 13.3-39.1 35.8-42.6c7.9-1.2 16-1.9 24.2-1.9s16.3 .6 24.2 1.9c22.5 3.5 35.8 23.2 35.8 42.6v3c1.3 .7 2.7 1.5 4 2.3l2.6-1.5c16.8-9.7 40.5-8 54.7 9.7c2.3 2.8 4.5 5.8 6.6 8.7c-2.1-57.1-49-102.7-106.6-102.7zm91.3 163.9c6.3-3.6 9.5-11.1 6.8-18c-2.1-5.5-4.6-10.8-7.4-15.9l-2.3-4c-3.1-5.1-6.5-9.9-10.2-14.5c-4.6-5.7-12.7-6.7-19-3L574.4 311c-8.9-7.6-19.1-13.6-30.4-17.6v-21c0-7.3-4.9-13.8-12.1-14.9c-6.5-1-13.1-1.5-19.9-1.5s-13.4 .5-19.9 1.5c-7.2 1.1-12.1 7.6-12.1 14.9v21c-11.2 4-21.5 10-30.4 17.6l-18.2-10.5c-6.3-3.6-14.4-2.6-19 3c-3.7 4.6-7.1 9.5-10.2 14.6l-2.3 3.9c-2.8 5.1-5.3 10.4-7.4 15.9c-2.6 6.8 .5 14.3 6.8 17.9l18.2 10.5c-1 5.7-1.6 11.6-1.6 17.6s.6 11.9 1.6 17.5l-18.2 10.5c-6.3 3.6-9.5 11.1-6.8 17.9c2.1 5.5 4.6 10.7 7.4 15.8l2.4 4.1c3 5.1 6.4 9.9 10.1 14.5c4.6 5.7 12.7 6.7 19 3L449.6 457c8.9 7.6 19.2 13.6 30.4 17.6v21c0 7.3 4.9 13.8 12.1 14.9c6.5 1 13.1 1.5 19.9 1.5s13.4-.5 19.9-1.5c7.2-1.1 12.1-7.6 12.1-14.9v-21c11.2-4 21.5-10 30.4-17.6l18.2 10.5c6.3 3.6 14.4 2.6 19-3c3.7-4.6 7.1-9.4 10.1-14.5l2.4-4.2c2.8-5.1 5.3-10.3 7.4-15.8c2.6-6.8-.5-14.3-6.8-17.9l-18.2-10.5c1-5.7 1.6-11.6 1.6-17.5s-.6-11.9-1.6-17.6l18.2-10.5zM472 384a40 40 0 1 1 80 0 40 40 0 1 1 -80 0z"/></svg>
									</div>
									</div>
								</div>
							</div>
						</button>
					</div>

				  </div>
				</div>
			  </div>
			</div>

			<!-- Page content 
			<div class="container-fluid mt--6">
				<br>
				<div class="row">
				
					<?php
					/*try{
						$sql = "SELECT 
							`post`.`id` AS `post_id`,
							`post`.`user_id` AS `post_user`,
							`post`.`title` AS `post_title`,
							`post`.`context` AS `post_context`,
							`post`.`status` AS `post_status`,
                            `post`.`created_on` AS `post_on`,
							`user`.`type` AS `user_type`,
							`user`.`profileImage` AS `user_image`,
							`user`.`firstname` AS `user_fname`, `user`.`lastname` AS `user_lname`
							 FROM `post` 
							 INNER JOIN `user` ON `user`.`id`= `post`.`user_id`
							 WHERE `post`.`status`='1' ORDER BY `post_on` DESC";
						$query = $con->query($sql);
						$count=$query->rowCount();
						if($count<1){*/
					?>
						<div class="col-xl-12">
							<div class="card">
							  <div class="card-header">
								<h6 class="text-black text-uppercase ls-1 mb-1">ANNOUNCEMENT</h6>
								<h5 class="h3 text-uppercase text-primary mb-0"> </h5>
								<span class="text-muted"><?php //echo $row['created_on']; ?></h5>
							  </div>
							  <div class='card-body'>No Data Found
								<?php //echo $row['context']; ?>
							  </div>
							</div>
						</div>
					<?php
						//}
						//else{
					?>
						<div class="col-xl-12">
							<div class="card">
							  <div class="card-header">
								<h4 class="text-black text-uppercase ls-1 mb-1"><i class="ni ni-notification-70"></i> ANNOUNCEMENT</h4>
								<h5 class="h3 text-uppercase text-primary mb-0"> </h5>
								<span class="text-muted"><?php //echo $row['created_on']; ?></h5>
							  </div>
							  
							</div>
						</div>
					<?php
						//}
						//while ($row = $query->fetch(PDO::FETCH_ASSOC)) {	
					?>
					<div class="col-xl-12">
						<div class="card">
						  <div class="card-header">
							<div class="poster">
							<?php // $userphoto = $row['user_image'];
								/*if ($userphoto == "" || $userphoto == "NULL") :
								 echo' <img src="img/profile.png" class="avatar rounded-circle mr-3">';
								else : 
									//echo$row['user_type'];
								   echo'<img src="../'.$row['user_type'].'/img/'.htmlentities($userphoto).'" class="avatar rounded-circle mr-3">';
								endif;
								//Posted By & Posted On
								echo '<h5 class="text-black  mb-0">'.$row['user_fname'].' '.$row['user_lname'].'<br>';
								echo'<span class="text-muted""><small>';
								$post_created=''.$row['post_on'];
								echo $row['user_type'].' | '.created_on($post_created);
								echo'</small></span></h5>';
								?>
								<?php
								if($user['id']==$row['post_user']){
									*/
								?>
								<div class="text-right" style="margin-top:-30px;">
									<div class="dropdown">
									  <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										<i class="fas fa-ellipsis-v"></i>
									  </a>
									  <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
										<a class="dropdown-item" href="announcement_edit.php?id=<?php// echo $row['post_id'] ?>&edit=edit" style="color: black;" type="button"><i class="fas fa-pen" style="color:#172b4d;"></i> Edit post</a>
										<a class="dropdown-item" href="announcement_controller.php?id=<?php //echo $row['post_id'] ?>&del=delete" onClick="return confirm('Are you sure you want to clear, <?php echo htmlentities($row['post_title']); ?> ?')"><i class="fas fa-trash" style="color:#f5365c;"></i> Delete post</a>
									  </div>
									</div>
								</div>
								<?php //}?>
							</div>
						  </div>
						  <div class='card-body'>
							<h5 class="h3 text-uppercase text-primary mb-0"><?php //echo $row['post_title']; ?></h5>
							<?php // echo $row['post_context']; ?>
						  </div>
						</div>
					</div>
					<?php	
					/*	}//while
					}catch(Exception $e){
						$_SESSION['error']='Something went wrong in accessing annoouncement post.';
					}*/
					?>
				</div>-->
				<?php
					include("include/footer.php"); //Edit topnav on this page
				?>
			</div>
		</div>
	</body>
</html>