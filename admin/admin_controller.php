<?php
	error_reporting(0);
	session_start();
	include "../include/conn.php";
	include "include/session.php";
	include "../include/function.php";
	
	//ADD ADMIN
	if (isset($_POST['add'])) {
		$type = 'admin';
		$firstname = 'New';
		$lastname = 'Staff';
		$password = '12345';
		$passwordhash = password_hash($password, PASSWORD_DEFAULT);
		$username = $_POST["username"];
		$age = $_POST["age"];
		$phone_no = $_POST["phone_no"];
		$email = $_POST["email"];
		$address = $_POST["address"];
		$img='default_pic.jpg';
		$created_on = date('Y-m-d H:i:s');
		
		//CHECK USERNAME IF THERE IS ANY DUPLICATION
		$check_username=getrecord('user',['username',],[$username]);
		if(!empty($check_username)){
			$_SESSION['error']='Username is already taken.';
			echo" <script> window.location.href='admin.php'; </script> ";
			exit();
		}
		//ADD NEW STAFF
		$field = ['type','username','password','firstname','lastname','phone_no','email','age','address','image','created_on'];
		$data = [$type, $username, $passwordhash, $firstname, $lastname, $phone_no, $email, $age, $address, $image, $created_on];
		$new_user = addrecord('user', $field, $data);
		if (!$result) {
				$_SESSION['error'] = 'Something went wrong in adding new staff. Please try again.';
				echo" <script> location.href='admin.php'; </script> ";
				exit();
		}
		$_SESSION['success'] = 'Account created, account password sent.';
		echo" <script> location.href='admin.php'; </script> ";
		exit();
	}

	// DELETE ADMIN
	if (isset($_GET['del'])) {
		$id = $_GET['id'];
		try {
			if($id == '2'){
				$_SESSION['error'] = 'Default staff cannot be deleted.';
				echo" <script> location.href='admin.php'; </script> ";
				exit();
			}
			
			$stmt = $con->prepare("DELETE FROM `user` WHERE id=? LIMIT 1");
			if ($stmt->execute([$id])) {
				$_SESSION['success'] = 'Staff removed.';
				echo" <script> location.href='admin.php'; </script> ";
				exit();
			} else {
				$_SESSION['error'] = 'Something went wrong.';
				echo" <script> location.href='admin.php'; </script> ";
				exit();
			}
		} catch (PDOException $e) {
			$_SESSION['error'] = 'Something went wrong: ' . $e->getMessage();
			echo" <script> location.href='admin.php'; </script> ";
			exit();
		}
	}

	