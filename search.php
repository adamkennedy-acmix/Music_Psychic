<?php

require_once 'dbconfig.php';

$query = $_GET['query'];
// Get the value sent from the search bar

$min_lenth = 2;

if(strlen($query) >= $min_lenth){

  $query = htmlspecialchars($query);

  $query = mysqli_real_escape_string($link, $query);

  if ($result = mysqli_query($link, "SELECT * FROM events WHERE 'location'='$query%' OR 'artist'='$query%' OR 'venue'='$query%'")){

    /* determine number of rows result set */
    $row_cnt = mysqli_num_rows($result);

    printf("Result set has %d rows.\n", $row_cnt);

    /* close result set */
    mysqli_free_result($result);
  }


/*  if(mysqli_num_rows($raw_results) > 0){

    while($results = mysqli_fetch_array($raw_results)){
      echo "hit";

    }
  }
  else {
    echo "No hits";
  } */
}
else{
  echo "Minimum length is ".$min_lenth;
}

mysqli_close($link);
 ?>
