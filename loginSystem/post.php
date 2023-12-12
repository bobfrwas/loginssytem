<?php

include_once "models/user.php";
include_once "models/db.php";





?>

<html>
    <head>

<link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/create_an_account.css" rel="stylesheet">

    <link rel="stylesheet" href="animate.css-main/animate.css">

    <style>
      body {
        font-family: Arial, sans-serif;
        background-color: #f8f8f8;
        margin: 0;
        padding: 0;
      }

      .container {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
      }

      .form-wrapper {
        background-color: #ffffff;
        border-radius: 8px;
        padding: 40px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        width: 400px;
      }

      h2 {
        text-align: center;
        margin-bottom: 20px;
      }

      .form-group {
        margin-bottom: 20px;
      }

      label {
        display: block;
        margin-bottom: 5px;
      }

      input[type="text"],
      input[type="email"],
      input[type="password"] {
        width: 100%;
        padding: 8px;
        border: 1px solid #cccccc;
        border-radius: 4px;
      }

      input[id="content"]{
        height: 4rem;
      }

      button[type="submit"] {
        background-color: #007bff;
        color: #ffffff;
        border: none;
        padding: 10px 20px;
        border-radius: 4px;
        cursor: pointer;
        width: 100%;
      }

      button[type="submit"]:hover {
        background-color: #0056b3;
      }

      p {
        text-align: center;
        margin-top: 20px;
      }

      a {
        color: #007bff;
        text-decoration: none;
      }

      a:hover {
        text-decoration: underline;
      }
    </style>
  </head>

  <body>
    <div class="container">
        <div class="form-wrapper">
          <h2>Create a post</h2>
          <form action="post_a_post.php" method="POST">
            <div class="form-group">
              <label for="title">Title</label>
              <input type="text" id="title" name="title" required>
            </div>
            <div class="form-group">
              <label for="content">Message</label>
              <input type="text" id="content" name="content" required>
            </div>
            <div class="form-group">
              <label for="hashtags">Type your #here</label>
              <input type="text" id="hashtags" name="hashtags" required>
            </div>
            <div class="form-group">
            <input type="file" name="fileToUpload" id="fileToUpload">
            </div>
            <button type="submit">Post</button>
          </form>
          
        </div>
      </div>

 
    
    





</html>