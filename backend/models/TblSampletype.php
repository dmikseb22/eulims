<?php

namespace app\models;

use Yii;
use \app\models\base\TblSampletype as BaseTblSampletype;

/**
 * This is the model class for table "tbl_sampletype".
 */
class TblSampletype extends BaseTblSampletype
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['sample_type', 'test_category_id'], 'required'],
            [['test_category_id'], 'integer'],
            [['sample_type'], 'string', 'max' => 75],
            [['lock'], 'default', 'value' => '0'],
            [['lock'], 'mootensai\components\OptimisticLockValidator']
        ]);
    }
	
}
