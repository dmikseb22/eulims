<?php

namespace common\modules\dbmanager;
use yii\helpers\FileHelper;

/**
 * dbmanager module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @var array
     */
    protected $fileList = [];
    
    public $path;
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'common\modules\dbmanager\controllers';
    
    /**
     * @return array
     */
    public function getFileList()
    {
        return $this->fileList;
    }
    
    /**
     * {@inheritdoc}
     */
    public function init()
    {
        $this->fileList = FileHelper::findFiles($this->path, ['only' => ['*.sql', '*.gz','*.rar','*.zip','*.tar']]);
        $this->path = \Yii::getAlias($this->path);
        parent::init();
        if (!isset(\Yii::$app->i18n->translations['dbManager'])) {
            \Yii::$app->i18n->translations['dbManager'] = [
                'class' => 'yii\i18n\PhpMessageSource',
                'sourceLanguage' => 'en',
                'basePath' => '@common/modules/dbmanager',
            ];
        }
        // custom initialization code goes here
    }
}
