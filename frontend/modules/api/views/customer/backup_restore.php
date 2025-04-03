<?php

use yii\helpers\Html;
/*
 * Project Name: eulims_ * 
 * Copyright(C)2018 Department of Science & Technology -IX *  
 * 09 7, 18 , 4:36:23 PM * 
 * Module: backup_restore * 
 */
?>
<script type="text/javascript">
    function myFunction() {
    var x = document.getElementById("myDIV");
    if (x.style.display === "none") {
        x.style.display = "block";
    } else {
        x.style.display = "none";
    }
} 
    </script>
<div class="system-default-index">
    
    
    <div class="row">

        <div class="col-md-6">
            <div class="col-md-10">
                <div class="box box-primary" style="padding:0px">
                    <div class="box-header" style="background-color: #3c8dbc;color:#fff;">
                        <h4 class="box-title"><img src="/images/icons/customer.png" style="width:25px"></i>Customers</h4>
                        <div class="box-tools pull-right">
                            <button type="button" style="color:#000" class="btn btn-box-tool" title="Sync Results" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-bars"></i>
                            </button>
                        </div>
                    </div>      
                    <div class="box-body">
                        
                        <div class="row" style="margin-top:10px">
                            <?php echo "&nbsp&nbsp&nbsp&nbsp".Html::button('<i class="fa fa-refresh"></i> Restore', [ 'onclick'=>"window.location.href = '" . \Yii::$app->urlManager->createUrl(['/api/customer/restore']) . "';" ,'title'=>'Sync',  'class' => 'btn btn-primary']); ?>
                            <!-- <div class="col-md-3"><button class="btn btn-primary"><i class="fa fa-download"></i> Local Sync</button></div>
                            <div class="col-md-9"><button class="btn btn-primary"><i class="fa fa-refresh"></i> Online Sync</button></div> -->
                        </div>

                        <div class="box" style="margin-top: 5px">
                            <div class="box-header">
                                <h3 class="box-title">Recent Activity</h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body no-padding">
                                <table class="table table-condensed">
                                    <tbody><tr>
                                            <th style="width: 10px">#</th>
                                            <th>Task</th>
                                            <th>Date</th>
                                           
                                        </tr>
                                        <tr>
                                            <td>1.</td>
                                            <td>Backup Module</td>
                                            <td>
                                                <div class="progress progress-xs">
                                                    <div class="progress-bar progress-bar-danger" style="width: 55%"></div>
                                                </div>
                                            </td>
                                          
                                        </tr>
                                        <tr>
                                            <td>2.</td>
                                            <td>Restore Module</td>
                                            <td>
                                                <div class="progress progress-xs">
                                                    <div class="progress-bar progress-bar-yellow" style="width: 70%"></div>
                                                </div>
                                            </td>
                                            
                                        </tr>
                                        <tr>
                                            <td>3.</td>
                                            <td>Backup Module</td>
                                            <td>
                                                <div class="progress progress-xs progress-striped active">
                                                    <div class="progress-bar progress-bar-primary" style="width: 30%"></div>
                                                </div>
                                            </td>
                                            
                                        </tr>
                                        <tr>
                                            <td>4.</td>
                                            <td>Backup Module</td>
                                            <td>
                                                <div class="progress progress-xs progress-striped active">
                                                    <div class="progress-bar progress-bar-success" style="width: 90%"></div>
                                                </div>
                                            </td>
                                           
                                        </tr>
                                    </tbody></table>
                            </div>
                            <!-- /.box-body -->
                        </div>

                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            
        </div>
    </div>

    <div class="row">
        <div class="row">
            <!-- <div class="col-md-6">column 1</div>
            <div class="col-md-6">columns 2</div> -->
        </div>
    </div>
</div>

<div id="myDIV" style="display:none; margin: 0 auto;
    text-align: left;
    width: 800px;">
  
</div>
    
    
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
       <h4 class="box-title">Sync Results</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="box" style="margin-top: 5px">
                            <div class="box-header">
                                <h3 class="box-title">Module - Type of Sync</h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body no-padding">
                                <table class="table table-condensed">
                                    <tbody><tr>
                                            <th style="width: 10px">#</th>
                                            <th>Task</th>
                                            <th>Date</th>
                                           
                                        </tr>
                                        <tr>
                                            <td>1.</td>
                                            <td>Backup Module</td>
                                            <td>
                                                <div class="progress progress-xs">
                                                    <div class="progress-bar progress-bar-danger" style="width: 55%"></div>
                                                </div>
                                            </td>
                                          
                                        </tr>
                                        <tr>
                                            <td>2.</td>
                                            <td>Restore Module</td>
                                            <td>
                                                <div class="progress progress-xs">
                                                    <div class="progress-bar progress-bar-yellow" style="width: 70%"></div>
                                                </div>
                                            </td>
                                            
                                        </tr>
                                        <tr>
                                            <td>3.</td>
                                            <td>Backup Module</td>
                                            <td>
                                                <div class="progress progress-xs progress-striped active">
                                                    <div class="progress-bar progress-bar-primary" style="width: 30%"></div>
                                                </div>
                                            </td>
                                            
                                        </tr>
                                        <tr>
                                            <td>4.</td>
                                            <td>Backup Module</td>
                                            <td>
                                                <div class="progress progress-xs progress-striped active">
                                                    <div class="progress-bar progress-bar-success" style="width: 90%"></div>
                                                </div>
                                            </td>
                                           
                                        </tr>
                                    </tbody></table>
                            </div>
                            <!-- /.box-body -->
                        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
       
      </div>
    </div>
  </div>
</div>
