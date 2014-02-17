<?php
define('WP_USE_THEMES', false);
require_once('../../../wp-load.php');
require_once('functions.php');

$query = new WP_Query();
$year = (isset($_POST['year'])) ? $_POST['year'] : /*date('Y')*/null;

$allArticles = $query->query(array('post_type' => 'post', 'orderBy' => 'date', 'order' => 'DESC', 'year' => $year));
foreach($allArticles as $a) {
    $a->thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id($a->ID), "medium")[0];
    $a->permalink = get_permalink($a->ID);
}

$twig = initTwig('');
echo $twig->render('ajax.calendar.tpl.twig', array('actualites' => $allArticles));

