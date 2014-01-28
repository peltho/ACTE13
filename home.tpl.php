<?php
/**
 * Template Name: Template Accueil
 * @package WordPress
 * @subpackage MIAGE
 * @since MIAGE 1.0
 */
get_header();
$toRender['template_directory'] = get_template_directory_uri();
$toRender['title'] = get_the_title();
$calendrier = do_shortcode('[ai1ec view="monthly"]');

$query = new WP_Query();
$articles = $query->query(array('post_type' => 'post', 'posts_per_page' => 4, 'orderBy' => 'date', 'order' => 'DESC'));
foreach($articles as $a) {
    $a->thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $a->ID ), "medium")[0];
    $a->permalink = get_permalink($a->ID);
}

$twig = initTwig('');
echo $twig->render('home.tpl.twig', array('render'=>$toRender, 'articles' => $articles, 'calendrier' => $calendrier));
get_footer();