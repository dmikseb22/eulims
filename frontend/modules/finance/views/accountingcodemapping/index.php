<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\finance\AccountingcodemappingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Accountingcodemappings';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="accountingcodemapping-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Accountingcodemapping', ['create'], ['class' => 'btn btn-success']) ?>
          <?= Html::button('<span class="glyphicon glyphicon-plus"></span>Account Code Mapping', ['value'=>'accountingcodemapping/create', 'class' => 'btn btn-success btn-modal','title' => Yii::t('app', "Account Code Mapping"),'name'=>'Account Code Mapping']); ?>
  
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'mapping_id',
            'collectiontype_id',
            'accountingcode_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    
    
</div>
