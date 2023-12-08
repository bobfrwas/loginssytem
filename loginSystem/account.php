<?php 

include_once 'models/db.php';
include_once 'models/user.php';

session_start();

$logged_in = false;
if (isset($_SESSION['user'])) {
    $logged_in = true;
    $user = unserialize($_SESSION['user']);
}
//Because it is a 1 line comment like if you wanted to do that you could just go to the next line there is no need to do this on the same line.
?>

<html>
    <head>
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.0.0/uicons-regular-rounded/css/uicons-regular-rounded.css'>
        <style>


.navbar {
  background-color: #333;
  overflow: hidden;
  text-align: center;
  position: fixed;
  bottom: 0;
  width: 100%;
  left: 0;
  right: 0;
  margin-left: auto;
  margin-right: auto;
}

/* Style the links inside the navigation bar */
.navbar a {
  
  display: inline-block;
  color: #f2f2f2;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
  font-size: 17px;
}

/* Change the color of links on hover */
.navbar a:hover {
  background-color: #ddd;
  color: black;
}

/* Add a color to the active/current link */
.navbar a.active {
  background-color: #04AA6D;
  color: white;
}


    .post {
        padding: 10px;
        background-color: white;
        text-align: center;
    }
    .title {
        background-color: white;
        font-size: 2rem;
        padding: 4px;
    }
    .content {
        background-color: white;
    }
    .between_posts {
        padding: 4rem;
    }
    </style>

    </head>

    <body>
<?php  if ($logged_in): ?>
        <p>
            <a href="post.php">Create a post</a>
        </p>
        <p>
            <a href="log-out.php">Log out</a>
            <i class="fi fi-rr-edit"></i>
        </p>
<?php  else: ?>
    <p>
        <a href="login.php">Log in</a>
    </p>

    <p>
        <a href="sign_up.php">Sign up</a>
    </p>

<?php endif ?>
<?php
$user = new User(); 


?>

ID <?= $user->id ?>

<div class="navbar">
  <a href="index.html"><i class="fi fi-rr-home"></i></a>
  <a href="#explore.php"><i class="fi fi-rr-search"></i></a>
  <a href="post.php"><i class="fi fi-rr-edit"></i></a> 
  <a href="#notifications.php"><i class="fi fi-rr-bell"></i></a>
  <a href="account.php"><i class="fi fi-rr-user"></i></a>
</div>
    </body>
</html>