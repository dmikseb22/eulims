<?php

namespace common\models\lab;

use Yii;

/**
 * This is the model class for table "tbl_documentcontrolindex".
 *
 * @property int $documentcontrolindex_id
 * @property string $dcf_no
 * @property string $document_code
 * @property string $title
 * @property string $rev_no
 * @property string $effectivity_date
 * @property string $dc
 */
class Documentcontrolindex extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_documentcontrolindex';
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
            [['dcf_no', 'document_code', 'title', 'rev_no', 'effectivity_date', 'dc'], 'required'],
            [['effectivity_date'], 'safe'],
            [['dcf_no', 'document_code', 'title', 'rev_no', 'dc'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'documentcontrolindex_id' => 'Documentcontrolindex ID',
            'dcf_no' => 'Dcf No',
            'document_code' => 'Document Code',
            'title' => 'Title',
            'rev_no' => 'Rev No',
            'effectivity_date' => 'Effectivity Date',
            'dc' => 'Dc',
        ];
    }
}
