<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\system\Package;
use common\models\system\Rstl;
use kartik\select2\Select2;


$RstlList= ArrayHelper::map(Rstl::find()->all(),'name','name');

/* @var $this yii\web\View */
/* @var $model common\models\feedback\UserFeedback */
/* @var $form yii\widgets\ActiveForm */
?>

<script type="text/javascript">
    $( document ).ready(function() {
    
 

    
    document.getElementById('hiddenFilename').value = stringGen(10);
 //   document.getElementById('txtFilename').value = document.getElementById('hiddenFilename').value;
 
        if( document.getElementById('userfeedback-urlpath_screen').value != "")
        {
            var canvas = document.getElementById('uploadcanvas');
            var context = canvas.getContext('2d');

            // load image from data url
            var imageObj = new Image();

            imageObj.onload = function() {
            //  context.drawImage(this, 0, 0);
             context.drawImage(this, 0, 0, imageObj.width,    imageObj.height, 0, 0, canvas.width, canvas.height);
            };

            imageObj.src = '../../uploads/feedback/' +   document.getElementById('userfeedback-urlpath_screen').value;
        }
    
    //   alert(imageObj.src);
    
    });
    
    /**
     * This handler retrieves the images from the clipboard as a blob and returns it in a callback.
     * 
     * @see http://ourcodeworld.com/articles/read/491/how-to-retrieve-images-from-the-clipboard-with-javascript-in-the-browser
     * @param pasteEvent 
     * @param callback 
     */
    function retrieveImageFromClipboardAsBlob(pasteEvent, callback) {
        if (pasteEvent.clipboardData == false) {
            if (typeof (callback) == "function") {
                callback(undefined);
            }
        }
        ;

        var items = pasteEvent.clipboardData.items;

        if (items == undefined) {
            if (typeof (callback) == "function") {
                callback(undefined);
            }
        }
        ;

        for (var i = 0; i < items.length; i++) {
            // Skip content if not image
            if (items[i].type.indexOf("image") == -1)
                continue;
            // Retrieve image on clipboard as blob
            var blob = items[i].getAsFile();

            if (typeof (callback) == "function") {
                callback(blob);
            }
        }
    }

    window.addEventListener("paste", function (e) {

        // Handle the event
        retrieveImageFromClipboardAsBlob(e, function (imageBlob) {
            // If there's an image, display it in the canvas
            if (imageBlob) {
                var canvas = document.getElementById("uploadcanvas");
                var ctx = canvas.getContext('2d');

                // Create an image to render the blob on the canvas
                var img = new Image();

                // Once the image loads, render the img on the canvas
                img.onload = function () {
                    // Update dimensions of the canvas with the dimensions of the image
                    canvas.width = this.width;
                    canvas.height = this.height;

                    // Draw the image
                    ctx.drawImage(img, 0, 0);
                };

                // Crossbrowser support for URL
                var URLObj = window.URL || window.webkitURL;

                // Creates a DOMString containing a URL representing the object given in the parameter
                // namely the original Blob
                img.src = URLObj.createObjectURL(imageBlob);


            }
        });
    }, false);


</script>



<div class="row">
    <div class="col-md-6"><div class="user-feedback-form">

            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'url')->textInput() ?>

            <?= $form->field($model, 'urlpath_screen')->textInput(['readonly'=>true])->label("Screenshot Filename:") ?>

            <?= $form->field($model, 'details')->textarea(['rows' => 6]) ?>

            <?= $form->field($model, 'steps')->textarea(['rows' => 6]) ?>

            <?= $form->field($model, 'reported_by')->textInput(['maxlength' => true,'readonly'=>true,'value'=>Yii::$app->user->identity->username]) ?>
            
                        
            
            <?=
            $form->field($model, 'moduletested')->widget(Select2::classname(), [
                'data' => $dataPackageList,
                'language' => 'en',
                'options' => ['placeholder' => 'Select Module'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('Module Tested');
            ?>

         
             <?=
            $form->field($model, 'region_reported')->widget(Select2::classname(), [
                'data' => $RstlList,
                'language' => 'en',
                'options' => ['placeholder' => 'Select Region'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('Region Reported');
            ?>

            <?= $form->field($model, 'action_taken')->textInput(['maxlength' => true]) ?>

            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div></div>
    <div class="col-md-6">
        <h2>Upload Screenshot</h2>
        <p>
            Focus this tab and press <kbd>CTRL</kbd> + <kbd>V</kbd>. The image on your clipboard will be rendered on the canvas !
            
        </p>
        <canvas style="border:1px solid grey;width:600px;height:350px" id="uploadcanvas"></canvas>


       
        <div>
            <input type="button" onclick="uploadEx();" value="Upload" />
        </div>
        <form method="post" accept-charset="utf-8" name="form1">
            <input name="hidden_data" id='hidden_data' type="hidden"/>
            
            
            <input name="hiddenFilename" id='hiddenFilename' type="hidden"/>
        </form>

        <script>
            function uploadEx() {
               
                var canvas = document.getElementById("uploadcanvas");
                var dataURL = canvas.toDataURL("image/png");
                document.getElementById('hidden_data').value = dataURL;
                
                var fd = new FormData(document.forms["form1"]);

                var xhr = new XMLHttpRequest();
             
                
                
              //  document.getElementById('hidden_filename').value ='mariano.png'
               
             // document.getElementById('userfeedback-urlpath_screen').value = document.getElementById('hidden_filename').value;
             //    document.getElementById('txtFilename').value =;  //'mariano.png'
                xhr.open('POST', '../../uploads/feedback/uploaddata.php', true);


                xhr.upload.onprogress = function (e) {
                    if (e.lengthComputable) {
                        var percentComplete = (e.loaded / e.total) * 100;
                        console.log(percentComplete + '% uploaded');
                    //    alert('Succesfully uploaded');
                     
                    }
                };

                xhr.onload = function () {

                };
                xhr.send(fd);
                document.getElementById('userfeedback-urlpath_screen').value = document.getElementById('hiddenFilename').value;
               
           
                
            }         
            ;
            function stringGen(len)
                {
                    var text = " ";

                    var charset = "abcdefghijklmnopqrstuvwxyz0123456789";

                    for( var i=0; i < len; i++ )
                        text += charset.charAt(Math.floor(Math.random() * charset.length));
                    
                    var date = new Date();
                    var components = [
                        date.getFullYear(),
                        date.getMonth()+1,
                        date.getDate(),
                        date.getHours(),
                        date.getMinutes(),
                        date.getSeconds(),
                        date.getMilliseconds()
                    ];
                    
                    var id = components.join(".");
                     text = id + "_" + text+".png";
                    return text;
                }
        </script>
    </div>
</div>





