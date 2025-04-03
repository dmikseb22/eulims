<?php

namespace common\models\lab;

use Yii;
use yii\base\Model;
//use common\models\system\Profile;
use common\models\lab\Tagging;

/**
 * SampleregisterUser extended model of `common\models\lab\Tagging`.
 */
class SampleregisterUser extends Tagging
{
	
	/* public static function tableName()
    {
        return 'tbl_profile';
    }
    public static function getDb()
    {
        return \Yii::$app->db;  
    } */
	
    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }
	
	/* public function getUser()
    {
        return $this->hasOne(tableName(), ['tbl_profile.user_id' => 'user_id']);
    } */
	
	public static function getUser($userId)
	{
		//$params = [':userId' => $userId];

		$user = Yii::$app->db->createCommand('SELECT lastname, firstname, middleinitial 
							FROM eulims.tbl_profile profile INNER JOIN eulims_lab.tbl_tagging tagging
							ON tagging.user_id = profile.user_id
							WHERE tagging.user_id =:userId')
				   ->bindValues([':userId' => $userId])
				   ->queryOne();
		
		return $user['firstname']." ".((empty($user['middleinitial'])) ? "" : substr($user['middleinitial'], 0, 1).".")." ".$user['lastname'];
	}
}
