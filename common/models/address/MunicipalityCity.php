<?php

namespace common\models\address;

use Yii;

/**
 * This is the model class for table "tbl_municipality_city".
 *
 * @property int $municipality_city_id
 * @property int $province_id
 * @property string $citymun_code
 * @property string $psgc_code
 * @property string $citymun_desc
 * @property string $reg_desc
 * @property string $district
 *
 * @property Barangay[] $barangays
 * @property Province $province
 */
class MunicipalityCity extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_municipality_city';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('addressdb');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['province_id'], 'required'],
            [['province_id'], 'integer'],
            [['citymun_desc'], 'string'],
            [['citymun_code', 'psgc_code', 'reg_desc'], 'string', 'max' => 255],
            [['district'], 'string', 'max' => 2],
            [['province_id'], 'exist', 'skipOnError' => true, 'targetClass' => Province::className(), 'targetAttribute' => ['province_id' => 'province_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'municipality_city_id' => 'Municipality City ID',
            'province_id' => 'Province ID',
            'citymun_code' => 'Citymun Code',
            'psgc_code' => 'Psgc Code',
            'citymun_desc' => 'Citymun Desc',
            'reg_desc' => 'Reg Desc',
            'district' => 'District',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBarangays()
    {
        return $this->hasMany(Barangay::className(), ['municipality_city_id' => 'municipality_city_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProvince()
    {
        return $this->hasOne(Province::className(), ['province_id' => 'province_id']);
    }
}
