<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\file\FileInput;
use yii\helpers\Url;
use budyaga\cropper\Widget;
use yii\widgets\ActiveForm;
use yii\imagine\Image;
use Imagine\Image\Box;
use yii\bootstrap\Modal;


/* @var $this yii\web\View */
/* @var $model common\models\Profile */

$path = Yii::getAlias("@webroot")."\uploads\user\photo\\";

?>
<div class="profile-view">
    <div class="row">
   <div class="col-md-3">
        <?=
        Html::img(Yii::$app->urlManager->baseUrl . '\uploads\user\photo\\' . $model->getImageUrl(), [
            'class' => 'img-thumbnail img-responsive',
            'alt' => $model->user->username,
            'width' => 200,
            'data-toggle' => 'modal',
            'data-target' => '#w0'
        ])
        ?>
    </div>
    <div class="col-md-12">
        <?=
        DetailView::widget([
            'model' => $model,
            'attributes' => [
                [
                    'attribute' => 'user_id',
                    'label' => 'Username',
                    'value' => function($model) {
                        return $model->user->username;
                    }
                ],
                'lastname',
                'firstname',
                'designation',
                'middleinitial',
                [
                    'rstl_id' => 'rstl_id',
                    'label' => 'RSTL',
                    'value' => function($model) {
                        return $model->rstl->name;
                    }
                ],
                [
                    'lab_id' => 'lab_id',
                    'label' => 'Laboratory',
                    'value' => function($model) {
                        return $model->lab->labname;
                    }
                ],
                'contact_numbers',
            ],
        ])
        ?>
    </div>
    <div style="position:absolute;right:18px;bottom:10px;">
        <button type="button" class="btn btn-default" data-dismiss="modal" >Cancel</button>
    </div>
    </div>
</div>
