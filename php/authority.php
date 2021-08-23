<?php
	include('init.php');
	if(!isset($_SESSION['user_id']))
		header("Location: php/login.php");

?>