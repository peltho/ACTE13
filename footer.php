<?php
/**
 * Created by JetBrains PhpStorm.
 * User: thomas
 * Date: 14/01/14
 * Time: 16:22
 * To change this template use File | Settings | File Templates.
 */

$toRender['menu'] = wp_nav_menu( array( 'theme_location' => 'footer_nav','depth'=>1,'echo'=>0,'container' =>'','items_wrap' => '%3$s') );
$toRender['template_directory'] = get_template_directory_uri();
$twig = initTwig('');

echo $twig->render('footer.twig', array('render'=>$toRender));


wp_footer();
