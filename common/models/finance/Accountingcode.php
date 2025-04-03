<?php

namespace common\models\finance;

use Yii;

/**
 * This is the model class for table "tbl_accountingcode".
 *
 * @property int $accountingcode_id
 * @property string $accountcode
 * @property string $accountdesc
 *
 * @property Accountingcodemapping[] $accountingcodemappings
 * @property Collectiontype[] $collectiontypes
 */
class Accountingcode extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_accountingcode';
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
            [['accountcode'], 'string', 'max' => 50],
            [['accountdesc'], 'string', 'max' => 250],
            [['accountcode', 'accountdesc'], 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'accountingcode_id' => 'Accountingcode ID',
            'accountcode' => 'Accountcode',
            'accountdesc' => 'Accountdesc',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccountingcodemappings()
    {
        return $this->hasMany(Accountingcodemapping::className(), ['accountingcode_id' => 'accountingcode_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCollectiontypes()
    {
        return $this->hasMany(Collectiontype::className(), ['collectiontype_id' => 'collectiontype_id'])->viaTable('tbl_accountingcodemapping', ['accountingcode_id' => 'accountingcode_id']);
    }
}
