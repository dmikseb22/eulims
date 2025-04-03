<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\lab\Labsampletype */

$this->title = 'Create Labsampletype';
$this->params['breadcrumbs'][] = ['label' => 'Labsampletypes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="labsampletype-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
