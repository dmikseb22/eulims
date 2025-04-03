<?php


namespace common\models\finance;
use yii\data\SqlDataProvider;

use yii\base\Model;

class AccountcodeWithoutMapping extends Model
{
    public $accountcode;
    public $accountingcode_id;
    
    public function attributeLabels()
    {
        return [
             'accountingcode_id' => 'Account ID',
            'accountcode' => 'Account Code'
           
          
        ];
    }
    
    public function loadsp()
    {
        

        // add conditions that should always apply here

        $dataProvider = new SqlDataProvider([
    'sql' => 'Call spGetAccountCodeWithoutMapping'
                    ]);
        
        
        return $dataProvider;
    }
    
    
    
}

/* 
 * Project Name: eulims * 
 * Copyright(C)2018 Department of Science & Technology -IX * 
 * 05 22, 18 , 9:49:23 AM * 
 * Module: AccountcodeWithoutMapping * 
 */

