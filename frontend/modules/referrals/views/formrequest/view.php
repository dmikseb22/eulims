<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\referral\Formrequest */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Formrequests', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="formrequest-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->formrequest_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->formrequest_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'formrequest_id',
            'agency_id',
            'title',
            'number',
            'rev_num',
            'print_format',
            'rev_date',
            'logo_left',
            'logo_right',
        ],
    ]) ?>

</div>
