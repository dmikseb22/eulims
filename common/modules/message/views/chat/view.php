<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\modules\message\models\Chat */

$this->title = $model->chat_id;
$this->params['breadcrumbs'][] = ['label' => 'Chats', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?php

         /*<!-- end chat-header -->*/
/*    echo '<div class="chat-history">';
    echo '<ul>';*/
echo '<li class="clearfix">';
if (Yii::$app->user->id == $model->reciever_userid){
    echo "<div class='message-data'>";

    echo "<span class='message-data-name' >";
    echo Html::encode($model->getProfile($model->sender_userid)->firstname);
    echo "</span> <i class='fa fa-circle online'></i>";

    echo "<span class='message-data-time' >";
    echo Yii::$app->formatter->asRelativeTime($model->timestamp);
    echo "</span> &nbsp &nbsp";
    echo "</div>";

    echo "<div class='message my-message'>";
    echo Html::encode($model->message);
    echo "</div>";
}
else{
    echo '<div class="message-data align-right">';
    echo '<span class="message-data-time" >';
    echo Yii::$app->formatter->asRelativeTime($model->timestamp);
    echo '</span> &nbsp; &nbsp;';

    echo '<span class="message-data-name" >';
    echo Html::encode($model->getProfile($model->sender_userid)->firstname);
    echo '</span> <i class="fa fa-circle me"></i>';

    echo '</div>';
    echo '<div class="message other-message float-right">';
    echo Html::encode($model->message);
    echo '</div>';
}
echo '</li>';
/*    echo '</ul>';
    echo '</div>';*/ /*<!-- end chat-history -->*/
?>
<!--<div class="chat-message clearfix">
    <textarea name="message-to-send" id="message-to-send" placeholder ="Type your message" rows="3"></textarea>

    <i class="fa fa-file-o"></i> &nbsp;&nbsp;&nbsp;
    <i class="fa fa-file-image-o"></i>

    <button>Send</button>

</div>-->




