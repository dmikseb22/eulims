<?php
use yii\helpers\Html;
use yii\widgets\DetailView;


echo "<h3>Summary of this month's accomplishment</h3>";

echo DetailView::widget([
    'model'      => $data,
    'attributes' => [
    		'year',
            'month',
            'requests',
            'samples',
            'analyses',
            'fees',
            'gratis',
            'discounts',
            'gross',
            // 'labid'
          ]
]);
?>
<?php if(Yii::$app->request->isAjax){ ?>
    <button type="button" class="btn btn-danger pull-right" data-dismiss="modal">Cancel</button>
<?php } ?>
<?=Html::a(' Finalized',
                                ['saveaccomplishment?data='.json_encode($data)],
                                [
                                    'data-confirm' => "Are you sure you want to save and submit this month's accomplishment?",
                                    'class'=>'pull-right btn btn-success btn-large',
                                ]
                            ); 
?>
