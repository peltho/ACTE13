<?php
/**
 * Template Name: Template Actualités
 * @package WordPress
 * @subpackage MIAGE
 * @since MIAGE 1.0
 */
get_header();
$toRender['template_directory'] = get_template_directory_uri();
$toRender['title'] = get_the_title();

$query = new WP_Query();
$allArticles = $query->query(array('post_type' => 'post', 'orderBy' => 'date', 'order' => 'DESC', 'year' => /*$year*/2014));
foreach($allArticles as $a) {
    $a->thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id($a->ID), "medium")[0];
    $a->permalink = get_permalink($a->ID);
}

$twig = initTwig('');
echo $twig->render('actualites.twig', array('actualites' => $allArticles));

get_footer();