<?php
use yii2assets\pdfjs\PdfJs;

$this->title = 'Preview';
$this->params['breadcrumbs'][] = ['label' => 'Reports', 'url' => ['/reports']];
$this->params['breadcrumbs'][] ="Preview";
?>
<div style="margin-left: -10px;margin-top: -13px;margin-right: -10px">
<?= PdfJs::widget([
    'width'=>'100%',
    'height'=> '670px',
    'url'=>$url
]); ?>
</div>
