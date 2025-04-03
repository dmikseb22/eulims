<?php

use yii\helpers\Html;
use kartik\file\FileInput;
use yii\widgets\ActiveForm;
use common\components\Functions;

$func= new Functions();
/* @var $this yii\web\View */
/* @var $searchModel common\models\message\ChatSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Chats';
$this->params['breadcrumbs'][] = $this->title;

$this->registerCssFile("/css/modcss/chat.css", [
], 'css-chat');
?>
<div class="chat-index">
	
	<!-- MODAL HERE!! -->
	<button class="open-button" onclick="openForm()"><i class="fa fa-commenting-o"></i></button>
	<div class="chat-popup" id="myForm" name="myForm">
		<form class="form-container" enctype="multipart/form-data">
			<div class="chat-popup-header">
				<!--<span>OneLab Chat</span>-->
				<!--i class="fa fa-plus" id="plusgc"></i -->
				<a onclick="LoadModal('Create Group', '/chat/info/group');" href="#"><i class="fa fa-group"></i></a>
				<i class="fa fa-gear"></i>
				
				<label id="profilenamepop"> &nbsp;</label>
				<label id="chattype" hidden> &nbsp;</label> <!-- message(1) or file(2) -->
				<label id="ctype" hidden> &nbsp;</label> <!-- personnal(1) or group(2) -->
				<label id="dataid" hidden> &nbsp;</label> <!-- contact_id or group_id -->
				<!--label id="recipientid" hidden> &nbsp;</label -->
				<input type="text" id="recipientid" name="recipientid" hidden>
				<i class="fa fa-close" onclick="closeForm()"></i>

			</div>
			<div class="chat-popup-tab">
				<button type="button" class="btntab" id="btnuser"><i class="fa fa-user"></i></button>
			
				<button type="button" class="btntab" id="btngroup"><i class="fa fa-group"></i></button>
				 
			</div>
			<div class="scroll-style1" id="popchatbody">
			
			</div>
			<input type="file" name="filetoupload" id="UploadFile">
			<div class="chat-popup-footer">
				<textarea id="chatareapop" placeholder="Type message.." name="msg" required></textarea>
				<button type="button" class="btn" id="sendmes"><i class="fa fa-send-o"></i></button>
			</div>
		</form>
	</div>
	<!-- END MODAL HERE!! -->
	
</div>
<script type="text/javascript">

var x;
var profname ="";
function mes(id,type) {
	$("#recipientid").val(id);
	var user_id= <?= Yii::$app->user->identity->profile->user_id?>;
	const token =<?php echo json_encode($_SESSION['usertoken'])?>;
	
		$.ajax({
		url: "http://www.eulims.local/api/message/getcontact", //API LINK FROM THE CENTRAL
		type: 'POST',
		dataType: "JSON",
		beforeSend: function (xhr) {
			xhr.setRequestHeader('Authorization', 'Bearer '+ token);
		}, 
		data: {
			userid: user_id,
			recipientid: id,
			type:type
		},
		success: function(response) {
			var y;
			x="";
			x = x+'<br>';
			for(y=0;y<response.chat.length;y++){
			//x = x+ response.chat[y].sender_userid;
				var dt=new Date(response.chat[y].timestamp);
				dt=formatAMPM(dt);
				x = x+'<div>';
				var messagetype= response.chat[y].message_type;
				var chatdatatype= response.chat[y].chat_data_type;
				if (response.chat[y].sender_userid != user_id){
					
					x = x+"<div class='message-blue'>";
					if(chatdatatype == 2){
						profname= response.chat[y].contact_id;
						x = x+"<div class='message-prof'>"+profname+"</div>"; //Profile header	
					}
					
					if(messagetype == 1){
						x = x+"<p class='message-content'>"+response.chat[y].chat_data+"</p>";	
					}else{
						x= x+ "<a href='http://www.eulims.local/uploads/message/"+response.chat[y].chat_data+"' download>"+response.chat[y].chat_data+"</a>";
					}
					
					x = x+"<div class='message-timestamp-left'>"+dt+"</div>";
					x = x+"</div>";
					x = x+'<br>';
				
				
				}else{
					x = x+"<div class='message-orange'>";
					if(messagetype == 1){
						x = x+"<p class='message-content'>"+response.chat[y].chat_data+"</p>";	
					}else{
						x= x+ "<a href='http://www.eulims.local/uploads/message/"+response.chat[y].chat_data+"' download>"+response.chat[y].chat_data+"</a>";
					}
					x = x+"<div class='message-timestamp-right'>"+dt+"</div>";
					x = x+"</div>";
					x = x+'<br>';
				}

				x = x+'</div>';
						
			}
			
			
			$('#chattype').html(type);
			$('#dataid').html(response.id);
			if(type == 1){
				$("#ctype").text("1");//personal message
				$('#chathere').html(x); 
				$('#profilename').html(response.profile.fullname);
				
				$('#popchatbody').html(x); 
				
				$('#profilenamepop').html(response.profile.fullname);
			}
			if(type == 2){
				//console.log(response.profile);
				
				$("#ctype").text("2");//group message
				$('#profilenamepop').html(response.profile.group_name);
				$('#popchatbody').html(x); 
			}
		    
		},
		error: function(xhr, status, error) {
			alert(error);
		}
		});  
		
		$('#popchatbody').scrollTop($('#popchatbody')[0].scrollHeight);
		 //var elem = document.getElementById('Commentbox');
        // elem.scrollTop = elem.scrollHeight;
 }


function sendmessage() {
   var textchat=$('#chatareapop').val();
   if(textchat === ""){
	   //alert("Hello");
   }
   else{
	   $('#chattype').text("1");//Message type
	   sendchat(textchat);
   }
   
   if (document.getElementById("UploadFile").files.length === 0 ){ //For file attachment
		//alert("Please select a file to upload");
   }
   else{
	    $('#chattype').text("2");//Filetype
		var token=<?php echo json_encode($_SESSION['usertoken'])?>;
		var formData = new FormData($('form')[0]);
		
		$.ajax({
			url: "http://www.eulims.local/api/message/savefile", //API LINK FROM THE CENTRAL
			type: 'POST',
			dataType: "JSON",
			beforeSend: function (xhr) {
				xhr.setRequestHeader('Authorization', 'Bearer '+ token);
			}, 
			data: formData,
			success: function(response) {
				$('#UploadFile').val("");
				var txt=response.filename; //Filename
				if(response.message == "success"){
					//alert("Oks na lodi proceed next step!");	
					sendchat(txt);
				}
				else{
					alert("Error ka lodi!");
				}
				
				
			},
			error: function(xhr, status, error) {
				alert(error);
			},
			cache: false,
			contentType: false,
			processData: false
		}); 	
   }
 
  
} 



function formatAMPM(date) {
 const ye = new Intl.DateTimeFormat('en', { year: 'numeric' }).format(date);
 const mo = new Intl.DateTimeFormat('en', { month: 'short' }).format(date);
 const da = new Intl.DateTimeFormat('en', { day: '2-digit' }).format(date);

  var hours = date.getHours();
  var minutes = date.getMinutes();
  var ampm = hours >= 12 ? 'pm' : 'am';
  hours = hours % 12;
  hours = hours ? hours : 12; // the hour '0' should be '12'
  minutes = minutes < 10 ? '0'+minutes : minutes;
  var strTime = da+"-"+mo+"-"+ye + " " + hours + ':' + minutes + ' ' + ampm;
  return strTime;
}

window.setInterval(function(){
 
  // var id= $("#recipientid").value();
   var id=$("#recipientid").val();
   var type =$("#ctype").text();
   if(id == "")
   {
	  //alert("wala");   
   }
   else{
	  mes(id,type); 
   } 
  
   
  
}, 5000);

function openForm() {
	document.getElementById("myForm").style.display = "block";
}

function closeForm() {
	document.getElementById("myForm").style.display = "none";
}

$("#btnuser").click(function(){
	$("#recipientid").val("");
	$('#profilenamepop').html("");
	contacts();
});
$("#btngroup").click(function(){
	$("#recipientid").val("");
	$('#profilenamepop').html("");
	groupcontacts();
});


function contacts(){ //Personnal Messages
	var y;
	 y = "<h4>List of Contacts </h4>";
	<?php foreach ($contacts as $data)
	 { ?>
	y=y + "<a class='thismessage' onclick='mes(<?=$data['user_id']?>,1)'>";
	y= y + "<div class='first'><b>"+ '<?= $data['fullname']?>' +"</div>";
	y= y + "</a>";
	<?php } ?>
	//GROUPS
	y= y + "<br> <div> <h4>Groups Contacts </h4></div>";
	<?php foreach ($group as $data)
	 { ?>
	y=y + "<a class='thismessage1' onclick='mes(<?=$data['chat_group_id']?>,2)'>";
	y= y + "<div class='first'><b>"+ '<?= $data['chatGroup']['group_name']?>' +"</div>";
	y= y + "</a>";
	<?php } ?>
	
	
	$('#popchatbody').html(y); 
}
function groupcontacts(){ //Group Messages
	var y;
	//document.getElementById('popuser').style.display='block';
	 y = "<h4>List of Contacts </h4>";
	<?php foreach ($group as $data)
	 { ?>
	y=y + "<a class='thismessage' onclick='mes(<?=$data['chat_group_id']?>,2)'>";
	y= y + "<div class='first'><b>"+ '<?= $data['chatGroup']['group_name']?>' +"</div>";
	y= y + "</a>";
	<?php } ?>
	
	$('#popchatbody').html(y); 
}

function sendchat(txt) {
 //  var txt=$('#chatareapop').val();
   var token=<?php echo json_encode($_SESSION['usertoken'])?>;
   var id=$('#dataid').text();
   var type = $('#ctype').text();
   var dataxtype = $('#chattype').text();
   var sender_userid= <?= Yii::$app->user->identity->profile->user_id?>;
	$.ajax({
		url: "http://www.eulims.local/api/message/setmessage", //API LINK FROM THE CENTRAL
		type: 'POST',
		dataType: "JSON",
		beforeSend: function (xhr) {
			xhr.setRequestHeader('Authorization', 'Bearer '+ token);
		}, 
		data: {
			sender_userid: sender_userid,
			message: txt,
			type: type,
			id:id,
			dataxtype: dataxtype
		},
		success: function(response) {
			var dt=new Date();
			dt=formatAMPM(dt);
			x = x+'<br>';
			x = x+"<div class='message-orange'>";
			if(type == 1){
				x = x+"<p class='message-content'>"+txt+"</p>";
			}else{
				x= x+ "<a href='http://www.eulims.local/uploads/message/"+txt+"' download>"+txt+"</a>";
			}
			
			
			x = x+"<div class='message-timestamp-right'>"+dt+"</div>";
			x = x+"</div>";
			x = x+'<br>';
			$('#chatareapop').val(" ");
			$('#popchatbody').html(x); 
		},
		error: function(xhr, status, error) {
			alert(error);
		}
	}); 	
}
$("#sendmes").click(function(){
	sendmessage();
});

function getprofile(id) {
	var token=<?php echo json_encode($_SESSION['usertoken'])?>;
	$.ajax({
		url: "http://www.eulims.local/api/message/profile", //API LINK FROM THE CENTRAL
		type: 'POST',
		dataType: "JSON",
		beforeSend: function (xhr) {
			xhr.setRequestHeader('Authorization', 'Bearer '+ token);
		}, 
		data: {
			id:id
		},
		success: function(response) {
			return response.fullname;
		},
		error: function(xhr, status, error) {
			alert(error);
		}
	}); 	
}
 </script>