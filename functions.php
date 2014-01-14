<?php
/**
 * Created by JetBrains PhpStorm.
 * User: thomas
 * Date: 14/01/14
 * Time: 16:12
 * To change this template use File | Settings | File Templates.
 */

register_nav_menus(array(
    'main_nav' => 'Navigation principale',
    'footer_nav' => 'Navigation footer'
));

if( !is_admin()) {

    add_action( 'wp_enqueue_scripts', 'theme_name_scripts' );
    // less compiler
    require  get_template_directory().'/libraries/lessphp/lessc.inc.php';
    $less = new lessc;
    $less->compileFile(get_template_directory().'/less/style.less', get_template_directory().'/less/style.css');
    //$less->checkedCompile(get_template_directory().'/less/style.less', get_template_directory().'/less/style.css');

    function initTwig($path) {
        require_once get_template_directory().'/libraries/Twig/lib/Twig/Autoloader.php';
        Twig_Autoloader::register();
        $loader = new Twig_Loader_Filesystem(get_template_directory().'/template/'.$path);
        $twig = new Twig_Environment($loader, array(
            'cache' => get_template_directory().'/template/cache',
        ));
        @unlink($twig);
        return $twig;
    }
}