<?php

namespace common\models\lab;

use Yii;

/**
 * This is the model class for table "tbl_reportsummary".
 *
 * @property int $accomp_id
 * @property int $rstl_id
 * @property string $year
 * @property string $month
 * @property double $request
 * @property double $sample
 * @property double $test
 * @property double $actualfees
 * @property double $gratis
 * @property double $discount
 * @property double $gross
 */
class Reportsummary extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_reportsummary';
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
            [['rstl_id'], 'integer'],
            [['request', 'sample', 'test', 'actualfees', 'gratis', 'discount', 'gross'], 'number'],
            [['year'], 'string', 'max' => 4],
            [['month'], 'string', 'max' => 3],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'accomp_id' => 'Accomp ID',
            'rstl_id' => 'Rstl ID',
            'year' => 'Year',
            'month' => 'Month',
            'request' => 'Request',
            'sample' => 'Sample',
            'test' => 'Test',
            'actualfees' => 'Actualfees',
            'gratis' => 'Gratis',
            'discount' => 'Discount',
            'gross' => 'Gross',
        ];
    }
}
