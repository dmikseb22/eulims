<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\inventory\Equipmentservice */

$this->title = 'Create Equipmentservice';
$this->params['breadcrumbs'][] = ['label' => 'Equipmentservices', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="equipmentservice-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
