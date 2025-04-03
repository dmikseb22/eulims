<?php

namespace app\models;

use Yii;
use \app\models\base\TblTestcategory as BaseTblTestcategory;

/**
 * This is the model class for table "tbl_testcategory".
 */
class TblTestcategory extends BaseTblTestcategory
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['category_name', 'lab_id'], 'required'],
            [['lab_id'], 'integer'],
            [['category_name'], 'string', 'max' => 200],
            [['lock'], 'default', 'value' => '0'],
            [['lock'], 'mootensai\components\OptimisticLockValidator']
        ]);
    }
	
}
