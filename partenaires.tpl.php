<?php
/**
 * Template Name: Template Partenaires
 * @package WordPress
 * @subpackage MIAGE
 * @since MIAGE 1.0
 */
get_header();
$toRender['template_directory'] = get_template_directory_uri();
$toRender['title'] = get_the_title();

$query = new WP_Query();
$pages = $query->query(array('post_type' => 'page'));
$partenaires = get_page_children(get_the_ID(), $pages);
foreach($partenaires as $k => $p) {
    $toRender['partenaires'][$k]['url'] = $p->guid;
    $toRender['partenaires'][$k]['name'] = $p->post_title;
}

$twig = initTwig('');
echo $twig->render('partenaires.tpl.twig', array('render' => $toRender));
get_footer();