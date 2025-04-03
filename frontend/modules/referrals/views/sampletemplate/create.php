<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\referral\Sampletemplate */

$this->title = 'Create Sampletemplate';
$this->params['breadcrumbs'][] = ['label' => 'Sampletemplates', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sampletemplate-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
