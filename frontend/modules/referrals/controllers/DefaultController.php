<?php 

namespace frontend\modules\referrals\controllers;

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

        if(isset($_SESSION['usertoken'])){
            return $this->redirect('/referrals/referral');
        }
        
        return $this->render('login');
    }
}