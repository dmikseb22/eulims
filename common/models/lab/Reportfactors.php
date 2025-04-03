<?php

namespace common\models\lab;

use Yii;
use common\models\lab\Factors;
/**
 * This is the model class for table "tbl_reportfactors".
 *
 * @property int $accompfactor_id
 * @property string $yearmonth
 * @property string $name
 * @property string $remarks
 * @property int $factor_id
 * @property int $lab_id 
 */
class Reportfactors extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_reportfactors';
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
            [['yearmonth', 'factor_id','name'], 'required'],
            [['factor_id', 'lab_id'], 'integer'],
            [['yearmonth'], 'string', 'max' => 10],
            [['name'], 'string', 'max' => 50],
            [['remarks'], 'string', 'max' => 200],
            [['factor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Factors::className(), 'targetAttribute' => ['factor_id' => 'factor_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'accompfactor_id' => 'Accompfactor ID',
            'yearmonth' => 'Yearmonth',
            'name' => 'Name',
            'remarks' => 'Remarks',
            'factor_id' => 'Factor ID',
             'lab_id' => 'Lab ID', 
        ];
    }

    public function getFactor()
    {
        return $this->hasOne(Factors::className(), ['factor_id' => 'factor_id']);
    }
}
