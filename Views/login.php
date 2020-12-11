<?php 

// database connection
include('./header.php');



?>

<!-- login form -->
<div class="container">
	<div id="login_form" class="well theme_border">
		<h2 id="login_heading" class="text-center theme_color">Please Login</h2>
		<hr>
		<form method="POST" action="../Controllers/login_controller.php">
			<input type="email" maxlength="40" name="email" placeholder="Email Address" class="form-control" autocomplete="off" required>
			<div style="height: 10px;"></div>		
			<input type="password" maxlength="40" name="password" placeholder="Password" class="form-control" autocomplete="off" required> 
			<div style="height: 10px;"></div>
			<br>
			<div class="text-center">
				<button type="submit" id="login_button" class="btn">Login</button> 
				<br>
				<br>
				<br>
				<strong> No account? </strong>
				<a id="signup_back_button" href="./signup.php">Sign up</a>
			</div>
		</form>
		<div style="height: 15px;"></div>
		<div class="text-center" style="color: red; font-size: 15px;">
			<?php
				// display the notifications
				if(isset($_SESSION['msg'])){
					echo $_SESSION['msg'];
					unset($_SESSION['msg']);
				}
			?>
		</div>
	</div>
</div>



<?php 

// including footer
include('./footer.php'); 


?>