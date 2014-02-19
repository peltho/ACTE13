<?php
define('WP_USE_THEMES', false);
require_once('../../../wp-load.php');
require_once('functions.php');

$query = new WP_Query();
//$postYear = strtok(get_post(get_the_id(), "ARRAY_A")['post_date'], '-');
$year = (isset($_POST['year'])) ? $_POST['year'] : null;

$allArticles = $query->query(array('post_type' => 'post', 'orderBy' => 'date', 'order' => 'DESC', 'year' => $year));
foreach($allArticles as $a) {
    $a->excerpt = get_excerpt_by_id($a->ID);
    $a->thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id($a->ID), "medium")[0];
    $a->permalink = get_permalink($a->ID);
}
$annees = get_years();

$twig = initTwig('');
echo $twig->render('ajax.news.tpl.twig', array('actualites' => $allArticles, 'annees' => $annees));

