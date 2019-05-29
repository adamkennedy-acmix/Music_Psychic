<?php
// Initialize the session
session_start();

require 'dbconfig.php';

// Check if the user is logged in, if not then redirect him to login page
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

<div class="container">
  <h2>Show Search</h2>
  <p></p>
  <table class="table table-hover">
    <thead>
      <tr>
        <th>Artist</th>
        <th>Show Location</th>
        <th>Venue</th>
        <th>Date/Time</th>
        <th>Song Request</th>
        <?php
        if (isset($_POST['Search'])) {
            $search = mysqli_real_escape_string($link, $_POST['query']);
            $sql = "SELECT * FROM events WHERE location LIKE '%query%' OR artist LIKE '%query%' OR venue LIKE '%query%' OR date_time LIKE '%query%'";
            $result = mysqli_query($link, $sql);
            $queryresult = mysqli_num_rows($result);

            if ($queryresult > 0) {
              for ($i=0; $i < $queryresult; $i++) {
                $row = mysqli_fetch_array($result, MYSQLI_BOTH);
                echo "<tr id = ".$row[0]." >";
                echo "<td>".$row['artist']."</td>";
                echo "<td>".$row['location']."</td>";
                echo "<td>".$row['venue']."</td>";
                echo "<td>".$row['date_time']."</td>";
                ?>  <td>
                      <div class="request_<?php echo $row['eventid']; ?>" >
                        <form name="request_<?php echo $row['eventid']; ?>" action="jointest.php" method="POST">
                          <button name="request" class="btn btn-danger">Request</button>
                        </form>
                      </div>
                     </td>
                     </tr>
                <?php
              }
            }else {
              echo "There are no results matching your search!";
            }
          }
         ?>
      </tr>
    </thead>
    <tbody>
    </tbody>
  </table>
</div>

<div class="container">
  <h2>Shows Attending</h2>
  <p>The shows you've already made song request for are listed below.</p>
  <table class="table table-hover">
    <thead>
      <tr>
        <th>Artist</th>
        <th>Show Location</th>
        <th>Venue</th>
        <th>Date/Time</th>
        <th>Request Again</th>
        <th>Request</th>
      </tr>
    </thead>
      <tbody>
      <?php
        $id = $_SESSION['id'];
        if (2 > 1){
          $sql2 = "SELECT * FROM events INNER JOIN request ON events.eventid = request.eid WHERE request.uid = '$id' GROUP BY events.date_time";
          $result2 = mysqli_query($link, $sql2);
          $queryresult2 = mysqli_num_rows($result2);

          if ($queryresult2 > 0){
              for ($i=0; $i < $queryresult2; $i++){
              $row2 = mysqli_fetch_array($result2, MYSQLI_BOTH);
              echo "<tr id = ".$row2[0]." >";
              echo "<td>".$row2['artist']."</td>";
              echo "<td>".$row2['location']."</td>";
              echo "<td>".$row2['venue']."</td>";
              echo "<td>".$row2['date_time']."</td>";
              ?>
                <td>
                   <div class="form-group">
                     <form name="request_<?php echo $row2['eventid']; ?>" action="jointest.php" method="POST">
                       <button name="request" class="btn btn-default" value="<?php echo $row2['eventid']; ?>">Request</button>
                     </form>
                </td>
                <td>
                     <form name="request_<?php echo $row2['eventid']; ?>" action="event_request.php" method="POST">
                       <button name="request2" class="btn btn-default" value="<?php echo $row2['eventid']; ?>">View</button>
                     </form>
                   </div>
                  </td>
                </tr>


              <?php
              echo "</tr>";
              }
          }else {
            echo "<b>You have not requested songs for any shows yet!</b>";
          }
        }else {
          echo "DB Error";
        }
        ?>
      </tbody>
    </table>
  </div>

<div class="jumbotron" >
  <div class="container text-center">
    <h1>Music Psychic</h1>
    <p>The Music Fortune Teller.</p>
  </div>
</div>

</body>
