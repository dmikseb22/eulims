<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\message\models\Chat */

$this->title = 'Update Chat: ' . $model->chat_id;
$this->params['breadcrumbs'][] = ['label' => 'Chats', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->chat_id, 'url' => ['view', 'id' => $model->chat_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="chat-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
