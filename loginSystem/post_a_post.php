<?php
session_start();

include "models/db.php";
include "models/user.php";

$user = new User($connection, '', '', '');

$logged_in = false;
if ( !isset($_SESSION['user'])) {
    //
    header('Location: http://localhost/loginSystem/sign_up.php');
    //
}

$logged_in = true;
$user = unserialize($_SESSION['user']);
$user_id = $user->id;


$title = $_POST['title'];
$content = $_POST['content'];
$hashtags = $_POST['hashtags'];


$user->post_a_post($title, $content, $user_id , $hashtags);
header('Location: index.php');
?>