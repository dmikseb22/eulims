<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\widgets\Select2;

/* @var $this yii\web\View */
/* @var $model common\models\lab\Testnamemethod */

$this->title = $model->method;
$this->params['breadcrumbs'][] = ['label' => 'Testnamemethods', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$js=<<<JS

    $("#sync").click(function(){   
        var id = $("#method_id").val();
        var testname_id = $("#testname_id").val();
        var sampletype_id = $("#sampletype_id").val();
        var lab_id = $("#lab_id").val();

        $.ajax({
            url: "/lab/testnamemethod/syncmethod",
            type: 'POST',
            dataType: "JSON",
            data: {
                id: id,
                testname_id : testname_id,
                sampletype_id : sampletype_id,
                lab_id : lab_id
            },
    
            success: function(response) {
                $('#pending').html(' <div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i>Method Reference was already Synced!</h4>It is now available in the central server.</div>')
                //alert('Synced Successfully.');
            },
            error: function(xhr, status, error) {
                alert(error);
            }
        });
       
    });
JS;

$this->registerJs($js,\yii\web\View::POS_READY);
?>
<div class="testnamemethod-view">

    <input type="hidden" id="method_id" value="<?php echo $model->method_reference_id;?>">
    <div class="box-body">
        <ul class="products-list product-list-in-box">
            <li class="item">
                <div class="product-info" style="margin-left: -10px;">
                    <a href="javascript:void(0)" class="product-title"><?php echo $model->method; ?>
                        <span class="label label-success pull-right"> ₱<?php echo $model->fee; ?></span></a>
                    <span class="product-description">
                    <?php echo $model->reference; ?>
                    </span>
                </div>
            </li>
        </ul>
        <br>
        <?php if($response == '"Synced"'){  ?>
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-warning"></i>Method Reference was already Synced!</h4>
                It is now available in the central server.
            </div>
        <?php }else if($response == '"Not Synced"'){  ?>
        
        <div id="pending">
            <div id="lab-name">
                <?php
                    echo '<label class="control-label">Laboratory </label>';
                    echo Select2::widget([
                        'name' => 'lab_id',
                        'id' => 'lab_id',
                        'data' => $laboratories,
                        'theme' => Select2::THEME_KRAJEE,
                        'options' => ['placeholder' => 'Select Laboratory '],
                        'pluginOptions' => [
                            'allowClear' => true,
                        ],
                    ]);
                ?>
                <span class="error-lab text-danger" style="position:fixed;"></span>
            </div>

            <div id="sampletype-name">
                <?php
                    echo '<label class="control-label">Sampletype</label>';
                    echo Select2::widget([
                        'name' => 'sampletype_id',
                        'id' => 'sampletype_id',
                        'data' => $sampletypes,
                        'theme' => Select2::THEME_KRAJEE,
                        'options' => ['placeholder' => 'Select Sampletype'],
                        'pluginOptions' => [
                            'allowClear' => true,
                        ],
                    ]);
                ?>
                <span class="error-lab text-danger" style="position:fixed;"></span>
            </div>

            <div id="testname-name">
                <?php
                    echo '<label class="control-label">Testname</label>';
                    echo Select2::widget([
                        'name' => 'testname_id',
                        'id' => 'testname_id',
                        'data' => $testnamelist,
                        'theme' => Select2::THEME_KRAJEE,
                        'options' => ['placeholder' => 'Select Testname'],
                        'pluginOptions' => [
                            'allowClear' => true,
                        ],
                    ]);
                ?>
                <span class="error-lab text-danger" style="position:fixed;"></span>
            </div>
            <br>

            <div class="alert alert-warning alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-warning"></i> Sync now?</h4>
                Method reference is available to sync. Want to sync now?
                <br><br>
                <button type="button" id="sync" class="btn btn-block btn-default btn-flat">Sync Now</button>
            </div>
        </div>
        <?php }else{ echo 'Error'; }?>
    </div>

</div>