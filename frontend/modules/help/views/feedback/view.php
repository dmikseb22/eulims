<?php

use yii\helpers\Html;
use yii\widgets\DetailView;


/* @var $this yii\web\View */
/* @var $model common\models\feedback\UserFeedback */

$this->title = $model->feedback_id;
$this->params['breadcrumbs'][] = ['label' => 'User Feedbacks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-feedback-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->feedback_id], ['class' => 'btn btn-primary']) ?>
        <?=
        Html::a('Delete', ['delete', 'id' => $model->feedback_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ])
        ?>
    </p>
    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            // other attributes ...

                [
                'label'=>'Screenshot',
                'attribute' => 'urlpath_screen',
                'value' => function($model){
          return Html::a(Html::img('/uploads/feedback/' . $model->urlpath_screen, ['title'=>'View Screenshot', 'alt'=>'yii','width' => '100', 'height' => '100']), [ '/uploads/feedback/' . $model->urlpath_screen]);
                 },    
                         'format'=>'raw',
            ],
        ],
    ])
    ?>
    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            'feedback_id',
            'url:ntext',
          //  'urlpath_screen:ntext',
            'details:ntext',
            'steps:ntext',
            'reported_by',
            'region_reported',
            'moduletested',
            'action_taken',
        ],
    ])
    ?>

   

   
    
     




</div>
