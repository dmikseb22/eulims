<?php

namespace frontend\modules\api\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\Response;
use linslin\yii2\curl;
use common\models\lab\Restore_request;
use common\models\lab\Restore_analysis;
use common\models\lab\Restore_sample;
use common\models\lab\Sample;
use common\models\lab\Analysis;
use common\models\lab\Customer;
use yii\helpers\Json;


/**
 * Site controller
 */

class ProgressbarController extends Controller {

    public function actionIndex() {
        return $this->render('/api/lab/index');
    }

    public function actionShow() {
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('show');
        }else{
            return $this->render('show');
        }
    }

    public function actionOne() {
        if (Yii::$app->request->isAjax) {
            sleep(1);
            if (true) {
                $res = array(
                    'success' => true,
                    'nextLabel' => Yii::t('app', 'Action two ...'),
                    'nextUrl' => Url::to(['two'])
                );
            } else {
                $res = array(
                    'success' => false,
                    'errorMsg' => Yii::t('text', 'An error occurred while processing.'),
                );
            }

            Yii::$app->response->format = Response::FORMAT_JSON;
            return $res;
        }
    }

    public function actionTwo() {
        if (Yii::$app->request->isAjax) {
            sleep(1);
            if (true) {
                $res = array(
                    'success' => true,
                    'nextLabel' => Yii::t('app', 'Action three ...'),
                    'nextUrl' => Url::to(['three'])
                );
            } else {
                $res = array(
                    'success' => false,
                    'errorMsg' => Yii::t('text', 'An error occurred while processing.'),
                );
            }

            Yii::$app->response->format = Response::FORMAT_JSON;
            return $res;
        }
    }

    public function actionThree() {
        if (Yii::$app->request->isAjax) {
            $inclPic = Yii::$app->request->post('inclPic');

            if ($inclPic == 'false' || sleep(1)) {
                $res = array(
                    'success' => ($inclPic == 'false') ? 'skipped' : true,
                    'nextLabel' => Yii::t('app', 'Action four ...'),
                    'nextUrl' => Url::to(['four'])
                );
            } else {
                $res = array(
                    'success' => false,
                    'errorMsg' => Yii::t('text', 'An error occurred while processing.'),
                );
            }

            Yii::$app->response->format = Response::FORMAT_JSON;
            return $res;
        }
    }

    public function actionFour() {
        if (Yii::$app->request->isAjax) {
            sleep(1);
            if (true) {
                $res = array(
                    'success' => true,
                    'nextLabel' => Yii::t('app', 'Action five ...'),
                    'nextUrl' => Url::to(['five'])
                );
            } else {
                $res = array(
                    'success' => false,
                    'errorMsg' => Yii::t('text', 'An error occurred while processing.'),
                );
            }

            Yii::$app->response->format = Response::FORMAT_JSON;
            return $res;
        }
    }

    public function actionFive() {
        if (Yii::$app->request->isAjax) {
            sleep(1);

            if (true) {
                $res = [];

                $apiUrl="https://api3.onelab.ph/get/request/view?rstl_id=11&page=1&per-page=50";
                $curl = new curl\Curl();
                $responselab = $curl->get($apiUrl);   
                $lab = Json::decode($responselab);
        
                $count = 0;
                $duplicate = 0;
        
                foreach ($lab as $var)
                {    
                     //   $model_request = Restore_request::find()->where(['request_ref_num'=>$var['request_ref_num']])->all();
                    //    if (!$model_request){

                       

                            $newRequest = new Restore_request();
                            $newRequest->request_id = $var['request_old_id'];
                            $newRequest->request_ref_num = $var['request_ref_num'];
                            $newRequest->request_datetime= $var['request_datetime'];
                            $newRequest->rstl_id= $var['rstl_id'];
                            $newRequest->lab_id= $var['lab_id'];
                            $newRequest->customer_id= $var['customer_id'];
                            $newRequest->payment_type_id= $var['payment_type_id'];
                            $newRequest->modeofrelease_ids= $var['modeofrelease_ids'];
                            $newRequest->discount = $var['discount'];
                            $newRequest->purpose_id= $var['purpose_id'];
                            $newRequest->conforme= $var['conforme'];
                            $newRequest->report_due= $var['report_due'];
                            $newRequest->total= $var['total'];
                            $newRequest->receivedBy = $var['receivedBy'];
                            $newRequest->recommended_due_date = $var['recommended_due_date'];
                            $newRequest->est_date_completion = $var['est_date_completion'];
                            $newRequest->items_receive_by = $var['items_receive_by'];
                            $newRequest->equipment_release_date = $var['equipment_release_date'];
                            $newRequest->certificate_release_date = $var['certificate_release_date'];
                            $newRequest->released_by = $var['released_by'];
                            $newRequest->posted = $var['posted'];
                            $newRequest->status_id = $var['status_id'];
                            $newRequest->selected = $var['selected'];
                            $newRequest->other_fees_id = $var['other_fees_id'];
                            $newRequest->request_type_id = $var['request_type_id'];
                            $newRequest->position = $var['position'];
                            $newRequest->completed = $var['completed'];
                            $newRequest->received_by = $var['received_by'];
                            $newRequest->payment_status_id = $var['payment_status_id'];
                            $newRequest->oldColumn_requestId= $var['oldColumn_requestId'];
                            $newRequest->oldColumn_sublabId= $var['oldColumn_sublabId'];
                            $newRequest->oldColumn_orId = $var['oldColumn_orId'];
                            $newRequest->oldColumn_completed= $var['oldColumn_completed'];
                            $newRequest->oldColumn_cancelled= $var['oldColumn_cancelled'];
                            $newRequest->oldColumn_create_time= $var['oldColumn_create_time'];
                            $newRequest->request_old_id= $var['request_old_id'];
                            $newRequest->created_at= $var['created_at'];
                            $newRequest->discount_id= $var['discount_id'];
                            $newRequest->customer_old_id= $var['customer_old_id'];
                            $newRequest->tmpCustomerID= $var['tmpCustomerID'];
                            $count++;
                              
                            if($newRequest->save()){
                                    $message = "saved request";               
                            }else{
                                    $message = "not saved request";
                            }
        
                        // }else{
                        //     $duplicate++;
                        // }
        
                        $analyses = $var['analyses'];
                        foreach ($analyses as $anals){
        
                            $model_analysis = Restore_analysis::find()->where(['analysis_id'=>$anals['analysis_id']])->all();
                            if (!$model_analysis){
                                $newanalysis = new Restore_analysis();
                                $newanalysis->analysis_id=$anals['analysis_old_id'];
                                $newanalysis->rstl_id=$anals['rstl_id'];
                                $newanalysis->pstcanalysis_id=$anals['pstcanalysis_id'];
                                $newanalysis->sample_id=$anals['sample_id'];
                                $newanalysis->sample_code=$anals['sample_code'];
                                $newanalysis->testname=$anals['testname'];
                                $newanalysis->method=$anals['method'];
                                $newanalysis->references=$anals['references'];
                                $newanalysis->quantity=$anals['quantity'];
                                $newanalysis->fee=$anals['fee'];
                                $newanalysis->test_id=$anals['test_id'];
                                $newanalysis->cancelled=$anals['cancelled'];
                                $newanalysis->date_analysis=$anals['date_analysis'];
                                $newanalysis->user_id=$anals['user_id'];
                                $newanalysis->is_package=$anals['is_package'];
                                $newanalysis->oldColumn_deleted=$anals['oldColumn_deleted'];
                                $newanalysis->analysis_old_id=$anals['analysis_old_id'];
                                $newanalysis->oldColumn_taggingId=$anals['oldColumn_taggingId'];
                                $newanalysis->oldColumn_result=$anals['oldColumn_result'];
                                $newanalysis->oldColumn_package_count=$anals['oldColumn_package_count'];
                                $newanalysis->oldColumn_requestId=$anals['oldColumn_requestId'];
                                $newanalysis->request_id=$anals['request_id'];
                                $newanalysis->testcategory_id=$anals['testcategory_id'];
                                $newanalysis->sample_type_id=$anals['sample_type_id'];
                                $newanalysis->old_sample_id=$anals['old_sample_id'];
                                $newanalysis->save(true);
                            }
                        }
          
                            $sample = $var['samples'];
                            foreach ($sample as $samp){
                                $model_sample = Restore_sample::find()->where(['sample_id'=>$samp['sample_id']])->all();
                                if (!$model_request){
                                $newSample = new Restore_sample();
                                $newSample->rstl_id=$samp['rstl_id'];
                                $newSample->sample_id=$samp['sample_old_id'];
                                $newSample->pstcsample_id=$samp['pstcsample_id'];
                                $newSample->sampletype_id=$samp['sampletype_id'];
                                $newSample->package_id=$samp['package_id'];
                                $newSample->package_rate=$samp['package_rate'];
                                $newSample->sample_code=$samp['sample_code'];
                                $newSample->samplename=$samp['samplename'];
                                $newSample->description=$samp['description'];
                                $newSample->sampling_date=$samp['sampling_date'];
                                $newSample->remarks=$samp['remarks'];
                                $newSample->request_id=$samp['request_id'];
                                $newSample->sample_month=$samp['sample_month'];
                                $newSample->sample_year=$samp['sample_year'];
                                $newSample->active=$samp['active'];
                                $newSample->sample_old_id=$samp['sample_old_id'];
                                $newSample->oldColumn_requestId=$samp['oldColumn_requestId'];
                                $newSample->oldColumn_completed=$samp['oldColumn_completed'];
                                $newSample->oldColumn_datedisposal=$samp['oldColumn_datedisposal'];
                                $newSample->oldColumn_mannerofdisposal=$samp['oldColumn_mannerofdisposal'];
                                $newSample->oldColumn_batch_num=$samp['oldColumn_batch_num'];
                                $newSample->oldColumn_package_count=$samp['oldColumn_package_count'];
                                $newSample->testcategory_id=$samp['testcategory_id'];
                                $newSample->save(true);
                        }
                    }           
                }
        
            
                    Yii::$app->session->setFlash('success', $count.' Records Successfully Restored'); 
                    return $this->redirect(['/api/lab/index']);
             
            } else {
                $res = array(
                    'success' => true,
                  //  'errorMsg' => Yii::t('text', 'An error occurred while processing.'),
                );
            }

            Yii::$app->response->format = Response::FORMAT_JSON;
            return $res;
        }
    }

}