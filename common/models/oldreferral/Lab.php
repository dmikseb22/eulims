<?php

namespace common\models\oldreferral;

use Yii;

/**
 * This is the model class for table "lab".
 *
 * @property int $id
 * @property string $labName
 * @property string $labCode
 */
class Lab extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lab';
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
            [['labName', 'labCode'], 'required'],
            [['labName'], 'string', 'max' => 50],
            [['labCode'], 'string', 'max' => 25],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'labName' => 'Lab Name',
            'labCode' => 'Lab Code',
        ];
    }
}
