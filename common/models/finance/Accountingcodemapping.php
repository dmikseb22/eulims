<?php

namespace common\models\finance;

use Yii;

/**
 * This is the model class for table "tbl_accountingcodemapping".
 *
 * @property int $mapping_id
 * @property int $collectiontype_id
 * @property int $accountingcode_id
 * @property Accountingcode $accountingcode
 * @property Collectiontype $collectiontype
 */
class Accountingcodemapping extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_accountingcodemapping';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('financedb');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['accountingcode_id', 'collectiontype_id'], 'integer'],
            [['accountingcode_id', 'collectiontype_id'], 'unique', 'targetAttribute' => ['accountingcode_id', 'collectiontype_id']],
            [['accountingcode_id'], 'exist', 'skipOnError' => true, 'targetClass' => Accountingcode::className(), 'targetAttribute' => ['accountingcode_id' => 'accountingcode_id']],
            [['collectiontype_id'], 'exist', 'skipOnError' => true, 'targetClass' => Collectiontype::className(), 'targetAttribute' => ['collectiontype_id' => 'collectiontype_id']],
             [['accountingcode_id', 'collectiontype_id'], 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'mapping_id' => 'Mapping ID',
            'accountingcode_id' => 'Accountingcode ID',
            'collectiontype_id' => 'Collectiontype ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccountingcode()
    {
        return $this->hasOne(Accountingcode::className(), ['accountingcode_id' => 'accountingcode_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCollectiontype()
    {
        return $this->hasOne(Collectiontype::className(), ['collectiontype_id' => 'collectiontype_id']);
    }
}
