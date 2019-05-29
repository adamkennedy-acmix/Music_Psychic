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
    $s_artist = $s_title = $s_album = "";
    $s_artist_err = $s_title_err = "";


    $event = mysqli_real_escape_string($link, $_POST["request"]);
    $sql = "SELECT * FROM events WHERE eventid = $event";
    $result = mysqli_query($link, $sql);
    $queryresult = mysqli_num_rows($result);

    if ($queryresult > 0) {
      for ($i=0; $i < $queryresult; $i++) {
        $row = mysqli_fetch_array($result, MYSQLI_BOTH);
        $temp_event_id = $row[0];
        $temp_artist = $row['artist'];
        $temp_location = $row['location'];
        $temp_venue = $row['venue'];
        $temp_date_time = $row['date_time'];
      }
    }else {
      echo "There are no results matching your search!";
    }

    //Processing form data for submission
    if($_SERVER["REQUEST_METHOD"] == "POST"){

      $event = mysqli_real_escape_string($link, $_POST["request"]);
      $sql = "SELECT * FROM events WHERE eventid = $event";
      $result = mysqli_query($link, $sql);
      $queryresult = mysqli_num_rows($result);

      $id = $_SESSION['id'];


        if(empty($_POST["s_artist"])){
            $s_artist_err = "Please enter a artist name.";
        } elseif(empty($_POST["s_title"])){
            $s_title_err = "Please enter a song title.";
        }else{

            $s_artist = mysqli_real_escape_string($link, $_POST["s_artist"]);
            $s_title = mysqli_real_escape_string($link, $_POST["s_title"]);
            $s_album = mysqli_real_escape_string($link, $_POST["s_album"]);

            $sql2 = "SELECT * FROM request WHERE uid = '$id' AND eid = '$temp_event_id' AND s_artist = '$s_artist' AND s_title = '$s_title'";

            $result2 = mysqli_query($link, $sql2);
            $queryresult2 = mysqli_num_rows($result2);

            if ($queryresult2 > 0) {
                Echo $query_err = "You have already entered a request for this song! Try entering another song.";
              }
              elseif (mysqli_query($link, "INSERT into request (eid, uid, s_artist, s_title, s_album) VALUES ('$temp_event_id', '$id', '$s_artist', '$s_title', '$s_album')")) {
                Echo "Your request has been successfully added to the event's playlist suggestions!";
              }
              else {
              echo "Something went wrong?";
              }
            }
        // Close connection
        mysqli_close($link);

      } else {
        header("location: show_user.php");
        exit;
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
          <li><a href="show_creation.php">Create Event</a></li>
          <li class="active"><a href="#">Song Request</a></li>
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
    <h2>Request A Song</h2>
    <p> Request a song for the <?php echo $temp_artist; ?> show in <?php echo  $temp_location; ?> at the <?php echo  $temp_venue; ?> on <?php echo $temp_date_time; ?> </p>
    <form class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
      <div class="form-group <?php echo (!empty($s_artist_err)) ? 'has-error' : ''; ?>">
        <label class="control-label col-sm-2" for="s_artist">Artist:</label>
        <div class="col-sm-6">
          <input type="text" class="form-control" name="s_artist" placeholder="Michael Jackson" value="<?php echo $s_artist; ?>">
        </div>
      </div>
      <div class="form-group <?php echo (!empty($s_title_err)) ? 'has-error' : ''; ?>" >
        <label class="control-label col-sm-2" for="s_title">Song:</label>
        <div class="col-sm-6">
          <input type="text" class="form-control" name="s_title" placeholder="Billie Jean" value="<?php echo $s_title; ?>">
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-sm-2" for="s_album">Album:</label>
        <div class="col-sm-6">
          <input type="text" class="form-control" name="s_album" placeholder="Thriller" value="<?php echo $s_album; ?>">
          <input type="hidden" class="form-control" name="request" value="<?php echo $event; ?>">
        </div>
      </div>
      <div class="form-group">
        <div class="col-sm-offset-2 col-sm-6">
          <button type="submit" class="btn btn-default" name="submit">Submit</button>
      </div>
      </div>
    </form>
    </div>
    </div>


    <div class="jumbotron">
      <div class="container text-center">
        <h1>Music Psychic</h1>
        <p>The Music Fortune Teller.</p>
      </div>
    </div>


    </body>
