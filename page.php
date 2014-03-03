<?php
get_header();

$toRender['template_directory'] = get_template_directory_uri();
$toRender['title'] = get_the_title();
$toRender['page'] = get_post(get_the_id(), "ARRAY_A");
$toRender['page']['image'] = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_id()), "article")[0];

$twig = initTwig('');
echo $twig->render('page.twig', array('render' => $toRender));
get_footer();