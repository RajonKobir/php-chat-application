
<?php

// database connection
include('./conn.php');


// updates the chat messages in every 5s
if (isset($_POST['to_user_id'])){
    echo fetch_user_chat_history($_POST['session_id'], $_POST['to_user_id'], $conn);

}


?>