<?php


get_header();
$toRender="";
$twig = initTwig('');

echo $twig->render('page.twig', array('render'=>$toRender));
get_footer();