<?php

namespace frontend\modules\finance\components\models;

use common\models\finance\Op;
use Yii;
use yii\base\Model;

class Ext_Op extends Op
{
    public $RequestIds;
    public $requestid_update;
    public function rules()
    {
        return [
            [['transactionnum', 'collectiontype_id', 'payment_mode_id', 'order_date', 'customer_id', 'purpose'], 'required'],
	    ['RequestIds', 'required','message' => 'Please select Request.'],
            [['rstl_id', 'collectiontype_id', 'payment_mode_id', 'customer_id', 'created_receipt', 'allow_erratum','on_account'], 'integer'],
            [['order_date','RequestIds','requestid_update'], 'safe'],
            [['total_amount'], 'number'],
            [['transactionnum','RequestIds','invoice_number'], 'string', 'max' => 100],
            [['purpose'], 'string', 'max' => 200],
           ];
    }
}



