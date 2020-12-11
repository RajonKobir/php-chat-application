<?php

// database connection
include('../Models/conn.php');

// receives the posted value
$listing_id = mysqli_real_escape_string($conn, $_POST['listing_id']);

//remove listing
$delete_listing_query = "DELETE FROM all_listing WHERE `id`='$listing_id'"; 
$result = mysqli_query($conn, $delete_listing_query);



?>