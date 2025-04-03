<?php

namespace common\models\referral;

use Yii;

/**
 * This is the model class for table "tbl_pstc".
 *
 * @property int $pstc_id
 * @property int $agency_id
 * @property string $name
 */
class Pstc extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_pstc';
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
            [['agency_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'pstc_id' => 'Pstc ID',
            'agency_id' => 'Agency ID',
            'name' => 'Name',
        ];
    }
}
