<?php

namespace common\models\system;

use Yii;

/**
 * This is the model class for table "tbl_rstl_details".
 *
 * @property int $id
 * @property int $rstl_id
 * @property string $name
 * @property string $address
 * @property string $contacts
 * @property string $shortName
 * @property string $labName
 * @property string $labtypeShort
 * @property string $description
 * @property string $website
 *
 * @property Rstl $rstl
 */
class RstlDetails extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_rstl_details';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['rstl_id', 'name', 'address', 'contacts', 'shortName', 'labName', 'labtypeShort', 'description'], 'required'],
            [['rstl_id'], 'integer'],
            [['contacts', 'description'], 'string'],
            [['name', 'website'], 'string', 'max' => 200],
            [['address', 'labName'], 'string', 'max' => 255],
            [['shortName'], 'string', 'max' => 15],
            [['labtypeShort'], 'string', 'max' => 5],
            [['rstl_id'], 'unique'],
            [['rstl_id'], 'exist', 'skipOnError' => true, 'targetClass' => Rstl::className(), 'targetAttribute' => ['rstl_id' => 'rstl_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'rstl_id' => 'Rstl ID',
            'name' => 'Name',
            'address' => 'Address',
            'contacts' => 'Contacts',
            'shortName' => 'Short Name',
            'labName' => 'Lab Name',
            'labtypeShort' => 'Labtype Short',
            'description' => 'Description',
            'website' => 'Website',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRstl()
    {
        return $this->hasOne(Rstl::className(), ['rstl_id' => 'rstl_id']);
    }
}
