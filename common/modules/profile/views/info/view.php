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
use kartik\export\ExportMenu;
use kartik\grid\GridView;
use common\components\Functions;


/* @var $this yii\web\View */
/* @var $model common\models\Profile */

$this->title = $model->firstname;
//$this->params['breadcrumbs'][] = ['label' => 'Profile', 'url' => ['/profile']];
//$this->params['breadcrumbs'][] = $this->title;
$func=new Functions();


?>


				
<div class="profile-view">
    <div class="panel panel-default col-xs-12">
        <div class="panel-body">
            <div class="col-md-12" style="text-align: center">
            <!-- <img src="/images/profile/2.jpg" height="40px" width="40px" /> -->
               <?= Html::img("/uploads/user/photo/".$model->image_url, [ 
                    'class' => 'img-thumbnail img-responsive',
                    'alt' => $model->user->username,
                    'width'=>250,
                 
                    'data-toggle'=>'modal',
                    'data-target'=>'#w0'
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
                    'contact_numbers',
                ],
            ])
            ?>
            </div>
        </div>
    </div>
    <div class="form-group pull-right">
        <div class="row pull-right" style="padding-right: 15px">
            <button style='margin-left: 5px' type='button' class='btn btn-secondary pull-left-sm' data-dismiss='modal'>Cancel</button>
        </div>
    </div>
</div>
