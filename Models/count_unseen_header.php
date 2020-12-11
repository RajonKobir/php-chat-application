<?php 

// starts the session
session_start();

// including the database connection
include('./conn.php');

// if not logged in
if (!isset($_SESSION['id']) || (trim ($_SESSION['id']) == '')) {

    echo 'no';

}

// if logged in
else if (isset($_SESSION['id']) || (trim ($_SESSION['id']) != '')){
    $result = mysqli_query($conn, "SELECT * FROM chat_message 
    WHERE `to_user_id` = '".$_SESSION['id']."' 
    AND `status` = '1' ");
    $count = mysqli_num_rows($result);
    $output = '';
    if($count > 0)
    {
     $output = $count;
    }
    echo $output;
}







?>