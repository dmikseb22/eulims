<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\lab\Testreport */

$this->title = 'Create Test report';
$this->params['breadcrumbs'][] = ['label' => 'Testreports', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="testreport-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
