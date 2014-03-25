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
    //$less->compileFile(get_template_directory().'/less/style.less', get_template_directory().'/less/style.css');
    $less->checkedCompile(get_template_directory().'/less/style.less', get_template_directory().'/less/style.css');

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

function get_excerpt_by_id($post_id) {
    $the_post = get_post($post_id); //Gets post ID
    $the_excerpt = $the_post->post_content; //Gets post_content to be used as a basis for the excerpt
    $excerpt_length = 35; //Sets excerpt length by word count
    $the_excerpt = strip_tags(strip_shortcodes($the_excerpt)); //Strips tags and images
    $words = explode(' ', $the_excerpt, $excerpt_length + 1);
    if(count($words) > $excerpt_length) :
        array_pop($words);
        array_push($words, '…');
        $the_excerpt = implode(' ', $words);
    endif;
    $the_excerpt = '<p>' . $the_excerpt . '</p>';
    return $the_excerpt;
}

function get_first_post_year() {
    $query = new WP_Query();
    $firstPost = $query->query(array('post_type' => 'post', 'orderBy' => 'date', 'order' => 'ASC', 'showposts' => 1));
    $f = (!empty($firstPost)) ? get_post($firstPost[0]->ID, "ARRAY_A"): null;
    return (!empty($f)) ? strtok($f['post_date'], '-') : "Aucune";
}

function get_last_post_year() {
    $query = new WP_Query();
    $lastPost = $query->query(array('post_type' => 'post', 'orderBy' => 'date', 'order' => 'DESC', 'showposts' => 1));
    $l = (!empty($lastPost)) ? get_post($lastPost[0]->ID, "ARRAY_A") : null;
    return (!empty($l)) ? strtok($l['post_date'], '-') : "Aucune";
}

function get_years() {
    $annees = array();
    $firstYear = get_first_post_year();
    $lastYear = get_last_post_year();

    $i = 0;
    for($annee = $firstYear; $annee <= $lastYear; ++$annee) {
        $annees[$i] = $annee;
        $i++;
    }
    return array_reverse($annees);
}

//Ajout de nouvelles tailles d'images
if ( function_exists( 'add_image_size' ) ) {
    add_image_size('miniature', 270, 135, true);
    add_image_size('article', 758, 200, true);
    add_image_size('event', 600, 200, true);
    add_image_size('event_thumbnail', 50, 50, true);
}