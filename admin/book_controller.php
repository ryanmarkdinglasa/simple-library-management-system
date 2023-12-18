<?php
	error_reporting(E_ALL);
	session_start();
	include "../include/conn.php";
	include "../include/function.php";
	include "include/session.php";
	
	//ADD BOOK
	if (isset($_POST['add'])) {
		$title = trim($_POST['title']);
		$isbn = trim($_POST['isbn']);
		$author = trim($_POST['author']);
		$book_price = trim($_POST['book_price']);
		$genre = trim($_POST['genre']);
		$quantity = trim($_POST['quantity']);
		$created_on = date('Y-m-d H:i:s');

		//CHECK ISBN IF THERE IS ANY DUPLICATION
		$check_isbn=getrecord('book',['isbn',],[$isbn]);
		if(!empty($check_isbn)){
			$_SESSION['error']='Book with that ISBN already exist.';
			echo" <script> window.location.href='book.php'; </script> ";
			exit();
		}
		//ADD NEW STAFF
		$field = ['title','isbn','author','book_price','genre','quantity','created_on'];
		$data = [$title, $isbn, $author, $book_price, $genre, $quantity, $created_on];
		$result = addrecord('book', $field, $data);
		if (!$result) {
				$_SESSION['error'] = 'Something went wrong in adding new book. Please try again.';
				echo" <script> window.location.href='book.php'; </script> ";
				exit();
		}
		$_SESSION['success'] = 'New Book created.';
		echo" <script> window.location.href='book.php'; </script> ";
		exit();
	}

	// EDIT BOOK
	if (isset($_POST['edit'])) {
		$id = trim($_POST['edit_id']);
		$title = trim($_POST['edit_title']);
		$isbn = trim($_POST['edit_isbn']);
		$author = trim($_POST['edit_author']);
		$book_price = trim($_POST['edit_book_price']);
		$genre = trim($_POST['edit_genre']);
		$quantity = trim($_POST['edit_quantity']);

		if (empty($id) || empty($title) || empty($author) || empty($book_price) || empty($genre) || empty($quantity)) {
			$_SESSION['error'] = 'Some fields are missing.';
			header('Location: book.php');
			exit();
		}

		// Validate ISBN format
		if (!preg_match('/^\d{9}[\d|X]$/', $isbn)) {
			$_SESSION['error'] = 'Invalid ISBN format. It should be a 10-digit ISBN.';
			header('Location: book.php');
			exit();
		}

		// Validate book price format
		if (!preg_match('/^\d+(\.\d{1,2})?$/', $book_price)) {
			$_SESSION['error'] = 'Invalid book price format. Please use a valid decimal number (e.g., 10 or 10.99).';
			header('Location: book.php');
			exit();
		}

		// Validate quantity as a positive integer
		if (!ctype_digit($quantity) || intval($quantity) <= 0) {
			$_SESSION['error'] = 'Invalid quantity. Please provide a positive integer value.';
			header('Location: book.php');
			exit();
		}

		// Check for duplicate ISBN excluding the current book
		$sql = "SELECT `id` FROM `book` WHERE `id` <> ? AND `isbn` = ?";
		$stmt = $con->prepare($sql);
		$stmt->execute([$id, $isbn]);
		$duplicateISBN = $stmt->fetch(PDO::FETCH_ASSOC);
		if ($duplicateISBN) {
			$_SESSION['error'] = 'Book with that ISBN already exists for another book.';
			header('Location: book.php');
			exit();
		}

		// Update the book details
		$field = ['id', 'title', 'isbn', 'author', 'book_price', 'genre', 'quantity'];
		$data = [$id, $title, $isbn, $author, $book_price, $genre, $quantity];
		$result = updaterecord('book', $field, $data);
		if (!$result) {
			$_SESSION['error'] = 'Something went wrong while updating the book. Please try again.';
			header('Location: book.php');
			exit();
		}

		$_SESSION['success'] = 'Book details updated successfully.';
		header('Location: book.php');
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
	

	
	