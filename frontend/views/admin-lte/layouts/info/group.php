<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\components\Functions;
use yii\helpers\Url;
use kartik\grid\GridView;

$js=<<<SCRIPT
   $(".kv-row-checkbox").click(function(){
        setids();
   });    
   $(".select-on-check-all").change(function(){
        setids();
   });
  
SCRIPT;
$this->registerJs($js);
?>
<div class="form" style="margin:0important;padding:0px!important;padding-bottom: 10px!important;">

    <?php $form = ActiveForm::begin(); ?>
    <div class="alert alert-info" style="background: #d9edf7 !important;margin-top: 1px !important;">
     <a href="#" class="close" data-dismiss="alert" >×</a>
    <p class="note" style="color:#265e8d">Fields with <i class="fa fa-asterisk text-danger"></i> are required.</p>
     </div>
   
    <div style="padding:0px!important;">
         <div class="row">
            <div class="col-lg-12"> 
                <?= $form->field($model, 'group_name')->textarea(['maxlength' => true]); ?>
            </div>
        </div>
        
		
		<div>
		<?php 
		$gridColumn = [
			['class' => 'kartik\grid\SerialColumn'
			],
			[
				 'class' => '\kartik\grid\CheckboxColumn',
			],
			[
				'attribute'=>'fullname',
				'enableSorting' => false,
				'contentOptions' => [
					'style'=>'overflow: auto; white-space: normal; word-wrap: break-word;'
				],
			],     
		];
		?>
		<table id="data-table">
        <?php foreach ($possible_recipients as $data)
		 { 
			//echo $data['user_id'];
			
			echo "  <tr>";
			echo "<td><input type='checkbox' name='recipients' /></td>";
			echo "<td>".$data['user_id']."</td>";
			echo "<td>".$data['fullname']."</td>";
			echo " </tr>";
		 }
		 ?>	
		 </table>
		
		</div>
		
        <div class="form-group pull-right">
			<input type="button" class="btn btn-success" value="Create" id="creategroup" />
            <?php if(Yii::$app->request->isAjax){ ?>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            <?php } ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>

 <script type="text/javascript">
    $("#creategroup").click(function(){
        //Reference the Table.
        var grid = document.getElementById("data-table");
 
        //Reference the CheckBoxes in Table.
        var checkBoxes = grid.getElementsByTagName("INPUT");
		
		var userids =[];
        //Loop through the CheckBoxes.
        for (var i = 0; i < checkBoxes.length; i++) {
            if (checkBoxes[i].checked) {
                var row = checkBoxes[i].parentNode.parentNode;
				userids.push(row.cells[1].innerHTML); // array push
            }
        }
        //$("#chatgroup-userids").val(userids); 
	   var x = userids.toString();
	   var groupname= $("#chatgroup-group_name").val();
	   var token=<?php echo json_encode($_SESSION['usertoken'])?>;
	   var sender_userid= <?= Yii::$app->user->identity->profile->user_id?>;
		$.ajax({
			url: "http://www.eulims.local/api/message/setgroup", //API LINK FROM THE CENTRAL
			type: 'POST',
			dataType: "JSON",
			beforeSend: function (xhr) {
				xhr.setRequestHeader('Authorization', 'Bearer '+ token);
			}, 
			data: {
				sender_userid: sender_userid,
				userids: x,
				groupname: groupname
			},
			success: function(response) {
				alert(response.message);
			},
			error: function(xhr, status, error) {
				alert(error);
			}
		}); 
		
   });  
</script>
