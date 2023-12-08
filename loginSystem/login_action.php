<?php

include_once 'models/db.php';
include_once 'models/user.php';

$u = new User();
$u->load($connection, $_POST['email'], $_POST['password']);

$u->authenticate();


if ($u->is_logged_in()) {
    session_start();
    $_SESSION['user'] = serialize($u);
    header("Location: index.php");
}

else {
    echo "Could not log in with these credentials";
}

?>