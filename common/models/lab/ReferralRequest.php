<?php

namespace common\models\lab;

use Yii;

/**
 * This is the model class for table "tbl_referral_request"..
 *
 * @property int $referral_request_id
 * @property int $request_id
 * @property string $sample_receive_date
 * @property int $receiving_agency_id
 * @property int $testing_agency_id
 * @property int $referral_type_id
 */
class Referralrequest extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_referral_request';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('labdb');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['request_id', 'sample_received_date', 'referral_type_id'], 'required'],
            [['request_id', 'receiving_agency_id', 'testing_agency_id', 'referral_type_id'], 'integer'],
            [['sample_received_date'], 'safe'],
            [['request_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'referral_request_id' => 'Referral Request ID',
            'request_id' => 'Request ID',
            'sample_received_date' => 'Sample Received Date',
            'receiving_agency_id' => 'Receiving Agency ID',
            'testing_agency_id' => 'Testing Agency ID',
            'referral_type_id' => 'Referral Type ID',
        ];
    }
}
