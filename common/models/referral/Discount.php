<?php

namespace common\models\referral;

use Yii;

/**
 * This is the model class for table "tbl_discount".
 *
 * @property int $discount_id
 * @property string $type
 * @property string $rate
 * @property int $active
 *
 * @property Referral[] $referrals
 */
class Discount extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_discount';
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
            [['type'], 'required'],
            [['rate'], 'number'],
            [['active'], 'integer'],
            [['type'], 'string', 'max' => 25],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'discount_id' => 'Discount ID',
            'type' => 'Type',
            'rate' => 'Rate',
            'active' => 'Active',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReferrals()
    {
        return $this->hasMany(Referral::className(), ['discount_id' => 'discount_id']);
    }
}
