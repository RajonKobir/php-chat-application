<?php
// session starts
	session_start();

// database connection
	include('../Models/conn.php');
	
// if not logged-in
	if (!isset($_SESSION['id']) || (trim ($_SESSION['id']) == '')) {
		echo '<script>alert("Please Login!");window.location.assign("../Views/login.php");</script>';
    exit();
	}
	
		
?>