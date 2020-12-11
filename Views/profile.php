<?php 
// adding database connection and logged in check
include('../Controllers/session_controller.php');

// including header
include('./header.php'); 

?>



<!-- starting the body -->
<div class="container">
	<div class="row">
		<div class="col-md-4 col-sm-3">
			<p class="" style="color: #757E47; font-size:18px;font-weight:bold;">Welcome <?php echo $_SESSION['name']; ?>!</p>
		</div>
	</div>
</div>
		




<div class="container">
	<div id="profile_listing">
		

<?php


// dynamic configuration of every single listing
$data =  '
<div id="load_more_area" class="container listing_container" style="margin-top:10px;">
<div class="row">
';  

// initializing query
$displayquery = "SELECT * FROM `all_listing` WHERE `user_id` = '".$_SESSION['id']."' ORDER BY `id` DESC LIMIT 8"; 
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
        <div class="" style="margin-left:30%;">
            <button type="submit" id="delete_listing" data-listing_id="'.$row['id'].'" class="btn delete_btn theme_border">Delete</button>
        </div> 
    </div>
</div>



</div>
</div>
';


}

$data .= '
</div>
</div>
<div class="text-center" style="margin-top:50px;margin-left:40px;margin-bottom:100px;">
    <a id="load_more" class="btn vw_mr_btn theme_border">View More</a>
    <input type="hidden" id="load_input" name="load_input" value="8">
</div>';



} else{
    $data = '<p class="text-center" style="margin-top:20px;">Please add a Listing!</p>';
}


// this will display all of the listing ofthis individual user
echo $data;


?>



	</div>
</div>






<script>  




$(document).ready(function(){




// delete listing
$(document).on('click', '#delete_listing', function(){
	var confirm_msg = confirm("Are You Sure?");
	if(confirm_msg == true){
		var listing_id = $(this).data('listing_id');
		$.ajax({
				url:"../Controllers/delete_listing_controller.php",
				method:"POST",
				data:{listing_id: listing_id},
				success:function(data){
					alert("Listing Is Deleted!");window.location.assign("./profile.php");
				}
			})
	}

});



// load more
$(document).on('click', '#load_more', function(){
    var load_number = $('#load_input').val();
		$.ajax({
				url:"../Models/load_more_profile.php",
				method:"POST",
				data:{load_number: load_number},
				success:function(data){

                    var new_n = $('#load_input').val();
                    var new2 = parseFloat(new_n) + 8;
                    $('#load_input').val(new2);
                    var load_number = $('#load_input').val();

                    var load_more_area= document.getElementById("load_more_area");
                    var body_link = document.createElement("div");
                    body_link.setAttribute("class", "row");
                    body_link.setAttribute("id", "body_link"+load_number);
                    load_more_area.appendChild(body_link);
                    $('#body_link'+load_number).html(data);


				}
			})

});


	
});  
</script>






<?php 

include('./footer.php'); 


?>