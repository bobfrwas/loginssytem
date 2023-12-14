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

.navbar a {
  display: inline-block;
  color: #f2f2f2;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
  font-size: 28px;
}


@media (max-width: 767px) {
  .navbar a {
    padding: 10px 30px;
  }
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
  background-color: #f5f5f5;
  border: 1px solid #ddd;
  padding: 20px;
  margin-bottom: 20px;
  text-align: center;
}

.title {
  font-size: 20px;
  font-weight: bold;
  margin-bottom: 12px;
  background-color: lightgrey;
}

.content {
  font-size: 16px;
  line-height: 1.5;
  margin-bottom: 18px;
}

.buttons {
  display: inline-block;
  padding: 10px 20px;
  font-size: 32px;
  font-weight: bold;
  text-align: center;
  text-decoration: none;
  background-color: #f5f5f5;
  color: #fff;
  border: none;
  cursor: pointer;
}
    .buttons > * {
  margin-right: 0.5rem;
}
.user {
    font-size: 1rem;
}
.trending {
    text-align: center;
    font-size: 30px;
    color: red;
    font-weight: bold;
}
    </style>

    </head>

    <body>

<div class="trending"><h1>Trending posts</h1><div>

<?php
$user = new User(); 

$user->display_favourite_posts();
?>

<div class="navbar">
  <a href="index.php"><i class="fi fi-rr-home"></i></a>
  <a href="search.php"><i class="fi fi-rr-search"></i></a>
  <a href="post.php"><i class="fi fi-rr-edit"></i></a> 
  <a href="#notifications.php"><i class="fi fi-rr-bell"></i></a>
  <a href="account.php"><i class="fi fi-rr-user"></i></a>
  <a href="trending.php"><i class="fi fi-rr-fire-flame-curved"></i></a>
</div>
    </body>
</html>