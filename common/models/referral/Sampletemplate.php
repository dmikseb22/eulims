<?php

namespace common\models\referral;

use Yii;

/**
 * This is the model class for table "tbl_sampletemplate".
 *
 * @property int $sampletemplate_id
 * @property string $samplename
 * @property string $description
 */
class Sampletemplate extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_sampletemplate';
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
            [['samplename', 'description'], 'required'],
            [['description'], 'string'],
            [['samplename'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'sampletemplate_id' => 'Sampletemplate ID',
            'samplename' => 'Samplename',
            'description' => 'Description',
        ];
    }
}
