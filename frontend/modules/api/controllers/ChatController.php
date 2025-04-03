<?php

namespace frontend\modules\api\controllers;

use Yii;

use common\models\system\LoginForm;
use common\models\system\Profile;
use common\models\system\User;

use common\models\system\Rstl;

use common\modules\message\models\Chat;


class ChatController extends \yii\rest\Controller
{
    
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => \sizeg\jwt\JwtHttpBearerAuth::class,
            'except' => ['login', 'server'],
            // 'user'=> [\Yii::$app->customeraccount,\Yii::$app->user]
        ];

        return $behaviors;
    }

    protected function verbs(){
        return [
            'login' => ['POST'],
            'logout' => ['POST'],
            'user' => ['GET'],
            'samplecode' => ['GET'],
            'analysis' => ['GET'],
           // 'server' => ['GET'],
             'data' => ['GET'],
        ];
    }

    /**
     * @return \yii\web\Response
     */
    public function actionLogin()
    {
            $model = new LoginForm();
            $my_var = \Yii::$app->request->post();
            $model->email = $my_var['email'];
            $model->password = $my_var['password'];
           
            if ($model->login()) {      
                $signer = new \Lcobucci\JWT\Signer\Hmac\Sha256();
                /** @var Jwt $jwt */
                $jwt = \Yii::$app->jwt;
                $token = $jwt->getBuilder()
                    ->setIssuer('http://example.com')// Configures the issuer (iss claim)
                    ->setAudience('http://example.org')// Configures the audience (aud claim)
                    ->setId('4f1g23a12aa', true)// Configures the id (jti claim), replicating as a header item
                    ->setIssuedAt(time())// Configures the time that the token was issue (iat claim)
                    ->setExpiration(time() + 3600 * 24)// Configures the expiration time of the token (exp claim)
                    ->set('uid', \Yii::$app->user->identity->user_id)// Configures a new claim, called "uid"
                    //->set('username', \Yii::$app->user->identity->username)// Configures a new claim, called "uid"
                    ->sign($signer, $jwt->key)// creates a signature using [[Jwt::$key]]
                    ->getToken(); // Retrieves the generated token
    
                    $users = User::find()->where(['LIKE', 'email', $my_var['email']])->one();
                    $profile = Profile::find()->where(['user_id'=>$users->user_id])->one();
                    $role = AuthAssignment::find()->where(['user_id'=>$users->user_id])->one();
        
                    return $this->asJson([
                        'token' => (string)$token,
                        'user'=> (['email'=>$users->email,
                                    'firstName'=>$profile->firstname,
                                    'middleInitial' => $profile->middleinitial,
                                    'lastname' => $profile->lastname,
                                    'type' => $role->item_name,]),
                    ]);
                } else {
                    return $this->asJson([
                        'success' => false,
                        'message' => 'Email and Password didn\'t match',
                    ]);
                }
    }

    public function actionUser()
    {  
        $user_id =\Yii::$app->user->identity->profile->user_id;
        $users = User::find()->where(['LIKE', 'user_id', $user_id])->one();
        $profile = Profile::find()->where(['user_id'=>$user_id])->one();
        $role = AuthAssignment::find()->where(['user_id'=>$users->user_id])->one();
        $signer = new \Lcobucci\JWT\Signer\Hmac\Sha256();
        /** @var Jwt $jwt */
        $jwt = \Yii::$app->jwt;
        $token = $jwt->getBuilder()
            ->setIssuer('http://example.com')// Configures the issuer (iss claim)
            ->setAudience('http://example.org')// Configures the audience (aud claim)
            ->setId('4f1g23a12aa', true)// Configures the id (jti claim), replicating as a header item
            ->setIssuedAt(time())// Configures the time that the token was issue (iat claim)
            ->setExpiration(time() + 3600 * 24)// Configures the expiration time of the token (exp claim)
            ->set('uid', \Yii::$app->user->identity->user_id)// Configures a new claim, called "uid"
            //->set('username', \Yii::$app->user->identity->username)// Configures a new claim, called "uid"
            ->sign($signer, $jwt->key)// creates a signature using [[Jwt::$key]]
            ->getToken(); // Retrieves the generated token
        return $this->asJson([
                'token' => (string)$token,
                'user'=> (['email'=>$users->email,
                'firstName'=>$profile->firstname,
                'middleInitial' => $profile->middleinitial,
                'lastname' => $profile->lastname,
                'type' => $role->item_name]),
                'user_id'=> $users->user_id
            ]);               
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLogout()
    {
        return $this->render('index');
    }

    /**
     * @return \yii\web\Response
     */
    public function actionData()
    {
        return $this->getuserid();
    }

    function getuserid(){
        $myvar = \Yii::$app->request->headers->get('Authorization');

        $rawToken = explode("Bearer ", $myvar);
        $rawToken = $rawToken[1];
        $token = \Yii::$app->jwt->getParser()->parse((string) $rawToken);
        return $token->getClaim('uid');
    }

     //************************************************
     public function actionServer(){

        $server = $_SERVER['SERVER_NAME'];
        if(!$sock = @fsockopen($server, 80))
            {
                $data = array("status" => "offline");
            }
            else
            {
                $data = array("status" => "online");
            }

           
        return $this->asJson($data);   
    }
	
	//************************************************

    public function actionSetMessage(){ //send message
        $my_var = \Yii::$app->request->post();


       if(!$my_var){
            return $this->asJson([
                'success' => false,
                'message' => 'POST empty',
            ]); 
       }
        //attributes Purpose, Sample Quantity, Sample type, Sample Name and Description, schedule date and datecreated
        $chat = new Chat();
        $chat->sender_userid = $my_var['sender_userid'];
        $chat->reciever_userid = $my_var['reciever_userid'];
        $chat->message= $my_var['message'];
        $chat->status_id=1;//sent
		$chat->contact_id=$my_var['contact_id'];
        if($chat->save()){
            return $this->asJson([
                'success' => true,
                'message' => 'Message Sent',
            ]); 
        }
        else{
            return $this->asJson([
                'success' => false,
                'message' => 'Message Failed',
            ]); 
        }
    }

}
