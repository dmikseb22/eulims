<?php

namespace common\models\referral;

use Yii;

/**
 * This is the model class for table "tbl_industrytype".
 *
 * @property integer $industrytype_id
 * @property string $industry
 *
 * @property Customer[] $customers
 */
class Industrytype extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_industrytype';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('refferaldb');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['industry'], 'required'],
            [['industry'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'industrytype_id' => 'Industrytype ID',
            'industry' => 'Industry',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomers()
    {
        return $this->hasMany(Customer::className(), ['industrytype_id' => 'industrytype_id']);
    }
}
