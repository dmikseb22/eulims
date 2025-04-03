<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\finance\Customertransaction */

$this->title = 'Create Customertransaction';
$this->params['breadcrumbs'][] = ['label' => 'Customertransactions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customertransaction-create">

    

    <?= $this->render('_form', [
        'model' => $model,
        'customerwallet_id' => $customerwallet_id
    ]) ?>

</div>
