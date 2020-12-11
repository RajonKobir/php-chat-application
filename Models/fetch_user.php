<?php

// database connection
include('../Models/conn.php');

// receives the posted value
if(isset($_POST['session_id'])){
    $_SESSION['id'] = $_POST['session_id'];




$output = '';

// setting up the query
$query = mysqli_query($conn, "SELECT * FROM chat_message WHERE `to_user_id` = '".$_SESSION['id']."'
OR `from_user_id` = '".$_SESSION['id']."' ORDER BY `timestamp` DESC");

if(mysqli_num_rows($query) > 0){

$result = mysqli_fetch_all($query);


$chat_ids = array();  // initialize an empty array

// loop into every results from query
foreach($result as $row)
{
	
	if($row[1] != $_SESSION['id']){
		array_push($chat_ids, $row[1]);
	}
	if($row[2] != $_SESSION['id']){
		array_push($chat_ids, $row[2]);
	}


	
}		// foreach ends


// puts all chatted users in an array
$unique_chat_ids = array_unique($chat_ids);

$i = 1;

// loop into every elements in the array
foreach($unique_chat_ids as $single_id){

// getting usernames
	$username = get_user_name($single_id, $conn);

// inbox page left sidebar
	$output .= '
		<a id="button'.$i.'" class="btn chat_list start_chat" data-touserid="'.$single_id.'" data-tousername="'.$username.'">
		<div class="chat_people">
	';


		$status = '';
		$current_timestamp = strtotime(date("Y-m-d H:i:s") . '- 10 second');
		$current_timestamp = date('Y-m-d H:i:s', $current_timestamp);
		$user_last_activity = fetch_user_last_activity($single_id, $conn);

		if($user_last_activity > $current_timestamp)
		{
		$status = '<div class="chat_img"><i class="fa fa-dot-circle" style="color:green;"></i> </div>';
		}
		else
		{
		$status = '<div class="chat_img"><i class="fa fa-dot-circle" style="color:#999;"></i> </div>';
		}

		

		$output .= '
		'.$status.'
		<div class="chat_ib">
		<h5 class="click_user_field">'.$username.'<span class="chat_date">'.count_unseen_message($single_id, $_SESSION['id'], $conn).'
		</span></h5><p>'.fetch_is_type_status($single_id, $conn).'</p></div>';


$output .= '
	</div>
	</a>
';

$i++;

}    // foreach ends


}else{  // if any rows not found from query
	$output .= '<tr><td colspan="3"><p class="text-center">No Message History!</p></td></tr>';
}




echo $output;

} // end of if isset


?>
