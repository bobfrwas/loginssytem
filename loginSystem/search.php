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
</style>

</head>

<body>

<form action="search_action.php" method="post">
    <div class="mb-3">
            <label for="search" class="form-label">Search</label>
            <input name="search" type="text" class="form-control" id="search">
            <button type="submit">Search</button>
        </div>

<div class="navbar">
  <a href="index.html"><i class="fi fi-rr-home"></i></a>
  <a href="#explore.php"><i class="fi fi-rr-search"></i></a>
  <a href="post.php"><i class="fi fi-rr-edit"></i></a> 
  <a href="#notifications.php"><i class="fi fi-rr-bell"></i></a>
  <a href="account.php"><i class="fi fi-rr-user"></i></a>
</div>

