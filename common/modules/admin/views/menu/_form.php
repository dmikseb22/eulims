<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\modules\admin\models\Menu;
use yii\helpers\Json;
use common\modules\admin\AutocompleteAsset;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use common\models\auth\AuthItem;

/* @var $this yii\web\View */
/* @var $model mdm\admin\models\Menu */
/* @var $form yii\widgets\ActiveForm */
//AutocompleteAsset::register($this);
//$opts = Json::htmlEncode([
//        'menus' => Menu::getMenuSource(),
//        'routes' => Menu::getSavedRoutes(),
//]);
//$this->registerJs("var _opts = $opts;");
//$this->registerJs($this->render('_script.js'));
$MenuList= ArrayHelper::map(Menu::find()->all(),'id','name');
$RouteList= ArrayHelper::map(AuthItem::find()->where(['LIKE', 'name', '/%', false])->all(),'name','name');
?>

<div class="menu-form">
    <?php if(!Yii::$app->request->isAjax){ ?>
    <?= $this->renderFile(__DIR__ . '/../menu.php', ['button' => 'menu']); } ?>
    <?php $form = ActiveForm::begin(); ?>
    <?php //Html::activeHiddenInput($model, 'parent', ['id' => 'parent_id']); ?>
    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'name')->textInput(['maxlength' => 128]) ?>

            <?php //$form->field($model, 'parent_name')->textInput(['id' => 'parent_name']) ?>
            
            <?=
            $form->field($model, 'parent')->widget(Select2::classname(), [
                'data' => $MenuList,
                'language' => 'en',
                'options' => ['placeholder' => 'Select Parent Menu'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
            <?=
            $form->field($model, 'route')->widget(Select2::classname(), [
                'data' => $RouteList,
                'language' => 'en',
                'options' => ['placeholder' => 'Select Route'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
            <?php //$form->field($model, 'route')->textInput(['id' => 'route']) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'order')->input('number') ?>

            <?= $form->field($model, 'data')->textarea(['rows' => 4]) ?>
        </div>
    </div>
    <div class="form-group" style="float: right">
    <?php
    echo Html::submitButton($model->isNewRecord ? Yii::t('rbac-admin', 'Create') : Yii::t('rbac-admin', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) 
    ?>
    <button style='margin-left: 5px;' type='button' class='btn btn-secondary' data-dismiss='modal'>Cancel</button>
    </div>
    <?php ActiveForm::end(); ?>
</div>
