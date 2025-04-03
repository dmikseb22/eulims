<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\lab\Procedure */

$this->title = 'Create Procedure';
$this->params['breadcrumbs'][] = ['label' => 'Procedures', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="procedure-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
