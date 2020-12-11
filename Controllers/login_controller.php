<?php
// session starts
	session_start();

// database connection
	include('../Models/conn.php');

// filters unnecesarry inputs
	function check_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
	
// if post method found
	if ($_SERVER["REQUEST_METHOD"] == "POST") {

		if (!isset($_SESSION['id']) || (trim ($_SESSION['id']) == '')) {

// saving inputs filtering through check_input fn
		$email = check_input($_POST['email']);
		$password = check_input($_POST["password"]);
		$fpassword=md5($password);
		
// database query for a user exists or not
		$query=mysqli_query($conn,"select * from `user` where email='$email' and password='$fpassword'");
		
		if(mysqli_num_rows($query)==0){
			$_SESSION['msg'] = "Login Failed, Invalid Input!";
			header('location: ../Views/login.php');
		}
		else{
			
			$row=mysqli_fetch_array($query);

// building the session variables
// most important
				$_SESSION['id'] = $row['id'];
				$_SESSION['name'] = $row['name'];
				$_SESSION['email'] = $row['email'];
				$sub_query = mysqli_query($conn, "INSERT INTO login_details (`user_id`, `user_email`) 
				VALUES ('".$row['id']."', '".$row['email']."')
				");
// login success
echo '<script>window.alert("Logged-In Successfully, Welcome!");window.location.href="../";</script>';
		}
		
	}else{
		$_SESSION['msg'] = "You're Already Logged-In!";
		header('location: ../Views/login.php');
	}
}
?>