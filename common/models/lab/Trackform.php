<?php

namespace common\models\lab;

use Yii;
use yii\base\Model;

class TrackForm extends Model
{
    public $referencenumber;

    public function rules()
    {
        return [
            [['referencenumber'], 'required'],
        ];
    }
}