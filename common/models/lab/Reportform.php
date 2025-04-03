<?php

namespace common\models\lab;

use Yii;
use yii\base\Model;

class Reportform extends Model
{
    public $lab_id,$year;

    public function rules()
    {
        return [
            [['lab_id','year'], 'required'],
        ];
    }
}