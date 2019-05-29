<?php
// Initialize the session
session_start();

require 'dbconfig.php';

//Variables initialize with empty values
$name_feed = $email_feed = $subject_feed = $message_feed = "";
$name_feed_err = $email_feed_err = $subject_feed_err = $message_feed_err = "";

//Processing form data for submission
if($_SERVER["REQUEST_METHOD"] == "POST"){


      if(empty($_POST["name_feed"])){
          $name_feed_err = "Please enter your name.";
      } elseif(empty($_POST["email_feed"])){
          $email_feed_err = "Please enter a valid email address.";
      } elseif(empty($_POST["subject_feed"])){
          $subject_feed_err = "Please enter a subject line.";
      } elseif(empty($_POST["message_feed"])){
          $message_feed_err = "Please enter text in the box.";
      } else{

          $name_feed = mysqli_real_escape_string($link, $_POST["name_feed"]);
          $email_feed = mysqli_real_escape_string($link, $_POST["email_feed"]);
          $subject_feed = mysqli_real_escape_string($link, $_POST["subject_feed"]);
          $message_feed = mysqli_real_escape_string($link, $_POST["message_feed"]);


          if (empty($name_feed_err) && empty($email_feed_err) && empty($subject_feed_err) && empty($message_feed_err)){
             mysqli_query($link, "INSERT into support (name_feed, email_feed, subject_feed, message_feed) VALUES ('$name_feed', '$email_feed', '$subject_feed', '$message_feed')");
             header("location: index.php");
           }else {
              echo "Something went wrong?";
            }
          }
        //close connection
        mysqli_close($link);
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
</style>

<body>

  <nav class="navbar navbar-inverse">
    <div class="container-fluid">
      <div class="navbar-header">
        <a class="navbar-brand" href="#"><span class="glyphicon glyphicon-cd"></span> Music Psychic</a>
      </div>
      <ul class="nav navbar-nav">
        <li><a href="index.php">Login</a></li>
        <li class="active"><a href="support_exterior.php">Support</a></li>
        <li><a href="about.php">About</a></li>
      </ul>
    </div>
  </nav>

  <div class="container">
  <div class="col-sm-2"></div>
    <h2>Feedback</h2>
    <p>We need and apprciate your feedback. Please send us any questions, comments, or concerns you have about our platform. Thanks!</p>

    <form class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
      <div class="form-group <?php echo (!empty($name_feed_err)) ? 'has-error' : ''; ?>">
        <label class="control-label col-sm-2"  for="name_feed">Name:</label>
          <div class="col-sm-6">
            <input type="text" class="form-control" name="name_feed">
          </div>
      </div>
      <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
        <label class="control-label col-sm-2" for="email_feed">Email:</label>
        <div class="col-sm-6">
          <input type="email" class="form-control" name="email_feed">
        </div>
      </div>
      <div class="form-group <?php echo (!empty($subject_feed_err)) ? 'has-error' : ''; ?>">
        <label class="control-label col-sm-2" for="subject-feed">Subject:</label>
        <div class="col-sm-6">
          <input type="text" class="form-control" name="subject_feed">
        </div>
      </div>
      <div class="form-group <?php echo (!empty($message_feed_err)) ? 'has-error' : ''; ?>">
        <label class="control-label col-sm-2" for="message_feed">Message:</label>
          <div class="col-sm-6">
            <textarea name="message_feed" rows="10" cols="30" class="form-control">
            </textarea>
          </div>
      </div>
      <div class="form-group">
        <div class="col-sm-offset-2 col-sm-6">
          <button type="submit" class="btn btn-default" name="submit">Submit</button>
      </div>
      </div>
    </form>

  </div>
<div class="jumbotron" >
  <div class="container text-center">
    <h1>Music Psychic</h1>
    <p>The Music Fortune Teller.</p>
  </div>
</div>


</body>
</html>
