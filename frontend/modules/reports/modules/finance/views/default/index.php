<?php

$this->title = 'Finance';
$this->params['breadcrumbs'][] = ['label' => 'Reports', 'url' => ['/reports']];
$this->params['breadcrumbs'][] = $this->title;
?>
<style type="text/css">

.imgHover:hover{
    border-radius: 15px;
    box-shadow: 0 0 0 4pt #3c8dbc;
    transition: box-shadow 0.5s ease-in-out;
}
</style>

<div class="Lab-default-index">
   <div class="body-content">
        <div class="box box-primary color-palette-box" style="padding:0px">
        <div class="box-header" style="background-color: #fffff;color:#000" data-widget="collapse">
          <h3 class="box-title" data-widget="collapse"><i class="fa fa-tag"></i>Finance</h3>
          <div class="box-tools pull-right" >
                <button type="button" style="color:#000" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
        </div>      
        <div class="box-body">
          <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-12">
              
               <div  style="padding-top: 1px;padding-bottom: 1px;display:block;text-align: center">
                  <a href="#" title="Billing"><img class="imgHover" src="/images/billingsquare.png" style="height:120px;width: 120px" ></a>
              </div>
            </div>
            <!-- /.col -->
            <div class="col-md-3 col-sm-6 col-xs-12">
            
             <div  style="padding-top: 1px;padding-bottom: 1px;display:block;text-align: center">
                 <a href="/reports/finance/financialreports/" title="Financial Reports"><img class="imgHover" src="/images/financialsquare.png" style="height:120px;width: 120px"></a>
              </div>
            </div>
            <!-- /.col -->
            <div class="col-md-3 col-sm-6 col-xs-12">
              

               <div  style="padding-top: 1px;padding-bottom: 1px;display:block;text-align: center">
                   <a href="#" title="Cashier"><img class="imgHover" src="/images/cashiersquare.png" style="height:120px;width: 120px"></a>
              </div>
            </div>
            
            <div class="col-md-3 col-sm-6 col-xs-12">
           
               <div  style="padding-top: 1px;padding-bottom: 1px;display:block;text-align: center">
                 <a href="#" title="Customer Wallet"><img class="imgHover" src="/images/customerwalletsquare.png" style="height:120px;width: 120px"></a>
              </div>
            </div>
            
            <!-- /.col -->
            
            <!-- /.col -->  
          </div>
        </div>
        <!-- /.box-body -->
        </div>
        
        
        
        
        
        
        
        
        
    </div>
</div>