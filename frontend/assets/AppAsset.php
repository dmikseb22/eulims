<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'css/breadcrumbs.css',
        'css/nprogress.css',
        'css/modcss/servicesmod.css',
        'css/progress-spinner.css'
    ];
    public $js = [
        'js/bootbox.min.js',
        'js/main.js',
        'js/jquery.validate.min.js',
        'js/nprogress.js',
        'js/ui/1.11.3/jquery-ui.min.js',
        'js/jquery.tabletojson.js',
        'js/table.object.js',
        'js/modal.js',
        'js/progress_bar.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
