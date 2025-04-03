<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\referral\Bidnotification */

$this->title = 'Create Bidnotification';
$this->params['breadcrumbs'][] = ['label' => 'Bidnotifications', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bidnotification-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
