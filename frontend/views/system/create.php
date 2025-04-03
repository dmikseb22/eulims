<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\system\Rstl */

$this->title = 'Create Rstl';
$this->params['breadcrumbs'][] = ['label' => 'Rstls', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rstl-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
