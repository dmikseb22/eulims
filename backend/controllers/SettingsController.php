<?php

namespace backend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

class SettingsController extends \yii\web\Controller
{
    public function actionEnable()
    {
        \Yii::$app->maintenanceMode->enable();
        return "System is in Maintenance Mode.";
    }
    public function actionDisable()
    {
        \Yii::$app->maintenanceMode->disable();
        return "System is Live now.";
    }
    public function actionIndex()
    {
        if (Yii::$app->request->isAjax)
        {
            return $this->renderAjax('index');
        }
        else
        {
            return $this->render('index');

        }
       // return $this->render('index');
    }

}
