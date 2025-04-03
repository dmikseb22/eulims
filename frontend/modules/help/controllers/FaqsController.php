<?php

namespace frontend\modules\help\controllers;
use yii\db\Query;


class FaqsController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
    public function actionTopics($id)
    {
       return $this->render('topics', [
            'id' => $id,
        ]);
    }

}
