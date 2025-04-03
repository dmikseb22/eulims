<?php

use yii\widgets\Pjax;
use yii\helpers\Html;
use yii\bootstrap\Tabs;

/* @var $this yii\web\View */

$this->title = 'Admin EULIMS';
?>
<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<link href="/css/site.css" rel="stylesheet">

<div class="site-index">
    <?php
    $JS = <<<SCRIPT
     $("#tab_1").load('/admin/user');        
SCRIPT;
    $this->registerJs($JS);
    ?>
     <div class="body-content">
        <div class="box box-default color-palette-box" style="padding:0px">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-tag"></i> System Settings</h3>
          <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
        </div>      
        <div class="box-body">
          <div class="row">
            <div class="col-sm-4 col-md-2">
              <h4 class="text-center">System Maintenance</h4>
               <div  style="padding-top: 1px;padding-bottom: 1px;display:block;text-align: center">
                  <a href="/settings" title="System Maintenance"><img src="/images/system.png" style="height:40%;width: 40%" ></a>
              </div>
            </div>
            <!-- /.col -->
            <div class="col-sm-4 col-md-2">
              <h4 class="text-center">Gii</h4>

             <div  style="padding-top: 1px;padding-bottom: 1px;display:block;text-align: center">
                 <a href="/gii" title="Yii Code Generator"><img src="/images/yii2.png" style="height:35%;width: 35%"></a>
              </div>
            </div>
            <!-- /.col -->
            <div class="col-sm-4 col-md-2">
              <h4 class="text-center">Debug</h4>

               <div  style="padding-top: 1px;padding-bottom: 1px;display:block;text-align: center">
                   <a href="/debug" title="Debug"><img src="/images/system.png" style="height:40%;width: 40%"></a>
              </div>
            </div>
            
            <div class="col-sm-4 col-md-2">
              <h4 class="text-center">Module Manager</h4>

               <div  style="padding-top: 1px;padding-bottom: 1px;display:block;text-align: center">
                 <a href="/module/manager" title="Module Manager"><img src="/images/package.png" style="height:35%;width: 35%"></a>
              </div>
            </div>
            <div class="col-sm-4 col-md-2">
              <h4 class="text-center">Module List</h4>

               <div  style="padding-top: 1px;padding-bottom: 1px;display:block;text-align: center">
                 <a href="/module" title="Module List"><img src="/images/list.png" style="height:30%;width: 30%"></a>
              </div>
            </div>
            <!-- /.col -->
            <div class="col-sm-4 col-md-2">
              <h4 class="text-center">Package Details</h4>

               <div  style="padding-top: 1px;padding-bottom: 1px;display:block;text-align: center">
                 <a href="/module/details" title="Module Details"><img src="/images/details.png" style="height:30%;width: 30%"></a>
              </div>
            </div>
            <!-- /.col -->  
          </div>
        </div>
        <!-- /.box-body -->
      </div>
        <div class="box box-default color-palette-box">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-tag"></i> Role Based Access Control (RBAC) Settings</h3>
          <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-sm-4 col-md-2">
              <h4 class="text-center">Users</h4>
              <div  style="padding-top: 1px;padding-bottom: 5px;display:block;text-align: center">
                 <a href="/admin/user" title="Debug"><img src="/images/users.png" style="height:30%;width: 30%"></a>
              </div>
            </div>
            <!-- /.col -->
            <div class="col-sm-4 col-md-2">
              <h4 class="text-center">Assignment</h4>

             <div  style="padding-top: 1px;padding-bottom: 1px;display:block;text-align: center">
                <a href="/admin" title="Debug"> <img src="/images/assignment.png" style="height:25%;width: 25%"></a>
              </div>
            </div>
            <!-- /.col -->
            <div class="col-sm-4 col-md-2">
              <h4 class="text-center">Route</h4>
              <div  style="padding-top: 1px;padding-bottom: 1px;display:block;text-align: center">
                <a onclick="ShowModal('Route','/admin/route')" href="#" title="Route"> <img src="/images/route.png" style="height:30%;width: 30%"></a>
              </div>
            </div>
            <!-- /.col -->
            <div class="col-sm-4 col-md-2">
              <h4 class="text-center">Roles</h4>

              <div  style="padding-top: 1px;padding-bottom: 5px;display:block;text-align: center">
                <a onclick="ShowModal('Roles','/admin/role')" href="#" title="Roles"> <img src="/images/roles.png" style="height:40%;width: 40%"></a>
              </div>
            </div>
            <!-- /.col -->
            <div class="col-sm-4 col-md-2">
              <h4 class="text-center">Permissions</h4>

               <div  style="padding-top: 1px;padding-bottom: 1px;display:block;text-align: center">
                 <a href="/admin/permission" title="Debug"><img src="/images/permission.png" style="height:30%;width: 30%"></a>
              </div>
            </div>
            <div class="col-sm-4 col-md-2">
              <h4 class="text-center">Menus</h4>
             <div  style="padding-top: 1px;padding-bottom: 1px;display:block;text-align: center">
                 <a href="/admin/menu" title="Debug"> <img src="/images/menus.png" style="height:30%;width: 30%"></a>
              </div>
            </div>
          </div>
          <!-- /.row -->
          <div class="row">
            
            <!-- /.col -->
            <div class="col-sm-4 col-md-2">
              <h4 class="text-center">Rules</h4>
              <div  style="padding-top: 1px;padding-bottom: 20px;display:block;text-align: center">
                 <a href="/admin/rule" title="Debug"> <img src="/images/rules.png" style="height:30%;width: 30%"></a>
              </div>
            </div>
            <div class="col-sm-4 col-md-2">
              <h4 class="text-center">System Maintenance</h4>

              <div  style="padding-top: 1px;padding-bottom: 20px;display:block;text-align: center">
                 <a href="#" onclick="LoadModal('System Maintenance','/settings')" title="Debug"> <img src="/images/rules.png" style="height:30%;width: 30%"></a>
                 
              </div>
            </div>
            <!-- /.col -->
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
        <!-- /.box-body -->
      </div>
    </div>
</div>

<div id="theModal" class="modal fade text-center">
    <div class="modal-dialog">
      <div class="modal-content">
         
      </div>
    </div>
</div>
<div class="modal fade in" id="ModalNew" style="padding-right: 16px;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Default Modal</h4>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
