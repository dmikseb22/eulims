<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\referral\Methodreference */

$this->title = 'Create Methodreference';
$this->params['breadcrumbs'][] = ['label' => 'Methodreferences', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="methodreference-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
