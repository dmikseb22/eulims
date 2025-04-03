<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\lab\Testnamemethod */

$this->title = 'Create Testnamemethod';
$this->params['breadcrumbs'][] = ['label' => 'Testnamemethods', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="testnamemethod-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
