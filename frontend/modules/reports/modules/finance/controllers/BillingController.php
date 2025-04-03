<?php


namespace frontend\modules\reports\modules\lab\controllers;
use yii\web\Controller;
use Yii;
/**
 * Description of BillingController
 *
 * @author OneLab
 */
class BillingController extends Controller{
     /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
