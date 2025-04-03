<?php
/**
 * Created by PhpStorm.
 * User: OneLab
 * Date: 22/05/2020
 * Time: 08:50
 */

namespace common\modules\message\models;

use Yii;
/**
 * This is the model class for table "tbl_chat".
 *
 * @property int $contact_id
 * @property string $user_id
 * @property string $timestamp
 *
 * @property Contacts[] $Contact
 */

class Contacts extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'tbl_contacts';
    }

    public static function getDb()
    {
        return Yii::$app->get('messagedb');
    }

    public function rules()
    {
        return [
            [['contact_id', 'user_id'], 'required'],
            [['contact_id'], 'integer'],
            [['user_id'], 'string'],
            [['timestamp'], 'safe'],

        ];
    }

    public function attributeLabels()
    {
        return [
            'contact_id' => 'Contact ID',
            'user_id' => 'User ID',
            'timestamp' => 'Timestamp',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContact()
    {
        return $this->hasMany(Contacts::className(), ['contact_id' => 'contact_id']);
    }

}