<?php

namespace console\controllers;
// namespace app\commands;

use \yii\console\Controller;
use \common\models\inventory\Products;

/**
 * This is an example...


**/

class HelloController extends Controller
{

 	public $message;

    
    public function options($actionID)
    {
        return ['message'];
    }
    
    public function optionAliases()
    {
        return ['m' => 'message'];
    }


 
    public function actionIndex($message = 'hello world')
    {
        echo " starting the job.  \n";
       
        $ctr = 100;
        $prod = Products::find(1)->one();
        while($ctr>0){

        	$xprod = new Products();
	        $xprod->attributes = $prod->attributes;
	        $xprod->save();
	        // if($xprod->save())
	        // 	echo "1  \n";
	        // else
	        	// echo "0";

        	$ctr--;
        }
         echo " Ended the job.  \n";

    }
    public function actionCreate($message = 'hello world')
    {
        echo $message . "\n";
    }

}