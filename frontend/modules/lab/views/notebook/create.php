<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\lab\LabNotebook */

$this->title = 'Create Lab Notebook';
$this->params['breadcrumbs'][] = ['label' => 'Lab Notebooks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lab-notebook-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
