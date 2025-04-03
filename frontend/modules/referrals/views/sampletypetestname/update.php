<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\referral\Sampletypetestname */

$this->title = 'Update Sampletypetestname: ' . $model->sampletypetestname_id;
$this->params['breadcrumbs'][] = ['label' => 'Sampletypetestnames', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->sampletypetestname_id, 'url' => ['view', 'id' => $model->sampletypetestname_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="sampletypetestname-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
