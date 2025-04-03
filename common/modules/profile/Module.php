<?php

namespace common\modules\profile;
use common\modules\profile\ProfileAsset;
/**
 * @property string assetsUrl
 * profile module definition class
 */
class Module extends \yii\base\Module
{
    private $ProfileAsset;
    public $defaultRoute = 'info';
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'common\modules\profile\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        ProfileAsset::register(\Yii::$app->view);
        $this->ProfileAsset = \Yii::$app->assetManager->getPublishedUrl('@common/modules/profile/assets');
        parent::init();

        // custom initialization code goes here
    }
    public function getAssetsUrl()
    {
        return $this->ProfileAsset;
    }
}
