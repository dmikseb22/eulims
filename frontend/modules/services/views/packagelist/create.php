<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\lab\Packagelist */

$this->title = '';
$this->params['breadcrumbs'][] = ['label' => 'Packagelists', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="packagelist-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
