<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\lab\LabManager */

$this->title = 'Create Lab Manager';
$this->params['breadcrumbs'][] = ['label' => 'Lab Managers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lab-manager-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
