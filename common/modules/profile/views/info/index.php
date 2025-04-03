<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\export\ExportMenu;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use common\models\system\User;
use kartik\grid\ActionColumn;
use common\components\Functions;

//use kartik\grid\GridView;
/* @var $this yii\web\View */
/* @var $searchModel common\models\ProfileSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Profile';
$this->params['breadcrumbs'][] = $this->title;

if(Yii::$app->user->can('access-his-profile')){
    $UserList= ArrayHelper::map(User::findAll(['user_id'=>Yii::$app->user->identity->user_id]),'user_id','username');
}else{
    $UserList= ArrayHelper::map(User::find()->all(),'user_id','username');
}

if(!Yii::$app->user->can('can-delete-profile')){
   $Buttontemplate="{view}{update}";
}else{
   $Buttontemplate="{view}{update}{delete}"; 
}
$gridColumn = [
    ['class' => 'yii\grid\SerialColumn'],
    [
        'attribute' => 'user_id',
        'label' => 'Username',
        'value' => function($model) {
            return $model->user->username;
        },
        'filterType' => GridView::FILTER_SELECT2,
        'filter' => ArrayHelper::map(User::find()->asArray()->all(), 'user_id', 'username'),
        'filterWidgetOptions' => [
            'pluginOptions' => ['allowClear' => true],
        ],
        'filterInputOptions' => ['placeholder' => 'User', 'userz_id' => 'grid-products-search-category_type_id']
    ],
    'lastname',
    'firstname',
    'middleinitial',
    'designation',
    'contact_numbers',
    [
        'class' => ActionColumn::className(),
        'template' => $Buttontemplate,
        'buttons'=>[
              'view'=>function ($url, $model) {
                  return Html::button('<span class="glyphicon glyphicon-eye-open"></span>', ['value'=>'/profile/info/view?id='.$model->profile_id, 'onclick'=>'ShowModal(this.title, this.value);', 'class' => 'btn btn-primary','title' => Yii::t('app', "View Profile")]);
              },
              'update'=>function ($url, $model) {
                  $profile= \common\models\system\Profile::find()->where(['profile_id'=>$model->profile_id])->one();
                  if($profile){
                      return Html::button('<span class="glyphicon glyphicon-pencil"></span>', ['value'=>'/profile/info/update?id='.$model->profile_id,'onclick'=>'ShowModal(this.title, this.value);', 'class' => 'btn btn-success','title' => Yii::t('app', "Update Profile")]);
                  }else{
                      return Html::button('<span class="glyphicon glyphicon-pencil"></span>', ['value'=>'#','onclick'=>'', 'class' => 'btn btn-success disabled','title' => Yii::t('app', "Update Profile")]);
                  }
                  
              }
          ],
    ],
];
if(Yii::$app->user->can("profile-full-access")){
    //$CreateUserButton=Html::button('<i class="fa fa-user-md"> Create User Profile</i>',[
    //    'class'=>'btn btn-primary',
    //    'onclick'=>"ShowModal('Create User Profile','/profile/info/create')",
    //]);
    $CreateUserButton=Html::button('Create User Profile', ['onclick'=>'ShowModal(this.title,this.value)','value'=>'/profile/info/create','title'=>'Create New Profile','class' => 'btn btn-success']);
}else{
    $CreateUserButton="";
}
$func=new Functions();
$Header="Port Management System<br>";
$Header.="Profile List";
?>
<div class="profile-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <div class="table-responsive">
        <?=
        GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'bordered' => true,
            'striped' => true,
            'condensed' => true,
            'responsive' => false,
            'hover' => true,
            'exportConfig'=>$func->exportConfig("Profile List", "profile list", $Header),
            'columns' => $gridColumn,
            'pjax' => true,
            'pjaxSettings' => [
                'options' => [
                    'id' => 'kv-pjax-container-products',
                    'enablePushState' => false
                ]
            ],
            'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'heading' => '<span class="glyphicon glyphicon-book"></span>  ' . Html::encode($this->title),
                'before'=>$CreateUserButton
            ],
        ]);
        ?>
    </div>
</div>
