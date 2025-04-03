<?php

namespace common\models\lab;

use Yii;

/**
 * This is the model class for table "tbl_factors".
 *
 * @property int $factor_id
 * @property string $title
 * @property int $type
 * @property string $rate
 * @property string $remarks
 */
class Factors extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_factors';
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
            [['title','type'], 'required'],
            [['type'], 'integer'],
            [['rate'], 'number'],
            [['title'], 'string', 'max' => 50],
            [['remarks'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'factor_id' => 'Factor ID',
            'title' => 'Title',
            'type' => 'Type',
            'rate' => 'Rate',
            'remarks' => 'Remarks',
        ];
    }
}
