<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\api\Migrationportal */

$this->title = 'Create Migrationportal';
$this->params['breadcrumbs'][] = ['label' => 'Migrationportals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="migrationportal-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
