<?php

namespace common\models\referral;

use Yii;

/**
 * This is the model class for table "tbl_agencydetails".
 *
 * @property int $agencydetails_id
 * @property int $agency_id
 * @property string $name
 * @property string $address
 * @property string $contacts
 * @property string $short_name
 * @property string $lab_name
 * @property string $labtype_short
 * @property string $description
 */
class Agencydetails extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_agencydetails';
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
            [['agency_id', 'name', 'address', 'contacts', 'short_name', 'lab_name', 'labtype_short', 'description'], 'required'],
            [['agency_id'], 'integer'],
            [['contacts', 'description'], 'string'],
            [['name'], 'string', 'max' => 200],
            [['address', 'lab_name'], 'string', 'max' => 255],
            [['short_name'], 'string', 'max' => 15],
            [['labtype_short'], 'string', 'max' => 5],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'agencydetails_id' => 'Agencydetails ID',
            'agency_id' => 'Agency ID',
            'name' => 'Name',
            'address' => 'Address',
            'contacts' => 'Contacts',
            'short_name' => 'Short Name',
            'lab_name' => 'Lab Name',
            'labtype_short' => 'Labtype Short',
            'description' => 'Description',
        ];
    }
}
