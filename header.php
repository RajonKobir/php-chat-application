<!DOCTYPE html>
<html>
<head>

	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Currency Change</title>

	<link rel="shortcut icon" href="./Assets/images/favicon.ico" type="image/x-icon">	

<!-- Roboto Font -->
<link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'>
<!-- jQuery library -->
<script src="./Assets/js/jquery.min.js"></script>
<!-- Bootstrap CSS -->
<link rel="stylesheet" href="./Assets/css/bootstrap.min.css" />
<!-- Bootstrap JS -->
<script src="./Assets/js/bootstrap.min.js"></script>
<!-- Custom Fonts -->
<link href="./Assets/font-awesome/css/all.min.css" rel="stylesheet" type="text/css">
<!-- Custom CSS -->
<link rel="stylesheet" href="./Assets/css/style.css">
<!-- Responsive CSS -->
<link rel="stylesheet" href="./Assets/css/responsive.css">

<!-- Additional Plugins, Downloaded -->
<link rel="stylesheet" href="./Assets/css/jquery-ui.css">
<link rel="stylesheet" href="./Assets/css/emojionearea.min.css">
<script src="./Assets/js/jquery-ui.js"></script>
<script src="./Assets/js/emojionearea.min.js"></script>



<script>
$(document).ready(function(){

	
// click on add listing button on top
$('#header_add_listing_btn').click(function(){
		$.ajax({
			url:"./Controllers/modal_controller.php",
			method:"GET",
			success:function(data)
			{
				if(data == 1){
					$("#listing_modal").modal("show");
				}
				else if(data == 0){
					alert("Please Login!");window.location.assign("./Views/login.php");
				}
			}
		})
    

});



// dynamic fn for sending get request to the currency api
function currency_exchange(from_currency, to_currency, from_amount) {

var form = new FormData();
var settings = {
  "url": "https://api.exchangeratesapi.io/latest?base="+from_currency,
  "method": "GET",
  "timeout": 0,
  "processData": false,
  "mimeType": "multipart/form-data",
  "contentType": false,
  "data": form
};

$.ajax(settings).done(function (response) {
    var data = JSON.parse(response);
    var Rate = data.rates;

var x;
for (x in Rate) {
if(x == to_currency){
    var multiple = Rate[x] * from_amount;
	var result = multiple.toFixed(2);
		document.getElementById("to_amount").innerHTML = result;
		document.getElementById("hidden_amount").value = result;
    break;
}
}  // end of for-in loop


}); // end of ajax function


} // end of function currency_exchange



// keyup function for two decimal places
$('#from_amount').keyup(function(){
if($(this).val().indexOf('.')!=-1){         
    if($(this).val().split(".")[1].length > 2){                
        if( isNaN( parseFloat( this.value ) ) ) return;
        this.value = parseFloat(this.value).toFixed(2);
    }  
}    
var from_amount = $('#from_amount').val();
var from_currency = $('#from_currency').val();
	if(from_currency || from_currency != ''){
		currency_exchange(from_currency, 'SGD', from_amount);
	}
return this; //for chaining
});


// dynamic amount showing
$("#from_currency").change(function(){
var from_amount = $('#from_amount').val();
var from_currency = $('#from_currency').val();
if(from_amount || from_amount != ''){
	currency_exchange(from_currency, 'SGD', from_amount);
}

});



});
</script>

	

</head>

<body>
	
<header>
    <div class="container-fluid">
		<div class="row">
			<div class="col-md-2 col-sm-12 col-xs-12 text-center">
				<a class="logo_link" href="./"> <img src="./Assets/images/logo.png" alt="image not found!" width="200"> </a>
			</div>

			<div class="col-md-1 col-md-offset-7 col-sm-4 col-xs-4 text-center">
				<button id="header_add_listing_btn" class="text-center add_listing_btn theme_border">Add Listing</button>
			</div>
			<div class="col-md-1 col-sm-4 col-xs-4 text-center"> 
				<a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fas fa-user-circle user_icon"></i></a>
				<?php 
				if(!isset( $_SESSION['id'] ) || $_SESSION['id'] == ''){
					echo '
					<ul class="dropdown-menu">
						<li><a href="./Views/login.php" data-toggle="modal">Login</a></li>
						<li><a href="./Views/signup.php">Signup</a></li>
					</ul>
					';
				}else{
					echo '
					<ul class="dropdown-menu">
						<li><a href="./Views/profile.php" data-toggle="modal">Profile</a></li>
						<li><a href="./Controllers/logout_controller.php">Logout</a></li>
					</ul>
					';
				}
				?>
			</div>
			<div class="col-md-1 col-sm-4 col-xs-4 text-center"> 
				<a href="./Views/inbox.php">
					<i id="header_msg_icon" class="fas fa-comment-alt comment_box"></i>
					<p id="header_msg_counter"></p>
				</a>
			</div>
			</div>
		</div>
    </div>
</header>



<!-- //////////////// ADD LISTING MODAL ////////////////// -->
<div class="modal fade" id="listing_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			<h5 class="text-center"> New Listing </h5><br>
			<p>You have:</p>

			<form method="POST" action="./Controllers/modal_submit_controller.php" class="form">
				<div class="row">
					<div class="col-sm-2">
						<label class="font-weight-bold mt-1">Currency:</label>
					</div>
					<div class="col-sm-4">
						<div class="form-group">
							<select id="from_currency" name="from_currency" class="form-control" required autofocus>
										<option value="">Select Currency</option>
										<option value="AUD">AUD</option>
										<option value="CNY">CNY</option>
										<option value="EUR">EUR</option>
										<option value="GBP">GBP</option>
										<option value="JPY">JPY</option>
										<option value="KRW">KRW</option>
										<option value="THB">THB</option>
										<option value="USD">USD</option>
							</select>
						</div>

					</div>
					<div class="col-sm-2">
						<label class="font-weight-bold mt-1">Amount:</label>
					</div>
					<div class="col-sm-4">
						<div class="form-group">
						<input type="number" min="1" max="999999999999999" step="0.01" id="from_amount" name="from_amount" style="width: 100%;" class="form-control ml-2" placeholder="0.00" required>
					</div>
					</div>
				</div>

			<p>Exchanging to:</p>

			<div>
				<h5 class="text_color">SGD &nbsp; &nbsp; 
				<span id="to_amount">0.00</span>
				<input type="hidden" id="hidden_amount" name="to_amount" value="0.00" readonly>	 
				&nbsp;<button class="live_btn theme_color theme_border" style="background:#fff;"><i class="fa fa-bolt mr-2 theme_color"> </i>live</button></h5>
			</div>

			<p>Meet up Location:</p>
			<input name="modal_location" maxlength="60" style="width: 100%;" type="text" class="form-control ml-2" value="" placeholder="Location" required>

			<div class="form-group text-center mt-4">
				<input type="submit" name="listing_submit" value="Create Listing" class="btn create_listing_btn px-5 theme_border">
			</div>
			</form>
			</div>
		</div>
	</div>
</div>
<!-- modal end -->

