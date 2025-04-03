<?php

namespace frontend\modules\reports\modules\lab\controllers;

use yii\web\Controller;
use Yii;

/**
 * Default controller for the `Lab` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        //$config = require(Yii::$app->basePath.'/config/_modules.php');
        //$config= require(Yii::$app->basePath.'/config/_modules.php');
        //echo "<pre>";
        //var_dump($config);
        //echo "</pre>";
        return $this->render('index');
    }
}
