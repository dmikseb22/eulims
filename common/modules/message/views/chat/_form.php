<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\modules\message\models\Chat */
/* @var $form yii\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin(); ?>
<div class="container clearfix">
    <div class="people-list" id="people-list">
        <label style="color:white"> <h4>Home </h4></label>
        <span style=><?=Html::button('<span class="glyphicon glyphicon-home"></span>', ['value' => '/message/chat/index','onclick'=>'location.href=this.value', 'class' => 'btn btn-primary']);?>
            <div class="search">
            <input type="text" placeholder="search" />
            <i class="fa fa-search"></i>
        </div>
        <ul class="list">

        </ul>
    </div>

    <div class="chat" >
        <div class="chat-header clearfix">
            <?php

            echo $form->field($model, 'reciever_userid')->widget(Select2::classname(), [
                'data' => $possible_recipients,
                'theme' => Select2::THEME_BOOTSTRAP,
                'options' => ['placeholder' => 'Choose the recipient'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>

        </div> <!-- end chat-header -->

        <div class="chat-history">
            <ul id="idconvo">

            </ul>

        </div> <!-- end chat-history -->

        <div class="chat-message clearfix">
            <?= $form->field($model, 'message')->textarea(['rows' => 2]) ?>
            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? 'Send' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
				
            </div>
        </div> <!-- end chat-message -->

    </div> <!-- end chat -->

</div>
<div class="chat-form">


    <!--<div class="form-group">
        <?/*= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) */?>
    </div>-->



</div>
<?php ActiveForm::end(); ?>
