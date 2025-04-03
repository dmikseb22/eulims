<?php
use yii\helpers\Html;
use yii\widgets\DetailView;

$model = json_decode($model);
?>
<h3>Are these the same person? <?php echo Html::a("Same",
            ['applysync','code'=>$model->customer_code,'email'=>$model->email],
            [
                'data-confirm' => "Are you sure you want the record to sync to your local copy?",
                'class'=>'btn btn-success',
            ]
        );  
    ?></h3>
<div class="customer-view">
    <div class="col-md-6">
        <span class='badge legend-font btn-primary' ><span class="glyphicon glyphicon-cloud"> </span>  Cloud Copy</span>
         <?= DetailView::widget([
        'model' =>$model,
        'attributes' => [
            'customer_code',
            'customer_name',
            'head',
            'tel',
            'fax',
            'email:email',
            'address',
        ],
     ])?>
    </div>
    <div class="col-md-6">
        <span class='badge legend-font btn-primary' ><span class="glyphicon glyphicon-arrow-down"> </span>  Local Copy</span>
         <?= DetailView::widget([
        'model' =>$local,
        'attributes' => [
            'customer_code',
            'customer_name',
            'head',
            'tel',
            'fax',
            'email:email',
            'address',
        ],
    ])?>
    </div>
</div>