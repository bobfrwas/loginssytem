<?php
session_start();

include "models/db.php";
include "models/user.php";



$logged_in = false;
if ( !isset($_SESSION['user'])) {
    //
    header('Location: http://localhost/loginSystem/sign_up.php');
    //
}

$logged_in = true;
$user = unserialize($_SESSION['user']);
$user->like_a_post($_GET["post_id"]);

header('Location: http://localhost/loginSystem/index.php');
