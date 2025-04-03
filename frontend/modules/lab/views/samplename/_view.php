<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
?>

<?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'sample_name_id',
            'sample_name',
            'description',
        ],
    ]) ?>