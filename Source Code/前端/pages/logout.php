<?php 
	setcookie('username',"",time()-3600);
    setcookie("role","",time()-3600);
    setcookie("recent_operations", "", 1, "/");
	header('Location:login.php');
?>