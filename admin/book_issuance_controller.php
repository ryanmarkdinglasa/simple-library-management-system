<?php
	error_reporting(E_ALL);
	session_start();
	include "../include/conn.php";
	include "../include/function.php";
	include "include/session.php";
	
	// ADD BOOK
	if (isset($_POST['add'])) {
		$issue_date = date('Y-m-d');
		$return_date = date('Y-m-d', strtotime($_POST['return_date']));
		$is_return = -1;
		$remarks = trim($_POST['remarks']);
		$user_id = trim($_POST['student']);
		$book_id = trim($_POST['book']);
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
			echo" <script> window.location.href='book_issuance.php'; </script> ";
			exit();
		}

		// Check if the user has no pending penalty or balance
		$balance_query = "SELECT SUM(`penalty`) AS total_penalty FROM `book_issuance` WHERE `user_id` = ? AND `penalty` > 0";
		$balance_stmt = $con->prepare($balance_query);
		$balance_stmt->execute([$user_id]);
		$balance = $balance_stmt->fetch(PDO::FETCH_ASSOC);

		if ($balance['total_penalty'] > 0) {
			$_SESSION['error'] = 'User still has pending penalties. Please settle them first.';
			echo" <script> window.location.href='book_issuance.php'; </script> ";
			exit();
		}

		# RETURN DATE SHOULD BE GREATER THAN ISSUE DATE
		if ($issue_date > $return_date) {
			$_SESSION['error'] = 'Return date should be greater than the issue date.';
			echo" <script> window.location.href='book_issuance.php'; </script> ";
			exit();
		}

		// Add new borrowed book
		$field = ['issue_date', 'return_date', 'is_return', 'remarks', 'user_id', 'book_id', 'penalty', 'is_approve', 'approved_by', 'created_on'];
		$data = [$issue_date, $return_date, $is_return, $remarks, $user_id, $book_id, $penalty, $is_approve, $approved_by, $created_on];
		$result = addrecord('book_issuance', $field, $data);
	
		if (!$result) {
			$_SESSION['error'] = 'Something went wrong in issuing a book. Please try again.';
			echo" <script> window.location.href='book_issuance.php'; </script> ";
			exit();
		}
		$_SESSION['success'] = 'Borrowed book is on approval.';
		echo" <script> window.location.href='book_issuance.php'; </script> ";
		exit();
	}



	// Return a book 
	if (isset($_POST['return'])) {
		$book_id = $_POST['return_book_id'];
		$student_id = $_POST['return_student_id'];
	
		// Validate inputs
		if (empty($book_id) || empty($student_id)) {
			$_SESSION['error'] = 'Book or Student field is missing.';
			echo" <script> window.location.href='book_issuance.php'; </script> ";
			exit();
		}
		
		$get_book_issuance_sql = "SELECT * FROM `book_issuance` WHERE `book_id`=? AND `user_id`=? AND `is_return`=? ORDER BY `id` ASC LIMIT 1";
		$get_book_issuance_stmt = $con->prepare($get_book_issuance_sql);
		$get_book_issuance_stmt->execute([$book_id, $student_id, -1]);
		$get_book_issuance = $get_book_issuance_stmt->fetch(PDO::FETCH_ASSOC);

		// Validate User if he/she has that book borrowed
		if (empty($get_book_issuance)) {
			$_SESSION['error'] = 'User has not borrowed this book or has already returned it.';
			header('Location: book_issuance.php');
			exit();
		}
		// Calculate penalty for late return
		$issue_date = strtotime($get_book_issuance['issue_date']);
		$return_date = strtotime($get_book_issuance['return_date']);
		$current_date = time();
	
		if ($current_date > $return_date) {
			$days_late = floor(($current_date - $return_date) / (60 * 60 * 24)); // Calculate days late
			$penalty = $days_late * 56; // Calculate penalty (56 per day)
		} else {
			$penalty = 0; // No penalty if returned on time or before return date
		}
	
		try {
			$con->beginTransaction();
	
			$stmt = $con->prepare("UPDATE `book_issuance` SET `is_return`=?, `penalty`=?, `approved_by`=? WHERE id=? LIMIT 1");
			$approver = $user['lastname'] . ', ' . $user['firstname'];
	
			if (!$stmt->execute(['1', $penalty, $approver, $get_book_issuance['id']])) {
				throw new Exception('Failed to mark book as returned.');
			}
	
			$get_quantity = getrecord('book', ['id'], [$book_id]);
			$book_quantity = intval($get_quantity['quantity']) + 1;
	
			$update_book_quantity = $con->prepare("UPDATE `book` SET `quantity`=? WHERE id=? LIMIT 1");
			if (!$update_book_quantity->execute([$book_quantity, $book_id])) {
				throw new Exception('Failed to update book quantity.');
			}
	
			$con->commit();
			$_SESSION['success'] = 'Issued book is marked as returned.';
			echo" <script> window.location.href='book_issuance.php'; </script> ";
			exit();
		} catch (PDOException | Exception $e) {
			$con->rollBack();
			$_SESSION['error'] = 'Something went wrong.' . $e->getMessage();
			echo" <script> window.location.href='book_issuance.php'; </script> ";
			exit();
		}
	}
	
	
	
	//DEACTIVATE SCHOLARSHIP PROVIDER
	if (isset($_GET['off']) && $_GET['off']==1) {
		$id=$_GET['id'];
		try{
			$stmt = $con->prepare("UPDATE `book_issuance` SET `is_approve`='-1', `approved_by`=? WHERE id=?");
			if(!$stmt->execute([$user['id'], $id])){
				$_SESSION['error']='Something went wrong deactivating faculty. Please try again.';
				echo " <script> location.href='book_issuance.php'; </script> ";
				exit();
			}
			$_SESSION['success']='Issued book is disapproved.';
			echo " <script> location.href='book_issuance.php'; </script> ";
			exit();
		}catch(Exception $e){
			$_SESSION['error']='Something went wrong .'.$e->getMessage();
			echo " <script> location.href='book_issuance.php'; </script> ";
			exit();
		}
		
	}		

	// pay penalty
	if (isset($_POST['pay'])) {
		$book_issuance_id = trim($_POST['book_issuance_id']);
		$amount = floatval($_POST['amount']);
		$penalty = floatval($_POST['penalty']);
		
		// Validate the entered amount should be a positive number
		if ($amount <= 0) {
			$_SESSION['error'] = 'Amount should be a positive number.';
			header('Location: book_issuance.php');
			exit();
		}

		// Update penalty
		$penalty -= $amount;

		// Ensure penalty doesn't go below zero
		if ($penalty < 0) {
			$_SESSION['error'] = 'Amount exceeds the remaining penalty.';
			header('Location: book_issuance.php');
			exit();
		}

		// Update book issuance
		$field = ['id', 'penalty'];
		$data = [$book_issuance_id, $penalty];
		$result = updaterecord('book_issuance', $field, $data);

		if (!$result) {
			$_SESSION['error'] = 'Something went wrong in updating the penalty.';
			header('Location: book_issuance.php');
			exit();
		}

		$_SESSION['success'] = 'Penalty paid with an amount of: ' . $amount;
		header('Location: book_issuance.php');
		exit();
	}
