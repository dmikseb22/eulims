<?php

namespace common\models\address;

use Yii;

/**
 * This is the model class for table "tbl_barangay".
 *
 * @property int $barangay_id
 * @property int $province_id
 * @property int $municipality_city_id
 * @property string $brgy_code
 * @property string $brgy_desc
 * @property string $reg_code
 * @property string $district
 *
 * @property Province $province
 * @property MunicipalityCity $municipalityCity
 */
class Barangay extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_barangay';
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
            [['province_id', 'municipality_city_id'], 'required'],
            [['province_id', 'municipality_city_id'], 'integer'],
            [['brgy_desc'], 'string'],
            [['brgy_code', 'reg_code'], 'string', 'max' => 255],
            [['district'], 'string', 'max' => 2],
            [['province_id'], 'exist', 'skipOnError' => true, 'targetClass' => Province::className(), 'targetAttribute' => ['province_id' => 'province_id']],
            [['municipality_city_id'], 'exist', 'skipOnError' => true, 'targetClass' => MunicipalityCity::className(), 'targetAttribute' => ['municipality_city_id' => 'municipality_city_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'barangay_id' => 'Barangay ID',
            'province_id' => 'Province ID',
            'municipality_city_id' => 'Municipality City ID',
            'brgy_code' => 'Brgy Code',
            'brgy_desc' => 'Brgy Desc',
            'reg_code' => 'Reg Code',
            'district' => 'District',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProvince()
    {
        return $this->hasOne(Province::className(), ['province_id' => 'province_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMunicipalityCity()
    {
        return $this->hasOne(MunicipalityCity::className(), ['municipality_city_id' => 'municipality_city_id']);
    }
}
