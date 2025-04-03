<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\modules\admin\components\RouteRule;
use common\modules\admin\AutocompleteAsset;
use yii\helpers\Json;
use common\modules\admin\components\Configs;

/* @var $this yii\web\View */
/* @var $model mdm\admin\models\AuthItem */
/* @var $form yii\widgets\ActiveForm */
/* @var $context mdm\admin\components\ItemController */

$context = $this->context;
$labels = $context->labels();
$rules = Configs::authManager()->getRules();
unset($rules[RouteRule::RULE_NAME]);
$source = Json::htmlEncode(array_keys($rules));

$js = <<<JS
    $('#rule_name').autocomplete({
        source: $source,
    });
JS;
AutocompleteAsset::register($this);
$this->registerJs($js);
?>

<div class="auth-item-form">
    <?php if(!Yii::$app->request->isAjax){ ?>
    <?= $this->renderFile(__DIR__ . '/../menu.php', ['button' => $labels['Items']]); ?>
    <?php } ?>
    <?php $form = ActiveForm::begin(['id' => 'item-form']); ?>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'name')->textInput(['maxlength' => 64]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'description')->textarea(['rows' => 2]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'ruleName')->textInput(['id' => 'rule_name']) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'data')->textarea(['rows' => 6]) ?>
        </div>
    </div>
    <div class="form-group" style="float: right">
        <?php
        echo Html::submitButton($model->isNewRecord ? Yii::t('rbac-admin', 'Create') : Yii::t('rbac-admin', 'Update'), [
            'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary',
            'name' => 'submit-button'])
        ?>
        <button style='margin-left: 5px;' type='button' class='btn btn-secondary' data-dismiss='modal'>Cancel</button>
    </div>
    <?php ActiveForm::end(); ?>
</div>
