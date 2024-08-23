<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class ColorAdminAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
       'css/fonts.css',
       'plugins/jquery-ui/themes/base/minified/jquery-ui.min.css',
       'plugins/bootstrap/css/bootstrap.min.css',
       'plugins/font-awesome/css/font-awesome.min.css',
       'css/animate.min.css',
       'css/style.min.css',
       'css/style-responsive.min.css',
       'css/theme/default.css',
       'plugins/jquery-jvectormap/jquery-jvectormap.css',
       'plugins/isotope/isotope.css',
       'plugins/lightbox/css/lightbox.css',
       'css/style.css',
       'plugins/flag-icon/css/flag-icon.css',
       'plugins/password-indicator/css/password-indicator.css',
       'plugins/switchery/switchery.min.css',

       //sarvar_akbarov
       'css/my_css.css',
       //
       
    ];
    public $depends = [
        // 'yii\web\YiiAsset',
        // 'yii\bootstrap\BootstrapAsset',
    ];
    public $jsOptions = ['position' => \yii\web\View::POS_HEAD];

    public $js = [
        'plugins/jquery/jquery-1.9.1.min.js',
        'plugins/jquery/jquery-migrate-1.1.0.min.js',
        'plugins/jquery-ui/ui/minified/jquery-ui.min.js',
        'plugins/bootstrap/js/bootstrap.min.js',
        'plugins/slimscroll/jquery.slimscroll.min.js',
        'plugins/jquery-cookie/jquery.cookie.js',
        'plugins/flot/jquery.flot.min.js',
        'plugins/flot/jquery.flot.time.min.js',
        'plugins/flot/jquery.flot.resize.min.js',
        'plugins/flot/jquery.flot.pie.min.js',
        'plugins/sparkline/jquery.sparkline.js',
        'plugins/jquery-knob/js/jquery.knob.js',
        'js/page-with-two-sidebar.demo.min.js',
        'plugins/jquery-jvectormap/jquery-jvectormap.min.js',
        'plugins/jquery-jvectormap/jquery-jvectormap-world-mill-en.js',
        'plugins/isotope/jquery.isotope.min.js',
        'plugins/lightbox/js/lightbox.min.js',
        'js/gallery.demo.min.js',
//        'js/gallery-v2.demo.min.js',
        'js/dashboard.min.js',
        'js/apps.min.js',
        'js/myjs.js',
        'js/new.js',

        //sarvar_akbarov
        'js/my_js.js',
        'js/inputFilter.js',
        'js/items.js',
        //

        //'js/chat.js',
        'plugins/switchery/switchery.min.js',
        'js/form-slider-switcher.demo.min.js',
    ];
}
