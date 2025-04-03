<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use common\models\system\User;
use yii\helpers\ArrayHelper;
use common\models\system\Rstl;
use common\models\lab\Lab;
//use cozumel\cropper\ImageCropper;
use kartik\widgets\FileInput;
use yii\web\View;

//use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model common\models\Profile */
/* @var $form yii\widgets\ActiveForm */
if(Yii::$app->user->can('access-his-profile') && !Yii::$app->user->can('profile-full-access')){
    $UserList= ArrayHelper::map(User::findAll(['user_id'=>Yii::$app->user->identity->user_id]),'user_id','email');
}else{
    $UserList= ArrayHelper::map(User::find()->all(),'user_id','email');
}
$RstlList= ArrayHelper::map(Rstl::find()->all(),'rstl_id','name');
$LabList= ArrayHelper::map(lab::find()->all(),'lab_id','labname');

$js =<<< SCRIPT
   $('#profileImage_upload').on('fileclear', function(event) {
      $('#profile-image_url').val('');
      $('#profile-avatar').val('');
   });      
SCRIPT;
$this->registerJs($js, View::POS_READY);
$this->registerCssFile("/css/profile.css");
$imagePath=\Yii::$app->getModule("profile")->assetsUrl."/photo/";


?>
<div class="profile-form">
    <?php
    $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data'] // important
    ]);
    echo $form->field($model, 'image_url')->hiddenInput(['value' => $model->image_url])->label(false);
    echo $form->field($model, 'avatar')->hiddenInput(['value' => $model->avatar])->label(false); 
    ?>
    <div class="row" style="text-align: center">
        <div class="col-md-6" style="text-align: center">
        <?php
        // your fileinput widget for single file upload
        echo $form->field($model, 'image')->widget(FileInput::classname(), [
            'options' => [
                'id' => 'profileImage_upload',
                'accept' => 'image/*',
            ],
            'pluginOptions' => [
                'allowedFileExtensions' => ['jpg', 'gif', 'png'],
                'overwriteInitial' => true,
                'resizeImages' => true,
                'style'=>'margin-left: 140px',
                'initialPreview' => [
                    '<img src=/uploads/user/photo/'.$model->image_url.' width="200" class="file-preview-image">',
                ],
                'showUpload' => false,
                'showRemove' => false,
                'showBrowse' => true,
                'showText' => false,
                'showClose'=>false
            ],
                //'value'=>Yii::$app->basePath.'\web\uploads\user\photo\\'.$model->avatar
        ])->label(false);
        ?>
        </div>
    </div><!-- end of Row -->
    <div class="row">
        <div class="col-md-6">
            <?=
            $form->field($model, 'user_id')->widget(Select2::classname(), [
                'data' => $UserList,
                'language' => 'en',
                'options' => ['placeholder' => 'Select User'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label("Username/Email");
            ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'lastname')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
        <?= $form->field($model, 'firstname')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'middleinitial')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
        <?= $form->field($model, 'designation')->textInput() ?>
        </div>
        <div class="col-md-6">
        <?= $form->field($model, 'contact_numbers')->textInput() ?>
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
    <div class="row pull-right" style="padding-right: 15px">
    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <button style='margin-left: 5px' type='button' class='btn btn-secondary pull-left-sm' data-dismiss='modal'>Cancel</button>
    </div>    
   <?php ActiveForm::end(); ?>
</div>
