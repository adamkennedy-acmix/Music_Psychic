<?php
// Initialize the session
session_start();

require 'dbconfig.php';

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: index.php");
    exit;
}

$event = mysqli_real_escape_string($link, $_POST["request2"]);
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

<div class="container">
  <h2><?php echo  $temp_artist; ?> Show Song Request</h2>
  <p>Here are the song request for the <?php echo  $temp_artist; ?> show  in <?php echo  $temp_location; ?> at the <?php echo  $temp_venue; ?> on <?php echo  $temp_date_time; ?>. </p>
  <table class="table table-hover">
    <thead>
      <tr>
        <th>Requests</th>
        <th>Song Title</th>
        <th>Song Artist</th>
        <?php
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            $search2 = mysqli_real_escape_string($link, $event);
            $sql2 = "SELECT DISTINCT `s_artist`, `s_title` FROM `request` WHERE `eid` = $event";
            $result2 = mysqli_query($link, $sql2);
            $queryresult2 = mysqli_num_rows($result2);

            if ($queryresult2 > 0) {
              for ($i=0; $i < $queryresult2; $i++) {
                $row2 = mysqli_fetch_array($result2, MYSQLI_BOTH);
                $temp_song = $row2['s_title'];
                $temp_artist = $row2['s_artist'];


                $sql3 = "SELECT COUNT(`s_title`) AS `count` FROM `request` WHERE `eid` = $event AND `s_artist` = '$temp_artist' AND `s_title` = '$temp_song'";
                $result3 = mysqli_query($link, $sql3);
                $queryresult3 = mysqli_num_rows($result3);
                $row3 = mysqli_fetch_array($result3, MYSQLI_BOTH);
                $temp_count = $row3['count'];


                echo "<tr>";
                echo "<td>".$temp_count."</td>";
                echo "<td>".$temp_song."</td>";
                echo "<td>".$temp_artist."</td>";
                echo "</tr>";

              }
            }else {
              echo "There are no results yet!";
            }
          } else {
            header("location: show_user.php");
            exit;
          }
         ?>
      </tr>
    </thead>
    <tbody>
    </tbody>
  </table>
  <h2>Make Another Song Request</h2>
  <p></p>
  <div class="form-group">
    <form name="request_<?php echo $row['eventid']; ?>" action="jointest.php" method="POST">
      <button name="request" class="btn btn-default" value="<?php echo $temp_event_id; ?>">Request</button>
    </form>
  </div>
</div>

<div class="jumbotron" >
  <div class="container text-center">
    <h1>Music Psychic</h1>
    <p>The Music Fortune Teller.</p>
  </div>
</div>

</body>
