<?php

namespace common\modules\message\controllers;

use common\modules\message\models\Contacts;
use Yii;
use common\modules\message\models\Chat;
use common\modules\message\models\ChatSearch;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use common\modules\message\models\ChatAttachment;
use yii\web\UploadedFile;
use common\modules\message\models\ChatGroup;
use common\modules\message\models\GroupMember;
use common\models\system\LoginForm;
/**
 * ChatController implements the CRUD actions for Chat model.
 */
class ChatController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Chat models.
     * @return mixed
     */
    public function actionIndex()
    {
		$session = Yii::$app->session;
		if(isset($_SESSION['usertoken'])){
			//echo "sadasf";
			$token=$_SESSION['usertoken'];
			 $searchModel = new ChatSearch();
			//$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
			$query = $this->Getallmessage();
			$dataProvider = New ActiveDataProvider(['query'=>$query]);

			$queryGroup = $this->GetallGC();
			$dataProviderGrp = New ActiveDataProvider(['query'=>$queryGroup]);
			
			$file= new ChatAttachment();
			$chat=new Chat();
			if ($chat->load(Yii::$app->request->post()) and $file->load(Yii::$app->request->post())) {
				$sds = UploadedFile::getInstance($file, 'filename');

				//save message
				$contact = Contacts::find()->where(['contact_id'=>$chat->sender_userid])->one();
				$contact_id=$contact->user_id;
				$str_total = explode(',', $contact_id);
				$arr_length = count($str_total); 
				$receiverid="";
				for($i=0;$i<$arr_length;$i++){
					 if(Yii::$app->user->id != $str_total[$i]){
						$receiverid= $str_total[$i];
					 }
				}
				$chat->reciever_userid=$receiverid;
				/////////////////////////////////////////////////////////
				$chat->contact_id=$chat->sender_userid;
				$chat->sender_userid= Yii::$app->user->id;
				$chat->status_id=1;//sent
				$chat->message=$chat->message;
				$chat->save();
				//end of save message-----
				
				//for file attachment
				if (!empty($sds) && $sds !== 0) {                
					$sds->saveAs('uploads/message/' . $chat->chat_id.'.'.$sds->extension);
					$file->filename ='uploads/message/'.$chat->chat_id.'.'.$sds->extension;
					
					$this->Saveattachment($file->filename,$chat->contact_id);
				}
				
				//end
				
				Yii::$app->session->setFlash('success', 'Message Sent!'); 
				return $this->redirect(['/message/chat/index']);
				
			}else{ */
				
				
				return $this->render('index', [
				'searchModel' => $searchModel,
				'dataProvider' => $dataProvider,
				'dataProviderGrp'=>$dataProviderGrp,
				'file'=>$file,
				'chat'=>$chat,
				'token'=>$token
				]);
			//}
		}else{
			$model = new LoginForm();
			if ($model->load(Yii::$app->request->post())){
				//echo $model->email;
				//echo $model->password;
				
			}else{
				return $this->render('login', [
				'model' => $model
				]);
			}	
		} 
    }

/*    Public function actionView($sendId){
        $searchmodel = new ChatSearch();
        $query = Chat::find()->where(['reciever_userid' => Yii::$app->user->id, 'sender_userid' => $sendId])
                            ->orderBy('timestamp');
        
		$dataProvider = New ActiveDataProvider(['query' => $query]);
        return $this->render('index',[
            'searchModel' => $searchmodel,
            'dataProvider' => $dataProvider,
        ]);
    }*/

    /**
     * Displays a single Chat model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($sendId)
    {
        return $this->render('view', [
            'model' => $this->findModel($sendId),
        ]);
    }

    /**
     * Creates a new Chat model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
		/*$session = Yii::$app->session;
		$session->set('language', 'en-US');
		
		$language = $session->get('language');
		$language = $session['language'];
		$language = isset($_SESSION['language']) ? $_SESSION['language'] : null;
		
		echo $language;*/
        $model = new Chat();
       
        $possible_recipients = Chat::getPossibleRecipients();
		$recipients=ArrayHelper::map($possible_recipients, 'id', 'username');
        if ($model->load(Yii::$app->request->post())) {
	
			$userid=Yii::$app->user->id;
			$recipientid=$model->reciever_userid; //ibahin
		
			$arr = [$userid,$recipientid];
			sort($arr);
			$str = implode(",", $arr); 
			
			$contact = Contacts::find()->where(['user_id'=>$str])->one();
			
			$id="";   
			if (!$contact){
			
				$convo= new Contacts();
				$convo->user_id=$str;
				$convo->save(false);
				$id=$convo->contact_id;
			}else{
				$id=$contact->contact_id;
			}
			//Send message
			$model->sender_userid= Yii::$app->user->id;
			$model->status_id=1;//sent
			$model->contact_id=$id;
			$model->save(false); 
			
			//////
			
			Yii::$app->session->setFlash('success', 'Message Sent!');
            return $this->redirect(['/message/chat/index']);
        } else {
            return $this->render('create', [
                'model' => $model,
				'possible_recipients' => $recipients,
            ]);
        } 
		
    }

    /**
     * Updates an existing Chat model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->chat_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Chat model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Chat model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Chat the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Chat::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	
	public function Getallmessage(){
		$query = Chat::find()
                            ->select(['contact_id','message','sender_userid','status_id'])
                            ->andWhere(['or',
                                ['sender_userid'=>Yii::$app->user->id]
                            ])
							->groupBy('contact_id')
                            ->orderBy(['timestamp'=>SORT_DESC]);
		return $query;					
	}
    Public function GetallGC(){
        $queryGroup = ChatGroup::find()->select(['chat_group_id', 'group_name']);
        return $queryGroup;
    }
    public function actionGetSearchMessage($id){
        $query = Chat::find()
            ->select(['contact_id','message','sender_userid','status_id'])
            ->andWhere(['or',
                ['like', 'message', $id. '%', false],
                ['sender_userid'=>Yii::$app->user->id]
            ])
            ->limit(6)
            ->groupBy('contact_id')
            ->orderBy(['timestamp'=>SORT_DESC]);

        $dataProvider = New ActiveDataProvider(['query'=>$query]);
        if(Yii::$app->request->isAjax){
        return $this->render('index', [
            'dataProvider' => $dataProvider
        ]);}
    }
	
	public function actionGetsendermessage($id)
    {
		$query = Chat::find()
							->andWhere(['or',
								   ['contact_id'=>$id]
							   ])
                            ->orderBy('timestamp');

        Chat::updateAll(['status_id' => 2],  ['contact_id' => $id, 'status_id' => 1]);
		$dataProvider = New ActiveDataProvider(['query' => $query]);
        header("Refresh:0; url=index.php");

        if(Yii::$app->request->isAjax){
			//return $id;
			return $this->renderAjax('convo_view', ['dataProvider'=>$dataProvider]);
        }

	}
    public function actionGetGCmessage($gcid, $id)
    {
        $query = Chat::find()
            ->andWhere(['or',
                ['group_id'=>$gcid]
            ])
            ->orderBy('timestamp');

        Chat::updateAll(['status_id' => 2],  ['contact_id' => $id, 'status_id' => 1, 'group_id'=> $gcid]);
        $dataProvider = New ActiveDataProvider(['query' => $query]);
        header("Refresh:0; url=index.php");

        if(Yii::$app->request->isAjax){
            //return $id;
            return $this->renderAjax('convo_view', ['dataProvider'=>$dataProvider]);
        }

    }
	
	public function Sendmessage($senderid,$message,$contactid)
    {
		$model = new Chat();
		$model->sender_userid= Yii::$app->profile->id;
		//$model->reciever_userid= $senderid; //
		$model->status_id=1;//sent
        $arr = [Yii::$app->user->id,$senderid];
        sort($arr);
        $str = implode(",", $arr);
        $contact = Contacts::find()->where(['user_id'=>$str])->one();
        if($contact !=null) {
            $model->contact_id = $contact->user_id;
        }
        $model->message=$message;
		$model->save();
		return;
	}
	
	public function Saveattachment($filename,$id)
    {
		$model = new ChatAttachment();
		$model->uploadedby_userid= Yii::$app->user->id;
		$model->filename= $filename; 
		$model->contact_group_id=$id;
		$model->save(); 
		return ;
	}
	
	 public function actionGroup()
    {
	    $model = new ChatGroup();
		$user = new Yii::$app->controller->module->userModelClass;
		$possible_recipients = $user::find();
        $possible_recipients->where(['!=', 'user_id', Yii::$app->user->id]);
		$dataProvider = New ActiveDataProvider(['query'=>$possible_recipients]);
		
		if ($model->load(Yii::$app->request->post())) {
			
			//echo "Lost in your Light";
			$userids=$model->userids;
			$str_user = explode(',', $userids);
			$arr_length = count($str_user);
			$model->createdby_userid=Yii::$app->user->id;
			$model->save();
			
			for($i=0;$i<$arr_length;$i++){
				$member= new GroupMember();
				$member->chat_group_id = $model->chat_group_id;
				$member->user_id=$str_user[$i];
				$member->save();
			}
			Yii::$app->session->setFlash('success', 'Successfully created!');
            return $this->redirect(['/message/chat/index']);
			
		}
		else{
			return $this->renderAjax('group', [
			'model' => $model,
			'possible_recipients' => $dataProvider,
			]);
		}
		
        
    }
	
	public function actionSettoken($token)
    {
		$session = Yii::$app->session;
		
		$session->set('usertoken', $token);
		return;
	}	
    public function beforeAction($action) 
	{ 
		$this->enableCsrfValidation = false; 
		return parent::beforeAction($action); 
	}	
	

}
