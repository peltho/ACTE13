<?php
/**
 * Created by JetBrains PhpStorm.
 * User: thomas
 * Date: 14/01/14
 * Time: 16:12
 * To change this template use File | Settings | File Templates.
 */

get_header();
$twig = initTwig('');

echo $twig->render('index.twig', array('render'=>$toRender));
get_footer();