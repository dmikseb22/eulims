<?php
use common\models\help\Topics;
/* @var $this yii\web\View */

$this->title = 'FAQs';
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
        <div class="box-header" style="background-color: #fff;color:#000" data-widget="collapse">
          <h3 class="box-title" data-widget="collapse"><i class="fa fa-tag"></i>FAQs</h3>
          <div class="box-tools pull-right" >
                <button type="button" style="color:#000" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                0p</button>              </div>
        </div>      
        <div class="box-body">
          <div class="row" style="padding:20px">
              <?php 
              $list = Topics::find()->all();
              foreach ($list as $i => $lists) {
                  ?>
                  
                  <?php echo $lists->topic_id ?>. <a href="/help/faqs/topics?id=<?php echo $lists->topic_id ?>"><?php echo $lists->details ?></a>
                  <br>
                  <?php
              }
              ?>
            
          </div>
        </div>
        <!-- /.box-body -->
        </div>
        
       
        
      
      
        
    </div>
</div>
