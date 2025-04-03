<?php 

namespace frontend\modules\pstc\controllers;

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
            return $this->redirect('/pstc/pstcrequest');
        }
        
        return $this->render('login');
    }

}