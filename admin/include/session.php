<?php
	include '../include/conn.php';
		if($_SESSION['type']=='admin'){
			$stmt = $con->prepare("SELECT * FROM `user` WHERE `id` = ? LIMIT 1");
			$stmt->execute([$_SESSION['admin']]);
			$user = $stmt->fetch(PDO::FETCH_ASSOC);;
			if(empty($user)){
				echo"<script>window.location.href='../403.php';</script>";
			}
		}else{
			echo"<script>window.location.href='../403.php';</script>";
		}
	
	
