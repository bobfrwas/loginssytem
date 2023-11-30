<?php 

include_once 'models/db.php';
include_once 'models/user.php';

session_start();

$logged_in = false;
if (isset($_SESSION['user'])) {
    $logged_in = true;
    $user = unserialize($_SESSION['user']);
}
?>

<html>
    <head></head>

    <body>
        hello world
<?php if ($logged_in): ?>
        <p>
            Hello <?=$user->email;?>
        </p>
        <p>
            <a href="post.php">Create a post</a>
        </p>
        <p>
            <a href="log-out.php">Log out</a>
        </p>
<?php  else: ?>
    <p>
        <a href="login.php">Log in</a>
    </p>

    <p>
        <a href="sign_up.php">Sign up</a>
    </p>
<?php endif ?>
    </body>
</html>