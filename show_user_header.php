<?php
// Initialize the session
session_start();

require 'dbconfig.php';

// Check if the user is logged in, if not then redirect them to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: index.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Music Psychic - Show User Page</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="play.png">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<style>
.jumbotron {
  background-image: url("guitar.jpg");
  background-repeat: no-repeat;
  background-attachment: fixed;
  background-position: inherit;
  background-size: cover;
  color: white;

}
</style>

<body>

<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#"><span class="glyphicon glyphicon-cd"></span> Music Psychic</a>
    </div>
    <ul class="nav navbar-nav">
      <li><a href="#"><span class="glyphicon glyphicon-user"></span> <?php echo htmlspecialchars($_SESSION["username"]); ?> </a></li>
      <li class="active"><a href="show_user.php">Show</a></li>
      <li><a href="show_creation.php">Create Event</a></li>
      <li><a href="support.php">Support</a></li>
    </ul>
     <form class="navbar-form navbar-left" action="show_user_search.php" method="POST">
      <div class="form-group">
        <input type="text" name="query" class="form-control" placeholder="Search for Show">
      </div>
      <form>
      <button type="submit" name="Search" class="btn btn-default"><span class="glyphicon glyphicon-search"></span></button>
      <a href="mplogout.php" class="btn btn-danger">Sign Out</a>
      </form>
    </form>
  </div>
</nav>
