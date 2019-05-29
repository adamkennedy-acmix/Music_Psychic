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
          /*$id = $_SESSION["id"];*/
          $sql2 = "SELECT * FROM request, events WHERE request.eid = events.eventid AND request.uid = '$id'  GROUP BY events.date_time";
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
