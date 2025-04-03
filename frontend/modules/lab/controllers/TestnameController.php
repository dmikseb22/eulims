<?php

namespace frontend\modules\lab\controllers;

use Yii;
use common\models\lab\Testname;
use common\models\lab\TestnameSearch;
use common\models\lab\TestnamemethodSearch;
use common\models\lab\SampletypetestnameSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TestnameController implements the CRUD actions for Testname model.
 */
class TestnameController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Testname models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TestnameSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort->defaultOrder = ['testName' => SORT_ASC];

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Testname model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        if(Yii::$app->request->isAjax){
            return $this->renderAjax('view', [
                    'model' => $this->findModel($id),
                ]);
        }
    }

    /**
     * Creates a new Testname model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Testname();

        $post= Yii::$app->request->post();
        if ($model->load(Yii::$app->request->post())) {
            $testname = Testname::find()->where(['testName'=> $post['Testname']['testName']])->one();

            if($testname){
              //  Yii::$app->session->setFlash('warning', "The system has detected a duplicate record. You are not allowed to perform this operation."); 
                return $this->runAction('index');
            }else{
                $post= Yii::$app->request->post();
                $model->save();  
               // Yii::$app->session->setFlash('success', 'Test Name Successfully Created'); 
                return $this->runAction('index');
            } 
        }

        if(Yii::$app->request->isAjax){
            $model->create_time=date("Y-m-d h:i:s");
            $model->update_time=date("Y-m-d h:i:s");
            return $this->renderAjax('_form', [
                'model' => $model,
            ]);
       }
    }


    /**
     * Creates a new Testname
     * If creation is successful, the browser will be redirected to the 'testnamemethod/index' page.
     /*
        Created By: Bergel T. Cutara
        Contacts:

        Email: b.cutara@gmail.com
        Tel. Phone: (062) 991-1024
        Mobile Phone: (639) 956200353

        Description: This action is performed by the testnamemethod .

     * @return mixed
     */
    public function actionCreatebytestnamemethod()
    {
        $model = new Testname();

        $post= Yii::$app->request->post();
        if ($model->load(Yii::$app->request->post())) {
            $testname = Testname::find()->where(['testName'=> $post['Testname']['testName']])->one();

            if($testname){
                return $this->redirect(['/lab/testnamemethod']);
            }else{
                $model->save();
                return $this->redirect(['/lab/testnamemethod']);
            } 
        }

        if(Yii::$app->request->isAjax){
            $model->create_time=date("Y-m-d h:i:s");
            $model->update_time=date("Y-m-d h:i:s");
            return $this->renderAjax('_form', [
                'model' => $model,
            ]);
       }
    }


    public function actionTestname()
    {
        $searchModel = new SampletypetestnameSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('/sampletypetestname/indexsampletypetestname', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionTestnamemethod()
    {
        $searchModel = new TestnamemethodSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('/testnamemethod/indextestname', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreatetestname()
    {
        $model = new Testname();

        $post= Yii::$app->request->post();
               if ($model->load(Yii::$app->request->post())) {
                    $testname = Testname::find()->where(['testName'=> $post['Testname']['testName']])->one();
        
                    if($testname){
                  //      Yii::$app->session->setFlash('warning', "The system has detected a duplicate record. You are not allowed to perform this operation."); 
                        return $this->runAction('testname');
                    }else{
                        $post= Yii::$app->request->post();
                        $model->save();  
                  //      Yii::$app->session->setFlash('success', 'Test Name Successfully Created'); 
                        return $this->runAction('testname');
                   } 

                }
        if(Yii::$app->request->isAjax){
            $model->create_time=date("Y-m-d h:i:s");
            $model->update_time=date("Y-m-d h:i:s");
            return $this->renderAjax('_formtestname', [
                'model' => $model,
            ]);
       }
    }

    public function actionCreatetestnamemethod()
    {
        $model = new Testname();

        $post= Yii::$app->request->post();
        if ($model->load(Yii::$app->request->post())) {
            $testname = Testname::find()->where(['testName'=> $post['Testname']['testName']])->one();

            if($testname){
           //     Yii::$app->session->setFlash('warning', "The system has detected a duplicate record. You are not allowed to perform this operation."); 
                return $this->runAction('testnamemethod');
            }else{
                $post= Yii::$app->request->post();
                $model->save();  
           //     Yii::$app->session->setFlash('success', 'Test Name Successfully Created'); 
                return $this->runAction('testnamemethod');
            } 
        }

        if(Yii::$app->request->isAjax){
            $model->create_time=date("Y-m-d h:i:s");
            $model->update_time=date("Y-m-d h:i:s");
            return $this->renderAjax('_formtestnamemethod', [
                'model' => $model,
            ]);
       }
    }

    /**
     * Updates an existing Testname model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        
                if ($model->load(Yii::$app->request->post()) && $model->save()) {
                 //   Yii::$app->session->setFlash('success', 'Test Name Successfully Updated'); 
                    return $this->redirect(['index']);

                } else if (Yii::$app->request->isAjax) {
                    return $this->renderAjax('update', [
                        'model' => $model,
                    ]);
                 }
    }

    /**
     * Deletes an existing Testname model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id); 
        if($model->delete()) {            
           // Yii::$app->session->setFlash('success', 'Test Name Successfully Deleted'); 
            return $this->redirect(['index']);
        } else {
            return $model->error();
        }
    }

    /**
     * Finds the Testname model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Testname the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Testname::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
