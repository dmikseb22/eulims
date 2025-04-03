<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\grid\ActionColumn;
use \yii\helpers\ArrayHelper;
use common\components\Functions;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use common\components\ReferralComponent;
use kartik\grid\DataColumn;
use yii\widgets\ActiveForm;
use kartik\widgets\DepDrop;
use kartik\widgets\Select2;
use kartik\dialog\Dialog;
use kartik\widgets\Growl;

/* @var $this yii\web\View */
/* @var $searchModel common\models\referral\ServiceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Referral Service';
$this->params['breadcrumbs'][] = ['label' => 'Referrals', 'url' => ['/referrals']];
$this->params['breadcrumbs'][] = $this->title;
$func=new Functions();
$refcomp = new ReferralComponent();
?>
<div class="service-index">
    <div class="service-image-loader" style="display: hidden;"></div>
    <!--<div style="background-color: #aed6f1 ;border: 2px solid  #5dade2 ;" class="alert">
        <span style="color:#000000;">
            <strong>Note : </strong> Offer / Unoffer test for your agency. If test/calibration is not found in the list, please contact the administrator to add your test/calibration.
        </span>
    </div>-->
        <div class="row">
            <?php
                $form = ActiveForm::begin([
                    'id' => 'service-form',
                    'options' => [
                        'class' => 'form-horizontal',
                        //'data-pjax' => true,
                    ],
                    'method' => 'post',
                    'action' => '/referrals/service/offer',
                ])
            ?>
            <div class="col-sm-4">
            <?php
                echo '<label class="control-label">Laboratory </label>';
                echo Select2::widget([
                    'name' => 'service-lab_id',
                    'data' => $laboratory,
                    'theme' => Select2::THEME_KRAJEE,
                    'options' => ['id' => 'service-lab_id'],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'placeholder' => 'Select Laboratory',
                    ],
                ]);
            ?>
            </div>
            <div class="col-sm-4">
            <?php
                echo '<label class="control-label">Sample Type </label>';
                echo DepDrop::widget([
                    'type'=>DepDrop::TYPE_SELECT2,
                    'name' => 'service-sampletype_id',
                    'data' => $sampletype,
                    'options' => ['id'=>'service-sampletype_id'],
                    'select2Options' => ['pluginOptions' => ['allowClear' => true]],
                    'pluginOptions' => [
                        'depends'=>['service-lab_id'],
                        'placeholder' => 'Select Sample Type',
                        'url'=>Url::to(['list_sampletype']),
                        'loadingText' => 'Loading Sample type...',
                        //"depdrop:change"=>"function() { alert('HKJHK'); }",
                    ],
                ]);
            ?>
            </div>
            <div class="col-sm-4">
            <?php
                echo '<label class="control-label">Test Name </label>';
                echo DepDrop::widget([
                    'type'=>DepDrop::TYPE_SELECT2,
                    'name' => 'service-testname_id',
                    'data' => $testname,
                    'options' => ['id'=>'service-testname_id'],
                    'select2Options' => ['pluginOptions' => ['allowClear' => true]],
                    'pluginOptions' => [
                        'placeholder' => 'Select Test Name',
                        'depends'=>['service-lab_id','service-sampletype_id'],
                        'url'=>Url::to(['list_testname']),
                        'loadingText' => 'Loading Test name...',
                        /*"change" => "function() {
                            //var testId = this.value;
                            $.ajax({
                                url: '".Url::toRoute("gettestnamemethod")."',
                                //dataType: 'json',
                                method: 'GET',
                                //data: {service-testname_id:testId},
                                data: $(this).serialize(),
                                success: function (data, textStatus, jqXHR) {
                                    //$('.image-loader').removeClass( \"img-loader\" );
                                    $('#methodreference').html(data);
                                },
                                beforeSend: function (xhr) {
                                    //alert('Please wait...');
                                    //$('.image-loader').addClass( \"img-loader\" );
                                },
                                error: function (jqXHR, textStatus, errorThrown) {
                                    alertWarning.alert(\"<p class='text-danger' style='font-weight:bold;'>Error Encountered!</p>\");
                                }
                            });
                        }",*/
                    ],
                ]);
            ?>
            </div>
        </div>
        <br>
        <!--<div class="container">-->
            <!--<div class="table-responsive">-->
        <div class="row">
            <div class="col-lg-12">
            <?php
                /*echo GridView::widget([
                    'id' => 'service-grid',
                    'dataProvider'=> $dataProvider,
                    'pjax'=>true,
                    'pjaxSettings' => [
                        'options' => [
                            'enablePushState' => false,
                        ]
                    ],
                    'responsive'=>true,
                    'striped'=>true,
                    'hover'=>true,
                    'panel' => [
                        'heading'=>'<h3 class="panel-title">Offer / Unoffer Services</h3>',
                        'type'=>'primary',
                        'before'=>'
                        <span style="color:#000000;">
                            <strong>Note : </strong> Offer / Unoffer test for your agency. If test/calibration is not found in the list, please contact the administrator to add your test/calibration.
                        </span>',
                        'after'=>'',
                    ],
                    'columns' => [
                        'service_id',
                        'agency_id',
                        'method_ref_id',
                        'offered_date',
                    ],
                    'toolbar' => '',
                ]);*/
            ?>
            <div id="methodreference">
                <?php
                    echo $this->render('_methodreference', [ 'methodrefDataProvider' => $methodrefDataProvider,'count_methods'=>$count_methods]);
                ?>
            </div>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
<?php
// Warning alert for no selected sample or method
echo Dialog::widget([
    'libName' => 'alertWarning', // a custom lib name
    'overrideYiiConfirm' => false,
    'options' => [  // customized BootstrapDialog options
        'size' => Dialog::SIZE_SMALL, // large dialog text
        'type' => Dialog::TYPE_DANGER, // bootstrap contextual color
        'title' => "<i class='glyphicon glyphicon-alert' style='font-size:20px'></i> Warning",
        'buttonLabel' => 'Close',
    ]
]);

echo Growl::widget([
    'type' => Growl::TYPE_SUCCESS,
    'title' => '',
    'icon' => '',
    'body' => 'Finished Loading.',
    'showSeparator' => true,
    'delay' => 1000,
    'pluginOptions' => [
        'placement' => [
            'from' => 'top',
            'align' => 'center',
        ]
    ]
]);

?>
<script type="text/javascript">
    $('#service-lab_id').on('change', function(event,textStatus, jqXHR) {
        $("#service-sampletype_id").val('').trigger('change');
    });
    $('#service-sampletype_id').on('change', function(event,textStatus, jqXHR) {
        $("#service-testname_id").val('').trigger('change');
    });
    $('#service-testname_id').on('change',function(event){
    //$('#service-form').on('change',function(event){
        var lab = $('#service-lab_id').val();
        var sampletype = $('#service-sampletype_id').val();
        var testname = $('#service-testname_id').val();
        $.ajax({
            url : '/referrals/service/gettestnamemethod',
            method: 'GET',
            //data: $('form').serialize(),
            data: {lab_id:lab,sampletype_id:sampletype,testname_id:testname},
            success: function (data){
                $('.service-image-loader').removeClass("img-loader");
                $('#methodreference').html(data);
            },
            beforeSend: function (xhr) {
                //alert('Please wait...');
                $('.service-image-loader').addClass("img-loader");
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alertWarning.alert("<p class='text-danger' style='font-weight:bold;'>Error Encountered!</p>");
            }
        });
    });

function offerService(){
    //$('#btn-offer').on('click',function(e){
        //e.preventDefault();
        var methodrefs = $('#method-reference-grid').yiiGridView('getSelectedRows');
        //var selected = $("input[name='methodref_id']").val();
        
        if(methodrefs.length < 1) {
            alertWarning.alert("<p class='text-danger' style='font-weight:bold;'>No method selected!</p>");
            return false;
        }
        /*else if ($('input[type=radio][name=methodref_id]', '#method-reference-grid').length < 1) {
            alertWarning.alert("<p class='text-danger' style='font-weight:bold;'>No Method selected!</p>");
            return false;
        }
        else if(!$("input[name='methodref_id']").is(':checked') || radioMethod == '') {
            alertWarning.alert("<p class='text-danger' style='font-weight:bold;'>No Method selected!</p>");
            return false;
        }*/
        else {
            //var url = '/referrals/service/offer';
            //$('.modal-title').html('Offer Service');
            //$('#modal').modal('show')
            //    .find('#modalContent')
            //    .load(url);
            //$('.image-loader').addClass('img-loader');
            //$('.service-index form').submit();
            //$('.image-loader').removeClass('img-loader');
            //alert('GG');
            var method_ids = [];
            $.each($("input[name='methodref_ids[]']:checked"), function(){
                method_ids.push($(this).val());
            });

            var method_ids_string = JSON.stringify(method_ids);
            var lab = $('#service-lab_id').val();
            var sampletype = $('#service-sampletype_id').val();
            var testname = $('#service-testname_id').val();

            $.ajax({
                url : '/referrals/service/offer',
                method: 'POST',
               // data: $('.service-index form').serialize(),
                data: {methodref_ids:method_ids_string,lab_id:lab,sampletype_id:sampletype,testname_id:testname},
                //data: $('#method-reference-grid').serialize(),
                //data: {lab_id:lab,sampletype_id:sampletype,testname_id:testname},
                success: function (data){
                    //$('#methodreference').html(data);
                    //$('.service-index form').submit();
                    if(data == 1){
                        $.notify({
                            // options
                            icon: 'glyphicon glyphicon-ok',
                            message: 'Successfully offered service(s).'
                        },{
                            // settings
                            type: 'success',
                            delay: 1000,
                            timer: 2000,
                            placement: {
                                from: "top",
                                align: "center"
                            },
                            offset: {
                                x: 200,
                                y: 230
                            }
                        });
                    } else if(data == 2) {
                        $.notify({
                            // options
                            icon: 'glyphicon glyphicon-ban-circle',
                            message: 'Please offer methods that are not yet offered.'
                        },{
                            // settings
                            type: 'error',
                            delay: 1000,
                            timer: 2000,
                            placement: {
                                from: "top",
                                align: "center"
                            },
                            offset: {
                                x: 200,
                                y: 230
                            }
                        });
                    } else {
                        $.notify({
                            // options
                            icon: 'glyphicon glyphicon-alert',
                            message: 'Failed to offer service(s).'
                        },{
                            // settings
                            type: 'error',
                            delay: 1000,
                            timer: 2000,
                            placement: {
                                from: "top",
                                align: "center"
                            },
                            offset: {
                                x: 200,
                                y: 230
                            }
                        });
                    }
                    //$.pjax.reload({container:"#method-reference-grid-pjax",url: '/referrals/service?lab_id='+lab+'&methodref_ids='+method_ids_string+'&sampletype_id='+sampletype+'&testname_id='+testname,replace:false,timeout: false});
                    $.pjax.reload({container: "#method-reference-grid", url: '/referrals/service/gettestnamemethod?lab_id='+lab+'&methodref_ids='+method_ids_string+'&sampletype_id='+sampletype+'&testname_id='+testname,replace:false,timeout: false});
                   // $('#method-reference-grid-pjax').load('/referrals/service/gettestnamemethod?lab_id='+lab+'&methodref_ids='+method_ids_string+'&sampletype_id='+sampletype+'&testname_id='+testname);
                    $("#btn-remove").on('click',removeService);
                    $("#btn-offer").on('click',offerService);
                    $('.service-image-loader').removeClass("img-loader");
                },
                beforeSend: function (xhr) {
                    $("input[name='methodref_ids_all']:checked").val('');
                    $('input:checkbox[name=methodref_ids_all]').attr('checked',false);
                    $('input:checkbox[name=methodref_ids_all]').prop("checked", false);
                    $("input:checkbox[name='methodref_ids[]']").prop("checked", false);
                    $("input:checkbox[name='methodref_ids[]']").attr('checked',false);
                    $("#btn-remove").prop("onclick", null).off("click");
                    $("#btn-offer").prop("onclick", null).off("click");
                    $('.service-image-loader').addClass("img-loader");
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alertWarning.alert("<p class='text-danger' style='font-weight:bold;'>Error Encountered!</p>");
                }
            });
        }
    //});
}

function removeService(){
    var methodrefs = $('#method-reference-grid').yiiGridView('getSelectedRows');
    if(methodrefs.length < 1) {
        alertWarning.alert("<p class='text-danger' style='font-weight:bold;'>No method selected!</p>");
        return false;
    }
    else {
        var method_ids = [];
        $.each($("input[name='methodref_ids[]']:checked"), function(){
            method_ids.push($(this).val());
        });
        
        var method_ids_string = JSON.stringify(method_ids);
        var lab = $('#service-lab_id').val();
        var sampletype = $('#service-sampletype_id').val();
        var testname = $('#service-testname_id').val();

        BootstrapDialog.show({
            title: "<span class='glyphicon glyphicon-alert'></span>&nbsp;&nbsp;WARNING",
            message: "<div class='alert alert-danger' style='border:2px #ff3300 dotted;margin:auto;font-size:13px;text-align:justify;text-justify:inter-word;'>"
                +"<p style='font-weight:bold;font-size:13px;'><span class='glyphicon glyphicon-alert' style='font-size:17px;'></span>&nbsp;&nbsp;All checked methods that you did not offer will not be removed as service.</p>"
                +"</div>"
                +"<p class='note' style='margin:15px 0 0 15px;font-weight:bold;color:#0d47a1;font-size:14px;'>Do you wish to continue?</p>",
            buttons: [
                {
                    label: 'Yes',
                    // no title as it is optional
                    cssClass: 'btn-primary',
                    action: function(thisDialog){
                        thisDialog.close();
                        $.ajax({
                            url : '/referrals/service/remove',
                            method: 'POST',
                            data: {methodref_ids:method_ids_string,lab_id:lab,sampletype_id:sampletype,testname_id:testname},
                            success: function (data){
                                $('.service-image-loader').removeClass("img-loader");
                                if(data == 1){
                                        $.notify({
                                            // options
                                            icon: 'glyphicon glyphicon-ok',
                                            message: 'Successfully removed service(s).'
                                        },{
                                            // settings
                                            type: 'success',
                                            delay: 1000,
                                            timer: 2000,
                                            placement: {
                                                from: "top",
                                                align: "center"
                                            },
                                            offset: {
                                                x: 200,
                                                y: 230
                                            }
                                        });
                                    } else {
                                        $.notify({
                                            // options
                                            icon: 'glyphicon glyphicon-alert',
                                            message: 'Failed to remove service(s). Selected method may not be offered as service yet.'
                                        },{
                                            // settings
                                            type: 'error',
                                            delay: 1000,
                                            timer: 2000,
                                            placement: {
                                                from: "top",
                                                align: "center"
                                            },
                                            offset: {
                                                x: 200,
                                                y: 230
                                            }
                                        });
                                    }
                                //$.pjax.reload({container:"#method-reference-grid-pjax",url: '/referrals/service?lab_id='+lab+'&methodref_ids='+method_ids_string+'&sampletype_id='+sampletype+'&testname_id='+testname,replace:false,timeout: false});
                                //$("#method-reference-grid").yiiGridView("applyFilter");
                                $.pjax.reload({container: "#method-reference-grid", url: '/referrals/service/gettestnamemethod?lab_id='+lab+'&methodref_ids='+method_ids_string+'&sampletype_id='+sampletype+'&testname_id='+testname,replace:false,timeout:false});
                                //$('#method-reference-grid-pjax').load('/referrals/service/gettestnamemethod?lab_id='+lab+'&methodref_ids='+method_ids_string+'&sampletype_id='+sampletype+'&testname_id='+testname);
                                $("#btn-remove").on('click',removeService);
                                $("#btn-offer").on('click',offerService);
                            },
                            beforeSend: function (xhr) {
                                $("input[name='methodref_ids_all']:checked").val('');
                                $('input:checkbox[name=methodref_ids_all]').attr('checked',false);
                                $('input:checkbox[name=methodref_ids_all]').prop("checked", false);
                                $("input:checkbox[name='methodref_ids[]']").prop("checked", false);
                                $("input:checkbox[name='methodref_ids[]']").attr('checked',false);
                                $("#btn-remove").prop("onclick", null).off("click");
                                $("#btn-offer").prop("onclick", null).off("click");
                                $('.service-image-loader').addClass("img-loader");
                            },
                            error: function (jqXHR, textStatus, errorThrown) {
                                alertWarning.alert("<p class='text-danger' style='font-weight:bold;'>Error Encountered!</p>");
                            }
                        });
                    }
                }, 
                {
                    label: 'No',
                    action: function(thisDialog){
                        thisDialog.close();
                    }
                }
            ]
        });
    }
}
</script>

<style type="text/css">
/* Absolute Center Spinner */
.img-loader {
    position: fixed;
    z-index: 999;
    /*height: 2em;
    width: 2em;*/
    height: 64px;
    width: 64px;
    overflow: show;
    margin: auto;
    top: 0;
    left: 0;
    bottom: 0;
    right: 0;
    background-image: url('/images/img-png-loader64.png');
    background-repeat: no-repeat;
}
/* Transparent Overlay */
.img-loader:before {
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
