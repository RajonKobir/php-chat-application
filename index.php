
<?php
// adding database connection
include('./Models/conn.php');

// including header
include('./header.php');

?>


<!-- starting the body -->
<div class="container mt-5">
	<div class="row">
        <div class="col-md-6 text-right">
            <h3 class="mt-6 looking_for">I am looking for :</h3>
        </div>
        <div class="col-md-6">
            <select id="select_currency_home" class="form-control select_body">
                <option value="all">All Currency</option>
                <option value="AUD">AUD</option>
                <option value="CNY">CNY</option>
                <option value="EUR">EUR</option>
                <option value="GBP">GBP</option>
                <option value="JPY">JPY</option>
                <option value="KRW">KRW</option>
                <option value="THB">THB</option>
                <option value="USD">USD</option>
            </select>
        </div>
    </div>
</div>


<div class="container mt-5 pt-2" style="margin-bottom:20px">
    <div class="row">
        <select id="select_amount_home" class="ml-2 form-control select_recent">
            <option value="all">Recent</option>
            <option value="high">Highest Amount(SGD)</option>
            <option value="low">Lowest Amount(SGD)</option>
        </select>
    </div>
</div>






<?php

// dynamic configuration of every single listing
$data =  '
<div id="load_more_area" class="container listing_container">
<div class="row">
';  


// initializing query
$displayquery = "SELECT * FROM `all_listing` ORDER BY `timestamp` DESC LIMIT 8"; 


// change the database query upon conditions
if(isset($_GET['select_currency']) || isset($_GET['select_amount'])){
        $select_currency = $_GET['select_currency'];
        $select_amount = $_GET['select_amount'];
    
        if($select_currency != 'all' && $select_amount == 'all'){
            $displayquery = "SELECT * FROM `all_listing` WHERE `from_currency` = '$select_currency' ORDER BY `timestamp` DESC LIMIT 8"; 
        }
    
        else if($select_currency != 'all' && $select_amount != 'all'){
            if($select_amount == 'high'){
                $displayquery = "SELECT * FROM `all_listing` WHERE `from_currency` = '$select_currency' ORDER BY `to_amount` DESC LIMIT 8"; 
            }
            else if($select_amount == 'low'){
                $displayquery = "SELECT * FROM `all_listing` WHERE `from_currency` = '$select_currency' ORDER BY `to_amount` ASC LIMIT 8"; 
            }
        }
    
        else if($select_currency == 'all' && $select_amount != 'all'){
            if($select_amount == 'high'){
                $displayquery = "SELECT * FROM `all_listing`  ORDER BY `to_amount` DESC LIMIT 8"; 
            }
            else if($select_amount == 'low'){
                $displayquery = "SELECT * FROM `all_listing`  ORDER BY `to_amount` ASC LIMIT 8"; 
            }
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
    $data .= '<button type="submit" id="delete_listing" data-listing_id="'.$row['id'].'" class="btn delete_btn theme_border" style="width:80px;">Delete</button>';
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
} 
$data .= '
</div>
</div>';

// this will display all of the listing
echo $data;
?>



<!-- Load More Button -->
<div class="container text-center" style="margin-top:50px;margin-bottom:100px;">
    <a id="load_more" class="btn vw_mr_btn theme_border">View More</a>
    <input type="hidden" id="load_input" name="load_input" value="8">
</div>



<script>



$(document).ready(function(){


// counts and display the unseen messages
count_unseen_header();

	// updating header incomming
	setInterval(function(){
		count_unseen_header();
	}, 5000);

// describing the fn
	function count_unseen_header(){
$.ajax({
		url:"./Models/count_unseen_header.php",
		method:"GET",
		success:function(data)
		{
			if(data != 'no' ){
				$('#header_msg_counter').text(data);
			}
		}
		
	})

}





// delete listing
$(document).on('click', '#delete_listing', function(){
	var confirm_msg = confirm("Are You Sure?");
	if(confirm_msg == true){
		var listing_id = $(this).data('listing_id');
		$.ajax({
				url:"./Controllers/delete_listing_controller.php",
				method:"POST",
				data:{listing_id: listing_id},
				success:function(){
					alert("Listing Is Deleted!");window.location.assign("./index.php");
				}
			})
	}

});


// load more
$(document).on('click', '#load_more', function(){
    var load_number = $('#load_input').val();
    var select_currency = $('#select_currency_home').val();
    var select_amount = $('#select_amount_home').val();
		$.ajax({
				url:"./Models/load_more.php",
				method:"POST",
				data:{
                    load_number: load_number, 
                    select_currency: select_currency,
                    select_amount: select_amount
                    },
				success:function(data){

                    var new_n = $('#load_input').val();
                    var new2 = parseFloat(new_n) + 8;
                    $('#load_input').val(new2);
                    // var load_number = $('#load_input').val();

                    var load_more_area= document.getElementById("load_more_area");
                    var body_link = document.createElement("div");
                    body_link.setAttribute("class", "row");
                    body_link.setAttribute("id", "body_link"+load_number);
                    load_more_area.appendChild(body_link);
                    $('#body_link'+load_number).html(data);

				}
			})

});



// // select currency button on homepage
$("#select_currency_home").change(function(){

var select_currency = $('#select_currency_home').val();
var select_amount = $('#select_amount_home').val();

window.location.assign("./index.php?select_currency="+select_currency+"&select_amount="+select_amount);

});


// // select amount button on homepage
$("#select_amount_home").change(function(){

var select_currency = $('#select_currency_home').val();
var select_amount = $('#select_amount_home').val();

window.location.assign("./index.php?select_currency="+select_currency+"&select_amount="+select_amount);

});




// change on select
// if isset get request from url
$.urlParam = function(name){
    var results = new RegExp('[\\?&]' + name + '=([^&#]*)').exec(window.location.href);
		return results[1] || 0;
	}
	if( $.urlParam('select_currency') != '' || $.urlParam('select_amount') != '' ){
		var select_currency = $.urlParam('select_currency');
		var select_amount = $.urlParam('select_amount');
        $('#select_currency_home').val(select_currency);
        $('#select_amount_home').val(select_amount);

	}
	






});  
</script>


<?php
// including footer
include('./footer.php');


?>









