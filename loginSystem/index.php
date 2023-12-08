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
    <head>
    
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.0.0/uicons-bold-rounded/css/uicons-bold-rounded.css'>
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

a {
    color: black;
}
    .post {
        padding: 10px;
        background-color: grey;
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
    .buttons {
        background-color: rgb(191, 188, 187);
        padding: 1rem;
        font-size: 2rem;
    }
    .buttons > * {
  margin-right: 0.5rem;
}
.user {
    font-size: 1rem;
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

$user->display_posts();
?>

<div class="navbar">
  <a href="index.html"><i class="fi fi-rr-home"></i></a>
  <a href="#explore.php"><i class="fi fi-rr-search"></i></a>
  <a href="post.php"><i class="fi fi-rr-edit"></i></a> 
  <a href="#notifications.php"><i class="fi fi-rr-bell"></i></a>
  <a href="account.php"><i class="fi fi-rr-user"></i></a>
</div>
    </body>
</html>