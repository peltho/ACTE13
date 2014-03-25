<?php
/**
 * Template Name: Template Contact
 * @package WordPress
 * @subpackage MIAGE
 * @since MIAGE 1.0
 */

get_header();
$toRender['template_directory'] = get_template_directory_uri();
$toRender['title'] = get_the_title();
$toRender['description'] = get_field("description");
$toRender['extrait'] = get_field("extrait");

$toRender['coordonnees']['adresse'] = get_field("adresse");
$toRender['coordonnees']['complement_adresse'] = get_field("complement_dadresse");
$toRender['coordonnees']['code_postal'] = get_field("code_postal");
$toRender['coordonnees']['telephone'] = get_field("telephone");
$toRender['coordonnees']['fax'] = get_field("fax");
$toRender['coordonnees']['email'] = get_bloginfo('admin_email');
$toRender['fichiers'] = get_field("fichiers");

$twig = initTwig('');
echo $twig->render('contact.tpl.twig', array('render' => $toRender));
get_footer();