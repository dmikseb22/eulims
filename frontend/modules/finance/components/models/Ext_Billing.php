<?php


namespace frontend\modules\finance\components\models;
use common\models\finance\Billing;
use common\models\finance\Receipt;
/**
 * Description of Ext_Billing
 *
 * @author OneLab
 */
class Ext_Billing extends Billing{
    public $OpIds;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'customer_id', 'billing_date', 'due_date'], 'required'],
            [['user_id', 'customer_id', 'receipt_id'], 'integer'],
            [['billing_date', 'due_date'], 'safe'],
            [['amount'], 'number'],
            ['amount', 'compare', 'compareValue' => 0, 'operator' => '>'],
            [['soa_number','invoice_number','OpIds'], 'string', 'max' => 100],
           // [['receipt_id'], 'exist', 'skipOnError' => true, 'targetClass' => Receipt::className(), 'targetAttribute' => ['receipt_id' => 'receipt_id']],
        ];
    }
    //put your code here
    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {
        // Place your custom code here
            //Get the last generated Primarykey
            $rstl=$GLOBALS['rstl_id'];
            $curYear=(int)date("Y");
            $LastBilling_id= $this->GetLastPrimaryKey()+1;
            $bi=$rstl.'-'.$curYear.'-'.$LastBilling_id;
            //11-2018-1
            $this->invoice_number=$bi;
            return true;
        } else {
            return false;
        }
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'billing_id' => 'Billing ID',
            'invoice_number' => 'Invoice #', 
            'user_id' => 'User',
            'customer_id' => 'Customer',
            'soa_number' => 'Soa Number',
            'billing_date' => 'Billing Date',
            'due_date' => 'Due Date',
            'receipt_id' => 'Receipt ID',
            'amount' => 'Amount',
        ];
    }
    /**
     * @description This function will get the last generated billing_id
     * @return integer
     */
    public function GetLastPrimaryKey(){
        $Connection=$this->getDb();
        $sql="SELECT IFNULL(MAX(billing_id),0) AS Max_ID FROM `tbl_billing`";
        $Command=$Connection->createCommand($sql);
        $Rows=$Command->queryOne();
        return (float)$Rows['Max_ID'];
    }
}
