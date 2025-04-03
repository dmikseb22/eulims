<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\lab\Documentcontrolconfig */

$this->title = 'Create Documentcontrolconfig';
$this->params['breadcrumbs'][] = ['label' => 'Documentcontrolconfigs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="documentcontrolconfig-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
