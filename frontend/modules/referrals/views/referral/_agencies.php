 <?php
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\bootstrap\Button;
 ?>
 <div class="col-md-12">
    <h1>Agencies</h1>
<?=
    GridView::widget([
        'id' => 'method-reference-grid',
        'dataProvider'=> $agencies,
        'floatHeaderOptions' => ['scrollingTop' => true],
        'responsive'=>true,
        'striped'=>true,
        'hover'=>true,
        'bordered' => true,
        'columns' => [
            [
                'class' => '\kartik\grid\SerialColumn',
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-center','style'=>'max-width:5px;'],
            ],
            [
                'attribute'=>'region',
                'contentOptions' => ['class' => 'text-center','style'=>'max-width:10px;white-space:pre-line;'],
            ],
            [
                'attribute'=>'code',
                'contentOptions' => ['class' => 'text-center','style'=>'max-width:5px;white-space:pre-line;'],
            ],
            [
                'attribute'=>'name',
                'contentOptions' => ['class' => 'text-center','style'=>'max-width:50px;white-space:pre-line;'],
            ],
             [
                'class' => 'kartik\grid\ActionColumn',
                'contentOptions' => ['style' => ''],
                'template'=>'{refer}',
                'header'=>'Turn-Around-Time',
                'buttons'=>[
                    'refer'=>function ($url, $model)use($referral_id) {

                        $urls = '/referrals/referral/confirmed?agency_id='.$model->agency_id.'&referral_id='.$referral_id.'&type=2&company='.(string)$model->code;
                        return '<a class="toclick" name="'.$urls.'"><i class="fa fa-refresh fa-spin"></i>  Checking Turn around time...</a>';
                    },
                ],
            ],
             [
                'class' => 'kartik\grid\ActionColumn',
                'contentOptions' => ['style' => ''],
                'template'=>'{refer}',
                'header'=>'Send',
                'buttons'=>[
                    'refer'=>function ($url, $model)use($referral_id) {
                        $urls = '/referrals/referral/confirmedsend?agency_id='.$model->agency_id.'&referral_id='.$referral_id.'&type=2&company='.(string)$model->code;
                        return '<a class="toclick" name="'.$urls.'"><i class="fa fa-refresh fa-spin"></i>  Checking Turn around time...</a>';
                     
                    },
                ],
            ],
        ],
        'toolbar' => false,
    ]);
?>
</div>

<script type="text/javascript">
    


jQuery(document).ready(function ($) {

    setTimeout(function() {
        $('.toclick').each(function(i, obj) {

            $(this).load(this.name);
            // $(this).attr('disabled', 'disabled');
        });

    }, 2000);
});
</script>