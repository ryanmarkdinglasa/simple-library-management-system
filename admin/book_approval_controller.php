<?php
	error_reporting(E_ALL);
	session_start();
	include "../include/conn.php";
	include "../include/function.php";
	include "include/session.php";
	
	// approve
	if (isset($_GET['on'])) {
		$id = $_GET['id'];
		try {
			$con->beginTransaction();
	
			// Fetch the book issuance record
			$get_book_issuance = getrecord('book_issuance', ['id'], [$id]);
			$stmt = $con->prepare("UPDATE `book_issuance` SET `is_approve`=?, `approved_by`=? WHERE id=? LIMIT 1");
			$approver = $user['lastname'] . ', ' . $user['firstname'];
	
			if (!$stmt->execute(['1', $approver, $id])) {
				throw new Exception('Failed to approve issued book.');
			}
	
			// Update book quantity
			$get_quantity = getrecord('book', ['id'], [$get_book_issuance['book_id']]);
			$book_quantity = intval($get_quantity['quantity']) - 1;
	
			$update_book_quantity = $con->prepare("UPDATE `book` SET `quantity`=? WHERE id=? LIMIT 1");
			if (!$update_book_quantity->execute([$book_quantity, $get_book_issuance['book_id']])) {
				throw new Exception('Failed to update book quantity.');
			}
	
			$con->commit();
			$_SESSION['success'] = 'Issued book is approved.';
			header('Location: book_issuance.php');
			exit();
		} catch (PDOException | Exception $e) {
			$con->rollBack();
			$_SESSION['error'] = 'Something went wrong.' . $e->getMessage();
			header('Location: book_issuance.php');
			exit();
		}
	}
	
	
	// disapprove a issued book
	if (isset($_GET['off']) && $_GET['off'] == 1) {
		$id = $_GET['id'];
		try {
			$con->beginTransaction();
	
			$stmt = $con->prepare("UPDATE `book_issuance` SET `is_approve`=?, `approved_by`=? WHERE id=? LIMIT 1");
			$approver = $user['lastname'] . ', ' . $user['firstname'];
	
			if (!$stmt->execute(['-1', $approver, $id])) {
				throw new Exception('Failed to disapprove the issued book.');
			}
	
			$con->commit();
			$_SESSION['success'] = 'Issued book is disapproved.';
			header('Location: book_issuance.php');
			exit();
		} catch (PDOException | Exception $e) {
			$con->rollBack();
			$_SESSION['error'] = 'Something went wrong.' . $e->getMessage();
			header('Location: book_issuance.php');
			exit();
		}
	}
	
	