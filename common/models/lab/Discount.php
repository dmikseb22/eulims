<?php

namespace common\models\lab;

use Yii;

/**
 * This is the model class for table "tbl_discount".
 *
 * @property integer $discount_id
 * @property string $type
 * @property string $rate
 * @property integer $status
 *
 * @property Request[] $requests
 */
class Discount extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
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
        return Yii::$app->get('labdb');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type'], 'required'],
            [['rate'], 'number'],
            [['status'], 'integer'],
            [['type'], 'string', 'max' => 25],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'discount_id' => 'Discount ID',
            'type' => 'Type',
            'rate' => 'Rate',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRequests()
    {
        return $this->hasMany(Request::className(), ['discount_id' => 'discount_id']);
    }
}
