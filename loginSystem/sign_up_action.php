<?php

include "models/db.php";
include "models/user.php";

//if we don't have any data
if( ! isset($_POST["email"])) {
    header("Location: /");
    exit;
}

//if we have data
var_dump($_POST);

$user = new User();
$user->sign_up($connection, $_POST['name'],$_POST['email'], $_POST["password"]);

$email_check = $user->user_email_check($_POST['email']);
if ($email_check == "email_unused"){

    $user->insert();
    header("Location: login.php");}

else {
    echo "Email in use";
}




