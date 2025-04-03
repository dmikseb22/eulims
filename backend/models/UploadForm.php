<?php



namespace backend\models;
use yii\base\Model;
use yii\web\UploadedFile;
/**
 * Description of UploadForm
 *
 * @author OneLab
 */
class UploadForm {
    /**
     * @var UploadedFile
     */
    public $imageFile;

    public function rules()
    {
        return [
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
        ];
    }
    
    public function upload()
    {
        if ($this->validate()) {
            $this->imageFile->saveAs('/uploads/user/photo/' . $this->imageFile->baseName . '.' . $this->imageFile->extension);
            return true;
        } else {
            return false;
        }
    }
}
