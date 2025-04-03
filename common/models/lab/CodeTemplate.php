<?php

namespace common\models\lab;

use Yii;

/**
 * This is the model class for table "tbl_code_template".
 *
 * @property int $code_template_id
 * @property int $rstl_id
 * @property string $request_code_template
 * @property string $sample_code_template
 * @property int $generate_mode
 */
class CodeTemplate extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_code_template';
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
            [['rstl_id', 'request_code_template', 'sample_code_template'], 'required'],
            [['rstl_id','generate_mode'], 'integer'],
            [['request_code_template', 'sample_code_template'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'code_template_id' => 'Code Template ID',
            'rstl_id' => 'Rstl ID',
            'request_code_template' => 'Request Code Template',
            'sample_code_template' => 'Sample Code Template',
            'generate_mode'=>'Generate Mode'
        ];
    }
}
