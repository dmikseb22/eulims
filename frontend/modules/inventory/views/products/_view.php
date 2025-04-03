<?php 
use yii\helpers\Html;
use yii\helpers\Url;
?>
<div class="view">
	<div>
		<?php 
		$var="";
		if($model->Image1){
			$var = Url::base()."/".$model->Image1;
		}else{
			$var = Url::base()."/uploads/products/no-image.png";
		}
	
	 ?>
	<img src="<?= $var ?>" class="img-modalx" name=<?= $model->product_name ?> title="/inventory/products/opensched?id=<?= $model->product_id?>">
	<?php echo Html::encode($model->getAttributeLabel('product_code')); ?>:<br>
	<b><?php echo Html::a(Html::encode($model->product_code)); ?></b>
	<br>
	<?php echo Html::encode($model->getAttributeLabel('product_name')); ?>:<br>
	<b><?php echo Html::a(Html::encode($model->product_name), array('/inventory/products/view', 'id'=>$model->product_id)); ?></b>
	</div>
</div>