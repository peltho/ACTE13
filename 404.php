<?php
get_header();

$toRender['template_directory'] = get_template_directory_uri();
$toRender['title'] = "404 - Page non trouvée...";
$toRender['description'] ="La page recherchée est indisponible ou n'existe pas";

$twig = initTwig('');
echo $twig->render('dispositifs.missions.tpl.twig', array('render' => $toRender));
get_footer();