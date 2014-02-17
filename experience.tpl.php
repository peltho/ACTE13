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
    'comment_field' => '<textarea id="TxtMessageTemoignage" name="comment" placeholder="Votre expérience"></textarea>',
    'comment_notes_before' => '',
    'comment_notes_after' => ''
);

$comments_anciens = array();
$comments_jeunes = array();
$comments = get_comments(array('post_id' => get_the_id(), 'status' => 'approve'));
foreach($comments as $c) {
    switch(get_comment_meta($c->comment_ID)['type']['0']) {
        case "ancien": array_push($comments_anciens, $c); break;
        case "jeune": array_push($comments_jeunes, $c); break;
//        default : echo "aucun";
    }
}

$toRender['comments_jeunes'] = $comments_jeunes;
$toRender['comments_anciens'] = $comments_anciens;
$toRender['comments_equipe'] = get_field("temoignage");

ob_start();
comment_form($args);
$form_commentaire = ob_get_clean();

$twig = initTwig('');
echo $twig->render('experience.tpl.twig', array('render' => $toRender, 'form_commentaire' => $form_commentaire));
get_footer();