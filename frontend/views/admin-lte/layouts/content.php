<?php
use yii\widgets\Breadcrumbs;
use yii\bootstrap\Modal;
use kartik\dialog\Dialog;
use yii2mod\alert\Alert;

$StartYear=2014;
$CurYear=date('Y');
if($StartYear>=$CurYear){
    $CopyrightYear=$StartYear;
}else{
    $CopyrightYear=$StartYear.'-'.$CurYear;
}
$Host= "//".Yii::$app->getRequest()->serverName;
//echo $Host;
//echo Dialog::widget();
?>
<div class="content-image-loader" style="display: none;"><img src='/images/img-png-loader90.png' alt=''></div>
<div class="content-wrapper">
    <?php
    Modal::begin([
        'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
        'bodyOptions'=>[
            'class' => 'modal-body',
            'style'=>'padding-bottom: 20px',
        ],
        'options' => [
            'id' => 'modal',
            'tabindex' => false, // important for Select2 to work properly
        ],
        'header' => '<h4 class="fa fa-clone" style="padding-top: 0px;margin-top: 0px;padding-bottom:0px;margin-bottom: 0px"> <span class="modal-title" style="font-size: 16px;font-family: \'Source Sans Pro\',sans-serif;"></span></h4>'
    ]);
    echo "<div>";
    echo "<div id='modalContent' style='margin-left: 5px;'><div style='text-align:center;'><img src='/images/img-loader64.gif' alt=''></div></div>";
    echo "<div>&nbsp;</div>";
    echo "</div>";
    Modal::end();

    Modal::begin([
        'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
        'bodyOptions'=>[
            'class' => 'modal-body',
            //'style'=>'padding-bottom: 20px',
            'style'=>'padding: 0',
        ],
        'options' => [
            'id' => 'modalNotification',
            'tabindex' => false, // important for Select2 to work properly
        ],
        'header' => '<h4 style="padding-top: 0px;margin-top: 0px;padding-bottom:0px;margin-bottom: 0px"><span class="glyphicon glyphicon-bell" style="margin-right:7px;"></span><span class="modal-title" style="font-size: 16px;font-family: \'Source Sans Pro\',sans-serif;"></span></h4>'
    ]);
    echo "<div id='modalBody' style='margin: 0;'><div style='text-align:center;padding:20px;'><img src='/images/img-loader64.gif' alt=''></div></div>";
    Modal::end();
	
	Modal::begin([
        'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
        'bodyOptions'=>[
            'class' => 'modal-body',
            //'style'=>'padding-bottom: 20px',
            'style'=>'padding: 0',
        ],
        'options' => [
            'id' => 'modalBidNotification',
            'tabindex' => false, // important for Select2 to work properly
        ],
        'header' => '<h4 style="padding-top: 0px;margin-top: 0px;padding-bottom:0px;margin-bottom: 0px"><span class="glyphicon glyphicon-bell" style="margin-right:7px;"></span><span class="modal-title" style="font-size: 16px;font-family: \'Source Sans Pro\',sans-serif;"></span></h4>'
    ]);
    echo "<div id='modalBody' style='margin: 0;'><div style='text-align:center;padding:20px;'><img src='/images/img-loader64.gif' alt=''></div></div>";
    Modal::end();
    
    echo Breadcrumbs::widget([
      'itemTemplate' => "<li><i>{link}</i></li>\n", // template for all links
      'tag'=>'ol', //<li class="active"><span>Data</span></li>
      'activeItemTemplate'=>'<li class="active"><span>{link}</span></li>',
      'options'=>['class'=>'breadcrumb breadcrumb-arrow'],
      'homeLink' => [ 
                'label' => '<i class="glyphicon glyphicon-home"></i>',
                'encode' => false,
                'url' => Yii::$app->homeUrl,
            ],
      'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]);
    ?>
    <section class="content">
        <div id="eulims_progress" class="system-progress progress-stop" style="position: absolute;z-index: 20000;width: 100%;height: 100%;"></div>
        <?= Alert::widget() ?>
        <?= $content ?>
    </section>
</div>

<footer class="main-footer">
    <div class="pull-right hidden-xs">
        ULIMS <b>Version</b> 2.0 <b>Patched as of </b> May 17, 2021
    </div>
    <strong>Copyright &copy; <?= $CopyrightYear ?> <a href="//region9.dost.gov.ph" target="_blank">DOST-IX</a>.</strong> All rights
    reserved.</strong>
</footer>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
        <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
        <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
        <!-- Home tab content -->
        <div class="tab-pane" id="control-sidebar-home-tab">
    
                <!-- /.form-group -->

                <div class="form-group">
                    <!-- <label class="control-sidebar-subheading">
                        Turn off notifications
                        <input type="checkbox" class="pull-right"/>
                    </label> -->
                </div>
                <!-- /.form-group -->

                <div class="form-group">
                    <!-- <label class="control-sidebar-subheading">
                        Delete chat history
                        <a href="javascript::;" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
                    </label> -->
                </div>
                <!-- /.form-group -->
            </form>
        </div>
        <!-- /.tab-pane -->
    </div>
</aside><!-- /.control-sidebar -->
<!-- Add the sidebar's background. This div must be placed
     immediately after the control sidebar -->
<div class='control-sidebar-bg'></div>
<script type="text/javascript">
$(document).ready(function () {
    //fix bug for select2 mozilla firefox
    $.fn.modal.Constructor.prototype.enforceFocus = function () {};
    $.fn.modal.Constructor.prototype._enforceFocus = function() {};
});
</script>
<style type="text/css">
/* Absolute Center Spinner */
.content-img-loader {
    position: fixed;
    z-index: 999;
    /*height: 2em;
    width: 2em;*/
    height: 90px;
    width: 90px;
    overflow: show;
    margin: auto;
    top: 0;
    left: 0;
    bottom: 0;
    right: 0;
    background-image: url('/images/img-png-loader90.png');
    background-repeat: no-repeat;
}
/* Transparent Overlay */
.content-img-loader:before {
    content: '';
    display: block;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.3);
}
</style>
