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

$twig = initTwig('');
echo $twig->render('partenaires.tpl.twig', array('render' => $toRender));
get_footer();