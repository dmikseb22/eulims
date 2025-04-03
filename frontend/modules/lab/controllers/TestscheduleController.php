<?php

namespace frontend\modules\lab\controllers;

use frontend\modules\lab\components\_class\Schedule;
use common\models\lab\Request;
use common\models\lab\Analysis;
use common\models\lab\Testname;

class TestscheduleController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionSchedules(){
    	\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;   

	    $events = array();
	    $date = date('Y-m-d');
        $date1 = str_replace('-', '/', $date);
        $date1 = date('Y-m-d',strtotime($date1 . "-30 days"));

        $date2 = str_replace('-', '/', $date);
        $date2 = date('Y-m-d',strtotime($date2 . "+30 days")); //adding days should be accompanied by the standards of REcommended Maximum storage

	    $analyses =Analysis::find()->where(['between','date_analysis',$date1,$date2])->all();
	 
    	foreach ($analyses as $schedule) {
    		$testname = Testname::findOne($schedule->testname_id);
    		$Event= new Schedule();
	        $Event->id = $schedule->analysis_id;
	        $Event->start =$schedule->date_analysis;

	        $date = $schedule->date_analysis;
	        $date1 = str_replace('-', '/', $date);

	        if($testname){
	        	
	        	
		        // $newdate = date('Y-m-d',strtotime($date1 ."+".$testname->max_storage." hours")); //update this statement

		        $figures= explode(".",$testname->max_storage);
	    		$hours=(int)$figures[0]/24; //get the first numerical whole number for hours and convert to days
	    		$ceil= ceil($hours);
	    		$modulus=  (int)$figures[0]%24; //get the remaining hours for the duration to display in a day
	    		$minutes=((int)$figures[1] * .01)*60; //get the 2nd numerical decimal value conversion from hours to minutes


	    		//use this when you need precise target of end duration
		       // $newdate =date('Y-m-d',strtotime($date1 . "+".$hours." hours +".$minutes." minutes"));

	    		//use this when you just wanted to show what the the duration will end (whole number)
		       $newdate =date('Y-m-d',strtotime($date1 . "+".$ceil." days")); 

		        $Event->end = $newdate; //test the statement if the schedulereally add up in hours to the inital receiving of the sample to analyse
		        $Event->title =$schedule->sample->samplename."(".$schedule->sample->sample_code.") - ".$schedule->testname." until ".$modulus." hour(s) and ".$minutes." minute(s) of ".date('Y-m-d',strtotime($newdate."- 1 days"));
		        $Event->status = $schedule->tagging?$schedule->tagging->tagging_status_id:0;
		        $Event->knowthycolor();
		        // $Event->backgroundColor='#777';
		       
	        }
	        else{
	        	$Event->end = $Event->start;
	        	$Event->title =$schedule->sample->samplename."(".$schedule->sample->sample_code.") - No Testname Yet";
		        $Event->status = 0;
		        $Event->setbgcolor(0);
	        }
	         $events[] = $Event;
	        
    	}
	    

	    return $events;
    }
}
