<?php


//var_dump($stringTable);
//echo $values;



$this->title = $moduleTitle;
$this->params['breadcrumbs'][] = ['label' => 'Reports', 'url' => ['/reports']];
$this->params['breadcrumbs'][] = ['label' => 'Financial Reports', 'url' => ['/reports/finance/financialreports']];
$this->params['breadcrumbs'][] = $moduleTitle;
/**
 * Description of cashreceiptjournal
 *
 * @author mariano
 */
echo '<style type="text/css">

.box.box-solid.box-primary>.box-header {
            width:' .$tableWidth. 'px;
            background: #3c8dbc;
        }

        .dropdown-menu-right {
            right: auto;
            left: 0;
        }
        </style>';
 
?>





 
 



<style type="text/css">
    table, th, td {
        border: 1px solid black;
        text-align: center;
       
    }
    .tdValue
    {
        text-align: right;
        padding-right:5px;
        color:#3c8dbc;
        font-weight:bold;
        font-style:italic;
    }
</style>

<?php



?>



<div class="box box-primary box-solid" style="overflow: auto">
    <div class="box-header with-border">
              <h3 class="box-title"><?php echo $moduleTitle ?></h3>

              <!-- /.box-tools -->
    </div>

    <div class="box-body">
    <div class="btn-group" style="padding-bottom:10px">
        <button id="w1" class="btn btn-default dropdown-toggle" title="Export" data-toggle="dropdown">
        <i class="glyphicon glyphicon-export"></i>  <span class="caret"></span></button>

        <ul id="w2" class="dropdown-menu dropdown-menu-right">
        <li role="presentation" class="dropdown-header">Export Page Data</li>
        <li title="Microsoft Excel 95+"><a class="export-xls" href="#" onclick="exportTableToExcel('dvData')"><i class="text-success glyphicon glyphicon-floppy-remove"></i> Excel</a></li>
        <li title="Portable Document Format"><a class="export-pdf" href="#"><i class="text-danger glyphicon glyphicon-floppy-disk"></i> PDF</a></li>
       </div>
       <br>
        <div id="dvData">
    
            <?php
            echo $stringTable
            ?>
        </div>
        <br>
       
        
    </div>
    
   
    

</div>

<br><br>

<script>  
 
       

 function exportTableToExcel(tableID, filename = ''){
    var downloadLink;
    var dataType = 'application/vnd.ms-excel';
    var tableSelect = document.getElementById(tableID);
    var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
    
    // Specify file name
    filename = filename?filename+'.xls':'excel_data.xls';
    
    // Create download link element
    downloadLink = document.createElement("a");
    
    document.body.appendChild(downloadLink);
    
    if(navigator.msSaveOrOpenBlob){
        var blob = new Blob(['\ufeff', tableHTML], {
            type: dataType
        });
        navigator.msSaveOrOpenBlob( blob, filename);
    }else{
        // Create a link to the file
        downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
    
        // Setting the file name
        downloadLink.download = filename;
        
        //triggering the function
        downloadLink.click();
    }
}


 </script>  






