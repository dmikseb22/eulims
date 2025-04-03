<?php

use yii2assets\pdfjs\PdfJs;
use yii\helpers\Url;

if($model->proof){
	$url = Url::base().$model->proof;
	echo PdfJs::widget([
	    'width'=>'100%',
	    'height'=> '670px',
	    'url'=>$url
	]); 
}else{
	echo "<strong>no sds yet.</strong>"; 
}

?>