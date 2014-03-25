<?php
/**
 * Created by JetBrains PhpStorm.
 * User: thomas
 * Date: 14/01/14
 * Time: 16:21
 * To change this template use File | Settings | File Templates.
 */

$toRender['menu'] = wp_nav_menu( array( 'theme_location' => 'main_nav','depth'=>1,'echo'=>0,'menu_id' =>'NavHeader','container' =>'','items_wrap' => '%3$s') );
$toRender['template_directory'] = get_template_directory_uri();
$toRender['title'] = (get_the_title() ? get_the_title() : "Introuvable");
$toRender['isHome'] = is_page_template("home.tpl.php");
$toRender['description'] = get_field("description");
$parametres = get_page_by_title( "Paramètres");
$toRender['headerBackground'] = get_field("images",$parametres->ID);


$twig = initTwig('');
echo $twig->render('header.twig', array('render' => $toRender));
