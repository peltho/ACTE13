<?php
define('WP_USE_THEMES', false);
require_once('../../../wp-load.php');
require_once('functions.php');

$nom = htmlentities($_POST['nom']);
$mail = htmlentities($_POST['mail']);
$objet = htmlentities($_POST['objet']);
$message = htmlentities($_POST['message']);

if(!empty($nom) || !empty($mail) || !empty($message) || !empty($objet)) {
    $twig = initTwig('');
    $message = $twig->render('ajax.contact.tpl.twig', array('message' => $message, 'email' => $mail, 'nom' => $nom));
    $headers = 'From: '.$nom.' <'.$mail.'>' . "\r\n";
    echo wp_mail(get_bloginfo('admin_email'), $objet, $message, $headers);
}
else
    echo 0;
