<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\finance\Accountingcode */

$this->title = $model->accountcode;
$this->params['breadcrumbs'][] = ['label' => 'Accountingcodes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="accountingcode-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->accountingcode_id], ['class' => 'btn btn-primary']) ?>
        
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'accountingcode_id',
            'accountcode',
            'accountdesc',
        ],
    ]) ?>

</div>
