<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\DetailView;
use kartik\file\FileInput;
use yii\helpers\Url;
use common\components\Functions;

$func= new Functions();

use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/** @var $model common\modules\message\models\Chat */
/* @var $searchModel common\modules\message\models\ChatSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Chats';
$this->params['breadcrumbs'][] = $this->title;
//echo $token;
?>
<script>
    $(document).ready(

        function() {
            setInterval(function() {
                $.pjax.reload('#kv-pjax-container-inbox', {timeout : false})
            }, 3000);
        });
    function SearchMess(name) {
        const id = name;
        $.ajax({
            url: '/message/chat/GetSearchMessage',
            //dataType: 'json',
            method: 'GET',
            data: {id:ido},
            success: function (data, textStatus, jqXHR) {
                $('#inbox').html(data);
            }
        });
    }
	
    function openForm() {
        document.getElementById("myForm").style.display = "block";
    }

    function closeForm() {
        document.getElementById("myForm").style.display = "none";
    }
</script>
<html lang="en" >
<head>
    <meta charset="UTF-8">
    <title>OneLab Chat</title>

</head>
<div class="container clearfix">
    <div class="people-list" id="people-list">
        <!-- <label style="color:white"> <h4>Chats </h4></label> -->
        <div class="search">
            <input type="text" placeholder="search" onkeydown="SearchMess('jamestorres')"/>
            <i class="fa fa-search"></i>
        </div>
        <div class="inbox-history">


            <ul class="sidebar-menu tree" data-widget="tree">
                <li class="treeview">
                    <a href="/message/chat"><i class="fa fa-inbox" style="display:none;width:0px" "=""></i>
                        <span>
                            <span>Inbox</span>
                        </span>
                        <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                    </a>
                    <ul class="treeview-menu" id="inbox">
                        <!--<ul class="list" >-->
                            <?php \yii\widgets\Pjax::begin(['timeout' => 1, 'id'=>"kv-pjax-container-inbox", 'clientOptions' => ['container' => 'pjax-container']]); ?>
                            <?= \yii\widgets\ListView::widget([
                                'dataProvider' => $dataProvider,
                                'summary' => '',
                                'itemView' => 'mess_view'
                            ]);
                            ?>
                            <?php \yii\widgets\Pjax::end(); ?>
                        <!--</ul>-->
                    </ul>
                </li>

                <li class="treeview">
                    <a href="/message/chat"><i class="fa fa-inbox" style="display:none;width:0px" "=""></i>
                        <span>
                            <span>Group Message</span>
                        </span>
                        <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                    </a>
                    <ul class="treeview-menu" id="inbox">
                        <!--<ul class="list" >-->

                        <?= \yii\widgets\ListView::widget([
                            'dataProvider' => $dataProviderGrp,
                            'summary' => '',
                            'itemView' => 'gc_view'
                        ]);
                        ?>

                        <!--</ul>-->
                    </ul>
                </li>
            </ul>

        </div>
    </div>

    <div class="chat" >
        <div class="chat-header clearfix">
            <div class="chat-about">
                <div class="chat-with" id="receiver"></div>
                <div class="chat-num-messages"></div>
            </div>
            <!--<i class="fa fa-star"></i>-->
            <!--<a href="/message/chat/group"><i class="fa fa-group" onclick="LoadModal(this.title, this.value);"></i></a>-->
            <a onclick="LoadModal('Create Group', '/message/chat/group');" href="#"><i class="fa fa-group"></i></a>
            <a href="/message/chat/create"><i class="fa fa-plus-circle"></i></a>
        </div> <!-- end chat-header -->

        <div class="chat-history" id="chatHistory">
            <ul id="idconvo">

            </ul>
        </div> <!-- end chat-history -->

        <div class="chat-message clearfix">
            <?php $form = ActiveForm::begin(); ?>
            <?= $form->field($chat, 'sender_userid')->label(false) ?>
			<?= $form->field($chat, 'reciever_userid')->label(false) ?>
            <?= $form->field($chat, 'message')->textarea(['rows' => 2]) ?>



            <?= $form->field($file, 'filename')->widget(FileInput::classname(),
                [
                    'options' => ['multiple' => true],
                    'pluginOptions' => [
                        'showPreview' => true,
                        'showCaption' => true,
                        'showUpload' => false,
                        'showRemove'=>true
                    ]

                ]);
            ?>
            <div class="form-group">
				<button id="sendmessage"> Send </button>
			</div>

            <?php ActiveForm::end(); ?>
        </div> <!-- end chat-message -->

    </div> <!-- end chat -->
    <div class="inbox">
        <div class="inbox-header">
            <h3></h3>
        </div>
    </div>
</div> <!-- end container -->

<!--<script id="message-template" type="text/x-handlebars-template">
    <li class="clearfix">
        <div class="message-data align-right">
            <span class="message-data-time" >{{time}}, Today</span> &nbsp; &nbsp;
            <span class="message-data-name" >Olia</span> <i class="fa fa-circle me"></i>
        </div>
        <div class="message other-message float-right">
            {{messageOutput}}
        </div>
    </li>
</script>

<script id="message-response-template" type="text/x-handlebars-template">
    <li>
        <div class="message-data">
            <span class="message-data-name"><i class="fa fa-circle online"></i> Vincent</span>
            <span class="message-data-time">{{time}}, Today</span>
        </div>
        <div class="message my-message">
            {{response}}
        </div>
    </li>
</script>-->
<button class="open-button" onclick="openForm()"><i class="fa fa-commenting-o"></i></button>
<div class="chat-popup" id="myForm">
    <form action="/action_page.php" class="form-container">
        <div class="chat-popup-header">
            <!--<span>OneLab Chat</span>-->
            <i class="fa fa-gear"></i>
            <i class="fa fa-close" onclick="closeForm()"></i>

        </div>
        <div class="chat-popup-tab">
            <button type="button" class="btntab"><i class="fa fa-user"></i></button>
            <button type="button" class="btntab"><i class="fa fa-group"></i></button>
        </div>
        <div class="chat-popup-body">

        </div>
        <div class="chat-popup-footer">
<!--            <div class="input-group-btn">
                <div tabindex="500" class="btn btn-primary btn-file"><i class="glyphicon glyphicon-folder-open"></i>&nbsp;  <span class="hidden-xs"></span><input type="file" id="chatattachment-filename" class="" name="ChatAttachment[filename]" multiple="" data-krajee-fileinput="fileinput_94eb551c"></div>
            </div>-->
                <!--<input class="fa fa-paperclip" type="file">-->
                <!--<input type="file" id="chatattachment-filename" class="" name="ChatAttachment[filename]" multiple="" data-krajee-fileinput="fileinput_94eb551c">-->
            <i class="fa fa-paperclip"></i>
            <textarea placeholder="Type message.." name="msg" required></textarea>
            <button type="submit" class="btn" id="sendmes"><i class="fa fa-send-o"></i></button>
        </div>
        <!--<button type="button" class="btn cancel" onclick="closeForm()">Close</button>-->
    </form>
</div>
<!-- partial -->
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/3.0.0/handlebars.min.js'></script>
</body>
</html>

<script type="text/javascript">
$("#sendmessage").click(function(){
   var token=<?php echo json_encode($token) ?>;
   var sender_userid= $('#chat-reciever_userid').val();
   var reciever_userid= $('#chat-sender_userid').val();
   var message =  $('#chat-message').val();
  // alert(message);
  // alert("sdsdqwertyu");
	$.ajax({
		url: "http://www.eulims.local/api/message/setmessage", //API LINK FROM THE CENTRAL
		type: 'POST',
		dataType: "JSON",
		beforeSend: function (xhr) {
			xhr.setRequestHeader('Authorization', 'Bearer '+ token);
		}, 
		data: {
			sender_userid: sender_userid,
			reciever_userid: reciever_userid,
			
			message: message
		},
		success: function(response) {
			alert(response.message);
		},
		error: function(xhr, status, error) {
			alert(error);
		}
	}); 
});
</script>