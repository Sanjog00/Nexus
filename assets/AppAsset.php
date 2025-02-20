<?php

/**
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css',
        'https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css',

    ];
    public $js = [
        'js/script.js',
        'js/likes-popup.js',


    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap4\BootstrapPluginAsset',
        'yii\bootstrap4\BootstrapAsset',

    ];
}
