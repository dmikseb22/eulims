<?php
namespace frontend\modules\referrals\template;
/**
 * 
 */

use Yii;
use yii\base\Model;

class Srchref extends Model
{
	public $referralCode;
	public $referralDate;
	public $rstl_id;
	public $datefrom;
	public $dateto;
	public $lab_id;

	function __construct()
	{
		$this->rstl_id = Yii::$app->user->identity->profile->rstl_id;
		$this->datefrom = date('Y-m')."-01";
		$this->dateto = date('Y-m-d');
	}
}
?>