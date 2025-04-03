<?php

namespace api\modules\v1\controllers;

use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;

/**
 * Orderofpayment Controller API
 *
 * @author DOST IX ICT Team <red_x88@yahoo.com>
 */
class OrderofpaymentController extends ActiveController
{
    public $modelClass = 'api\modules\v1\models\Orderofpayment';    

    public function actions()
    {
        return array_merge(
            parent::actions(),
            [
                'index' => [
                    'class' => 'yii\rest\IndexAction',
                    'modelClass' => $this->modelClass,
                    'checkAccess' => [$this, 'checkAccess'],
                    'prepareDataProvider' => function ($action) {
                        $model = new $this->modelClass;
                        $query = $model::find();
                        //$query = $model::find()->joinWith('paymentitems');
                        $dataProvider = new ActiveDataProvider(['query' => $query, 'pagination' => false]);
                        return $dataProvider;
                    }
                ],
            ]
        );
    }

    public function actionSearch()
    {
        if (!empty($_GET)) {
            $model = new $this->modelClass;
            foreach ($_GET as $key => $value) {
                if (!$model->hasAttribute($key)) {
                    throw new \yii\web\HttpException(404, 'Invalid attribute:' . $key);
                }
            }
            try {
                $provider = new ActiveDataProvider([
                    'query' => $model->find()->where($_GET),
                    'pagination' => false
                ]);
            } catch (Exception $ex) {
                throw new \yii\web\HttpException(500, 'Internal server error');
            }

            if ($provider->getCount() <= 0) {
                throw new \yii\web\HttpException(404, 'No entries found with this query string');
            } else {
                return $provider;
            }
        } else {
            throw new \yii\web\HttpException(400, 'There are no query string');
        }
    }
}