<?php
  //include statement for the Header Section of the app
      include 'show_user_header.php';
?>
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
        <th>Request Song</th>
      </tr>
    </thead>
      <tbody>
      <?php
        if (isset($_POST['Search'])) {
          $search = mysqli_real_escape_string($link, $_POST['query']);
          $sql = "SELECT * FROM events WHERE location LIKE '%$search%' OR artist LIKE '%$search%' OR venue LIKE '%$search%' OR date_time LIKE '%$search%'";
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
                        <button name="request" class="btn btn-default" value="<?php echo $row['eventid']; ?>">Request</button>
                      </form>
                    </div>
                   </td>
                   </tr>
              <?php
              }
          }else {
            echo "There are no results matching your search!";
          }
        }else {
          echo "DB Error";
        }
        ?>
      </tbody>
    </table>
  </div>
  <?php
  // include statment for the footer section of the app
    include 'show_user_footer.php';
   ?>
