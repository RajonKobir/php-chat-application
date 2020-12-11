<?php

// database connection
include('./conn.php');


// recieves the post requests from homepage
$load_number = $_POST['load_number'];
$select_currency = $_POST['select_currency'];
$select_amount = $_POST['select_amount'];


// initializing with empty variable
$data = '';
$displayquery= '';

// change the database query upon conditions
    if($select_currency == 'all' && $select_amount == 'all'){
        $displayquery = "SELECT * FROM `all_listing` ORDER BY `timestamp` DESC LIMIT $load_number, 8"; 
    }
   
    else if($select_currency != 'all' && $select_amount == 'all'){
        $displayquery = "SELECT * FROM `all_listing` WHERE `from_currency` = '$select_currency' ORDER BY `timestamp` DESC LIMIT $load_number, 8"; 
    }

    else if($select_currency != 'all' && $select_amount != 'all'){
        if($select_amount == 'high'){
            $displayquery = "SELECT * FROM `all_listing` WHERE `from_currency` = '$select_currency' ORDER BY `to_amount` DESC LIMIT $load_number, 8"; 
        }
        else if($select_amount == 'low'){
            $displayquery = "SELECT * FROM `all_listing` WHERE `from_currency` = '$select_currency' ORDER BY `to_amount` ASC LIMIT $load_number, 8"; 
        }
    }

    else if($select_currency == 'all' && $select_amount != 'all'){
        if($select_amount == 'high'){
            $displayquery = "SELECT * FROM `all_listing`  ORDER BY `to_amount` DESC LIMIT $load_number, 8"; 
        }
        else if($select_amount == 'low'){
            $displayquery = "SELECT * FROM `all_listing`  ORDER BY `to_amount` ASC LIMIT $load_number, 8"; 
        }
    }
    

// executing the query
$result = mysqli_query($conn, $displayquery);

if(mysqli_num_rows($result) > 0){

// loop into every results from the query
    while ($row = mysqli_fetch_array($result)) {
    
        $data .= '
        <div class="col-md-6" style="">
        <div class="main_listing theme_border2" style="">
        
    <div class="row" style="margin-top:30px;margin-left:10px;">
    <div class="col-md-5">
        <span class="" style="font-size:20px; font-weight: bold;">'.$row['from_amount'].' &nbsp; '.$row['from_currency'].'</span>
    </div>
    <p class="col-md-2">to</p>
    <div class="col-md-5">
        <span class="theme_color" style="font-size:20px; font-weight: bold;">'.$row['to_amount'].' &nbsp; '.$row['to_currency'].'</span>
    </div>
    </div>
    
    
    <div class="row" style="margin-top:40px;margin-left:10px">
        <div class="col-md-6">
            <div class="rate_div float_left">
                <h1 calss="rate_div" style="font-size:20px;display:inline;">Rate: <span style="font-size:16px;color: #757E47;">'.$row['rate'].' &nbsp;</span></h1>
            </div>
            <div class="theme_border float_left" style="display:inline;">
                <i style="font-size:12px;color:#757E47" class="fa fa-bolt"></i><span style="font-size:12px;color:#757E47"> LIVE</span>
            </div>
        </div>
    
        <div class="col-md-6">
            <div class="marker_div float_left" style="margin-left: 45px;">
                <i style="font-size:25px;color:#999;" class="fa fa-map-marker"></i> 
            </div>
            <div class="location_div float_left">
                <p style="font-size:14px;" class="location_p">&nbsp; '.$row['location'].'</p>
            </div>
        </div>
    </div>
    
    
    
    <div class="row" style="margin-left:10px">
    <div class="col-md-6" >
        <div class="" style="">
            <div class="float_left" style="padding-right: 10px;">
                <i class="fa fa-user-circle" style="font-size: 40px;color:#999;"></i>
            </div> 
            <div class="float_left" style="padding-top: 10px;">
                <p class="name_p" style="font-size:16px;">'.$row['name'].'</p> 
            </div>    
        </div>       
    </div>     
        <div class="col-md-6 float-right">
            <div class="" style="margin-left:30%;">';
    
// delete or chat button upon logged in or not
    if (isset($_SESSION['id']) && $_SESSION['id'] == $row['user_id']) {
        $data .= '<button type="submit" id="delete_listing" data-listing_id="'.$row['id'].'" class="btn chat_btn theme_border">Delete</button>';
    }else{
        $data .= '<a target="_blank" href="./Views/inbox.php?chat_id='.$row['user_id'].'&chat_name='.$row['name'].'"><button type="submit" class="btn chat_btn theme_border">Chat</button></a>';
    }
    
      
    
    $data .= '</div> 
        </div>
    </div>
    
    
    
    </div>
    </div>
    ';
    
    }
} else{
    $data = '<div class="row text-center" style="margin-top:30px;"><p>No More Data!</p></div>';
}

// this will display all of the required listing
echo $data;



?>