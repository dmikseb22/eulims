<?php

use kartik\grid\GridView;
use common\models\lab\Tagging;

$this->title = 'Lab';
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
        
    <!-- Analysts dashboard -->
    <div class="box box-primary color-palette-box" style="padding:0px">
      <div class="box-header" style="background-color: #fffff;color:#000" data-widget="collapse">
        <h3 class="box-title" data-widget="collapse"><i class="fa fa-sticky-note"></i> To Dos</h3>
        <div class="box-tools pull-right" >
          <button type="button" style="color:#000" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
          </button>
        </div>
      </div>      
      <div class="box-body">
      <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <?= GridView::widget([
              'dataProvider' => $todoprovider,
              'columns' => [
                  ['class' => 'yii\grid\SerialColumn'],
                  [
                    'attribute'=>'sample_code',
                    'contentOptions' => ['class' => 'text-primary','style'=>'font-weight:bold;font-size:15px;background-color:#ddd!important;'],
                    'group'=>true,  // enable grouping,
                    'groupedRow'=>false,      
                  ],
                  [
                    'header'=>'Test',
                    'attribute'=>'remarks'
                  ],
                  [
                    'header'=>'Status',
                    'format'=>'raw',
                    'value'=>function($data){
                      $tags = Tagging::find()->where(['analysis_id'=>$data->package_id])->one();
                      if(!$tags)
                        return "<b style='color:red'>Pending</b>";
                      if($tags->tagging_status_id==2)
                        return "<b style='color:green'>Completed</b>";
                      else
                        return "<b style='color:#939337'>On-going</b>";
                    }
                  ],
                  [
                    'header'=>'Due Date',
                    'attribute'=>'description'
                  ],
              ],
          ]); ?>
        </div>
      </div>
      </div>
    </div>

       <div class="box box-primary color-palette-box" style="padding:0px">
        <div class="box-header" style="background-color: #fffff;color:#000" data-widget="collapse">
          <h3 class="box-title" data-widget="collapse"><i class="fa fa-tag"></i></h3>
          <div class="box-tools pull-right" >
                <button type="button" style="color:#000" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
        </div>      
        <div class="box-body">
          <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-12">
              
               <div  style="padding-top: 1px;padding-bottom: 1px;display:block;text-align: center">
                  <a href="/lab/request" title="Request"><img class="imgHover" src="/images/requestsquare.png" style="height:120px;width: 120px" ></a>
              </div>
            </div>
            <!-- /.col -->
            <div class="col-md-3 col-sm-6 col-xs-12">
            
             <div  style="padding-top: 1px;padding-bottom: 1px;display:block;text-align: center">
                 <a href="/lab/sample" title="Sample"><img class="imgHover" src="/images/samplesquare.png" style="height:120px;width: 120px"></a>
              </div>
            </div>
            <!-- /.col -->
            <div class="col-md-3 col-sm-6 col-xs-12">
              

               <div  style="padding-top: 1px;padding-bottom: 1px;display:block;text-align: center">
                   <a href="/lab/tagging" title="Tagging"><img class="imgHover" src="/images/taggingsquare.png" style="height:120px;width: 120px"></a>
              </div>
            </div>
            
            <div class="col-md-3 col-sm-6 col-xs-12">
           
               <div  style="padding-top: 1px;padding-bottom: 1px;display:block;text-align: center">
                 <a href="/lab/testname" title="Testname"><img class="imgHover" src="/images/testnamesquare.png" style="height:120px;width: 120px"></a>
              </div>
            </div>
            
            <!-- /.col -->
            
            <!-- /.col -->  
          </div>
        </div>
        <!-- /.box-body -->
        </div>
        
        
        <div class="box box-primary color-palette-box" style="padding:0px">
        <div class="box-header with-border" style="background-color: #fffff;color:#000" data-widget="collapse">
          <h3 class="box-title" data-widget="collapse"><i class="fa fa-tag"></i></h3>
          <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" style="color:#000" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
        </div>      
        <div class="box-body">
          <div class="row">
               <div class="col-md-2 col-sm-6 col-xs-12 col-md-offset-1">
             
               <div  style="padding-top: 1px;padding-bottom: 1px;display:block;text-align: center">
                  <a href="/lab/sampletype" title="Sampletype"><img class="imgHover" src="/images/sampletypessquare.png" style="height:120px;width: 120px" ></a>
              </div>
            </div>
            <div class="col-md-2 col-sm-6 col-xs-12 ">
               <!-- col-md-offset-1  if 5 columns --> 
             <div  style="padding-top: 1px;padding-bottom: 1px;display:block;text-align: center">
                 <a href="/lab/labsampletype" title="Lab Sampletype"><img class="imgHover" src="/images/labsampletypesquare.png" style="height:120px;width: 120px"></a>
              </div>
            </div> 
            
            <!-- /.col -->
          
            <!-- /.col -->
            <div class="col-md-2 col-sm-6 col-xs-12">
             
               <div  style="padding-top: 1px;padding-bottom: 1px;display:block;text-align: center">
                   <a href="/lab/sampletypetestname" title="Sampletype Testname"><img class="imgHover" src="/images/sampletypetestnamesquare.png" style="height:120px;width: 120px"></a>
              </div>
            </div>
            
            <div class="col-md-2 col-sm-6 col-xs-12">
             
               <div  style="padding-top: 1px;padding-bottom: 1px;display:block;text-align: center">
                   <a href="/lab/testnamemethod" title="Testname Method"><img class="imgHover" src="/images/testnamemethodsquare.png" style="height:120px;width: 120px"></a>
              </div>
            </div>
            
            <div class="col-md-2 col-sm-6 col-xs-12">
             

               <div  style="padding-top: 1px;padding-bottom: 1px;display:block;text-align: center">
                 <a href="/lab/methodreference" title="Method Reference"><img class="imgHover" src="/images/methodreferencesquare.png" style="height:120px;width: 120px"></a>
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
