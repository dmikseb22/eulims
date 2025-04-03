<?php

namespace app\models;

use Yii;
use \app\models\base\TblTest as BaseTblTest;

/**
 * This is the model class for table "tbl_test".
 */
class TblTest extends BaseTblTest
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['agency_id', 'testname', 'method', 'references', 'duration', 'test_category_id', 'sample_type_id', 'lab_id'], 'required'],
            [['agency_id', 'duration', 'test_category_id', 'sample_type_id', 'lab_id'], 'integer'],
            [['fee'], 'number'],
            [['testname'], 'string', 'max' => 200],
            [['method'], 'string', 'max' => 150],
            [['references'], 'string', 'max' => 100],
            [['lock'], 'default', 'value' => '0'],
            [['lock'], 'mootensai\components\OptimisticLockValidator']
        ]);
    }
	
}
