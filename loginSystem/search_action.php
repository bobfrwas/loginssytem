<?php
session_start();

include_once 'models/db.php';
include_once 'models/user.php';



$user = unserialize($_SESSION['user']);
$search_input = $_POST['search'];

$user->search($search_input);

?>