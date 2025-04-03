<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\referral\Methodreference */

$this->title = 'Update Methodreference: ' . $model->methodreference_id;
$this->params['breadcrumbs'][] = ['label' => 'Methodreferences', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->methodreference_id, 'url' => ['view', 'id' => $model->methodreference_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="methodreference-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
