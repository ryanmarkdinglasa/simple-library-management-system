<?php
	session_start();
	include("../include/conn.php");
	include("include/session.php");
	include("../include/function.php");
	if($user['username']){
		session_unset();
		session_destroy();
	}	
?>
<script language="javascript">
document.location="../";
</script>
