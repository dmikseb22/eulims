<?php

namespace backend\controllers;
use yii\filters\VerbFilter;
use common\models\lab\CodeTemplate;
use Yii;
/**
 * Description of AjaxController
 *
 * @author OneLab
 */
class AjaxController extends \yii\web\Controller{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                   // 'saverequesttemplate'=>['POST']
                ],
            ],
        ];
    }
    public function actionSaverequesttemplate(){
        $post=Yii::$app->request->post();
        $rstl_id=$post['rstl_id'];
        $request_code_template=$post['rtemp'];
        $sample_code_template=$post['stemp'];
        $gmode=$post['gmode'];
        $RequestcodeTemplate= CodeTemplate::find()->where(['rstl_id'=>$rstl_id])->one();
        if(!$RequestcodeTemplate){
            $RequestcodeTemplate=new CodeTemplate();
        }
        $RequestcodeTemplate->rstl_id=$rstl_id;
        $RequestcodeTemplate->request_code_template=$request_code_template;
        $RequestcodeTemplate->sample_code_template=$sample_code_template;
        $RequestcodeTemplate->generate_mode=$gmode;
        if($RequestcodeTemplate->save()){//OK
            $Return=[
                'Status'=>'Success',
                'rstl_id'=>$rstl_id,
                'requestcode_template'=>$RequestcodeTemplate->request_code_template
            ];
        }else{//Failed to save
            $Return=[
                'Status'=>'Failed',
                'rstl_id'=>0,
                'requestcode_template'=>''
            ];
        }
        \Yii::$app->response->format=\yii\web\Response::FORMAT_JSON;
        return $Return;
    }
    public function actionGettemplate(){
        $post=Yii::$app->request->post();
        $rstl_id=$post['rstl_id'];
        $RequestCodeTemplate= CodeTemplate::find()->where(['rstl_id'=>$rstl_id])->one();
       
        if($RequestCodeTemplate){
           $CodeTemplate=[
               'requestcode_template_id'=>$RequestCodeTemplate->code_template_id,
               'rstl_id'=>$RequestCodeTemplate->rstl_id,
               'requestcode_template'=>$RequestCodeTemplate->request_code_template,
               'sample_code_template'=>$RequestCodeTemplate->sample_code_template
           ]; 
        }else{
           $CodeTemplate=[
               'requestcode_template_id'=>0,
               'rstl_id'=>0,
               'requestcode_template'=>'',
               'sample_code_template'=>''
           ];  
        }
        \Yii::$app->response->format=\yii\web\Response::FORMAT_JSON;
        return $CodeTemplate;
    }
}
