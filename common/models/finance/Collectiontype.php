<?php

namespace common\models\finance;

use Yii;

/**
 * This is the model class for table "tbl_collectiontype".
 *
 * @property int $collectiontype_id
 * @property string $natureofcollection
 * @property int $status
 *
 * @property Accountingcodemapping[] $accountingcodemappings
 * @property Accountingcode[] $accountingcodes
 * @property Orderofpayment[] $orderofpayments
 * @property Receipt[] $receipts
 */
class Collectiontype extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_collectiontype';
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
            [['status'], 'integer'],
            [['natureofcollection'], 'string', 'max' => 50],
            [['natureofcollection'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'collectiontype_id' => 'Collectiontype ID',
            'natureofcollection' => 'Collection Type',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccountingcodemappings()
    {
        return $this->hasMany(Accountingcodemapping::className(), ['collectiontype_id' => 'collectiontype_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccountingcodes()
    {
        return $this->hasMany(Accountingcode::className(), ['accountingcode_id' => 'accountingcode_id'])->viaTable('tbl_accountingcodemapping', ['collectiontype_id' => 'collectiontype_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderofpayments()
    {
        return $this->hasMany(Op::className(), ['collectiontype_id' => 'collectiontype_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReceipts()
    {
        return $this->hasMany(Receipt::className(), ['collectiontype_id' => 'collectiontype_id']);
    }
}
