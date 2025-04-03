<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use common\components\Functions;
use yii2mod\alert\Alert;

/* @var $this yii\web\View */

//<div class="col-md-4"><a href="/finance/financialreports/collectionsummary/"><img class="img-responsive center-block" src="/images/summaryreportsquare.png" style="height:150px"/></a></div>

$this->title = 'Financial Reports';
$this->params['breadcrumbs'][] = ['label' => 'Reports', 'url' => ['/reports']];

$this->params['breadcrumbs'][] ='Financial Reports';
$link2 = 'reports/finance/financialreports/collectionsummary/';
?>
<style type="text/css">
    .imgHover:hover{
        border-radius: 25px;
        box-shadow: 0 0 0 5pt #3c8dbc;
        transition: box-shadow 0.5s ease-in-out;
    }
        
    .animationload {
    background-color: transparent;
    height: 100%;
    left: 0;
    position: relative;
    top: 0;
    width: 100%;
    z-index: 10000;
    }
    .osahanloading {
    animation: 1.5s linear 0s normal none infinite running osahanloading;
    background: #3c8dbc none repeat scroll 0 0;
    border-radius: 50px;
    height: 50px;
    left: 50%;
    margin-left: -25px;
    margin-top: -25px;
    position: absolute;
    top: 50%;
    width: 50px;
    }
    .osahanloading::after {
    animation: 1.5s linear 0s normal none infinite running osahanloading_after;
    border-color: #3c8dbc transparent;
    border-radius: 80px;
    border-style: solid;
    border-width: 10px;
    content: "";
    height: 80px;
    left: -15px;
    position: absolute;
    top: -15px;
    width: 80px;
    }
    @keyframes osahanloading 
    {
        0% {
        transform: rotate(0deg);
        }
        50% {
        background: #85d6de none repeat scroll 0 0;
        transform: rotate(180deg);
        }
        100% {
        transform: rotate(360deg);
        }
    }

    .glyphicon-refresh-animate {
    -animation: spin .7s infinite linear;
    -webkit-animation: spin2 .7s infinite linear;
    }

    @-webkit-keyframes spin2 {
    from { -webkit-transform: rotate(0deg);}
    to { -webkit-transform: rotate(360deg);}
    }

    .alert{
    display: none;
    }
</style>

<script type="text/javascript">
$( document ).ready(function() 
{
    
    
    
    $('#el').on('click', function(e) 
        {
        $.ajax({
           type:'POST',
          success: function(data) 
          {
             //  var siteNew = '/finance/financialreports/collectionsummary?year=' + $('#selYear :selected').text();
            //   window.location.href = siteNew;
            if($('#selMonth :selected').val() == '' || $('#selYear :selected').val() == '')
            {
            //   CrudAlert('Year/Month not supplied','WARNING',true,true,false); // alert('Year/Month not supplied');
               <?php
               Alert::widget([
            'options' => [
                'showCloseButton' => true,
                'showCancelButton' => true,
                'title' => 'Year/Month not supplied',
                'type' => 'WARNING',
                //'timer' => 1000
            ],
            'callback' => new \yii\web\JsExpression("
                        function () {
                        $('.sweet-overlay').css('display','none');
                        $('.sweet-alert').removeClass( \"showSweetAlert \" );
                        $('.sweet-alert').removeClass( \"visible \" );
                        $('.sweet-alert').addClass( \"hideSweetAlert \" );
                        $('.sweet-alert').css('display','none');
                        $('body').removeClass( \"stop-scrolling\" );
                        }"),
        ]);
               ?>
            }
            else
            {
            alert($('#selMonth :selected').val());
                 var siteNew = '/reports/financialreports/collectionsummary?iyear=' + $('#selYear :selected').text() + '?imonth='+ $('#selMonth :selected').val();
                 window.location.href = siteNew;
            }
            
           }
        });
    });
});

function loadUrl(obj)
    {
       if($('#selMonth :selected').val() == '' || $('#selYear :selected').val() == '')
            {
          //     alert('Year/Month not supplied');
            //    CrudAlert('Year/Month not supplied','WARNING',true,true,false);
           //  $('.alert').alert();
           //    $('.alert').show();
          
           //    bootbox.alert({
           //            message: "Year/Month not supplied!",
             //   });
                 
                 bootbox.dialog({
    title: 'Financial Reports',
     buttons: {
        close: {
            label: '<i class="fa fa-times"></i>&nbsp;&nbsp;Close',
            className: "btn-primary",
            

        }
    },
    message: 'Year/Month not supplied!'
}).addClass('');

          // alert alert-warning alert-dismissible fade show
            }
            else
            {
         //    alert('test');
            // $("#divSpinner").css("display", "block");
            $("#divSpinner").toggle();
          //  $("#divSpinner").hide();
             var siteNew='';
             switch(obj)
             {
                 case 'collection':
                     siteNew = '/reports/finance/financialreports/collectionreport?iyear=' + $('#selYear :selected').text() + '&imonth='+ $('#selMonth :selected').val();
                     break;
                 case 'summary':
                     siteNew = '/reports/finance/financialreports/collectionsummary?iyear=' + $('#selYear :selected').text() + '&imonth='+ $('#selMonth :selected').val();
                     break;
                 case 'receipt':
                     siteNew = '/reports/finance/financialreports/cashreceiptjournal?iyear=' + $('#selYear :selected').text() + '&imonth='+ $('#selMonth :selected').val();
                     break;
                 
             }
             // alert($('#selMonth :selected').val());
               //  var siteNew = '/finance/financialreports/collectionsummary?year=' + $('#selYear :selected').text() + '?month='+ $('#selYear :selected').val();
                 window.location.href = siteNew;
            }
    }
    
    </script>
    
 
    


<?php
Pjax::begin(['id' => 'pjax',
    'timeout' => 2000,
    'enablePushState' => false]);
?>
<?php
$form = ActiveForm::begin(
                [
                    'id' => 'test'
        ]);
?>

<div class="box box-primary box-solid" style="background:transparent">
    <div class="box-header with-border" style="text-align:center">
        <h2 class="box-title">Financial Reports</h2>

        <!-- /.box-tools -->
    </div>

    <div class="box-body">

        <div class="row">

            <div class="col-md-6">
                    <?php
                    echo $form->field($model, 'intYear')->dropDownList($listYear, [
                        'id' => 'selYear',
                        'prompt' => 'Select Year',
                        'type'=>'post'
                    ]);
                    ?>
            </div>
            
            <div class="col-md-6">
           
                <?php
                    echo $form->field($model, 'intMonth')->dropDownList($listMonth, [
                        'id' => 'selMonth',
                        'prompt' => 'Select Month',
                        'type'=>'post'
                    ]);
                    ?>
            </div>
        </div>
        
        <div class="row">
           
         
              <div class="col-md-4"><a href="#" onclick="loadUrl('collection')" data-dismiss="alert"><img class="imgHover img-responsive center-block" src="/images/collectionreportsquare.png" style="height:150px"/></a></div>
              <div class="col-md-4"><a href="#" onclick="loadUrl('summary')"><img class="imgHover img-responsive center-block" src="/images/summaryreportsquare.png" style="height:150px"/></a></div>
              <div class="col-md-4"><a href="#" onclick="loadUrl('receipt')"><img class="imgHover img-responsive center-block" src="/images/cashreceiptsquare.png" style="height:150px"/></a></div>
        </div>






    </div>
</div>



<div id="divSpinner" style="text-align:center;display:none;font-size:30px">
    
    <img src='/images/img-loader64.gif' alt=''>
    
</div>




<?php ActiveForm::end(); ?>
<?php Pjax::end(); ?>






