<?php
get_header();
$toRender['template_directory'] = get_template_directory_uri();
$toRender['title'] = get_the_title();

$toRender['actualite'] = get_post(get_the_id(), "ARRAY_A");
$toRender['actualite']['image'] = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_id()), "large")[0];

$args = array(
    'id_form' => 'WriteTemoignage',
    'title_reply' => '',
    'label_submit' => "Partager",
    'comment_field' => '<textarea id="TxtMessageTemoignage" name="comment" placeholder="Votre commentaire"></textarea>',
    'comment_notes_before' => '',
    'comment_notes_after' => ''
);

$toRender['comments'] = get_comments(array('post_id' => get_the_id(), 'status' => 'approve'));

$year = strtok(get_post(get_the_id(), "ARRAY_A")['post_date'], '-');
$query = new WP_Query();
$allArticles = $query->query(array('post_type' => 'post', 'orderBy' => 'date', 'order' => 'DESC', 'year' => $year));
foreach($allArticles as $a) {
    $a->excerpt = get_excerpt_by_id($a->ID);
    $a->thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id($a->ID), "medium")[0];
    $a->permalink = get_permalink($a->ID);
}

$annees = get_years();

ob_start();
comment_form($args);
$form_commentaire = ob_get_clean();

$twig = initTwig('');
echo $twig->render('actualite.twig', array('toRender' => $toRender,
                                           'form_commentaire' => $form_commentaire,
                                           'actualites' => $allArticles,
                                           'annees' => $annees));

get_footer();