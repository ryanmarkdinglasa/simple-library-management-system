	<?php
		error_reporting(0);
		session_start();
		include("include/conn.php");
		include("include/function.php");
		if (isset($_POST["signin"])) {
			$user = trim($_POST['username']);
			$pass = trim($_POST['password']);
			try {
				$stmt = $con->prepare("SELECT * FROM `user` WHERE `username` = ?");
				$stmt->execute([$user]);
				$user = $stmt->fetch(PDO::FETCH_ASSOC);
				if (!$user) {
					$_SESSION['error'] = "This account doesn't exist, please try again.";
					header('location: index.php');
					exit;
				}
				if (!password_verify($pass, $user['password'])) {
					$_SESSION['error'] = "Invalid username or password";
					echo"<script>window.location.href='index.php';</script>";
					exit();
				}
				$user_type=$user['type'];$_SESSION['type']=$user['type'];//admin
				$_SESSION[$user_type] = $user['id'];
				echo"<script>window.location.href='". $_SESSION['type'] ."/index.php';</script>";
				exit();
			} catch (Exception $e) {
				error_log($e->getMessage(), 0);
				$_SESSION['error'] = "Something went wrong. ".$e->getMessage();
				echo"<script>window.location.href='index.php';</script>";
				exit;
			}
		}
		else{
			$_SESSION['error'] = 'Invalid username or password';
			echo"<script>window.location.href='index.php';</script>";
			exit;
		}

