<?php
	error_reporting(0);
	session_start();
	include "../include/conn.php";
	include "../include/function.php";
	include "include/session.php";
	
	//ADD BOOK
	if (isset($_POST['add'])) {
		$issue_date = date('Y-m-d');
		$return_date = date('Y-m-d', strtotime($_POST['return_date']));
		$is_return = -1;
		$remarks = trim($_POST['remarks']);
		$user_id = trim($_POST['student_id']);
		$book_id = trim($_POST['book_id']);
		$penalty = 0.00;
		$is_approve = 0;
		$approved_by = '';
		$created_on = date('Y-m-d H:i:s');
	
		// CHECK USER BORRWED BOOK EXCEEDS 3 THIS WEEK
		$query = "SELECT COUNT(`user_id`) AS `borrowed_count` FROM `book_issuance` WHERE `user_id` = ? AND DATE(`issue_date`) >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)";
		$stmt = $con->prepare($query);
		$stmt->execute([$user_id]);
		$borrowed_books_count = $stmt->fetchColumn();
	
		// Validate borrowing limit
		$max_books_allowed = 3;
		if ($borrowed_books_count >= $max_books_allowed) {
			$_SESSION['error'] = 'User already exceeds the limit of borrowed books.';
			echo" <script> window.location.href='book.php'; </script> ";
			exit();
		}

		# RETURN DATE SHOULD BE GREATER THAN ISSUE DATE
		if ($issue_date > $return_date) {
			$_SESSION['error'] = 'Return date should be greater than the issue date.';
			echo" <script> window.location.href='book.php'; </script> ";
			exit();
		}

		// Add new borrowed book
		$field = ['issue_date', 'return_date', 'is_return', 'remarks', 'user_id', 'book_id', 'penalty', 'is_approve', 'approved_by', 'created_on'];
		$data = [$issue_date, $return_date, $is_return, $remarks, $user_id, $book_id, $penalty, $is_approve, $approved_by, $created_on];
		$result = addrecord('book_issuance', $field, $data);
	
		if (!$result) {
			$_SESSION['error'] = 'Something went wrong in adding a new borrowed book. Please try again.';
			echo" <script> window.location.href='book.php'; </script> ";
			exit();
		}
		$_SESSION['success'] = 'Borrowed book is on approval.';
		echo" <script> window.location.href='book.php'; </script> ";
		exit();
	}

	
	//DELETE STUDENT
	if (isset($_GET['del'])) {
		$id = $_GET['id'];
		try {
			$check_book=getrecord('book',['id',],[$id]);
			if(!empty($check_book)){
				$_SESSION['error']='Book with transactions, cannot be deleted.';
				echo" <script> window.location.href='book.php'; </script> ";
				exit();
			}
			$stmt = $con->prepare("DELETE FROM `book` WHERE id=? LIMIT 1");
			$stmt->execute([$id]);
			if ($stmt->rowCount() > 0) {
				$_SESSION['success'] = 'Book removed';
			} else {
				$_SESSION['error'] = 'Book not found';
			}
		} catch (Exception $e) {
			$_SESSION['error'] = 'Something went wrong.'.$e->getMessage();
		}
		echo" <script> window.location.href='book.php'; </script> ";
		exit();
	} 
	

	
	