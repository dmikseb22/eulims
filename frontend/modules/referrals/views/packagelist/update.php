<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\referral\Packagelist */

$this->title = 'Update Packagelist: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Packagelists', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->package_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="packagelist-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
