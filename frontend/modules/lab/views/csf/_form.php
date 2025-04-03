<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use common\models\lab\Request;
use common\models\lab\Businessnature;
use common\models\lab\Lab;
use common\models\lab\Markettype;
use common\models\lab\Paymenttype;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
use kartik\widgets\DepDrop;
use common\models\lab\Csf;

?>

<?php
$js=<<<SCRIPT
SCRIPT;
?>

<script>
/*  @preserve
jQuery pub/sub plugin by Peter Higgins (dante@dojotoolkit.org)
Loosely based on Dojo publish/subscribe API, limited in scope. Rewritten blindly.
Original is (c) Dojo Foundation 2004-2010. Released under either AFL or new BSD, see:
http://dojofoundation.org/license for more information.
*/
(function($) {
	var topics = {};
	$.publish = function(topic, args) {
	    if (topics[topic]) {
	        var currentTopic = topics[topic],
	        args = args || {};
	
	        for (var i = 0, j = currentTopic.length; i < j; i++) {
	            currentTopic[i].call($, args);
	        }
	    }
	};
	$.subscribe = function(topic, callback) {
	    if (!topics[topic]) {
	        topics[topic] = [];
	    }
	    topics[topic].push(callback);
	    return {
	        "topic": topic,
	        "callback": callback
	    };
	};
	$.unsubscribe = function(handle) {
	    var topic = handle.topic;
	    if (topics[topic]) {
	        var currentTopic = topics[topic];
	
	        for (var i = 0, j = currentTopic.length; i < j; i++) {
	            if (currentTopic[i] === handle.callback) {
	                currentTopic.splice(i, 1);
	            }
	        }
	    }
	};
})(jQuery);

</script>

<script src="/js/jsig/jSignature.js"></script>
<script src="/js/jsig/plugins/jSignature.CompressorBase30.js"></script>
<script src="/js/jsig/plugins/jSignature.CompressorSVG.js"></script>

<script src="/js/jsig/plugins/signhere/jSignature.SignHere.js"></script> 
<script>
$(document).ready(function() {
	
	// This is the part where jSignature is initialized.
	var $sigdiv = $("#signature").jSignature({'UndoButton':true})
	
	// All the code below is just code driving the demo. 
    , $tools = $('#tools')
    , $extra =$('#extra')
	, $extraarea = $('#displayarea')
	, pubsubprefix = 'jSignature.demo.'
	
	var export_plugins = $sigdiv.jSignature('listPlugins','export')
	, chops = ['<span><b>Extract signature data as: </b></span><select>','<option value="">(select export format)</option>']
	, name
	for(var i in export_plugins){
		if (export_plugins.hasOwnProperty(i)){
			name = export_plugins[i]
			chops.push('<option value="' + name + '">' + name + '</option>')
		}
	}
    chops.push('</select><span><b> or: </b></span>')
    
    $("#signature").on('mouseup touchend', function(e)
    {
        var data = $sigdiv.jSignature('getData', 'image');
        $("#hdnSignature").val(data);
       // document.getElementById("#hdnSignature").value = data;
 //    alert($("#hdnSignature").val());
    });
	
	$(chops.join('')).bind('change', function(e){
		if (e.target.value !== ''){
			var data = $sigdiv.jSignature('getData', e.target.value)
      //      alert(e.target.value);
            $.publish(pubsubprefix + 'formatchanged')
			if (typeof data === 'string'){
				$('textarea', $tools).val(data)
			} else if($.isArray(data) && data.length === 2){
				$('textarea', $tools).val(data.join(','))
				$.publish(pubsubprefix + data[0], data);
			} else {
				try {
					$('textarea', $tools).val(JSON.stringify(data))
				} catch (ex) {
					$('textarea', $tools).val('Not sure how to stringify this, likely binary, format.')
				}
			}
		}
	}).appendTo($tools)

	
	$('<input type="button" value="Reset Signature" class="btn btn-primary">').bind('click', function(e){
        $sigdiv.jSignature('reset');
        $("#hdnSignature").val('');
	}).appendTo($extra)
	
	$('<div><textarea style="width:100%;height:7em;"></textarea></div>').appendTo($tools)
	
	$.subscribe(pubsubprefix + 'formatchanged', function(){
		$extraarea.html('')
	})

	$.subscribe(pubsubprefix + 'image/svg+xml', function(data) {

		try{
			var i = new Image()
			i.src = 'data:' + data[0] + ';base64,' + btoa( data[1] )
			$(i).appendTo($extraarea)
		} catch (ex) {

		}
		
		var message = [
			"If you don't see an image immediately above, it means your browser is unable to display in-line (data-url-formatted) SVG."
			, "This is NOT an issue with jSignature, as we can export proper SVG document regardless of browser's ability to display it."
			, "Try this page in a modern browser to see the SVG on the page, or export data as plain SVG, save to disk as text file and view in any SVG-capabale viewer."
           ]
		$( "<div>" + message.join("<br/>") + "</div>" ).appendTo( $extraarea )
	});

	$.subscribe(pubsubprefix + 'image/svg+xml;base64', function(data) {
		var i = new Image()
		i.src = 'data:' + data[0] + ',' + data[1]
		$(i).appendTo($extraarea)
		
		var message = [
			"If you don't see an image immediately above, it means your browser is unable to display in-line (data-url-formatted) SVG."
			, "This is NOT an issue with jSignature, as we can export proper SVG document regardless of browser's ability to display it."
			, "Try this page in a modern browser to see the SVG on the page, or export data as plain SVG, save to disk as text file and view in any SVG-capabale viewer."
           ]
		$( "<div>" + message.join("<br/>") + "</div>" ).appendTo( $extraarea )
	});
	
	$.subscribe(pubsubprefix + 'image/png;base64', function(data) {
		var i = new Image()
		i.src = 'data:' + data[0] + ',' + data[1]
		$('<span><b>As you can see, one of the problems of "image" extraction (besides not working on some old Androids, elsewhere) is that it extracts A LOT OF DATA and includes all the decoration that is not part of the signature.</b></span>').appendTo($extraarea)
		$(i).appendTo($extraarea)
	});
	
	$.subscribe(pubsubprefix + 'image/jsignature;base30', function(data) {
		$('<span><b>This is a vector format not natively render-able by browsers. Format is a compressed "movement coordinates arrays" structure tuned for use server-side. The bonus of this format is its tiny storage footprint and ease of deriving rendering instructions in programmatic, iterative manner.</b></span>').appendTo($extraarea)
	});

	if (Modernizr.touch){
		$('#scrollgrabber').height($('#content').height())		
	}
	
})
</script>

<?php

$extremely_satisfied = "<img src='/uploads/csf/5-laugh-regular.svg' />";
$satisfied = "<img src='/uploads/csf/4-smile-regular.svg' />";
$neutral = "<img src='/uploads/csf/3-meh-regular.svg' />";
$unsatisfied = "<img src='/uploads/csf/2-frown.svg' />";
$extremely_unsatisfied = "<img src='/uploads/csf/1-angry-regular.svg' />";

$legend_extremely_satisfied = "<img src='/uploads/csf/5-laugh-regular.svg' /><div style='font-size:140%;text-align:center;'><b>(5)<br>Extremely Satisfied</b></div>";
$legend_satisfied = "<img src='/uploads/csf/4-smile-regular.svg' /><div style='font-size:140%;text-align:center;'><b>(4)<br><br>Satisfied</b></div>";
$legend_neutral = "<img src='/uploads/csf/3-meh-regular.svg' /><div style='font-size:140%;text-align:center;'><b>(3)<br><br>Neutral</b></div>";
$legend_unsatisfied = "<img src='/uploads/csf/2-frown.svg' /><div style='font-size:140%;text-align:center;'><b>(2)<br><br>Unsatisfied</b></div>";
$legend_extremely_unsatisfied = "<img src='/uploads/csf/1-angry-regular.svg' /><div style='font-size:140%;text-align:center;'><b>(1)<br>Extremely Unsatisfied</b></div>";

$requestnumbers=Request::find()->select(['request_id','request_ref_num','customer_id'])->where(['not',['request_ref_num'=>'null']])->orderBy(['request_id' => SORT_DESC])->all();
$requestnumbersproccessed= ArrayHelper::map($requestnumbers,'request_id','request_ref_num');

$requestlist= ArrayHelper::map(Businessnature::find()->orderBy(['nature' => SORT_DESC])->all(),'nature','nature');

                    //$btn_style = ';height: 45px;width: 45px; border-radius: 50%;display: inline-block;color:#0f096d;box-shadow: inset 0px 25px 0 rgba(255,255,255,0.3), 0 5px 5px rgba(0, 0, 0, 0.3);';
                    
                    $btn_style = ';width: 64px;height: 64px;background-color: transparent;border: none;border-radius: 50%;background-repeat: no-repeat;background-position: center center;font-size: 11px;padding: 1px;box-shadow: 0 0 3px #000;margin: 0 5px;';
                    $btn_stylerecommend = ';width: 50px;height: 50px;background-color: transparent;border: none;border-radius: 50%;background-repeat: no-repeat;background-position: center center;font-size: 11px;padding: 1px;box-shadow: 0 0 3px #000;margin: 0 5px;';
                    
                    $space = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                    ?>
                    
   <div class="csf-form" style="margin: 0 70px;">
   <?php //echo Html::button("<span class='glyphicon glyphicon-refresh'></span> Reset",['value' => '/lab/csf/index','onclick'=>'location.href=this.value', 'class' => 'btn btn-primary', 'title' => Yii::t('app', "View Request")]); ?>
                     <br>
                     <br>
                   
    <?php $form = ActiveForm::begin(); ?>         
    <div class="row">
        <div class="col-sm-6">
              
               
                <div class="panel panel-info">
                <div class="panel-heading" style="color:#142142;font-family:Century Gothic;font-size:130%;"><b>Information</b></div>
                    <div class="panel-body">

                    <!-- <?= $form->field($model, 'ref_num')->textInput(['maxlength' => true]) ?> -->

                    <?= $form->field($model,'ref_num')->widget(Select2::classname(),[
                        'data' => $requestnumbersproccessed,
                        'theme' => Select2::THEME_KRAJEE,
                        'pluginOptions' => ['allowClear' => true,'placeholder' => 'Select your Request Number'],
                        'pluginEvents' => [
					        "change" => 'function(data) { 
					            var data_id = $(this).val();
					            
					            $.ajax({url: "/lab/csf/getcust?id="+data_id, success: function(result){
								    $("#csf-name").val(result);
								  }});
					        }',
					    ],
                        ])
                        ?>

                    <?= $form->field($model,'nob')->widget(Select2::classname(),[
                        'data' => $requestlist,
                        'id'=>'name',
                        'theme' => Select2::THEME_KRAJEE,
                        'options' => ['id'=>'sample-type_id'],
                        'pluginOptions' => ['allowClear' => true,'placeholder' => 'Select Nature of Business'],
                        
                        ])
                        ?>

                        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                      
                        <?php echo $form->field($model, 'tom')->radioList(
                            ArrayHelper::map(Markettype::find()->all(),'id','type'),
                            ['itemOptions' => ['onchange'=>$js]]
                        ); ?>
                        <?php echo $form->field($model, 'service')->radioList(
                                                    ArrayHelper::map(Lab::find()->where(['active'=> 1])->all(),'lab_id','labname'),
                                                    ['itemOptions' => ['onchange'=>$js]]
                        ); ?>
                      
                    </div>
                </div>

                <div class="panel panel-info">
                <div class="panel-heading" style="color:#142142;font-family:Century Gothic;font-size:80%;"><b>Legends</b></div>
                    <div class="panel-body">
                    <?php echo Html::button($legend_extremely_satisfied, [ 'style'=>'background-color: #F5DEB3 !important;'.$btn_style]).$space ?> 
                    <?php echo Html::button($legend_satisfied, [ 'style'=>'background-color: #F5DEB3 !important;'.$btn_style]).$space ?>                 
                    <?php echo Html::button($legend_neutral, [  'style'=>'background-color: #F5DEB3 !important'.$btn_style]).$space ?>
                    <?php echo Html::button($legend_unsatisfied, ['style'=>'background-color: #F5DEB3 !important;'.$btn_style]).$space ?>
                    <?php echo Html::button($legend_extremely_unsatisfied, ['style'=>'background-color: #F5DEB3 !important;'.$btn_style]).$space ?>           
                   
                       
                      
                    </div>
                </div>

                    <div class="panel panel-info">
                    <div class="panel-heading" style="color:#142142;font-family:Century Gothic;font-size:130%;"><b>Delivery of Service</b></div>
                    <div class="panel-body">
                 
                    <?= $form->field($model, 'd_deliverytime')->hiddenInput()->label("Delivery Time") ?>
                    <?php echo Html::button($extremely_satisfied, ['onclick'=>'changeColor(this)', 'class' => 'd_deliverytime', 'value'=>'5', 'style'=>'background-color: #F5DEB3 !important;'.$btn_style]).$space ?> 
                    <?php echo Html::button($satisfied, ['onclick'=>'changeColor(this)', 'class' => 'd_deliverytime', 'value'=>'4', 'style'=>'background-color: #F5DEB3 !important;'.$btn_style]).$space ?>                 
                    <?php echo Html::button($neutral, ['onclick'=>'changeColor(this)', 'class' => 'd_deliverytime', 'value'=>'3', 'style'=>'background-color: #F5DEB3 !important'.$btn_style]).$space ?>
                    <?php echo Html::button($unsatisfied, ['onclick'=>'changeColor(this)', 'class' => 'd_deliverytime', 'value'=>'2', 'style'=>'background-color: #F5DEB3 !important;'.$btn_style]).$space ?>
                    <?php echo Html::button($extremely_unsatisfied, ['onclick'=>'changeColor(this)', 'class' => 'd_deliverytime','value'=>'1', 'style'=>'background-color: #F5DEB3 !important;'.$btn_style]).$space ?>           
                    <br>
                    <br>     
                    <?= $form->field($model, 'd_accuracy')->hiddenInput()->label("Correctness and accuracy of test results") ?>
                    <?php echo Html::button($extremely_satisfied, ['onclick'=>'changeColor(this)', 'class' => 'd_accuracy', 'value'=>'5', 'style'=>'background-color: #F5DEB3 !important;'.$btn_style]).$space ?>
                    <?php echo Html::button($satisfied, ['onclick'=>'changeColor(this)', 'class' => 'd_accuracy', 'value'=>'4', 'style'=>'background-color: #F5DEB3 !important;'.$btn_style]).$space ?>
                    <?php echo Html::button($neutral, ['onclick'=>'changeColor(this)', 'class' => 'd_accuracy', 'value'=>'3', 'style'=>'background-color: #F5DEB3 !important;'.$btn_style]).$space ?>
                    <?php echo Html::button($unsatisfied, ['onclick'=>'changeColor(this)', 'class' => 'd_accuracy', 'value'=>'2', 'style'=>'background-color: #F5DEB3 !important;'.$btn_style]).$space ?>
                    <?php echo Html::button($extremely_unsatisfied, ['onclick'=>'changeColor(this)', 'class' => 'd_accuracy','value'=>'1', 'style'=>'background-color: #F5DEB3 !important;'.$btn_style]).$space ?>   
                    <br>
                    <br>
                    <?= $form->field($model, 'd_speed')->hiddenInput()->label("Speed of Service") ?>
                    <?php echo Html::button($extremely_satisfied, ['onclick'=>'changeColor(this)', 'class'=>'d_speed', 'value'=>'5', 'style'=>'background-color: #F5DEB3 !important;'.$btn_style]).$space ?>
                    <?php echo Html::button($satisfied, ['onclick'=>'changeColor(this)', 'class'=>'d_speed', 'value'=>'4', 'style'=>'background-color: #F5DEB3 !important;'.$btn_style]).$space ?>
                    <?php echo Html::button($neutral, ['onclick'=>'changeColor(this)', 'class'=>'d_speed', 'value'=>'3', 'style'=>'background-color: #F5DEB3 !important;'.$btn_style]).$space ?>
                    <?php echo Html::button($unsatisfied, ['onclick'=>'changeColor(this)', 'class'=>'d_speed', 'value'=>'2', 'style'=>'background-color: #F5DEB3 !important;'.$btn_style]).$space ?>
                    <?php echo Html::button($extremely_unsatisfied, ['onclick'=>'changeColor(this)','class'=>'d_speed', 'value'=>'1', 'style'=>'background-color: #F5DEB3 !important;'.$btn_style]).$space ?>        
                   <br>
                    <br>
                     <?= $form->field($model, 'd_cost')->hiddenInput()->label("Cost") ?>
                    <?php echo Html::button($extremely_satisfied, ['onclick'=>'changeColor(this)', 'class'=>'d_cost', 'value'=> '5', 'style'=>'background-color: #F5DEB3 !important;'.$btn_style]).$space ?>
                    <?php echo Html::button($satisfied, ['onclick'=>'changeColor(this)', 'class'=>'d_cost', 'value'=> '4', 'style'=>'background-color: #F5DEB3 !important;'.$btn_style]).$space ?>
                    <?php echo Html::button($neutral, ['onclick'=>'changeColor(this)', 'class'=>'d_cost', 'value'=> '3', 'style'=>'background-color: #F5DEB3 !important;'.$btn_style]).$space ?>
                    <?php echo Html::button($unsatisfied, ['onclick'=>'changeColor(this)', 'class'=>'d_cost', 'value'=> '2', 'style'=>'background-color: #F5DEB3 !important;'.$btn_style]).$space ?>
                    <?php echo Html::button($extremely_unsatisfied, ['onclick'=>'changeColor(this)', 'class'=>'d_cost', 'value'=> '1', 'style'=>'background-color: #F5DEB3 !important;'.$btn_style]).$space ?>                
                    <br>
                    <br>
                    <?= $form->field($model, 'd_attitude')->hiddenInput()->label("Attitude of staff") ?>
                    <?php echo Html::button($extremely_satisfied, ['onclick'=>'changeColor(this)', 'class'=>'d_attitude', 'value'=>'5','style'=>'background-color: #F5DEB3 !important;'.$btn_style]).$space ?> 
                    <?php echo Html::button($satisfied, ['onclick'=>'changeColor(this)', 'class'=>'d_attitude', 'value'=>'4','style'=>'background-color: #F5DEB3 !important;'.$btn_style]).$space ?>
                    <?php echo Html::button($neutral, ['onclick'=>'changeColor(this)', 'class'=>'d_attitude', 'value'=>'3','style'=>'background-color: #F5DEB3 !important;'.$btn_style]).$space ?>
                    <?php echo Html::button($unsatisfied, ['onclick'=>'changeColor(this)', 'class'=>'d_attitude', 'value'=>'2','style'=>'background-color: #F5DEB3 !important;'.$btn_style]).$space ?>
                    <?php echo Html::button($extremely_unsatisfied, ['onclick'=>'changeColor(this)', 'class'=>'d_attitude', 'value'=>'1', 'style'=>'background-color: #F5DEB3 !important;'.$btn_style]).$space ?>          
                   <br>
                    <br>  <?= $form->field($model, 'd_overall')->hiddenInput()->label("Over-all customer experience") ?>
                    <?php echo Html::button($extremely_satisfied, ['onclick'=>'changeColor(this)', 'class'=>'d_overall', 'value'=>'5','style'=>'background-color: #F5DEB3 !important;'.$btn_style]).$space ?>
                    <?php echo Html::button($satisfied, ['onclick'=>'changeColor(this)', 'class'=>'d_overall', 'value'=>'4','style'=>'background-color: #F5DEB3 !important;'.$btn_style]).$space ?>
                    <?php echo Html::button($neutral, ['onclick'=>'changeColor(this)', 'class'=>'d_overall', 'value'=>'3','style'=>'background-color: #F5DEB3 !important;'.$btn_style]).$space ?>
                    <?php echo Html::button($unsatisfied, ['onclick'=>'changeColor(this)', 'class'=>'d_overall', 'value'=>'2','style'=>'background-color: #F5DEB3 !important;'.$btn_style]).$space ?>
                    <?php echo Html::button($extremely_unsatisfied, ['onclick'=>'changeColor(this)', 'class'=>'d_overall', 'value'=>'1','style'=>'background-color: #F5DEB3 !important;'.$btn_style]).$space ?>
                    </div>
                </div>
            </div>
            <div class="row">
        <div class="col-sm-6">
        <div class="panel panel-info">
        <div class="panel-heading" style="color:#142142;font-family:Century Gothic;font-size:100%;"><b>How <font color="red">Important</font> are these items to you?</b></div>
                <div class="panel-body">               
                <?= $form->field($model, 'i_deliverytime')->hiddenInput()->label("Delivery Time") ?>
                    <?php echo Html::button($extremely_satisfied, ['onclick'=>'changeColor(this)', 'class'=>'i_deliverytime', 'value'=>'5','style'=>'background-color: #F5DEB3 !important;'.$btn_style]).$space ?>   
                    <?php echo Html::button($satisfied, ['onclick'=>'changeColor(this)', 'class'=>'i_deliverytime', 'value'=>'4','style'=>'background-color: #F5DEB3 !important;'.$btn_style]).$space ?>
                    <?php echo Html::button($neutral, ['onclick'=>'changeColor(this)', 'class'=>'i_deliverytime', 'value'=>'3','style'=>'background-color: #F5DEB3 !important;'.$btn_style]).$space ?> 
                    <?php echo Html::button($unsatisfied, ['onclick'=>'changeColor(this)', 'class'=>'i_deliverytime',  'value'=>'2','style'=>'background-color: #F5DEB3 !important;'.$btn_style]).$space ?>
                    <?php echo Html::button($extremely_unsatisfied, ['onclick'=>'changeColor(this)', 'class'=>'i_deliverytime', 'value'=>'1','style'=>'background-color: #F5DEB3 !important;'.$btn_style]).$space ?>  
                    <br>
                    <br>
                    <?= $form->field($model, 'i_accuracy')->hiddenInput()->label("Correctness and accuracy of test results") ?>
                    <?php echo Html::button($extremely_satisfied, ['onclick'=>'changeColor(this)', 'class'=>'i_accuracy', 'value'=>'5','style'=>'background-color: #F5DEB3 !important;'.$btn_style]).$space ?>  
                    <?php echo Html::button($satisfied, ['onclick'=>'changeColor(this)', 'class'=>'i_accuracy', 'value'=>'4','style'=>'background-color: #F5DEB3 !important;'.$btn_style]).$space ?>    
                    <?php echo Html::button($neutral, ['onclick'=>'changeColor(this)', 'class'=>'i_accuracy', 'value'=>'3','style'=>'background-color: #F5DEB3 !important;'.$btn_style]).$space ?>
                    <?php echo Html::button($unsatisfied, ['onclick'=>'changeColor(this)', 'class'=>'i_accuracy', 'value'=>'2','style'=>'background-color: #F5DEB3 !important;'.$btn_style]).$space ?>             
                    <?php echo Html::button($extremely_unsatisfied, ['onclick'=>'changeColor(this)', 'class'=>'i_accuracy', 'value'=>'1','style'=>'background-color: #F5DEB3 !important;'.$btn_style]).$space ?>        
                    <br>
                    <br>
                    <?= $form->field($model, 'i_speed')->hiddenInput()->label("Speed of Service") ?>
                    <?php echo Html::button($extremely_satisfied, ['onclick'=>'changeColor(this)', 'class'=>'i_speed', 'value'=>'5','style'=>'background-color: #F5DEB3 !important;'.$btn_style]).$space ?>
                    <?php echo Html::button($satisfied, ['onclick'=>'changeColor(this)', 'class'=>'i_speed', 'value'=>'4','style'=>'background-color: #F5DEB3 !important;'.$btn_style]).$space ?> 
                    <?php echo Html::button($neutral, ['onclick'=>'changeColor(this)', 'class'=>'i_speed', 'value'=>'3','style'=>'background-color: #F5DEB3 !important;'.$btn_style]).$space ?> 
                    <?php echo Html::button($unsatisfied, ['onclick'=>'changeColor(this)', 'class'=>'i_speed', 'value'=>'2','style'=>'background-color: #F5DEB3 !important'.$btn_style]).$space ?> 
                    <?php echo Html::button($extremely_unsatisfied, ['onclick'=>'changeColor(this)', 'class'=>'i_speed', 'value'=>'1','style'=>'background-color: #F5DEB3 !important;'.$btn_style]).$space ?>          
                    <br>
                    <br>
                    <?= $form->field($model, 'i_cost')->hiddenInput()->label("Cost") ?>
                    <?php echo Html::button($extremely_satisfied, ['onclick'=>'changeColor(this)', 'class'=>'i_cost', 'value'=>'5','style'=>'background-color: #F5DEB3 !important;'.$btn_style]).$space ?>         
                    <?php echo Html::button($satisfied, ['onclick'=>'changeColor(this)', 'class'=>'i_cost', 'value'=>'4','style'=>'background-color: #F5DEB3 !important;'.$btn_style]).$space ?>        
                    <?php echo Html::button($neutral, ['onclick'=>'changeColor(this)', 'class'=>'i_cost', 'value'=>'3','style'=>'background-color: #F5DEB3 !important;'.$btn_style]).$space ?>
                    <?php echo Html::button( $unsatisfied, ['onclick'=>'changeColor(this)', 'class'=>'i_cost', 'value'=>'2','style'=>'background-color: #F5DEB3 !important;'.$btn_style]).$space ?>
                    <?php echo Html::button($extremely_unsatisfied, ['onclick'=>'changeColor(this)', 'class'=>'i_cost', 'value'=>'1','style'=>'background-color: #F5DEB3 !important;'.$btn_style]).$space ?>                  
                    <br>
                    <br>
                    <?= $form->field($model, 'i_attitude')->hiddenInput()->label("Attitude of Staff") ?>
                    <?php echo Html::button($extremely_satisfied, ['onclick'=>'changeColor(this)', 'class'=>'i_attitude', 'value'=>'5','style'=>'background-color: #F5DEB3 !important;'.$btn_style]).$space ?>             
                    <?php echo Html::button($satisfied, ['onclick'=>'changeColor(this)', 'class'=>'i_attitude', 'value'=>'4','style'=>'background-color: #F5DEB3 !important;'.$btn_style]).$space ?>
                    <?php echo Html::button($neutral, ['onclick'=>'changeColor(this)', 'class'=>'i_attitude', 'value'=>'3','style'=>'background-color: #F5DEB3 !important;'.$btn_style]).$space ?>
                    <?php echo Html::button($unsatisfied, ['onclick'=>'changeColor(this)', 'class'=>'i_attitude', 'value'=>'2','style'=>'background-color: #F5DEB3 !important;'.$btn_style]).$space ?>
                    <?php echo Html::button($extremely_unsatisfied, ['onclick'=>'changeColor(this)', 'class'=>'i_attitude', 'value'=>'1','style'=>'background-color: #F5DEB3 !important;'.$btn_style]).$space ?>                   
                    <br>
                    <br>
                    <?= $form->field($model, 'i_overall')->hiddenInput()->label("Over-all customer experience") ?>
                    <?php echo Html::button($extremely_satisfied, ['onclick'=>'changeColor(this)', 'class'=>'i_overall', 'value'=>'5','style'=>'background-color: #F5DEB3 !important;'.$btn_style]).$space ?>
                    <?php echo Html::button($satisfied, ['onclick'=>'changeColor(this)', 'class'=>'i_overall', 'value'=>'4','style'=>'background-color: #F5DEB3 !important;'.$btn_style]).$space ?>
                    <?php echo Html::button($neutral, ['onclick'=>'changeColor(this)', 'class'=>'i_overall', 'value'=>'3','style'=>'background-color: #F5DEB3 !important;'.$btn_style]).$space ?>                  
                    <?php echo Html::button($unsatisfied, ['onclick'=>'changeColor(this)', 'class'=>'i_overall', 'value'=>'2','style'=>'background-color: #F5DEB3 !important;'.$btn_style]).$space ?>     
                    <?php echo Html::button($extremely_unsatisfied, ['onclick'=>'changeColor(this)', 'class'=>'i_overall', 'value'=>'1','style'=>'background-color: #F5DEB3 !important;'.$btn_style]).$space ?>          
                                     
                    <br>
                    <br>
                </div>
        </div>
        <div class="panel panel-info">
            <div class="panel-heading" style="color:#142142;font-family:Century Gothic;font-size:100%;"><b>How likely is it that you would <font color="red">recommend</font> our service to others? 1-10</b></div>

                <div class="panel-body">
                    <?= $form->field($model, 'recommend')->hiddenInput()->label("Recommend")->label(false) ?>
                    <?php echo Html::button('<b><font size="4">10</b>', ['onclick'=>'changeColor_rec(this)','class'=>'recommend', 'value'=>'10','style'=>'background-color: #F5DEB3 !important;'.$btn_stylerecommend]) ?>
                    <?php echo Html::button('<b><font size="4">9</b>', ['onclick'=>'changeColor_rec(this)', 'class'=>'recommend', 'value'=>'9','style'=>'background-color: #F5DEB3 !important;'.$btn_stylerecommend]) ?>
                    <?php echo Html::button('<b><font size="4">8</b>', ['onclick'=>'changeColor_rec(this)', 'class'=>'recommend', 'value'=>'8','style'=>'background-color: #F5DEB3 !important;'.$btn_stylerecommend]) ?>
                    <?php echo Html::button('<b><font size="4">7</b>', ['onclick'=>'changeColor_rec(this)', 'class'=>'recommend', 'value'=>'7','value' => '2', 'style'=>'background-color: #F5DEB3 !important;'.$btn_stylerecommend]) ?>
                    <?php echo Html::button('<b><font size="4">6</b>', ['onclick'=>'changeColor_rec(this)',' class'=>'recommend', 'value'=>'6','style'=>'background-color: #F5DEB3 !important;'.$btn_stylerecommend]) ?>
                    <?php echo Html::button('<b><font size="4">5</b>', ['onclick'=>'changeColor_rec(this)', 'class'=>'recommend', 'value'=>'5','style'=>'background-color: #F5DEB3 !important;'.$btn_stylerecommend]) ?>
                    <?php echo Html::button('<b><font size="4">4</b>', ['onclick'=>'changeColor_rec(this)', 'class'=>'recommend', 'value'=>'4','style'=>'background-color: #F5DEB3 !important;'.$btn_stylerecommend]) ?>
                    <?php echo Html::button('<b><font size="4">3</b>', ['onclick'=>'changeColor_rec(this)', 'class'=>'recommend', 'value'=>'2','value' => '2', 'style'=>'background-color: #F5DEB3 !important;'.$btn_stylerecommend]) ?>     
                    <?php echo Html::button('<b><font size="4">2</b>', ['onclick'=>'changeColor_rec(this)', 'class'=>'recommend', 'value'=>'1','style'=>'background-color: #F5DEB3 !important;'.$btn_stylerecommend])?>    
                    <?php echo Html::button('<b><font size="4">1</b>', ['onclick'=>'changeColor_rec(this)', 'class'=>'recommend', 'value'=>'1','style'=>'background-color: #F5DEB3 !important;'.$btn_stylerecommend])?>            
                 </div>     
        </div>
        <div class="panel panel-info">
        <div class="panel-heading" style="color:#142142;font-family:Century Gothic;font-size:80%;"><b>Please give us your comments/ suggestions to improve our services. Also, let us know other test you require that we are not able to provide yet.</b></div>
            <div class="panel-body">
                 <?= $form->field($model, 'essay')->textArea(['rows' => '3'])->label(false) ?>
            </div>  
        </div>    
        <div class="panel panel-info">
        <div class="panel-heading" style="color:#142142;font-family:Century Gothic;font-size:80%;"><b>Please Sign below.</b></div>

            <div class="panel-body">
                <div class="row">
                    <div class="col-md-9">
                    <div id="signature"></div>
                    </div>
                    <div class="col-md-2">
                    <div id="extra"></div><br>
                    <?php echo Html::submitButton('Submit Feedback', ['class' => 'btn btn-primary']) ?>
                    </div>
                   
                </div>
                <?= $form->field($model, 'signature')->hiddenInput(['id'=>'hdnSignature'])->label(false) ?>
            </div>  
        </div>
        <p class="pull-right" style="font-size:8;">OP-011-F1<br>Rev. 4/11.24.21</p>
        </div>
       
            <?php $form->field($model, 'r_date')->hiddenInput()->label(false) ?>
        </div>
        </div>

        <div class="row" style="float: right;padding-right: 30px">
      

      
        <?php if($model->isNewRecord){ ?>
        <?php } ?>
    <?php ActiveForm::end(); ?>
</div>
<script type="text/javascript">
    function changeColor (btn, txtBoxId) {
        document.querySelectorAll('.' + btn.className).forEach(function (btn) {
            btn.style.backgroundColor = '#bbb';
        })
        let colors = ['#DC143C', '#FFA07A', '#F5DEB3', '#98FB98', '#3CB371' ]
        btn.style.backgroundColor = colors[btn.value - 1];
        document.getElementById('csf-' + btn.className).value = btn.value;
    }
    function changeColor_rec (btn, txtBoxId) {
        document.querySelectorAll('.' + btn.className).forEach(function (btn) {
            btn.style.backgroundColor = '#bbb';
        })
        let colors = ['#DC143C', '#CD5C5C', '#F08080', '#E9967A', '#FFA07A', '#FFEFD5', '#98FB98','#32CD32','#008000','#006400' ]
        btn.style.backgroundColor = colors[btn.value - 1];
        document.getElementById('csf-' + btn.className).value = btn.value;
    }
</script>
<?php ini_set("memory_limit", "10000M");?>