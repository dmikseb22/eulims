<?php

namespace common\models\referral;

use Yii;

/**
 * This is the model class for table "tbl_businessnature".
 *
 * @property integer $business_nature_id
 * @property string $nature
 *
 * @property Customer[] $customers
 */
class Businessnature extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_businessnature';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('referraldb');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nature'], 'required'],
            [['nature'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'business_nature_id' => 'Business Nature ID',
            'nature' => 'Nature',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomers()
    {
        return $this->hasMany(Customer::className(), ['business_nature_id' => 'business_nature_id']);
    }
}
