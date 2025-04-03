<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\finance\Check */

$this->title = Yii::t('app', 'Create Check');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Checks'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="check-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
