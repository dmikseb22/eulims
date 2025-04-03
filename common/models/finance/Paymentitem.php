<?php

namespace common\models\finance;

use Yii;
use frontend\modules\finance\components\models\Ext_Request;

/**
 * This is the model class for table "tbl_paymentitem".
 *
 * @property int $paymentitem_id
 * @property int $rstl_id
 * @property int $request_id
 * @property int $request_type_id
 * @property int $orderofpayment_id
 * @property string $details
 * @property double $amount
 * @property int $cancelled
 * @property int $status
 * @property int $receipt_id
 *
 * @property Orderofpayment $orderofpayment
 * @property Receipt $receipt 
 */
class Paymentitem extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_paymentitem';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('financedb');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['rstl_id', 'request_id', 'orderofpayment_id', 'details', 'amount','request_type_id'], 'required'],
            [['rstl_id', 'request_id','receipt_id', 'request_type_id', 'orderofpayment_id', 'cancelled', 'status'], 'integer'],
            [['amount'], 'number','max' =>$this->maxValue()],
           // [['amount'], 'maxValueValidation'],
            [['details'], 'string', 'max' => 50],
            [['orderofpayment_id'], 'exist', 'skipOnError' => true, 'targetClass' => Op::className(), 'targetAttribute' => ['orderofpayment_id' => 'orderofpayment_id']],
            [['receipt_id'], 'exist', 'skipOnError' => true, 'targetClass' => Receipt::className(), 'targetAttribute' => ['receipt_id' => 'receipt_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'paymentitem_id' => 'Paymentitem ID',
            'rstl_id' => 'Rstl ID',
            'request_id' => 'Request ID',
            'request_type_id' => 'Request Type',
            'orderofpayment_id' => 'Orderofpayment ID',
            'details' => 'Details',
            'amount' => 'Amount',
            'cancelled' => 'Cancelled',
            'status' => 'Status',
            'receipt_id' => 'Receipt ID', 
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderofpayment()
    {
        return $this->hasOne(Op::className(), ['orderofpayment_id' => 'orderofpayment_id']);
    }
    /**
    * @return \yii\db\ActiveQuery
    */
   public function getReceipt()
   {
       return $this->hasOne(Receipt::className(), ['receipt_id' => 'receipt_id']);
   }
   
   public function getRequest()
   {
       return $this->hasOne(Ext_Request::className(), ['request_id' => 'request_id']);
   }
   
   /*public function maxValueValidation()
    {
        if($this->amount > $this->maxValue())
        {
             $this->addError('amount','Amount is too big. Maximum value allowed is '.$this->maxValue());
             //$this->addError($attribute, 'The country must be either "USA" or "Indonesia".');
        }
    }*/

    public function maxValue()
    {
        if($this->request_id){
            $req_id=$this->request_id;
            $request= Ext_Request::find()->where(['request_id' => $req_id])->one();
            $total=$request['total'];
            $balance=$request->getBalance($req_id,$total);
            return $balance;
        }
        
    }
    
    
}
