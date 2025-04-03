<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\lab\LabManager */

?>
<div class="lab-manager-view">
    <?php echo DetailView::widget([
        'model' => $model,
        'attributes' => [
            'labmanager',
            'labname',
            'updated_at:datetime',
        ],
    ])  ?>
    <div class="form-group pull-right">
        <?php if(Yii::$app->request->isAjax){ ?>
            <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Cancel</button>
        <?php } ?>
    </div>
     <div style="height: 10px"></div>
</div>
