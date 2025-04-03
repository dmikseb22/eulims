<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\lab\Sampletypetestname */

$this->title = $model->sampletype_testname_id;
$this->params['breadcrumbs'][] = ['label' => 'Sampletypetestnames', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'sampletype_testname_id',
            'sampletype.type',
            'testname.testName',
            'added_by',
        ],
    ]) ?>

</div>
