<?php
/**
 * Template Name: Template Experience
 * @package WordPress
 * @subpackage MIAGE
 * @since MIAGE 1.0
 */
get_header();
$toRender['template_directory'] = get_template_directory_uri();
$toRender['title'] = get_the_title();

$args = array(
    'id_form' => 'WriteTemoignage',
    'title_reply' => '',
    'label_submit' => "Partager",
    'comment_field' => '<textarea id="TxtMessageTemoignage" name="comment" placeholder="Votre commentaire"></textarea>',
    'comment_notes_before' => '',
    'comment_notes_after' => ''
);

$toRender['comments'] = get_comments(array('post_id' => get_the_id(), 'status' => 'approve', 'comment_type' => 'jeune'));

ob_start();
comment_form($args);
$form_commentaire = ob_get_clean();

$twig = initTwig('');
echo $twig->render('experience.tpl.twig', array('render' => $toRender, 'form_commentaire' => $form_commentaire));
get_footer();