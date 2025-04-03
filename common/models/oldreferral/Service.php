<?php

namespace common\models\oldreferral;

use Yii;

/**
 * This is the model class for table "service".
 *
 * @property int $id
 * @property int $agency_id
 * @property int $method_ref_id
 */
class Service extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'service';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('oldreferraldb');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['agency_id', 'method_ref_id'], 'required'],
            [['agency_id', 'method_ref_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'agency_id' => 'Agency ID',
            'method_ref_id' => 'Method Ref ID',
        ];
    }
}
