<?php

namespace common\models\referral;

use Yii;

/**
 * This is the model class for table "tbl_cancelledreferral".
 *
 * @property int $cancelledreferral_id
 * @property int $referral_id
 * @property string $reason
 * @property string $cancel_date
 * @property int $agency_id
 * @property int $cancelled_by
 *
 * @property Referral $referral
 */
class Cancelledreferral extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_cancelledreferral';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('referraldb');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['referral_id', 'reason', 'cancel_date', 'agency_id', 'cancelled_by'], 'required'],
            [['referral_id', 'agency_id', 'cancelled_by'], 'integer'],
            [['cancel_date'], 'safe'],
            [['reason'], 'string', 'max' => 500],
            [['referral_id'], 'exist', 'skipOnError' => true, 'targetClass' => Referral::className(), 'targetAttribute' => ['referral_id' => 'referral_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'cancelledreferral_id' => 'Cancelledreferral ID',
            'referral_id' => 'Referral ID',
            'reason' => 'Reason',
            'cancel_date' => 'Cancel Date',
            'agency_id' => 'Agency ID',
            'cancelled_by' => 'Cancelled By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReferral()
    {
        return $this->hasOne(Referral::className(), ['referral_id' => 'referral_id']);
    }
}
