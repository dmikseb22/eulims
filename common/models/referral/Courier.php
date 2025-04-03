<?php

namespace common\models\referral;

use Yii;

/**
 * This is the model class for table "tbl_courier".
 *
 * @property int $courier_id
 * @property string $name
 * @property string $date_added
 *
 * @property Referraltrackreceiving[] $referraltrackreceivings
 * @property Referraltracktesting[] $referraltracktestings
 */
class Courier extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_courier';
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
            [['name'], 'required'],
            [['date_added'], 'safe'],
            [['name'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'courier_id' => 'Courier ID',
            'name' => 'Name',
            'date_added' => 'Date Added',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReferraltrackreceivings()
    {
        return $this->hasMany(Referraltrackreceiving::className(), ['courier_id' => 'courier_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReferraltracktestings()
    {
        return $this->hasMany(Referraltracktesting::className(), ['courier_id' => 'courier_id']);
    }
}
