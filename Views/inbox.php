<?php 

// adding database connection and logged in check
include('../Controllers/session_controller.php');

// including header
include('./header.php'); 


?>



<!-- starting the body -->
<div class="container">
	<h3 class=" text-center">INBOX</h3>
	<div class="messaging">

		<div class="inbox_msg">

			<div class="inbox_people">

					
				<div id="inbox_chat" class="inbox_chat"> <!-- loads chatted users -->
				
				</div>

			</div>

			<div class="mesgs">


				<div id="msg_history" class="msg_history"> <!-- display messages -->

				</div>


				<div id="type_msg" class="type_msg"> <!-- type and send msg area -->

				</div>


        	</div>




		</div>
		

		
	</div>
</div>






<script>  




$(document).ready(function(){


	fetch_user();
	

	// updating all in every 10 seconds
	setInterval(function(){
		update_last_activity();
		fetch_user();
		update_chat_history_data();
	}, 5000);

// first_instance();

// send message handler
function message_send(){

var to_user_id = $('.msg_send_btn').attr('id');
var from_user_id = <?php echo $_SESSION["id"]; ?>;
var chat_message = $('.emojionearea-editor').html();
if(chat_message != '')
	{

		if(to_user_id !== "undefined" &&  to_user_id != ''){
			$('.write_msg').val("");
					$('.notificaton_area').text("Message Sent!");
					$.ajax({
						url:"../Models/insert_chat.php",
						method:"POST",
						data:{
						    to_user_id:to_user_id,
						    from_user_id: from_user_id,
						    chat_message:chat_message
						},
						success:function(data)
						{
							var element = $('#chat_message_'+to_user_id).emojioneArea();
							element[0].emojioneArea.setText('');
							$('#msg_history').html(data);
						}
					})
		} // if ends
		else{
			$('.notificaton_area').text("Undefined Reciever!!!");
		}


	} // if chat msg ends
	else
	{
		$('.notificaton_area').text("Please Type a message!");
	}

} // function message_send ends






// function for getting url params
function getUrlVars() {
		var vars = {};
		var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
			vars[key] = value;
		});
		return vars;
	}

// checks if there any information in the url
if( getUrlVars()["chat_id"] != '' && getUrlVars()["chat_name"]  != ''){
	
var chat_id = getUrlVars()["chat_id"];
var chat_name = getUrlVars()["chat_name"];

if(chat_id != '' && chat_name != '' && typeof chat_id != "undefined" && typeof chat_name != "undefined"){
	// starts the write and send message area
	make_chat_dialog_box(chat_id, chat_name);

// starts the emojione free pluging	
$('.write_msg').emojioneArea({
	pickerPosition:'top',
	toneStyle: 'bullet',
	events: {
		keyup: function (editor, event) {
					var text = this.getText();
					if(text.length > 200){
						this.setText(text.substring(0, 200));
						alert('Maximum Limits Exceeded!');
					}
					if (event.keyCode === 13 && !event.shiftKey) {
								message_send();
							}
					
				}
			}
});
}else{

// when enter into inbox
setTimeout(function(){
	first_instance();
}, 1000);
}


} // if condition for URL ends here





// updates the chat inbox in every 5s
	function update_chat_history_data()
	{

		$('.chat_people').each(function(){
			var to_user_id = $('.msg_send_btn').data('touserid');
			fetch_user_chat_history(to_user_id);
		});
	}



// fetches chatted users
	function fetch_user()
	{
	    var session_id = <?php echo $_SESSION["id"]; ?>;
		$.ajax({
			url:"../Models/fetch_user.php",
			method:"POST",
			data:{
			    session_id: session_id
			},
			success:function(data){
				$('#inbox_chat').html(data);
			}
		})
	}
	
	


// fetches users chat messages in every 5s
	function fetch_user_chat_history(to_user_id){
	    var session_id = <?php echo $_SESSION["id"]; ?>;
		$.ajax({
			url:"../Models/fetch_user_chat_history.php",
			method:"POST",
			data:{
			    to_user_id: to_user_id,
			    session_id: session_id
			},
			success:function(data){
				$('#msg_history').html(data);
			}
		})
	}

	
	



// when member enter inbox
function first_instance(){
	var to_user_id = $('#button1').data('touserid');
	var to_user_name = $('#button1').data('tousername');
if(to_user_id !== "undefined" &&  to_user_id != ''){
	// starts the write and send message area
	make_chat_dialog_box(to_user_id, to_user_name);

// starts the emojione free pluging	
	$('.write_msg').emojioneArea({
		pickerPosition:'top',
		toneStyle: 'bullet',
		events: {
			keyup: function (editor, event) {
						var text = this.getText();
						if(text.length > 200){
							this.setText(text.substring(0, 200));
							alert('Maximum Limits Exceeded!');
						}

					if (event.keyCode === 13 && !event.shiftKey) {
								message_send();
							}
					}
				}
	});
}


}



// updates a users logged-in timestamp in every 5s
	function update_last_activity()
	{
	    var session_id = <?php echo $_SESSION["id"]; ?>;
		$.ajax({
			url:"../Models/update_last_activity.php",
			method:"POST",
			data:{
			    session_id: session_id
			},
			success:function()
			{

			}
		})
	}



// sends user id and name to the send button

	function make_chat_dialog_box(to_user_id, to_user_name)
{

var modal_content = '<div class="input_msg_write"><textarea id="chat_message_'+to_user_id+'" class="write_msg" placeholder="Type a message to '+to_user_name+'"></textarea>';
modal_content += '<button id="'+to_user_id+'" class="btn msg_send_btn" data-tousername="'+to_user_name+'" data-touserid="'+to_user_id+'">Send Message</button>';
modal_content += '<p id="sent_message_'+to_user_id+'" class="notificaton_area" style="color: #757E47;"></p></div>';

 fetch_user_chat_history(to_user_id);

 $('#type_msg').html(modal_content);
}


// when clicked on users on left nav
	$(document).on('click', '.start_chat', function(){
		var to_user_id = $(this).data('touserid');
		var to_user_name = $(this).data('tousername');

if(to_user_id != '' && to_user_name != ''){
	// starts the write and send message area
	make_chat_dialog_box(to_user_id, to_user_name);

	// starts the emojione free pluging	
		$('.write_msg').emojioneArea({
			pickerPosition:'top',
			toneStyle: 'bullet',
			events: {
				keyup: function (editor, event) {
							var text = this.getText();
							if(text.length > 200){
								this.setText(text.substring(0, 200));
								alert('Maximum Limits Exceeded!');
							}

					if (event.keyCode === 13 && !event.shiftKey) {
								message_send();
							}

						}
                      } //events end
		});
}


	});






// when clicked on message send button
	$(document).on('click', '.msg_send_btn', function(){
		message_send();

	});







// if a user starts writing
	$(document).on('focus', '.write_msg', function(){
	    var session_id = <?php echo $_SESSION["id"]; ?>;
		var is_type = 'yes';
		$.ajax({
			url:"../Models/update_is_type_status.php",
			method:"POST",
			data:{
			    is_type: is_type,
			    session_id: session_id
			},
			success:function()
			{

			}
		})
	});


// when the user stops writing
	$(document).on('blur', '.write_msg', function(){
	    var session_id = <?php echo $_SESSION["id"]; ?>;
		var is_type = 'no';
		$.ajax({
			url:"../Models/update_is_type_status.php",
			method:"POST",
			data:{
			    is_type: is_type,
			    session_id: session_id
			},
			success:function()
			{
				
			}
		})
	});



	



	
});  
</script>








<?php 


include('./footer.php'); 


?>