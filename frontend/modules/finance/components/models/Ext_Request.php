<?php

namespace frontend\modules\finance\components\models;

use Yii;
use common\models\lab\Request;
use common\models\finance\Paymentitem;

class Ext_Request extends Request
{
    public function rules()
    {
        return [
            [['request_datetime', 'rstl_id', 'lab_id', 'customer_id', 'payment_type_id', 'modeofrelease_ids', 'discount_id', 'purpose_id', 'report_due', 'conforme', 'receivedBy', 'created_at','request_type_id'], 'required'],
            [['request_datetime', 'report_due', 'recommended_due_date', 'est_date_completion', 'equipment_release_date', 'certificate_release_date'], 'safe'],
            [['rstl_id', 'lab_id', 'customer_id', 'payment_type_id', 'discount_id', 'purpose_id', 'created_at', 'posted', 'status_id', 'selected', 'request_type_id'], 'integer'],
            [['discount', 'total'], 'number'],
            [['request_ref_num', 'modeofrelease_ids', 'conforme', 'receivedBy'], 'string', 'max' => 50],
            [['position', 'items_receive_by', 'released_by', 'received_by'], 'string', 'max' => 100],
            [['request_ref_num'], 'unique'],
           ];
    }
    
    public static function getBalance($req_id,$total) 
	{
        $collection = Paymentitem::find()->where(['request_id' => $req_id])
                 ->andWhere(['status' => 2])
                 ->sum('amount');
        $balance = $total - $collection;
        
        return $balance;
    }
}