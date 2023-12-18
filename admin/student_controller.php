<?php
	error_reporting(E_ALL);
	session_start();
	include "../include/conn.php";
	include "../include/function.php";
	include "include/session.php";
	
	//DELETE STUDENT
	if (isset($_GET['del'])) {
		$id = $_GET['id'];
		try {
			$check_student = getrecord('book_issuance',['user_id'],[$id]);
			if (!empty($check_student)) {
				$_SESSION['error'] = 'User with transactions cannot be deleted.';
				echo" <script> window.location.href='student.php'; </script> ";
				exit();
			}
			$stmt = $con->prepare("DELETE FROM `user` WHERE id=? LIMIT 1");
			$stmt->execute([$id]);
			if ($stmt->rowCount() > 0) {
				$_SESSION['success'] = 'Student removed';
			} else {
				$_SESSION['error'] = 'Student not found';
			}
		} catch (Exception $e) {
			$_SESSION['error'] = 'Something went wrong.'.$e->getMessage();
		}
		echo" <script> window.location.href='student.php'; </script> ";
		exit();
	} 
	

	
	