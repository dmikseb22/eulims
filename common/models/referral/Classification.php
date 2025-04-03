<?php

namespace common\models\referral;

use Yii;

/**
 * This is the model class for table "tbl_classification".
 *
 * @property int $classification_id
 * @property string $classification
 */
class Classification extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_classification';
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
            [['classification'], 'required'],
            [['classification'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'classification_id' => 'Classification ID',
            'classification' => 'Classification',
        ];
    }
}
