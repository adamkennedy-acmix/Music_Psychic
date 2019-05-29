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
        <?php
          if (isset($_POST['Search'])) {
            $search = mysqli_real_escape_string($link, $_POST['query']);
            $sql = "SELECT * FROM events WHERE location LIKE '%query%' OR artist LIKE '%query%' OR venue LIKE '%query%' OR date_time LIKE '%query%'";
            $result = mysqli_query($link, $sql);
            $queryresult = mysqli_num_rows($result);

            if ($queryresult > 0) {
              while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>".$row['artist']."</td>";
                echo "<td>".$row['location']."</td>";
                echo "<td>".$row['venue']."</td>";
                echo "<td>".$row['date_time']."</td>";
                echo "</tr>";
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
</div><div class="container">
  <h2>Show Search</h2>
  <p></p>
  <table class="table table-hover">
    <thead>
      <tr>
        <th>Artist</th>
        <th>Show Location</th>
        <th>Venue</th>
        <th>Date/Time</th>
      </tr>
    </thead>
    <tbody>
    </tbody>
  </table>
</div>
