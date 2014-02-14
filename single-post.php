<?php
get_header();
$toRender['template_directory'] = get_template_directory_uri();
$toRender['title'] = get_the_title();

$toRender['actualite'] = get_post(get_the_id(), "ARRAY_A");
$toRender['actualite']['image'] = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_id()), "medium")[0];

$args = array(
    'id_form' => 'WriteTemoignage',
    'title_reply' => '',
    'label_submit' => "Partager",
    'comment_field' => '<textarea id="TxtMessageTemoignage" name="comment" placeholder="Votre commentaire"></textarea>',
    'comment_notes_before' => '',
    'comment_notes_after' => ''
);

$toRender['comments'] = get_comments(array('post_id' => get_the_id(), 'status' => 'approve'));

ob_start();
comment_form($args);
$form_commentaire = ob_get_clean();

//echo '<pre>';
//print_r($toRender['comments']);
//echo '</pre>';

$twig = initTwig('');
echo $twig->render('actualite.twig', array('toRender' => $toRender, 'form_commentaire' => $form_commentaire));

get_footer();