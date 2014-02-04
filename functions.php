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
add_action( 'wp_footer', 'acte13_scripts' );

function acte13_scripts() {
    wp_deregister_script('jquery');
    wp_register_script( 'jquery', get_template_directory_uri() . '/js/jquery-1.10.2.min.js', array(), '1.10.2', true );
    wp_register_script( 'flexslider', get_template_directory_uri() . '/js/flexslider/jquery.flexslider-min.js', array( 'jquery' ), '22012014', true );
    wp_register_script( 'jPanel', get_template_directory_uri() . '/js/jquery.jpanelmenu.min.js', array( 'jquery' ), '22012014', true );
    wp_register_script( 'jQueryUI', get_template_directory_uri() . '/js/jquery-ui-1.10.4.custom/js/jquery-ui-1.10.4.custom.min.js', array( 'jquery' ), '1.10.4.custom', true );
    wp_register_script( 'bootstrap', get_template_directory_uri() . '/less/bootstrap/dist/js/bootstrap.min.js', array( 'jquery' ), '1', true );
    wp_register_script( 'main', get_template_directory_uri() . '/js/main.js', array( 'jquery','flexslider','jPanel' ), '22012014', true );
    wp_enqueue_script( 'jquery' );
    wp_enqueue_script( 'flexslider' );
    wp_enqueue_script( 'jQueryUI' );
    wp_enqueue_script( 'jPanel' );
    wp_enqueue_script( 'bootstrap' );
    wp_enqueue_script( 'main' );
}

add_theme_support('post-thumbnails');
