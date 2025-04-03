<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'API Authentication';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="col-md-8 col-md-offset-2" style="margin-top: 100px; padding: 20px;">
    <div class="alert alert-danger" style="padding: 40px;">
        <h4><i class="icon fa fa-ban"></i> API Authentication!</h4>
        Please login to access the PSTC Module.

        <?php echo Html::button('<h5>Login Here</h5>', ['value'=>'/chat/info/login','style' => 'float: right; margin-top: -30px;', 'class' => 'btn btn-lg btn-info','title' => Yii::t('app', "Login"),'id'=>'btnOP','onclick'=>'LoadModal(this.title, this.value,"100px","300px");']) ?>
    </div>
</div>