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
    wp_register_script( 'googleMap',"https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false");
    wp_enqueue_script( 'jquery' );
    wp_enqueue_script( 'flexslider' );
    wp_enqueue_script( 'jQueryUI' );
    wp_enqueue_script( 'jPanel' );
    wp_enqueue_script( 'bootstrap' );
    wp_enqueue_script( 'main' );
    wp_enqueue_script( 'googleMap' );
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
    add_image_size('partenaire', 300, 300, true);
}

if ( is_admin() ) {
    if (!get_option('miniature_size_w'))	add_option('miniature_size_w',  270);
    if (!get_option('miniature_size_h'))	add_option('miniature_size_h',  135);
    if (!get_option('article_size_w'))	add_option('article_size_w', 758);
    if (!get_option('article_size_h'))	add_option('article_size_h', 200);
    if (!get_option('event_size_w'))	add_option('event_size_w', 600);
    if (!get_option('event_size_h'))	add_option('event_size_h', 200);
    if (!get_option('event_thumbnail_size_w'))	add_option('event_thumbnail_size_w', 50);
    if (!get_option('event_thumbnail_size_h'))	add_option('event_thumbnail_size_h', 50 );
    if (!get_option('partenaire_size_w'))	add_option('partenaire_size_w', 300);
    if (!get_option('partenaire_size_h'))	add_option('partenaire_size_h', 300 );
}

if ( is_admin() ) {
    function sf_image_size_input_fields( $post, $check = '' ) {

        // get a list of the actual pixel dimensions of each possible intermediate version of this image
        $size_names = array(
            'thumbnail' => __('Thumbnail'),
            'medium' => __('Medium'),
            'large' => __('Large'),
            'full' => __('Full Size'),
            'miniature' => __('Miniature', 'ACTE13'),
            'article' => __('Article', 'ACTE13'),
            'event' => __('Evénement', 'ACTE13'),
            'event_thumbnail' => __('Evénement Miniature', 'ACTE13'),
            'partenaire' => __('Partenaire', 'ACTE13'));

        if ( empty($check) )
            $check = get_user_setting('imgsize', 'medium');

        foreach ( $size_names as $size => $label ) {
            $downsize = image_downsize($post->ID, $size);
            $checked = '';

            // is this size selectable?
            $enabled = ( $downsize[3] || 'full' == $size );
            $css_id = "image-size-{$size}-{$post->ID}";
            // if this size is the default but that's not available, don't select it
            if ( $size == $check ) {
                if ( $enabled )
                    $checked = " checked='checked'";
                else
                    $check = '';
            } elseif ( !$check && $enabled && 'thumbnail' != $size ) {
                // if $check is not enabled, default to the first available size that's bigger than a thumbnail
                $check = $size;
                $checked = " checked='checked'";
            }

            $html = "<div class='image-size-item'><input type='radio' " . disabled( $enabled, false, false ) . "name='attachments[$post->ID][image-size]' id='{$css_id}' value='{$size}'$checked />";

            $html .= "<label for='{$css_id}'>$label</label>";
            // only show the dimensions if that choice is available
            if ( $enabled )
                $html .= " <label for='{$css_id}' class='help'>" . sprintf( "(%d&nbsp;×&nbsp;%d)", $downsize[1], $downsize[2] ). "</label>";

            $html .= '</div>';

            $out[] = $html;
        }

        return array(
            'label' => __('Size'),
            'input' => 'html',
            'html'  => join("\n", $out),
        );
    }
    function sf_image_attachment_fields_to_edit($form_fields, $post) {
        if ( substr($post->post_mime_type, 0, 5) == 'image' ) {
            $alt = get_post_meta($post->ID, '_wp_attachment_image_alt', true);
            if ( empty($alt) )
                $alt = '';

            $form_fields['post_title']['required'] = true;

            $form_fields['image_alt'] = array(
                'value' => $alt,
                'label' => __('Alternate Text'),
                'helps' => __('Alt text for the image, e.g. “The Mona Lisa”')
            );

            $form_fields['align'] = array(
                'label' => __('Alignment'),
                'input' => 'html',
                'html'  => image_align_input_fields($post, get_option('image_default_align')),
            );

            $form_fields['image-size'] = sf_image_size_input_fields( $post, get_option('image_default_size', 'medium') );

        } else {
            unset( $form_fields['image_alt'] );
        }
        return $form_fields;
    }
    add_filter('attachment_fields_to_edit', 'sf_image_attachment_fields_to_edit', 11, 2);
}	// fin de is_admin()