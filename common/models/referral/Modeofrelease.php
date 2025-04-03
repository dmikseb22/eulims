<?php

namespace common\models\referral;

use Yii;

/**
 * This is the model class for table "tbl_modeofrelease".
 *
 * @property int $modeofrelease_id
 * @property string $mode
 * @property int $status
 *
 * @property Referral[] $referrals
 */
class Modeofrelease extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_modeofrelease';
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
            [['modeofrelease_id', 'mode', 'status'], 'required'],
            [['modeofrelease_id', 'status'], 'integer'],
            [['mode'], 'string', 'max' => 25],
            [['modeofrelease_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'modeofrelease_id' => 'Modeofrelease ID',
            'mode' => 'Mode',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReferrals()
    {
        return $this->hasMany(Referral::className(), ['modeofrelease_id' => 'modeofrelease_id']);
    }
}
