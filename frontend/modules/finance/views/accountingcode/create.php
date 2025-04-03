<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\finance\Accountingcode */

$this->title = 'Create Account Code';
$this->params['breadcrumbs'][] = ['label' => 'Accountingcodes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="accountingcode-create">

  

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
