<?php

namespace frontend\modules\reports\modules\models;

use Yii;

/**
 * This is the model class for table "tbl_accomplishment_overall".
 *
 * @property int $yeardata
 * @property string $indicator
 * @property string $indicator_desc
 * @property string $type
 * @property string $total
 * @property string $totalrstl
 * @property string $totalrdi
 * @property string $region1
 * @property string $region2
 * @property string $region3
 * @property string $region4
 * @property string $region4L1
 * @property string $region4L2
 * @property string $region4L3
 * @property string $region4L4
 * @property string $region4b
 * @property string $region5
 * @property string $region6
 * @property string $region7
 * @property string $region8
 * @property string $region9
 * @property string $region10
 * @property string $region11
 * @property string $region12
 * @property string $region12L1
 * @property string $region12L2
 * @property string $caraga
 * @property string $car
 * @property string $barmm
 * @property string $itdi
 * @property string $fprdi
 * @property string $fnri
 * @property string $mirdc
 * @property string $pnri
 * @property string $ptri
 */
class AccomplishmentOverallRealtime extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_accomplishment_overall';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('realtimedb');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['yeardata'], 'integer'],
            [['indicator', 'type'], 'string', 'max' => 90],
            [['indicator_desc'], 'string', 'max' => 600],
            [['total', 'totalrstl', 'totalrdi', 'region1', 'region2', 'region3', 'region4', 'region4L1', 'region4L2', 'region4L3', 'region4L4', 'region4b', 'region5', 'region6', 'region7', 'region8', 'region9', 'region10', 'region11', 'region12', 'region12L1', 'region12L2', 'caraga', 'car', 'barmm', 'itdi', 'fprdi', 'fnri', 'mirdc', 'pnri', 'ptri'], 'string', 'max' => 60],
        ];
    }
    
    public static function primaryKey()
    {
        return ['id'];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'yeardata' => 'Yeardata',
            'indicator' => 'Indicator',
            'indicator_desc' => 'Indicator Desc',
            'type' => 'Type',
            'total' => 'Total',
            'totalrstl' => 'Totalrstl',
            'totalrdi' => 'Totalrdi',
            'region1' => 'Region1',
            'region2' => 'Region2',
            'region3' => 'Region3',
            'region4' => 'Region4',
            'region4L1' => 'Region4 L1',
            'region4L2' => 'Region4 L2',
            'region4L3' => 'Region4 L3',
            'region4L4' => 'Region4 L4',
            'region4b' => 'Region4b',
            'region5' => 'Region5',
            'region6' => 'Region6',
            'region7' => 'Region7',
            'region8' => 'Region8',
            'region9' => 'Region9',
            'region10' => 'Region10',
            'region11' => 'Region11',
            'region12' => 'Region12',
            'region12L1' => 'Region12 L1',
            'region12L2' => 'Region12 L2',
            'caraga' => 'Caraga',
            'car' => 'Car',
            'barmm' => 'Barmm',
            'itdi' => 'Itdi',
            'fprdi' => 'Fprdi',
            'fnri' => 'Fnri',
            'mirdc' => 'Mirdc',
            'pnri' => 'Pnri',
            'ptri' => 'Ptri',
        ];
    }
}
