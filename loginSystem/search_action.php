<?php
session_start();

include_once 'models/db.php';
include_once 'models/user.php';



$user = unserialize($_SESSION['user']);
$search_input = $_POST['search'];




?>
<html>

<head>
    <style>
        /* Container for the social media posts */
.social-media-post {
  background-color: #f5f5f5;
  border: 1px solid #ddd;
  padding: 20px;
  margin-bottom: 20px;
}

/* Title of the post */
.social-media-post .post-title {
  font-size: 180px;
  font-weight: bold;
  margin-bottom: 10px;
}

/* Content of the post */
.social-media-post .post-content {
  font-size: 14px;
  line-height: 1.5;
  margin-bottom: 15px;
}

/* Meta information of the post */
.social-media-post .post-meta {
  font-size: 12px;
  color: #888;
}

/* Hashtags in the post */
.social-media-post .post-hashtags {
  font-size: 12px;
  color: #555;
}

/* Author of the post */
.social-media-post .post-author {
  font-size: 14px;
  font-weight: bold;
  color: #333;
}

/* Date and time of the post */
.social-media-post .post-date {
  font-size: 12px;
  color: #888;
}
</style>

<body>

<?php

$user->search($search_input);