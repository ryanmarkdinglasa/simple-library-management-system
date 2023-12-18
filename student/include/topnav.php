<?php
	include("include/session.php");
?>
	<style>
	.notification{
		background:#FFF;
		color:#5E72E4;
	}
	.notification:hover{
		background:rgba(255,255,255,0.7);
	}
	.notification-count{
		width:15px;
		height:15px;
		text-align:center;
		border-radius:50%;
		background:red;
		color:white;
		line-height:9px;
		font-size:10px;
		font-weight:700;
		padding:2px 2px;
		position:abosulute;
		margin:0px -10px;
		
	}
	</style>
  <!-- Topnav -->
  <nav class="navbar navbar-top navbar-expand navbar-dark bg-primary border-bottom">
    <div class="container-fluid">
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav align-items-center ml-md-auto">
          <li class="nav-item dropdown">
       
          </li>
        </ul>
        <ul class="navbar-nav align-items-center ml-auto ml-md-0">
          <li class="nav-item dropdown">
            <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <div class="media align-items-center">
                  <span class="avatar avatar-sm rounded-circle">
                    <?php $userphoto = $user['image']; //user's photo
                    if ($userphoto == "") :
                    ?>
                      <img src="img/default_pic.jpg" alt="Image placeholder">
                    <?php else : ?>
                      <img alt="Image placeholder" src="img/<?php echo htmlentities($userphoto); ?>" style="width:40px;height:35px;border-radius:50%;">
                    <?php endif; ?>
                  </span>
                 
              </div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
              <div class="dropdown-header noti-title">
				 <div class="media-body ml-2 d-none d-lg-block">
                    <h5 class=" m-0 text-sm  font-weight-bold">
						<?php echo  htmlentities($user['firstname'].' '.$user['lastname']); //user's name ?>
					</h5>
					<h6 class="text-overflow m-0" data-toggle="tooltip" data-placement="left" title="Username">
						<?php echo htmlentities($_SESSION['type']); //position ?>
					</h6>
				</div>
				
            </div>
			  <div class="dropdown-divider"></div>
				<a href="profile.php" class="dropdown-item">
				  <i class="ni ni-single-02"></i>
				 <span>Profile</span>
				</a> 
				<a href="logout.php" class="dropdown-item">
				  <i class="ni ni-user-run"></i>
				  <span>Logout</span>
				</a>	
          </li>
        </ul>
      </div>
    </div>
  </nav>