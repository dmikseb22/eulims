<?php



namespace frontend\modules\reports\controllers;
use yii\web\Controller;
/**
 * Description of PreviewController
 *
 * @author Programmer
 */
class PreviewController extends Controller{
    public function actionIndex(){
        $purl= \Yii::$app->request->url;
        $url= substr($purl,21);  
        return $this->render('preview',['url'=>$url]);
    }
}
