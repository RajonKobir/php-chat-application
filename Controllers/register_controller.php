<?php
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
		$password = check_input($_POST["password"]);
		$password2 = check_input($_POST["password2"]);

		if($password == $password2){

			$email = check_input($_POST['email']);

				if(email_id_check($email)){

		$fpassword=md5($password);
		$name = check_input($_POST["name"]);
		
// database query for adding a user
mysqli_query($conn, "insert into `user` (name, email, password) values ('$name', '$email', '$fpassword')");
		
// if logged in
		$_SESSION['msg'] = "Signed-Up successfully. You may login now!"; 
		header('location: ../Views/login.php');

			}else{
				// if email exists
				$_SESSION['sign_msg'] = "Try A New Email ID!"; 
				header('location: ../Views/signup.php');
			}

		}else{
			// unmatched passwords
			$_SESSION['sign_msg'] = "Passwords did not match!"; 
			header('location: ../Views/signup.php');
		}

	}else{
		// if already logged in
		$_SESSION['sign_msg'] = "Log Out For Signup Again!";
		header('location: ../Views/signup.php');
	}
}



// email exists or not
function email_id_check($email){
	global $conn;
	
	$query = mysqli_query($conn, "select * from user where email='$email'");
	if(mysqli_num_rows($query) > 0){
		return false;
	}
	else{
		return true;
	}
}


?>