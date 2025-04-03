<?php
/* @var $this yii\web\View */
//<div class="col-md-3 col-sm-6 col-xs-12" style="text-align:center"><a href="/finance/cashier/reports/"><img class="img-responsive center-block" src="/images/reportsquare.png" style="height:150px"/>Reports</a></div>
$this->title = 'Cashier';
$this->params['breadcrumbs'][] = ['label' => 'Finance', 'url' => ['/finance/']];
$this->params['breadcrumbs'][] = $this->title;   
?>

<style type="text/css">

.imgHover:hover{
    border-radius: 20px;
    box-shadow: 0 0 0 5pt #3c8dbc;
    transition: box-shadow 0.5s ease-in-out;
}
</style>


<div class="box box-primary box-solid" style="background:transparent">
    <div class="box-header with-border">
              <h2 class="box-title">Cashier Dashboard</h2>

              <!-- /.box-tools -->
    </div>

    <div class="box-body">
   
    <div class="row">
        <div class="col-md-2 col-sm-6 col-xs-12 col-md-offset-1" style="text-align:center"><a href="/finance/cashier/collection/"><img class="imgHover img-responsive center-block" src="/images/ordersquare.png" style="height:150px"/></a></div>
        <div class="col-md-2 col-sm-6 col-xs-12" style="text-align:center"><a href="/finance/cashier/billing/"><img class="imgHover img-responsive center-block" src="/images/billingpaymentsquare.png" style="height:150px"/></div>
        <div class="col-md-2 col-sm-6 col-xs-12" style="text-align:center"><a href="/finance/cashier/receipt/"><img class="imgHover img-responsive center-block" src="/images/receiptsquare.png" style="height:150px"/></div>
        <div class="col-md-2 col-sm-6 col-xs-12" style="text-align:center"><a href="/finance/cashier/deposit/"><img class="imgHover img-responsive center-block" src="/images/depositsquare.png" style="height:150px"/></div>
        <div class="col-md-2 col-sm-6 col-xs-12" style="text-align:center"><a href="/finance/cashier/reports/"><img class="imgHover img-responsive center-block" src="/images/reportsquare.png" style="height:150px"/></div>
    </div>

    </div>
    
</div>


           
