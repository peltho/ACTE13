<?php
/**
 * Template Name: Template Dispositifs - Missions
 * @package WordPress
 * @subpackage MIAGE
 * @since MIAGE 1.0
 */
get_header();
$toRender['template_directory'] = get_template_directory_uri();
$toRender['title'] = get_the_title();
$toRender['fields'] = get_field('liste_collapsibles');

$twig = initTwig('');
echo $twig->render('dispositifs.missions.tpl.twig', array('render' => $toRender));
get_footer();