<?php
 
//MySQLi Procedural for server
$conn = mysqli_connect("localhost","idealitc_root","Rajon1573","idealitc_currency_change");
if (!$conn) {
	die("Connection failed: " . mysqli_connect_error());
}
 

// //MySQLi Procedural for local
// $conn = mysqli_connect("localhost","root","","currency_change");
// if (!$conn) {
// 	die("Connection failed: " . mysqli_connect_error());
// }



// setup timezone
date_default_timezone_set('Asia/Dhaka');



// fetches a users last logged-in timestamp
function fetch_user_last_activity($user_id, $conn)
{
 $query = mysqli_query($conn, "SELECT `last_activity` FROM login_details WHERE `user_id`='$user_id' ORDER BY `last_activity` DESC LIMIT 1");
 
 if(mysqli_num_rows($query) > 0){
    $result = mysqli_fetch_assoc($query);
    return $result['last_activity'];
 }


}


// fetches users chat messages
function fetch_user_chat_history($from_user_id, $to_user_id, $conn)
{
 $query = mysqli_query($conn, "SELECT * FROM chat_message 
 WHERE (`from_user_id` = '$from_user_id' 
 AND `to_user_id` = '$to_user_id')
 OR (`from_user_id` = '$to_user_id' 
 AND `to_user_id` = '$from_user_id')
 ORDER BY `timestamp` DESC");

 $result = mysqli_fetch_all($query);

 $output = '<ul class="list-unstyled">';


 foreach($result as $row)
 {
     $user_name = '';
     $dynamic_background = '';
     $chat_message = '';
     if($row[2] == $from_user_id)
     {
         if($row[5] == '2')
         {
             $chat_message = '<em>This message has been removed</em>';
             $user_name = '<b class="theme_color">You</b>';
         }
        // delete button in chat(bellow)
         else
         {
             $chat_message = $row[3];
            //  $user_name = '<button type="button" class="btn btn-danger btn-xs remove_chat" id="'.$row[0].'">x</button>&nbsp;<b class="text-success">You</b>';
             $user_name = '<b class="theme_color">You</b>';
         }
         

         $dynamic_background = 'background-color:#f1f1f1;';
     }
     else
     {
         if($row[5] == '2')
         {
             $chat_message = '<em>This message has been removed</em>';
         }
         else
         {
             $chat_message = $row[3];
         }
         $user_name = '<b class="" style="color: #757E47;">'.get_user_name($row[2], $conn).'</b>';
         $dynamic_background = 'background-color:#fff;';
     }
     $output .= '
     <li style="border-bottom:1px dotted #ccc;border-left:1px dotted #ccc;padding-top:8px; padding-left:8px; padding-right:8px;'.$dynamic_background.'">
         <p>'.$user_name.' - '.$chat_message.'
             <div align="right">
                 - <small><em>'.$row[4].'</em></small>
             </div>
         </p>
     </li>
     ';
 }



$output .= '</ul>';

$query = mysqli_query($conn, "UPDATE chat_message 
SET `status` = '0' 
WHERE from_user_id = '".$to_user_id."' 
AND to_user_id = '".$from_user_id."' 
AND `status` = '1'
");

 return $output;

} // end of fn



// returns the user name upon user id
function get_user_name($user_id, $conn)
{
 $query = mysqli_query($conn, "SELECT `name` FROM `user` WHERE `id` = '$user_id'");

 if(mysqli_num_rows($query) > 0){
 $result = mysqli_fetch_all($query);
    foreach($result as $row)
    {
     return $row[0];
    }

}
}



// counts the unseen messages
function count_unseen_message($from_user_id, $to_user_id, $conn)
{
 $result=mysqli_query($conn, "SELECT * FROM chat_message 
 WHERE `from_user_id` = '$from_user_id' 
 AND `to_user_id` = '$to_user_id' 
 AND `status` = '1'
 ");
 $count = mysqli_num_rows($result);
 $output = '';
 if($count > 0)
 {
  $output = '<span class="label label-success">'.$count.'</span>';
 }
 return $output;
}



// chatted persons typing or not
function fetch_is_type_status($user_id, $conn)
{
 $query = mysqli_query($conn, "SELECT `is_type` FROM login_details 
 WHERE `user_id` = '".$user_id."' 
 ORDER BY last_activity DESC 
 LIMIT 1");

if(mysqli_num_rows($query) > 0){

 $result = mysqli_fetch_assoc($query);

 $output = '';
  if($result['is_type'] == 'yes')
  {
   $output = ' - <small><em><span class="text-muted">Typing...</span></em></small>';
  }

 return $output;

}

}



?>