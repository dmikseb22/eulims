<?php

namespace common\models\finance;

use Yii;

/**
 * This is the model class for table "tbl_soa_billing".
 *
 * @property int $soa_billing_id
 * @property int $soa_id
 * @property int $billing_id
 *
 * @property Billing $billing
 * @property Soa $soa
 */
class SoaBilling extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_soa_billing';
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
            [['soa_id', 'billing_id'], 'required'],
            [['soa_id', 'billing_id'], 'integer'],
            [['billing_id'], 'exist', 'skipOnError' => true, 'targetClass' => Billing::className(), 'targetAttribute' => ['billing_id' => 'billing_id']],
            [['soa_id'], 'exist', 'skipOnError' => true, 'targetClass' => Soa::className(), 'targetAttribute' => ['soa_id' => 'soa_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'soa_billing_id' => 'Soa Billing ID',
            'soa_id' => 'Soa ID',
            'billing_id' => 'Billing ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBilling()
    {
        return $this->hasOne(Billing::className(), ['billing_id' => 'billing_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSoa()
    {
        return $this->hasOne(Soa::className(), ['soa_id' => 'soa_id']);
    }
}
