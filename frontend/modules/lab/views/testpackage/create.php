<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\lab\testpackage */

$this->title = 'Create Testpackage';
$this->params['breadcrumbs'][] = ['label' => 'Testpackages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="testpackage-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
