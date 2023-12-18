<body>
  <!-- Sidenav -->
  <nav class="sidenav navbar navbar-vertical fixed-left navbar-expand-xs navbar-light bg-white " id="sidenav-main">
    <div class="scrollbar-inner">
      <!-- Brand -->
      <style>
        .brand:hover{
          opacity:0.9;
          transition:0.3s;
        }
        .sidebar-user{
         
          border-radius: 5px;
          width:100%;
          height:50px;
          position:absolute;
          padding:10px 10px;
          line-height:50px;
          margin-top:100px;
          
        }
        .sidebar-user:hover,{
          background:rgb(246,249,252);
        }
        .sidebar-user span{
          float:left;
          margin:-17px 5px; 
        }
      </style>  
      <div class="sidenav-header d-flex align-items-center">
        <a class="navbar-brand" href="./" style="width:">
          <h4 class="text-primary">Library Management System</h4>
        </a>
          <div class="navbar-brand sidebar-user text-left">
            <a href="profile.php">
            <span class="avatar avatar-sm rounded-circle" >
              <?php $userphoto = $user['image']; //user's photo
                if ($userphoto == "") :
              ?>
              <img src="img/default_pic.jpg" alt="Image placeholder">
              <?php else : ?>
                <img alt="Image placeholder" src="img/<?php echo htmlentities($userphoto); ?>" style="width:40px;height:35px;border-radius:50%;">
              <?php endif; ?>
            </span>
            <span >
              <h5 class=" m-0 text-sm  font-weight-bold">
                <?php echo  htmlentities($user['firstname'].' '.$user['lastname']); //user's name ?>
              </h5>
              <h6 class="text-overflow m-0" data-toggle="tooltip" data-placement="left" title="User">
                <?php echo htmlentities($_SESSION['type']); //position ?>
              </h6>
            </span>
            </a>
          </div>
        

        <div class="ml-auto">
          <!-- Sidenav toggler -->
          <div class="sidenav-toggler d-none d-xl-block" data-action="sidenav-unpin" data-target="#sidenav-main">
            <div class="sidenav-toggler-inner">
              <i class="sidenav-toggler-line"></i>
              <i class="sidenav-toggler-line"></i>
              <i class="sidenav-toggler-line"></i>
            </div>
          </div>
        </div>
      </div>
      <br>
      <div class="navbar-inner">
        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="sidenav-collapse-main">
          <!-- Nav items -->
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link <?php echo ($parentpage == "dashboard" ? "  text-primary" : "") ?>" href="./">
                <i class="ni ni-shop text-primary"></i>
                <span class="nav-link-text">Dashboard</span>
              </a>
            </li>

            <li class="nav-item">
              <a class="nav-link <?php echo ($page == "Book" ? "  text-primary " : "") ?>" href="book.php">
                <i class="ni ni-books "></i>
                <span class="nav-link-text">Book</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?php echo ($page == "Approvals" ? "  text-primary " : "") ?>" href="book_approval.php">
                <i class="ni ni-archive-2 "></i>
                <span class="nav-link-text">Approvals</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?php echo ($page == "Book Issuance" ? "  text-primary " : "") ?>" href="book_issuance.php">
                <i class="ni ni-book-bookmark "></i>
                <span class="nav-link-text">Book Issuance</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?php echo ($parentpage == "Account" ? "  text-primary" : "") ?>" href="#navbar-dataakun" data-toggle="collapse" role="button" aria-expanded="<?php echo ($parentpage == "account" ? "true" : "false") ?>" aria-controls="navbar-dataaccount">
                <i class="ni ni-money-coins text-primary"></i>
                <span class="nav-link-text">Accounts</span>
              </a>
              <div class="collapse <?php echo ($parentpage == "Account" ? "show" : "") ?>" id="navbar-dataakun">
                <ul class="nav nav-sm flex-column">
                  <!--<li class="nav-item">
                    <a href="admin.php" class="nav-link  <?php // echo ($childpage == "admin" ? "text-primary" : "") ?>">Staff</a>
                  </li>-->
                  <li class="nav-item">
                    <a href="student.php" class="nav-link <?php echo ($childpage == "student" ? "text-primary" : "") ?>">Student</a>
                  </li>

                </ul>
              </div>
            </li>
            
           <!--
			      <li class="nav-item">
              <a class="nav-link <?php echo ($page == "announcement" ? "  text-primary" : "") ?>" href="announcement.php">
                <i class="ni ni-notification-70 text-primary"></i>
                <span class="nav-link-text">Announcement</span>
              </a>
            </li>
              -->
          </ul>
          <!-- Divider -->
        </div>
      </div>
    </div>
  </nav>