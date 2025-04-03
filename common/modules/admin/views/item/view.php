<?php

use common\modules\admin\AnimateAsset;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\YiiAsset;
//use yii\widgets\DetailView;
use kartik\detail\DetailView;

/* @var $this yii\web\View */
/* @var $model mdm\admin\models\AuthItem */
/* @var $context mdm\admin\components\ItemController */

$context = $this->context;
$labels = $context->labels();
$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('rbac-admin', $labels['Items']), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

AnimateAsset::register($this);
YiiAsset::register($this);
$opts = Json::htmlEncode([
    'items' => $model->getItems(),
]);
$this->registerJs("var _opts = {$opts};");
$this->registerJs($this->render('_script.js'));
$animateIcon = ' <i class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></i>';
?>
<div class="auth-item-view" style="padding-bottom: 20px">
    <?php if(!Yii::$app->request->isAjax){ ?>
    <?= $this->renderFile(__DIR__ . '/../menu.php', ['button' => $labels['Items']]); ?>
    <p>
        <button type='button' onclick="ShowModal('Update <?= $labels["Item"] ?>','/admin/<?= strtolower($labels["Item"]) ?>/update?id=<?= $model->name ?>')" class="btn btn-primary"><i class="fa fa-book-o"></i> Update <?= $labels['Item'] ?></button>
        <?=
        Html::a(Yii::t('rbac-admin', 'Delete'), ['delete', 'id' => $model->name], [
            'class' => 'btn btn-danger',
            'data-confirm' => Yii::t('rbac-admin', 'Are you sure to delete this item?'),
            'data-method' => 'post',
        ]);
        ?>
        <button type='button' onclick='ShowModal("Create <?= $labels["Item"] ?>","/create")' class="btn btn-success"><i class="fa fa-book-o"></i> Create New <?= $labels['Item'] ?></button>
    </p>
    <?php } ?>
    <div class="row">
        <div class="col-sm-12">
            <?=
            DetailView::widget([
                'model' => $model,
                'panel' => [
                    'type' => DetailView::TYPE_PRIMARY,
                    'heading' => '<i class="fa fa-user-circle fa-adn"></i> '.$labels["Item"]
                ],
                'attributes' => [
                    'name',
                    'description:ntext',
                    'ruleName',
                    'data:ntext',
                ],
                'template' => '<tr><th style="width:25%">{label}</th><td>{value}</td></tr>',
            ]);
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-5">
            <input class="form-control search" data-target="available"
                   placeholder="<?= Yii::t('rbac-admin', 'Search for available'); ?>">
            <select multiple size="20" class="form-control list" data-target="available"></select>
        </div>
        <div class="col-sm-1">
            <br><br>
            <?=
            Html::a('&gt;&gt;' . $animateIcon, ['assign', 'id' => $model->name], [
                'class' => 'btn btn-success btn-assign',
                'data-target' => 'available',
                'title' => Yii::t('rbac-admin', 'Assign'),
            ]);
            ?><br><br>
            <?=
            Html::a('&lt;&lt;' . $animateIcon, ['remove', 'id' => $model->name], [
                'class' => 'btn btn-danger btn-assign',
                'data-target' => 'assigned',
                'title' => Yii::t('rbac-admin', 'Remove'),
            ]);
            ?>
        </div>
        <div class="col-sm-5">
            <input class="form-control search" data-target="assigned"
                   placeholder="<?= Yii::t('rbac-admin', 'Search for assigned'); ?>">
            <select multiple size="20" class="form-control list" data-target="assigned"></select>
        </div>
    </div>
    <div class="row" style="float: right;padding-top: 20px;">
        <div class="col-md-12">
            <button style='margin-left: 5px;' type='button' class='btn btn-secondary' data-dismiss='modal'>Cancel</button>
        </div>
    </div>
</div>
