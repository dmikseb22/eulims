<?php

namespace frontend\modules\lab\components\_class;
/**
 * 
 */
class Schedule
{
	public $id;
	public $title;
	public $start;
	public $end;
	public $textColor='#fff';
	public $backgroundColor='#777';
	public $status=0;

	public function setbgcolor(int $color){
		switch ($color) {
			case '1': //completed
				$this->backgroundColor='#3c8dbc';
				break;
			case '2': //ongoing
				$this->backgroundColor='#00a65a';
				break;
			case '3': //Critical
				$this->backgroundColor='#f39c12';
				break;
			case '4': //untouched
				$this->backgroundColor='#ac2925';
				break;
			case '5': //cancelled
				$this->backgroundColor='#333';
				break;
			default: //pending
				$this->backgroundColor='#777';
				break;
		}
	}


	public function knowthycolor(){
		//this function should be able to determine if the task is ahead or in past already and if the task has been worked out or nah
		//this function would call the setbgcolor

		$today =strtotime(date('Y-m-d'));
		if(!$this->start){
			return false;
		}

		if($today>strtotime($this->end)){
			//the test is past the Reccomended Max Storage
			//know if the test has been touched
			if($this->status==2)
				$this->setbgcolor(1);
			elseif($this->status==1)
				$this->setbgcolor(2);
			elseif($this->status==3)
				$this->setbgcolor(5);
			else
				$this->setbgcolor(4);
			return false;
		}

		if(($today>strtotime($this->start))&&($today<strtotime($this->end))){
			//the test is in critical
			//know if the test has been touched
			if($this->status==2)
				$this->setbgcolor(1);
			elseif($this->status==1)
				$this->setbgcolor(2);
			elseif($this->status==3)
				$this->setbgcolor(5);
			else
				$this->setbgcolor(3);

			return false;
		}


		if($today<strtotime($this->start)){
			//the test is in critical
			//know if the test has been touched
			if($this->status==2)
				$this->setbgcolor(1);
			elseif($this->status==1)
				$this->setbgcolor(2);
			elseif($this->status==3)
				$this->setbgcolor(5);
			else
				$this->setbgcolor(0);
			return false;
		}

		return true;

	}
}
?>