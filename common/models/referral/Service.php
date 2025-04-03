<?php

namespace common\models\referral;

use Yii;

/**
 * This is the model class for table "tbl_service".
 *
 * @property int $service_id
 * @property int $agency_id
 * @property int $method_ref_id
 * @property int $offered_date
 */
class Service extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_service';
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
            [['agency_id', 'method_ref_id', 'offered_date'], 'required'],
            [['agency_id', 'method_ref_id', 'offered_date'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'service_id' => 'Service ID',
            'agency_id' => 'Agency ID',
            'method_ref_id' => 'Method Ref ID',
            'offered_date' => 'Offered Date',
        ];
    }
}
