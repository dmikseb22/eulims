<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\finance\Collectiontype */

$this->title = 'Create Collectiontype';
$this->params['breadcrumbs'][] = ['label' => 'Collectiontypes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="collectiontype-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
