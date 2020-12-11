<?php 

// database connection
include('./header.php');


?>

<!-- signup form -->
<div class="container">
	<div id="signup_form" class="well theme_border">
		<h2 id="signup_heading" class="text-center theme_color">Registration</h2>
		<hr>
		<form method="POST" action="../Controllers/register_controller.php">
		<input type="text" maxlength="18" name="name" placeholder="Name" class="form-control" autocomplete="off" required>
		<div style="height: 10px;"></div>
		<input type="email" maxlength="40" name="email" placeholder="Email Address" class="form-control" autocomplete="off" required>
		<div style="height: 10px;"></div>		
		<input type="password" maxlength="40" name="password" placeholder="Password" class="form-control" autocomplete="off" required> 
		<div style="height: 10px;"></div>
		<input type="password" maxlength="40" name="password2" placeholder="Retype-Password" class="form-control" autocomplete="off" required> 
		<div style="height: 10px;"></div>
		<br>
		<div class="text-center">
		<button id="signup_button" type="submit" class="btn">Register</button> 
		<br>
		<br>
		<a id="login_back_button" href="./login.php">Back to Login</a>
		</form>
		<div style="height: 15px;"></div>
		<div style="color: red; font-size: 15px;">
			<?php
				// display the notifications
				if(isset($_SESSION['sign_msg'])){
					echo $_SESSION['sign_msg'];
					unset($_SESSION['sign_msg']);
				}
			?>
			</div>
		</div>
	</div>
</div>


<?php 

// including footer
include('./footer.php'); 


?>