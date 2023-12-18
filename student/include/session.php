<?php
	include '../include/conn.php';
		if($_SESSION['type']=='student'){
			$stmt = $con->prepare("SELECT * FROM `user` WHERE `id`= ? LIMIT 1");
			$stmt->execute([$_SESSION['student']]);
			$user = $stmt->fetch(PDO::FETCH_ASSOC);;
			if(empty($user)){
				echo"<script>window.location.href='../403.php';</script>";
			}
		}else{
			echo"<script>window.location.href='../403.php';</script>";
		}
		if($_SESSION['type']=='' || $_SESSION['type']==NULL){
			echo"<script>window.location.href='../403.php';</script>";
		}
