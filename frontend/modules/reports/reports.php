<?php 
namespace frontend\modules\reports;

/**
 * Description of module
 *
 * @author OneLab
 */
class reports extends \yii\base\Module{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'frontend\modules\reports\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        //adding sub-module
        $this->modules = [
            'lab' => ['class' => 'frontend\modules\reports\modules\lab\lab'],
            'finance'=>['class'=>'frontend\modules\reports\modules\finance\finance'],
            'customer'=>['class'=>'frontend\modules\reports\modules\customer\customer'],
            'referral'=>['class'=>'frontend\modules\reports\modules\referral\referral']
        ];

        // custom initialization code goes here
    }
}
