<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\system\Rstl;
use kartik\select2\Select2;
use common\models\lab\Lab;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\modules\admin\models\form\Signup */

$this->title = Yii::t('rbac-admin', 'Signup');
$this->params['breadcrumbs'][] = $this->title;
$RstlList= ArrayHelper::map(Rstl::find()->all(),'rstl_id','name');
// $pstcList = [10=>'zc',111=>'zdn'];//temp
$LabList= ArrayHelper::map(lab::find()->all(),'lab_id','labname');
?>
<div class="site-signup">
    <?php if(!$isModal){ ?>
    <?= $this->renderFile(__DIR__.'/../menu.php',['button'=>'user']); ?>
    <?php } ?>
    <?= Html::errorSummary($model)?>
    <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
     <fieldset>
        <legend>Login Details</legend>
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'username') ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'email') ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'password')->passwordInput() ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'verifypassword')->passwordInput() ?>
            </div>
        </div>
     </fieldset>
    <fieldset>
        <legend>Profile Info</legend>
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'lastname')->textInput() ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'firstname')->textInput() ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'designation')->textInput() ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'middleinitial')->textInput() ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
            <?= $form->field($model, 'rstl_id')->widget(Select2::classname(), [
                'data' => $RstlList,
                'language' => 'en',
                'options' => ['placeholder' => 'Select RSTL'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); ?>
            </div>
            <div class="col-md-6">
            <?= $form->field($model, 'lab_id')->widget(Select2::classname(), [
                'data' => $LabList,
                'language' => 'en',
                'options' => ['placeholder' => 'Select Lab'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
            <?= $form->field($model, 'pstc_id')->widget(Select2::classname(), [
                'data' => $pstcs,
                'language' => 'en',
                'options' => ['placeholder' => 'Select PSTC'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); ?>
            </div>
            
        </div>
    </fieldset>
    <div class="form-group" style="float: right">
        <?= Html::submitButton(Yii::t('rbac-admin', 'Save'), ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
        <?php if(Yii::$app->request->isAjax){ ?>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <?php } ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
