<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\progress;
use common\models\lab\CustomerMigration;
use common\models\api\CustomerMigrationportal;


/* @var $this yii\web\View */
/* @var $searchModel common\models\api\MigrationportalSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Migrationportals';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="migrationportal-index">
    
    <?php if (Yii::$app->session->hasFlash('success')): ?>
        <div class="alert alert-success alert-dismissable">
             <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
             <h4><i class="icon fa fa-check"></i>Saved!</h4>
             <?= Yii::$app->session->getFlash('success') ?>
        </div>
    <?php endif; ?>
    
    <?php if (Yii::$app->session->hasFlash('error')): ?>
        <div class="alert alert-danger alert-dismissable">
             <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
             <h4><i class="icon fa fa-warning"></i>Note!</h4>
             <?= Yii::$app->session->getFlash('error') ?>
        </div>
    <?php endif; ?>

    <h1>Yii 1.0 to 2.0 Migration [Ulimsportal Only]</h1>
 

   <h2>TOTAL Request : <b><?= $allreq?></b></h2>
    <h2>Pending Request : <b><?= $rawreq?></b></h2>
    <h2>Migrated Request :<b> <?= $migreq?></b></h2>

  
</div>

<?php 
$this->registerCssFile("/css/modcss/migrationportal.css", [
    // 'depends' => [\yii\bootstrap\BootstrapAsset::className()],
    // 'media' => 'print',
], 'css-search-bar');
?>