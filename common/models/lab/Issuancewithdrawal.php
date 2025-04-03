<?php

namespace common\models\lab;

use Yii;

/**
 * This is the model class for table "tbl_issuancewithdrawal".
 *
 * @property int $issuancewithdrawal_id
 * @property string $document_code
 * @property string $title
 * @property string $rev_no
 * @property string $copy_holder
 * @property string $copy_no
 * @property string $issuance
 * @property string $withdrawal
 * @property string $date
 * @property string $name
 */
class Issuancewithdrawal extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_issuancewithdrawal';
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
            [['document_code', 'title', 'rev_no', 'copy_holder', 'copy_no', 'issuance', 'withdrawal', 'date', 'name'], 'required'],
            [['date'], 'safe'],
            [['document_code', 'title', 'rev_no', 'copy_holder', 'copy_no', 'issuance', 'withdrawal', 'name'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'issuancewithdrawal_id' => 'Issuancewithdrawal ID',
            'document_code' => 'Document Code',
            'title' => 'Title',
            'rev_no' => 'Rev No',
            'copy_holder' => 'Copy Holder',
            'copy_no' => 'Copy No',
            'issuance' => 'Issuance',
            'withdrawal' => 'Withdrawal',
            'date' => 'Date',
            'name' => 'Name',
        ];
    }
}
