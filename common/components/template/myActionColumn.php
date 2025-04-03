<?php


namespace common\components\template;
use kartik\grid\ActionColumn;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use Closure;
use yii\grid\ActionColumn as YiiActionColumn;
/**
 * Description of myActionColumn
 *
 * @author OneLab
 */
class myActionColumn extends ActionColumn{
    //put your code here
    public function init(){
        parent::init();
        $this->deleteOptions=['class'=>'btn btn-success'];
    }
}
