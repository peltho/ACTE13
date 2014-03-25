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
$toRender['description'] = get_field("description");
$toRender['extrait'] = get_field("extrait");

$query = new WP_Query();
$articles = $query->query(array('post_type' => 'post', 'posts_per_page' => 4, 'orderBy' => 'date', 'order' => 'DESC'));
foreach($articles as $a) {
    $a->excerpt = get_excerpt_by_id($a->ID);
    $a->thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id($a->ID), "miniature")[0];
    $a->permalink = get_permalink($a->ID);
}


$calendrier = do_shortcode('[ai1ec view="monthly"]');
$lienActualites = get_permalink(get_page_by_title('Actualités'));

$twig = initTwig('');
echo $twig->render('home.tpl.twig', array('render'     => $toRender,
                                          'articles'   => $articles,
                                          'calendrier' => $calendrier,
                                          'actualites' => $lienActualites));
get_footer();