<?php

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
use kartik\select2\Select2;
use kartik\checkbox\CheckboxX;
use kartik\grid\GridView;
use common\components\Functions;
//use bs\dbManager\models\BaseDumpManager;

/* @var $this yii\web\View */
$this->title = Yii::t('dbManager', 'DB Manager');
$this->params['breadcrumbs'][] = $this->title;

$config= Yii::$app->components;
/*echo "<pre>";
var_dump($config);
echo "</pre>";
var_dump($config);
*/
$form = ActiveForm::begin([
    'action'=>'/dbmanager/default/create-backup',
    'options' => [
        'id' => 'frmBackup',
        'method'=>'GET'
    ] // important
]);
$dbComponents= \Yii::$app->components;
$dbList=$dbComponents['backup']['databases'];
$dbs=[
    'all'=>'All Databases',
];
foreach($dbList as $db){
   $dbs[$db['db']]=$db['db'];
}
$js=<<<SCRIPT
    $("#btnGenerate").click(function(){
        $("#btnGenerate").attr("disabled", "disabled");
        ShowProgress();
        $("#frmBackup").submit();
    });
SCRIPT;
$this->registerJs($js);
$ext=[
    'tar'=>'Tape Archive (*.tar)',
    'zip'=>'Winzip (*.zip)',
    'gz'=>'Gzip (*.gz)',
    'rar'=>'Winrar(*.rar)'
];
$func=new Functions();
$Header="Department of Science and Technology<br>";
$Header.="Laboratory Request";
?>
<div class="panel panel-primary">
    <div class="panel-heading">Database Manager</div>
    <div class="panel-body">
        <?php if(!$Configured){ ?>
        <div class="alert alert-danger">
            <span>MySQL Bin Folder is not configured, Please Configure the path of MySQL bin folder! or &nbsp;
                <a href="/dbmanager/config" class="link">Take me to configuration page.</a>
            </span>
        </div>
        <?php } ?>
        <div class="row">
            <div class="col-md-3">
                <?=
                $form->field($model, 'extension')->widget(Select2::classname(), [
                    'data' => $ext,
                    'language' => 'en',
                    'options' => ['placeholder' => 'Select Extension'],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'disabled'=>!$Configured
                    ],
                ]);
                ?>
            </div>
            <div class="col-md-3">
                <label class="control-label" for="backupmodel-extension">Backup Database</label>
                <?=
                $form->field($model, 'backupdatabase')->widget(CheckboxX::class, [
                    'options'=>['id'=>'backupdatabase'],
                    'disabled'=>!$Configured,
                    'pluginOptions'=>['threeState'=>false],
                    'pluginEvents'=>[
                        "change"=>"function() { 
                            $('#backupmodel-database').prop('disabled', this.value==0 ? true : false);
                        }    
                    "
                    ],
                ])->label(false);
                ?>
            </div>
            <div class="col-md-3">
                <?=
                $form->field($model, 'database')->widget(Select2::classname(), [
                    'data' => $dbs,
                    'language' => 'en',
                    'options' => ['placeholder' => 'Select Database'],
                    'pluginOptions' => [
                        'allowClear' => false,
                        'disabled'=>!$Configured
                    ],
                ]);
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <label class="control-label" for="backupmodel-extension">Backup Images and Photos</label>
                <?=
                $form->field($model, 'backupfiles')->widget(CheckboxX::class, [
                    'options'=>['id'=>'backupfiles'],
                    'disabled'=>!$Configured,
                    'pluginOptions'=>['threeState'=>false],
                ])->label(false);
                ?>
            </div>
            <div class="col-md-3">
                <label class="control-label" for="backupmodel-extension">Auto Download</label>
                <?=
                $form->field($model, 'download')->widget(CheckboxX::class, [
                    'options'=>['id'=>'download'],
                    'disabled'=>!$Configured,
                    'pluginOptions'=>['threeState'=>false],
                ])->label(false);
                ?>
            </div>
            <div class="col-md-3" style="padding-right: 15px">
                <?php if(!$Configured){ ?>
                <?= Html::Button('<i class="fa fa-download"></i> Generate Backup', ['class' => 'btn btn-primary','disabled'=>!$Configured]) ?>
                <?php }else{ ?>
                <?= Html::Button('<i class="fa fa-download"></i> Generate Backup', ['id'=>'btnGenerate','class' => 'btn btn-primary','disabled'=>!$Configured]) ?>
                <?php } ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
    <div class="row">
        <div class="col-md-12" style="margin-left: 5px;padding-right: 25px">
     <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'bordered' => true,
        'striped' => true,
        'condensed' => true,
        'responsive' => false,
        'hover' => true,
        'pjax' => false, // pjax is set to always true for this demo
        'pjaxSettings' => [
            'options' => [
                    'enablePushState' => false,
              ],
        ],
       
        'exportConfig'=>$func->exportConfig("Laboratory Request", "laboratory request", $Header),
        'columns' => [
            [
                'attribute' => 'type',
                'label' => Yii::t('dbManager', 'Type'),
            ],
            [
                'attribute' => 'name',
                'label' => Yii::t('dbManager', 'Name'),
            ],
            [
                'attribute' => 'size',
                'label' => Yii::t('dbManager', 'Size'),
            ],
            [
                'attribute' => 'create_at',
                'label' => Yii::t('dbManager', 'Create time'),
            ],

            [
                'class' => 'kartik\grid\ActionColumn',
                'template' => '{download} {storage} {delete}', //{restore}
                'buttons' => [
                    'download' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-download-alt"></span>',
                            [
                                'download',
                                'id' => $model['id'],
                            ],
                            [
                                'title' => Yii::t('dbManager', 'Download'),
                                'class' => 'btn btn-sm btn-default',
                            ]);
                    },
                    'restore' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-import"></span>',
                            [
                                'restore',
                                'id' => $model['id'],
                            ],
                            [
                                'title' => Yii::t('dbManager', 'Restore'),
                                'class' => 'btn btn-sm btn-default',
                            ]);
                    },
                    'storage' => function ($url, $model) {
                        if (Yii::$app->has('backupStorage')) {
                            $exists = Yii::$app->backupStorage->has($model['name']);

                            return Html::a('<span class="glyphicon glyphicon-cloud-upload"></span>',
                                [
                                    'storage',
                                    'id' => $model['id'],
                                ],
                                [
                                    'title' => $exists ? Yii::t('dbManager', 'Delete from storage') : Yii::t('dbManager', 'Upload from storage'),
                                    'class' => $exists ? 'btn btn-sm btn-danger' : 'btn btn-sm btn-success',
                                ]);
                        }
                    },
                    'delete' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>',
                            [
                                'delete',
                                'id' => $model['id'],
                            ],
                            [
                                'title' => Yii::t('dbManager', 'Delete'),
                                'data-method' => 'post',
                                'data-confirm' => Yii::t('dbManager', "Are you sure you want to delete '$model[name]' script?"),
                                'class' => 'btn btn-sm btn-danger',
                            ]);
                    },
                ],
            ],
        ],
    ]) ?>
        </div>
    </div>
</div>
<?php if($file!=="") { ?>
<iframe width="1" height="1" frameborder="0" src="<?= $file ?>"></iframe>
<?php } ?>