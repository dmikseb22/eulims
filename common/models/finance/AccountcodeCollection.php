<?php



namespace common\models\finance;

use yii\base\Model;

/**
 * Description of AccountcodeCollection
 *
 * @author mariano
 */
class AccountcodeCollection Extends Model
{
    //put your code here
    public $accountcode;
    public $natureofcollection;
    
    public function attributeLabels()
    {
        return [
            
            'accountcode' => 'Account Code',
            'natureofcollection' => 'Collection Type'
           
          
        ];
    }
}




