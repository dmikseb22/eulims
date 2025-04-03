<?php

use yii\helpers\Html;
use \yii\helpers\StringHelper;
use \yii\helpers\Url;
use yii\widgets\DetailView;
/**
 * Created by PhpStorm.
 * User: OneLab
 * Date: 16/04/2020
 * Time: 21:52
 */
/** @var $model common\modules\message\models\Chat */
/* @var $searchModel common\modules\message\models\ChatSearch */
$id="";
$name="";
$receiver="";
/*if($model->sender_userid == Yii::$app->user->id){
	//$id=$model->reciever_userid;
	//$receiver=$model->sender_userid;
	//$name=($model->getProfile($model->reciever_userid)->fullname);
	$name="Later ko na isipin";
}
else{
	$id=$model->sender_userid;
	$receiver=$model->reciever_userid;
    $name=($model->getProfile($model->sender_userid)->fullname);
} */

?>
<script type="text/javascript">
   /* $(document).ready(function(){
        $("a.thismessage").on('click',function (ee) {
            const id=($(this).attr("id"));
            //alert(id);
            document.getElementById("chat-sender_userid").value=id;

            $.ajax({
                url: '/message/chat/getsendermessage',
                //dataType: 'json',
                method: 'GET',
                data: {id:id},
                success: function (data, textStatus, jqXHR) {
                    $('#idconvo').html(data);
                }
            });

        });
    });*/
function mes(id,mm,receiver,sender) {
    const ido=id;
    document.getElementById("receiver").innerText=mm;
    document.getElementById("chat-sender_userid").value=sender;
	document.getElementById("chat-reciever_userid").value=receiver;
    $.ajax({
        url: '/message/chat/getsendermessage',
        //dataType: 'json',
        method: 'GET',
        data: {id:ido},
        success: function (data, textStatus, jqXHR) {
            $('#idconvo').html(data);
            $('#chatHistory').scrollTop($('#chatHistory')[0].scrollHeight);
        }
    });
    /*const jam = ido;
        document.getElementById("receiver").innerText=jam;*/
}
</script>
<a class="thismessage" onclick="mes('<?= $model->contact_id?>', '<?php echo $name;?>', '<?php echo $receiver;?>','<?php echo $id;?>')" href="#">
<li class="clearfix">
<img src="/images/icons/customer.png" alt="avatar" style="width: 30px"/>
    <div class="about">
<?php
                    echo "<div class='name'>";
                    echo Html::encode($model->getProfile($id)->fullname);
                    echo "</div>";
                    echo "<div class='status'>";
                            if ($model->status_id == 1) {
                                echo '<img src="/images/icons/red.png" alt="avatar" style="width: 8px; padding-right: 2px; padding-top: 7px"/>';
                            }
                    echo StringHelper::truncateWords(($model->message), 5);
                    echo "</div>";
?>
    </div>
</li>
</a>

