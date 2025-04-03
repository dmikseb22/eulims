<?php

namespace frontend\modules\finance\components\models;

use Yii;
use yii\base\Model;
use common\models\finance\Receipt;
use common\models\system\Rstl;
use common\models\finance\Accountingcodemapping;

/**
 * OrderofpaymentSearch represents the model behind the search form about `common\models\finance\Orderofpayment`.
 */
class Ext_Receipt extends Receipt
{
    public $or;
    
    public function rules()
    {
        return [ 
            [['rstl_id', 'terminal_id', 'orderofpayment_id', 'or_number','deposit_type_id', 'receiptDate', 'payment_mode_id', 'payor', 'collectiontype_id', 'total', 'cancelled','or_series_id'], 'required'],
            [['rstl_id', 'terminal_id', 'orderofpayment_id', 'deposit_type_id', 'payment_mode_id', 'collectiontype_id', 'cancelled', 'deposit_id','or_series_id'], 'integer'],
            [['receiptDate'], 'safe'],
            [['total'], 'number'],
            [['or_number'], 'string', 'max' => 50],
            [['payor'], 'string', 'max' => 100],
            [['rstl_id', 'or_number'], 'unique', 'targetAttribute' => ['rstl_id', 'or_number']],
              [['or'], 'safe'],
            
        ];
    }
    
    public function getRstl()
    {
       return $this->hasOne(Rstl::className(), ['rstl_id' => 'rstl_id']);
    }
    
     public function getAccountingcodemap()
    {
       return $this->hasOne(Accountingcodemapping::className(), ['collectiontype_id' => 'collectiontype_id']);
    }
}
?>