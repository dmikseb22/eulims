<?php

namespace common\models\lab;

use Yii;

/**
 * This is the model class for table "tbl_documentcontrol_config".
 *
 * @property int $documentcontrolconfig_id
 * @property string $dcf
 * @property string $year
 * @property string $custodian
 * @property string $approved
 */
class Documentcontrolconfig extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_documentcontrol_config';
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
            [['dcf', 'year', 'custodian', 'approved'], 'required'],
            [['dcf', 'year', 'custodian', 'approved'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'documentcontrolconfig_id' => 'Documentcontrolconfig ID',
            'dcf' => 'Dcf',
            'year' => 'Year',
            'custodian' => 'Custodian',
            'approved' => 'Approved',
        ];
    }
}
