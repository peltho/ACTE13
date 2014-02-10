<?php
get_header();
$toRender['template_directory'] = get_template_directory_uri();
$toRender['title'] = get_the_title();

$toRender['actualite'] = get_post(get_the_id(), "ARRAY_A");
$toRender['actualite']['image'] = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_id()), "medium")[0];

// echo '<pre>';
// print_r($toRender['actualite']);
// echo '</pre>';

$twig = initTwig('');
echo $twig->render('actualite.twig', array('toRender' => $toRender));
get_footer();