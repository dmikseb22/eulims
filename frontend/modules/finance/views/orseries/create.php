<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\finance\Orseries */

$this->title = 'Create Orseries';
$this->params['breadcrumbs'][] = ['label' => 'Orseries', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="orseries-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
