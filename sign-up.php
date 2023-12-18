	<?php
		error_reporting(0);
		session_start();
		include("include/conn.php");
		include("include/function.php");
		if (isset($_POST["sign-up"])) {
			$firstname = trim($_POST['firstname']);
			$lastname = trim($_POST['lastname']);
			$username = trim($_POST['username']);
			$password = trim($_POST['password']);
			$passwordhash = password_hash($password, PASSWORD_DEFAULT);
			$age = trim($_POST['age']);
			$phone_no = trim($_POST['phone_no']);
			$email = trim($_POST['email']);
			$address = trim($_POST['address']);
			$type = 'student';
			$image = 'default_pic.jpg';
			$created_on = date('Y-m-d H:i:s');

			try {
				$check_username=getrecord('user',['username',],[$username]);
				if(!empty($check_username)){
					$_SESSION['error']='Username is already taken.';
					echo "<script >window.location.href='index.php'; </script>";
					exit();
				}
				$field = ['type','username','password','firstname','lastname','phone_no','email','age','address','image','created_on'];
				$data = [$type, $username, $passwordhash, $firstname, $lastname, $phone_no, $email, $age, $address, $image, $created_on];
				$new_user = addrecord('user',$field,$data);
				if (!$new_user) {
					$_SESSION['error']='Soemthing went wrong.';
					echo "<script >window.location.href='index.php'; </script>";
					exit();
				}
				//SUCCESS
				$_SESSION['success']='Account created.';
				echo "<script >window.location.href='index.php'; </script>";
				exit();
			} catch (Exception $e) {
				error_log($e->getMessage(), 0);
				$_SESSION['error'] = "Something went wrong. ".$e->getMessage();
				echo "<script >window.location.href='index.php'; </script>";
				exit;
			}
		}
		else{
			$_SESSION['error'] = 'Invalid username or password';
			echo "<script> window.location.href='index.php?error';</script>";
			exit;
		}

