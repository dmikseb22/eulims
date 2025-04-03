<?php

namespace common\models\address;

use Yii;

/**
 * This is the model class for table "tbl_province".
 *
 * @property int $province_id
 * @property int $region_id
 * @property string $psgc_code
 * @property string $prov_desc
 * @property string $reg_code
 * @property string $prov_code
 *
 * @property Barangay[] $barangays
 * @property MunicipalityCity[] $municipalityCities
 * @property Region $region
 */
class Province extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_province';
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
            [['region_id'], 'required'],
            [['region_id'], 'integer'],
            [['prov_desc'], 'string'],
            [['psgc_code', 'reg_code', 'prov_code'], 'string', 'max' => 255],
            [['region_id'], 'exist', 'skipOnError' => true, 'targetClass' => Region::className(), 'targetAttribute' => ['region_id' => 'region_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'province_id' => 'Province ID',
            'region_id' => 'Region ID',
            'psgc_code' => 'Psgc Code',
            'prov_desc' => 'Prov Desc',
            'reg_code' => 'Reg Code',
            'prov_code' => 'Prov Code',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBarangays()
    {
        return $this->hasMany(Barangay::className(), ['province_id' => 'province_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMunicipalityCities()
    {
        return $this->hasMany(MunicipalityCity::className(), ['province_id' => 'province_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRegion()
    {
        return $this->hasOne(Region::className(), ['region_id' => 'region_id']);
    }
}
