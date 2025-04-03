<?php

namespace backend\modules\system\controllers;

use Yii;
use common\models\lab\Discount;
use common\models\lab\discountSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DiscountController implements the CRUD actions for discount model.
 */
class DiscountController extends Controller
{
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
                ],
            ],
        ];
    }

    /**
     * Lists all discount models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new discountSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single discount model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->renderAjax('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new discount model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Discount();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
             Yii::$app->session->setFlash('success', 'Discount Successfully Saved!');
            \Yii::$app->session['config-item']=3;
            return $this->redirect(['/system/configurations']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
    public function actionUpdatediscount(){
        $post= \Yii::$app->request->post();
        $postvalues= \Yii::$app->request->post('Discount');
        $id=$post['editableKey'];
        $rate=$postvalues[$id]['rate'];
        $model = $this->findModel($id);
        if (isset($post['hasEditable'])) {
            $model->rate=$rate;
            $model->save();
        }
        $value=$model->rate;
        
        // return JSON encoded output in the below format
         \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return ['output'=>$value, 'message'=>''];
    }
    /**
     * Updates an existing discount model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Discount Successfully Updated!');
            \Yii::$app->session['config-item']=3;
            return $this->redirect(['/system/configurations']);
        } else {
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing discount model.
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
     * Finds the discount model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return discount the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Discount::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
