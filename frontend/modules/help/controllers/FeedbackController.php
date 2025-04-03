<?php

namespace frontend\modules\help\controllers;

use Yii;
use common\models\feedback\UserFeedback;
use common\models\feedback\UserFeedbackSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;


class FeedbackController extends \yii\web\Controller
{
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
     * Lists all UserFeedback models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserFeedbackSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single UserFeedback model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
    
    /**
     * Creates a new UserFeedback model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new UserFeedback();
        
        $sql = "select * from eulims.tbl_package
                union all
                select '0','Others','others','',''";
        
       
        $dataPackageList = ArrayHelper::map(Yii::$app->db->createCommand($sql)->queryAll(),'PackageName','PackageName');


        if ($model->load(Yii::$app->request->post()) && $model->save()) {
             Yii::$app->session->setFlash('success', 'User Feedback Successfully Created!');
            return $this->redirect(['view', 'id' => $model->feedback_id]);
        } else {
            return $this->render('create', [
                'model' => $model,'dataPackageList'=>$dataPackageList
            ]);
        }
    }

    /**
     * Updates an existing UserFeedback model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
         $sql = "select * from eulims.tbl_package
                union all
                select '0','Others','others','',''";
         $dataPackageList = ArrayHelper::map(Yii::$app->db->createCommand($sql)->queryAll(),'PackageName','PackageName');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->feedback_id]);
        } else {
            return $this->render('update', [
                'model' => $model,'dataPackageList'=>$dataPackageList
            ]);
        }
    }

    /**
     * Deletes an existing UserFeedback model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the UserFeedback model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return UserFeedback the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UserFeedback::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
