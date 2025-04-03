<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use common\modules\admin\components\Helper;
use yii\helpers\Url;
use common\models\system\User;

/* @var $this yii\web\View */
/* @var $model common\modules\admin\models\User */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => Yii::t('rbac-admin', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$controllerId = $this->context->uniqueId . '/';
function GetUser($id){
    $User= User::findOne($id);
    return $User->username;
}
?>
    <div class="user-form">
        <img border="5" src="<?= Yii::$app->params['uploadUrl'].$profile->getImageUrl() ?>" width="100">
     <?=
        DetailView::widget([
            'model' => $profile,
            'attributes' => [
                [
                    'attribute' => 'user_id',
                    'label' => 'Username',
                    'value' => GetUser($model->user_id)
                ],
                'fullname',
                [
                    'attribute' => 'user_id',
                    'label' => 'Email',
                    'value' => $model->email
                ],
                'designation',
                'middleinitial',
                'contact_numbers',
            ],
        ])
    ?>
    </div>
    <div class="form-group" style="float: right">
        <?= Html::submitButton(Yii::t('rbac-admin', 'Save'), ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
        <?php if(Yii::$app->request->isAjax){ ?>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <?php } ?>
    </div>
