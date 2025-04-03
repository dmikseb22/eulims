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
/** @var $model common\modules\message\models\ChatGroup */
/* @var $searchModel common\modules\message\models\ChatSearch */
?>
<script type="text/javascript">
    function mes(id,gc) {
        const ido=id;
        const idgc=gc;
        document.getElementById("receiver").innerText="waaalllllllllllllllllaaaa";
        $.ajax({
            url: '/message/chat/GetGCmessage',
            //dataType: 'json',
            method: 'GET',
            data: {gcid:idgc, id:ido},
            success: function (data, textStatus, jqXHR) {
                $('#idconvo').html(data);
                $('#chatHistory').scrollTop($('#chatHistory')[0].scrollHeight);
            }
        });
    }
</script>
<a class="thismessage" onclick="mes('<?php Yii::$app->user->id ?>','<?php $model->chat_group_id?>')" href="#">
    <li class="clearfix">
        <img src="/images/icons/customerpool.png" alt="avatar" style="width: 30px"/>
        <div class="about">
            <?php
            echo "<div class='name'>";
            echo Html::encode($model->group_name);
            echo "</div>";
            ?>
        </div>
    </li>
</a>

