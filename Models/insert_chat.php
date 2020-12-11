<?php

// database connection
include('./conn.php');


// receives the posted values
$to_user_id  = mysqli_real_escape_string($conn, $_POST['to_user_id']);
$from_user_id = mysqli_real_escape_string($conn, $_POST['from_user_id']);
$chat_message  = mysqli_real_escape_string($conn, $_POST['chat_message']);
$status   = '1';


// database query for save the message
$query = mysqli_query($conn, "INSERT INTO chat_message 
(`to_user_id`, `from_user_id`, `chat_message`, `status`) 
VALUES ('$to_user_id', '$from_user_id', '$chat_message', '$status')
");


if($query)
{
// updates the chat messages instantly
 echo fetch_user_chat_history($from_user_id, $to_user_id, $conn);
}

?>