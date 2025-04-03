<?php

namespace common\models\oldreferral;

use Yii;

/**
 * This is the model class for table "discount".
 *
 * @property int $id
 * @property string $type
 * @property double $rate
 * @property int $status
 */
class Discount extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'discount';
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
            [['type', 'rate', 'status'], 'required'],
            [['rate'], 'number'],
            [['status'], 'integer'],
            [['type'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'rate' => 'Rate',
            'status' => 'Status',
        ];
    }
}
