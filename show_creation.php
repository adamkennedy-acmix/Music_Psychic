<?php
// Start session
session_start();

// Config file included
require_once 'dbconfig.php';

// Check if the user is logged in, if not then redirect them to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: index.php");
    exit;
}
//Variables initialize with empty values
$artist = $location = $venue = $date_time = "";
$artist_err = $location_err = $venue_err = $date_time_err = $query_err = "";


//Processing form data for submission
if($_SERVER["REQUEST_METHOD"] == "POST"){

    if(empty($_POST["artist"])){
        $artist_err = "Please enter a artist name.";
    } elseif(empty($_POST["location"])){
        $location_err = "Please enter a location.";
    } elseif(empty($_POST["venue"])){
        $cell_err = "Please enter a venue name.";
    } elseif(empty($_POST["date_time"])){
        $date_time_err = "Please enter a valid date and time YYYY-MM-DD 00:00:00.";
    } else{

        $artist = mysqli_real_escape_string($link, $_POST["artist"]);
        $location = mysqli_real_escape_string($link, $_POST["location"]);
        $venue = mysqli_real_escape_string($link, $_POST["venue"]);
        $date_time = mysqli_real_escape_string($link, $_POST["date_time"]);

        $sql = "SELECT * FROM events WHERE artist = '$artist' AND location = '$location' AND venue = '$venue' AND date_time = '$date_time'";

        $result = mysqli_query($link, $sql);
        $queryresult = mysqli_num_rows($result);

        if ($queryresult > 0) {
            Echo $query_err = "The event already exist in the system try again!";
          } elseif (mysqli_query($link, "INSERT into events (artist, location, venue, date_time) VALUES ('$artist', '$location', '$venue', '$date_time')")) {
            echo "Success";
         }
         else {
            echo "Something went wrong?";
        }
      }
    // Close connection
    mysqli_close($link);

  }


 ?>



<!DOCTYPE html>
<html lang="en">
<head>
  <title>Music Psychic - New Show Creation</title>
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
      <li><a href="show_user.php">Show</a></li>
      <li class="active"><a href="show_creation.php">Create Event</a></li>
      <li><a href="support.php">Support</a></li>
    </ul>
    <form class="navbar-form navbar-left">
     <div class="form-group">
     </div>
     <form>
     <a href="mplogout.php" class="btn btn-danger">Sign Out</a>
     </form>
   </form>
  </div>
</nav>

<div class="container">
<div class="row">
<div class="col-sm-2"></div>
<h2>Create A New Event</h2>
<form class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
  <div class="form-group <?php echo (!empty($artist_err)) ? 'has-error' : ''; ?>">
    <label class="control-label col-sm-2" for="artist">Artist:</label>
    <div class="col-sm-6">
      <input type="text" class="form-control" name="artist" placeholder="Maroon 5" value="<?php echo $artist; ?>">
    </div>
  </div>
  <div class="form-group <?php echo (!empty($location_err)) ? 'has-error' : ''; ?>" >
    <label class="control-label col-sm-2" for="location">Location:</label>
    <div class="col-sm-6">
      <input type="text" class="form-control" name="location" placeholder="Los Angeles, CA" value="<?php echo $location; ?>">
    </div>
  </div>
  <div class="form-group <?php echo (!empty($venue_err)) ? 'has-error' : ''; ?>">
    <label class="control-label col-sm-2" for="venue">Venue:</label>
    <div class="col-sm-6">
      <input type="text" class="form-control" name="venue" placeholder="Staples Center" value="<?php echo $venue; ?>">
    </div>
  </div>
  <div class="form-group <?php echo (!empty($date_time_err)) ? 'has-error' : ''; ?>">
    <label class="control-label col-sm-2" for="date_time">Date & Time#:</label>
    <div class="col-sm-6">
      <input type="datetime" class="form-control" name="date_time" placeholder="YYYY-MM-DD 00:00:00" value="<?php echo $date_time; ?>">
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-6">
      <button type="submit" class="btn btn-default" name="submit">Submit</button>
  </div>
</form>
<div class="col-sm-2"></div>
</div>
</div>
</div>


<div class="jumbotron">
  <div class="container text-center">
    <h1>Music Psychic</h1>
    <p>The Music Fortune Teller.</p>
  </div>
</div>


</body>
