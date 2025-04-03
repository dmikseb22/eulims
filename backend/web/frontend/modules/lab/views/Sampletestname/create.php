<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\lab\Sampletypetestname */

$this->title = 'Create Sampletypetestname';
$this->params['breadcrumbs'][] = ['label' => 'Sampletypetestnames', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sampletypetestname-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
