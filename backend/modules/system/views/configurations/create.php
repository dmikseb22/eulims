<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\lab\Lab */

$this->title = 'Create Lab';
$this->params['breadcrumbs'][] = ['label' => 'Labs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lab-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
