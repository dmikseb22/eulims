<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = 'Sign In';

$fieldOptions1 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-envelope form-control-feedback'></span>"
];

$fieldOptions2 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-lock form-control-feedback'></span>"
];
?>
<style>
    /* latin-ext */
    @font-face {
        font-family: 'Audiowide';
        font-style: normal;
        font-weight: 400;
        src: local('Audiowide Regular'), local('Audiowide-Regular'), url('/font/audiowide_latin_ext.woff2') format('woff2');

    }
    /* latin */
    @font-face {
        font-family: 'Audiowide';
        font-style: normal;
        font-weight: 400;
        src: local('Audiowide Regular'), local('Audiowide-Regular'), url('/font/audiowide_latin.woff2') format('woff2');

    }

    .newtext {
        font-size: 72px;
        background: -webkit-linear-gradient( #1b4f72  , #3c8dbc);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        font: normal 52px/1 "Audiowide", Helvetica, sans-serif;
        -o-text-overflow: ellipsis;
        text-overflow: ellipsis;
        font-family: 'Audiowide';
        font-size: 60px;
        text-align: center;
    }
      .img-responsive {
  display: block;
  max-width: 100%;
  height: auto;
  margin:auto;
 
}

</style>

<div class="body-content" style="margin:10%;background: linear-gradient(110deg,  #b1d1e4 50%,#3c8dbc 50%);"  >
    <div >
        <div class="d-flex align-items-center" >

            <div>
                <div class="row">

                    <div class="col-sm-6 ">
                        <div class="d-flex align-items-center" >
                            <div class="row" style="margin-top: 10%">
                                <div class="col-sm-12 col-md-offset-0 ">
                                    <img src="/images/onelablogonew.png" style="width: 80%;border-radius: 15px 15px;display: block; height: auto; max-width: 100%;margin:0 auto;">
                                    </div>
                                <div class="col-sm-12 col-md-offset-0 ">
                                    
                                    <h1 class="newtext">
                                        E.U.L.I.M.S
                                    </h1>
                                    <p style="font-family: 'Audiowide';font-size:18px;color:#1b4f72;text-align:center;vertical-align: central">
                                        Enhanced Unified Laboratory Information Management System
                                    </p>

                                    <p style="font-family: 'Audiowide';font-size:18px;color:#1b4f72;text-align:center;vertical-align: central">
                                        Department of Science and Technology
                                    </p> 
                                    <br><br>
                                </div>
                            </div>



                        </div>
                    </div>

                    <div class="col-sm-6">
                       <div class="login-box">
    <div class="login-logo">
        <h2 style="font-family: 'Audiowide'">Admin Login</h2>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">Sign in to start your session</p>

        <?php $form = ActiveForm::begin(['id' => 'login-form', 'enableClientValidation' => false]); ?>

        <?= $form
            ->field($model, 'email', $fieldOptions1)
            ->label(false)
            ->textInput(['placeholder' => $model->getAttributeLabel('email')]) ?>

        <?= $form
            ->field($model, 'password', $fieldOptions2)
            ->label(false)
            ->passwordInput(['placeholder' => $model->getAttributeLabel('password')]) ?>

        <div class="row">
            <div class="col-xs-8">
                <?= $form->field($model, 'rememberMe')->checkbox() ?>
            </div>
            <!-- /.col -->
            <div class="col-xs-4">
                <?= Html::submitButton('Sign in', ['class' => 'btn btn-primary btn-block btn-flat', 'name' => 'login-button']) ?>
            </div>
            <!-- /.col -->
        </div>
        <?php ActiveForm::end(); ?>
        <div style="color:#999;margin:1em 0">
            If you forgot your password you can <?= Html::a('reset it', ['site/request-password-reset']) ?>.
        </div>
    </div>
    <!-- /.login-box-body -->
</div><!-- /.login-box -->
                    </div>
                </div> 

            </div>
        </div>
    </div>

</div>



