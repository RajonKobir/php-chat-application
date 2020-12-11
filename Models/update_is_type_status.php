<?php

// database connection
include('./conn.php');

// everytime a user starts writing a message
if(isset($_POST['session_id'])){
    $_SESSION["id"] = $_POST['session_id'];
    $query = mysqli_query($conn, "UPDATE login_details 
    SET is_type = '".$_POST["is_type"]."' 
    WHERE `user_id` = '".$_SESSION["id"]."'
    ");
}


?>