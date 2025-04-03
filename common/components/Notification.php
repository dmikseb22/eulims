<?php
//EGG
namespace common\components;

use Yii;
use linslin\yii2\curl;
use yii\base\Component;
use common\models\lab\Customer;

class Notification extends Component {
    
    public function sendSMS($hash, $sender, $recipient, $title, $message, $via, $module, $action)
    {
        $url='https://api.dost9.ph/sms/messages';
                   
        $curl = new curl\Curl();
        
        $response = $curl->setPostParams([
            'hash' => $hash, 
            'sender' => $sender, 
            'recipient' => $recipient, 
            'title' => $title, 
            'message' => $message, 
            'via' => $via, 
            'module' => $module, 
            'action' => $action
         ])
         ->post($url);
		 
		 return $response;
    }
    
	
	public function sendEmail($email,$refnum)
    {
		//$email='gallenoeden09@gmail.com';
        //get the customer profile using the email
        $customer = Customer::find()->where(['email'=>$email])->one();
        // Validate email
		if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
			 if($customer){
				//check if the customer has an account already
				//contruct the html content to be mailed to the customer
				$content ="
				<h1>Good day! $customer->customer_name</h1>

				<p>Your test report for reference#: ".$refnum." is ready and available for pick-up</p>

				<br>
				<p>Truly yours,</p>
				<h4>Onelab Team</h4>
				";

				//email the customer now
				//send the code to the customer's email
				\Yii::$app->mailer->compose()
				->setFrom('eulims.onelab@gmail.com')
				->setTo($email)
				->setSubject('Eulims')
				->setTextBody('Plain text content')
				->setHtmlBody($content)
				->send();

				return ([
					'success' => true,
					'message' => 'Code successfully sent to customer\'s email',
				]); 
			}
		}
        else{
            return ([
                'success' => false,
                'message' => 'Email is not a valid customer',
            ]); 
        }
	}
	
	
}