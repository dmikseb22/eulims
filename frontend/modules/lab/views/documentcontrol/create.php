<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\lab\Documentcontrol */

$this->title = 'Create Documentcontrol';
$this->params['breadcrumbs'][] = ['label' => 'Documentcontrols', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="documentcontrol-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
