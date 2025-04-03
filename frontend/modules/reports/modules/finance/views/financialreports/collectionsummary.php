<?php
/* @var $this yii\web\View */
use kartik\grid\GridView;
use yii\helpers\Html;

//var_dump($dataProviderCollectionSummary);
$this->title = $moduleTitle;
$this->params['breadcrumbs'][] = ['label' => 'Reports', 'url' => ['/reports']];
$this->params['breadcrumbs'][] = ['label' => 'Financial Reports', 'url' => ['/reports/finance/financialreports']];
$this->params['breadcrumbs'][] = $moduleTitle;

$i=0;
            
            $columnArrayNew [0]['attribute']= 'natureofcollection';
            $columnArrayNew [0]['hAlign']= 'middle';
            $columnArrayNew [0]['vAlign']= 'middle';
            $columnArrayNew [0]['header'] = 'Collection Type';
           // $columnArrayNew [0]['pageSummary']= true;
            
           
            $i=1;
            foreach ($columnHeaders as $col)
            {
                $columnArrayNew [$i]['attribute']= $col['accountcode'];
               
                $columnArrayNew [$i]['header'] = $col['accountcode'];
                $columnArrayNew [$i]['hAlign']= 'middle';
                $columnArrayNew [$i]['vAlign']= 'middle';
                $columnArrayNew [$i]['format']= 'raw';
                
                $columnArrayNew [$i]['pageSummary']= true;
             
                
              
                $i++;
            }
            
//var_dump($columnArrayNew);

?>
<style type="text/css">
    th {
    
    width: 100px;
}

.pull-right
{
    float:left!important;
}
.dropdown-menu-right {
    right: auto;
    left: 0;
}

</style>





<div style="overflow: auto;overflow-y: hidden;">
    
     <?= GridView::widget([
         'id'=>'tblCollection',
         'summary' => $moduleTitle,
        'dataProvider' => $dataProviderCollectionSummary,
         'panel'=>[
             'type'=>'primary', 
           //  'heading'=>'Account Code Mapping',
            
           //  'footer' => '{summary}'
             ],
       // 'filterModel' => $searchModel,
        'columns' => $columnArrayNew,
        'options' => ['style' => $gridOptions],
        'toolbar' => [
          //  [
         //   'content'=>'{toggleData}',
                //'options' => ['style' => 'margin-left:20px'],
          //  ],
        [
            'content'=>'{export}'
            
           
        ]
    ],
    'showPageSummary' => true,
    'hover' => true,
    'responsive' => true,
    'pjax'=>true,
        'pjaxSettings'=>[
        'neverTimeout'=>true,
        
    ]
         
       //  'rowOptions'=>
   //      'perfectScrollbar'=>true
    ]); ?>
    
</div>



<script type="text/javascript">
    
    $( document ).ready(function() {
        
       // var divHide = document.getElementById('tblCollection-container');
        
        //  divHide.style.display = 'none';
    
    });

    function showTable()
    {
        $('#tblCollection-container table').each(function(){ 
              var tmpTable = this;  
              this.id='myTempTable';
             
              tmpTable.rows[1].cells[3].style.color = "green";
              tmpTable.rows[1].cells[3].style.fontWeight = "bold";
              tmpTable.rows[1].cells[3].style.fontStyle = "italic";
              
              
              row_count =  $('#myTempTable').find('tr').length;
              column_count =  $('#myTempTable').find('td').length/(row_count-1);
           
                for(j = 1; j < column_count; j++)
                {
                    tmpTable.rows[0].cells[j].style.textAlign="right";
                }
                for(i = 1; i < row_count; i++)
                
                {    
                    for(j = 1; j < column_count; j++)
                     {
                         if(parseInt(tmpTable.rows[i].cells[j].innerText)>0)
                         {
                            tmpTable.rows[i].cells[j].style.textAlign="right";
                            tmpTable.rows[i].cells[j].style.color = "#3c8dbc";
                            tmpTable.rows[i].cells[j].style.fontWeight = "bold";
                            tmpTable.rows[i].cells[j].style.fontStyle = "italic";
                        }
                        else
                        {
                            tmpTable.rows[i].cells[j].innerText="";
                        }
                     }
                }
              
    });
}
</script>

<?php
$script = <<< JS
    $('#tblCollection-container table').each(function(){ 
              var tmpTable = this;  
              this.id='myTempTable';
             
              tmpTable.rows[1].cells[3].style.color = "green";
              tmpTable.rows[1].cells[3].style.fontWeight = "bold";
              tmpTable.rows[1].cells[3].style.fontStyle = "italic";
              
              
              row_count =  $('#myTempTable').find('tr').length;
              column_count =  $('#myTempTable').find('td').length/(row_count-1);
           
                for(j = 1; j < column_count; j++)
                {
                    tmpTable.rows[0].cells[j].style.textAlign="right";
                }
                for(i = 1; i < row_count; i++)
                
                {    
                    for(j = 1; j < column_count; j++)
                     {
                         if(parseInt(tmpTable.rows[i].cells[j].innerText)>0)
                         {
                            tmpTable.rows[i].cells[j].innerText= tmpTable.rows[i].cells[j].innerText.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                            tmpTable.rows[i].cells[j].style.textAlign="right";
                            tmpTable.rows[i].cells[j].style.color = "#3c8dbc";
                            tmpTable.rows[i].cells[j].style.fontWeight = "bold";
                            tmpTable.rows[i].cells[j].style.fontStyle = "italic";
                        }
                        else
                        {
                            tmpTable.rows[i].cells[j].innerText="";
                        }
                     }
                }
              
    });
JS;
$this->registerJs($script);
?>


