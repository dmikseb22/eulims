<?php
/* @var $this yii\web\View */

$this->title = 'Accounting';
$this->params['breadcrumbs'][] = ['label' => 'Finance', 'url' => ['/finance/']];
$this->params['breadcrumbs'][] = $this->title;    
?>

<style type="text/css">

img:hover{
    border-radius: 25px;
    box-shadow: 0 0 0 5pt #3c8dbc;
    transition: box-shadow 0.5s ease-in-out;
}
</style>

<div class="box box-primary box-solid" style="background:transparent">
    <div class="box-header with-border">
              <h2 class="box-title">Accounting Dashboard</h2>

              <!-- /.box-tools -->
    </div>

    <div class="box-body">
   
    <div class="row">
        <div class="col-md-6 col-sm-6 col-xs-12" style="text-align:center"><a href="/finance/accounting/op/"><img class="img-responsive center-block" src="/images/ordersquare.png" style="height:150px;"/></a></div>
        <div class="col-md-6 col-sm-6 col-xs-12" style="text-align:center"><a href="/finance/accounting/op-lab/"><img class="img-responsive center-block" src="/images/orderlabsquare.png" style="height:150px"/></a></div>
    </div>

    </div>
    
</div>