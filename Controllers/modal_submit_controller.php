<?php

// database connection
include('../Models/conn.php');


if(isset($_POST['listing_submit'])) {

// receives the posted values by filtering
    $from_currency = mysqli_real_escape_string($conn, $_POST['from_currency']);
    $from_amount = mysqli_real_escape_string($conn, $_POST['from_amount']);
    $modal_location = mysqli_real_escape_string($conn, $_POST['modal_location']);
    $to_amount = mysqli_real_escape_string($conn, $_POST['to_amount']);

$rate =  $from_amount / $to_amount;
$rate = round($rate, 2);

	$user_id = mysqli_real_escape_string($conn, $_SESSION['id']);
	$email = mysqli_real_escape_string($conn, $_SESSION['email']);
	$name = mysqli_real_escape_string($conn, $_SESSION['name']);

// database query for adding a listing
    mysqli_query($conn, "INSERT INTO all_listing (`email`, `name`, `user_id`, `from_currency`, `from_amount`, `to_amount`, `rate`, `location`) 
    VALUES ('$email', '$name', '$user_id', '$from_currency', '$from_amount', '$to_amount', '$rate', '$modal_location')");
    
echo '<script>alert("Listing Submitted Successfully!");window.location.assign("../Views/profile.php");</script>';

}


?>