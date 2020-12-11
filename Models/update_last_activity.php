<?php

// database connection
include('./conn.php');

// updates the presence logged in of a user 
if(isset($_POST['session_id'])){
    $_SESSION["id"] = $_POST['session_id'];
    $query = mysqli_query($conn, "UPDATE login_details 
    SET `last_activity` = now() 
    WHERE `user_id` = '".$_SESSION["id"]."'
    ");
}


?>