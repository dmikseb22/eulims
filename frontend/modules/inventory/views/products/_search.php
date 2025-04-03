<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\inventory\ProductsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="form-products-search">
<div class="panel panel-primary">
    <div class="panel-heading"></div>
    <div class="panel-body">
    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
    <div class="row">
        <div class="col-md-6">
    <?= $form->field($model, 'product_id')->textInput(['placeholder' => 'Product']) ?>
        </div>
        <div class="col-md-6">
    <?= $form->field($model, 'product_code')->textInput(['maxlength' => true, 'placeholder' => 'Product Code']) ?>
        </div>
    </div>
        <div class="row">
        <div class="col-md-6">
    <?= $form->field($model, 'product_name')->textInput(['maxlength' => true, 'placeholder' => 'Product Name']) ?>
        </div>
         <div class="col-md-6">   
    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
         </div>
        </div>
    <?= $form->field($model, 'price')->textInput(['maxlength' => true, 'placeholder' => 'Price']) ?>

    <?php /* echo $form->field($model, 'srp')->textInput(['maxlength' => true, 'placeholder' => 'Srp']) */ ?>

    <?php /* echo $form->field($model, 'category_type_id')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\common\models\inventory\Categorytype::find()->orderBy('categorytype_id')->asArray()->all(), 'categorytype_id', 'categorytype_id'),
        'options' => ['placeholder' => 'Choose Tbl categorytype'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); */ ?>

    <?php /* echo $form->field($model, 'qty_reorder')->textInput(['placeholder' => 'Qty Reorder']) */ ?>

    <?php /* echo $form->field($model, 'qty_onhand')->textInput(['placeholder' => 'Qty Onhand']) */ ?>

    <?php /* echo $form->field($model, 'qty_min_reorder')->textInput(['placeholder' => 'Qty Min Reorder']) */ ?>

    <?php /* echo $form->field($model, 'qty_per_unit')->textInput(['maxlength' => true, 'placeholder' => 'Qty Per Unit']) */ ?>

    <?php /* echo $form->field($model, 'discontinued')->checkbox() */ ?>

    <?php /* echo $form->field($model, 'suppliers_ids')->textarea(['rows' => 6]) */ ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    </div>
</div>
</div>
