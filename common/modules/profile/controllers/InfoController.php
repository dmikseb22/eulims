<?php

namespace common\modules\profile\controllers;

use Yii;
use common\models\system\Profile;
use common\models\system\ProfileSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\helpers\Html;
use common\components\MyPDF;
use common\modules\profile\ProfileAsset;

/**
 * ProfileController implements the CRUD actions for Profile model.
 */
class InfoController extends Controller
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
    public function actions()
    {
        return [
            'uploadPhoto' => [
                'class' => 'budyaga\cropper\actions\UploadAction',
                'url' => 'http://admin.eulims.local/upload/user/photo',
                'path' => '@frontend/web/uploads/user/photo',
            ]
        ];
    }
    /**
     * Lists all Profile models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProfileSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $model= Profile::find()->where(['user_id'=> \Yii::$app->user->id])->one();
        if($model){
            $pdfContent= $this->renderPartial('view',['model'=>$model]);
        }else{
            $pdfContent=null;
        }
        if(\Yii::$app->request->isAjax){
            return $this->renderAjax('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'pdfContent'=>$pdfContent,
            ]);
        }else{
            $dataProvider->pagination->pageSize=7;
            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'pdfContent'=>$pdfContent,
            ]);
        }
    }

    /**
     * Displays a single Profile model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
       // $image = realpath(dirname(__FILE__)).'\..' . '\assets\photo\\';
         if(\Yii::$app->request->isAjax){

          
            return $this->renderAjax('view', [
                'model' => $this->findModel($id),
            ]);
         }else{

            $x = 1;
             return $this->render('view', [
                'model' => $this->findModel($id),
               
              //  'images'=>$image
            ]); 
         }
    }
    /**
     * Creates a new Profile model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        Yii::$app->params['uploadPath'] = realpath(dirname(__FILE__)).'\..' . '\assets\photo\\';
        $model = new Profile();
        $HasImage=false;
        if ($model->load(Yii::$app->request->post())) {
            $image = UploadedFile::getInstance($model, 'image');
            if($image){
                // store the source file name
                $model->image_url = $image->name;
                $Imagename=explode(".",$image->name);
                $ext = $Imagename[1];
                // generate a unique file name
                $model->avatar = hash('haval160,4',$model->user_id).".{$ext}";
                $path = Yii::$app->params['uploadPath'] . $model->avatar;
                $HasImage=true;
            }
            if($model->validate() && $model->save()){
                if($HasImage){
                    $image->saveAs($path);
                }
                Yii::$app->assetManager->forceCopy=true;
                ProfileAsset::register(\Yii::$app->view);
                Yii::$app->assetManager->forceCopy=false;
                Yii::$app->session->setFlash('success', 'Profile Successfully Created!');
                return $this->redirect('/profile');
            }else{
                //Yii::$app->getSession()->setFlash('danger','Duplicate Entry, Username is Unique');
                //Yii::$app->session->setFlash('danger', "Duplicate Entry, Username is Unique");
                return $this->render('create', [
                   'model' => $model,
                ]);
            }
        } else {
            if(Yii::$app->request->isAjax){
                return $this->renderAjax('create', [
                    'model' => $model,
                ]);
            }else{
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }
    }

    /**
     * Updates an existing Profile model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        Yii::$app->params['uploadPath'] = realpath(dirname(__FILE__)).'\..' . '\assets\photo\\';
        $x = realpath(dirname(__FILE__)).'\..' . '\assets\photo\\';
        $model = $this->findModel($id);
        if(Yii::$app->user->can('access-his-profile') && !Yii::$app->user->can('profile-full-access')){
            if($model->user_id!=Yii::$app->user->identity->user_id){
                throw new NotFoundHttpException('The requested profile does not exist or you are not permitted to view this profile.');
            }
        }
        $OldAvatar=$model->avatar;
        $OldImageUrl=$model->image_url;
        $changeImage=false;
        if ($model->load(Yii::$app->request->post())) {
         
                $image = UploadedFile::getInstance($model, 'image');
                if($image){
                    // store the source file name
                    $model->image_url = $image->name;
                    $Imagename=explode(".",$image->name);
                    $ext = $Imagename[1];
                    // generate a unique file name
                    $model->avatar = $image->name;
                    $path = Yii::$app->params['uploadPath'] . $model->avatar;
                    //$backendpath = $BackendUploadPath . $model->avatar;
                    $changeImage=true;
                }
                $NewImageUrl=$model->image_url;
                if($model->avatar==''){
                    $model->avatar=$model->avatar=='' ? null : $model->avatar;
                    $model->image_url=$model->image_url=='' ? null : $model->$model->image_url;
                }
            if($model->save()){
                if($changeImage){
                    //Save image to frontend photo folder
                   // $image->saveAs($path);
                    $image->saveAs('uploads/user/photo/'.$image->name);
                    $this->Deleteimage($OldAvatar);
                    //Save image to backend photo folder
                    //copy($path,$backendpath);
                }/*elseif($OldImageUrl!==$model->image_url){
                    //Unlink Image
                    //unlink(Yii::$app->params['uploadPath'].$OldAvatar);
                    $this->Deleteimage($OldAvatar);
                }*/
                //return "Saved...";
                Yii::$app->assetManager->forceCopy=true;
                ProfileAsset::register(\Yii::$app->view);
                Yii::$app->assetManager->forceCopy=false;
                Yii::$app->session->setFlash('success', 'Profile Successfully Updated!');
                return $this->redirect(['/profile']);
            } else {
                throw new NotFoundHttpException('The requested profile does not exist or you are not permitted to view this profile.');
            }
        } else {
            if(Yii::$app->request->isAjax){
            return $this->renderAjax('update', [
                'model' => $model,
                'x'=>$x
            ]);
            }else{
               return $this->render('update', [
                'model' => $model,
                'x'=>$x
            ]); 
            }
        }
    }
    public function Deleteimage($avatar){
        $ImageUrl = realpath(dirname(__FILE__)).'/..' . '/assets/photo/'.$avatar;
        if(file_exists($ImageUrl)){
            unlink($ImageUrl);
        }
    }
    /**
     * Deletes an existing Profile model.
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
     * Finds the Profile model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Profile the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Profile::find()->where(['profile_id'=>$id])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested profile does not exist or you are not permitted to view this profile.');
        }
    }
}
