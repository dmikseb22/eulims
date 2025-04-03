<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use common\models\system\User;
use yii\helpers\ArrayHelper;
use common\models\system\Rstl;
use common\models\lab\Lab;
use cozumel\cropper\ImageCropper;
use kartik\widgets\FileInput;
use yii\web\View;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model common\models\Profile */
/* @var $form yii\widgets\ActiveForm */
if(Yii::$app->user->can('profile-full-access')){
    $UserList= ArrayHelper::map(User::find()->all(),'user_id','email');
}else{ 
    $UserList= ArrayHelper::map(User::findAll(['user_id'=>Yii::$app->user->identity->user_id]),'user_id','email');
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

?>

<div class="profile-form">
    <div class="row" style="margin-left: 30px">
            <?php $form = ActiveForm::begin([
                'options'=>['enctype'=>'multipart/form-data'] // important
            ]); ?>
            <div class="row">
                <span style="float:left; width: 250px;margin-right: 5px">
                <?php echo $form->field($model, 'image_url')->hiddenInput(['value' => $model->image_url])->label(false) ?>
                <?php echo $form->field($model, 'avatar')->hiddenInput(['value' => $model->avatar])->label(false) ?>
                <?php
                    // your fileinput widget for single file upload
                   echo $form->field($model, 'image')->widget(FileInput::classname(), [
                        'options'=>[
                            'id'=>'profileImage_upload',
                            'accept'=>'image/*'
                        ],
                        'pluginOptions'=>[
                            'allowedFileExtensions'=>['jpg','gif','png'],
                            'overwriteInitial'=>true,
                            'resizeImages'=>true,
                            'initialPreviewConfig'=>[
                                'width'=>'120px',
                            ],
                            'initialPreview' => [
                                '<img src="'.Yii::$app->urlManager->baseUrl.'\uploads\user\photo\\'.$model->getImageUrl().'" width="200" class="file-preview-image">',
                            ],
                            'showUpload'=>false,
                            'showRemove'=>false,
                            'showBrowse'=>true,
                            'showText'=>false
                        ],
                        //'value'=>Yii::$app->basePath.'\web\uploads\user\photo\\'.$model->avatar
                        ])->label(false);
                   
                     
                /*echo $form->field($model, 'image')->widget(\noam148\imagemanager\components\ImageManagerInputWidget::className(), [
                    'aspectRatio' => (16/9), //set the aspect ratio
                    'showPreview' => true, //false to hide the preview
                    'showDeletePickedImageConfirm' => false, //on true show warning before detach image
                ]);
                */
                ?>
                   
                </span>
            </div><!-- end of Row -->
            <div class="row">
            <span style="float:left; width: 250px;margin-right: 5px">
            <label class="control-label" for="profile-user_id">Username/Email</label>
            <?= $form->field($model, 'user_id')->widget(Select2::classname(), [
                'data' => $UserList,
                'language' => 'en',
                'options' => ['placeholder' => 'Select User'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label(false); ?>
            </span>
            <span style="float:left; width: 250px;margin-right: 5px">
            <?= $form->field($model, 'lastname')->textInput(['maxlength' => true]) ?>
            </span>
            </div>
            <div class="row">
            <span style="float:left; width: 250px;margin-right: 5px">
            <?= $form->field($model, 'firstname')->textInput(['maxlength' => true]) ?>
            </span>
            <span style="float:left; width: 250px;margin-right: 5px">
            <?= $form->field($model, 'middleinitial')->textInput(['maxlength' => true]) ?>
            </span>
            </div>
            <div class="row">
            <span style="float:left; width: 250px;margin-right: 5px">
            <?= $form->field($model, 'designation')->textInput() ?>
            </span>
            <span style="float:left; width: 250px;margin-right: 5px">
            <?= $form->field($model, 'contact_numbers')->textInput() ?>
            </span>
            </div>
            <div class="row">
            <span style="float:left; width: 250px;margin-right: 5px">
            <?= $form->field($model, 'rstl_id')->widget(Select2::classname(), [
                'data' => $RstlList,
                'language' => 'en',
                'options' => ['placeholder' => 'Select RSTL'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); ?>
            </span>
            <span style="float:left; width: 250px;margin-right: 5px">
            <?= $form->field($model, 'lab_id')->widget(Select2::classname(), [
                'data' => $LabList,
                'language' => 'en',
                'options' => ['placeholder' => 'Select Lab'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); ?>
            </span>
            </div>
            <div class="row" style="float: right;padding-right: 76px">
                <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                <?= Html::resetButton('Reset', ['class' => 'btn btn-danger']) ?>
                <?= Html::Button('Cancel', ['class' => 'btn btn-default','id'=>'modalCancel','data-dismiss'=>'modal']) ?>
            </div>

            <?php ActiveForm::end(); ?>
    </div>
</div>
