<?php

/*
 * Project Name: eulims_ * 
 * Copyright(C)2018 Department of Science & Technology -IX * 
 * 10 17, 18 , 2:32:52 PM * 
 * Module: AjaxController * 
 */

namespace frontend\modules\api\controllers;
use Yii;
use yii\rest\ActiveController;
use yii\web\Response;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;

/**
 * Description of AjaxController
 *
 * @author OneLab
 */
class AjaxController extends ActiveController{
    public $modelClass="";
    
    /* Declare actions supported by APIs (Added in api/modules/v1/components/controller.php too) */
    public function actions(){
        $actions = parent::actions();
        unset($actions['get-lab']);
        return $actions;
    }
    /* Declare methods supported by APIs */
    protected function verbs(){
        return [
            'get-lab' => ['GET'],
        ];
    }
    public function behaviors()
    {
	return [
	    [
	        'class' => 'yii\filters\ContentNegotiator',
	        'only' => ['view', 'index'],
	        'formats' => [
	            'application/json' => Response::FORMAT_JSON,
	        ],
	    ],
            [
                'class' => \yii\filters\Cors::className(),
                'cors' => [
                    'Origin' => ['*'],
                    'Access-Control-Request-Method' => ['GET', 'POST'],
                    'Access-Control-Request-Headers' => ['*'],
                    'Access-Control-Allow-Credentials' => true,
                    'Access-Control-Max-Age' => 86400,
                ]    
            ],
	];
    }
    public function actionGetlab(){
//        $get= Yii::$app->request->get();
//        $RSTLId=$get['rsid'];
//        $rqid=$get['rqid'];
//        $Connection=Yii::$app->labdb;
//        $Command=$Connection->createCommand("CALL spGetRSTL_Lab(:rstlid,:rqid)");
//        $Command->bindValue(':rstlid',$RSTLId);
//        $Command->bindValue(':rqid',$rqid);
//        $Rows=$Command->queryAll();
//        Yii::$app->response->format= yii\web\Response::FORMAT_JSON;;
//        return $Rows;
        $out = [];
    if (isset($_POST['depdrop_parents'])) {
        $params = $_POST['depdrop_parents'];
        $RSTLId=$params[0];
        $rqid=$params[1];
        $Connection=Yii::$app->labdb;
        $Command=$Connection->createCommand("CALL spGetRSTL_Lab(:rstlid,:rqid)");
        $Command->bindValue(':rstlid',$RSTLId);
        $Command->bindValue(':rqid',$rqid);
        $rows=$Command->queryAll();
        foreach($rows as $row){
            $out[]=['id'=>$row['lab_id'],'name'=>$row['labname']];
        }
        $selected  = null;
        echo Json::encode(['output'=>$out, 'selected'=>1]);
        return;
    }
    echo Json::encode(['output' => '', 'selected'=>'']);
    }
}
