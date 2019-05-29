<?php
// Config file included
require_once 'dbconfig.php';

//Variables initialize with empty values
$email = $username = $password = $confirm_password = $cell = "";
$email_err = $username_err = $password_err = $confirm_password_err = $cell_err = "";

//Processing form data for submission
if($_SERVER["REQUEST_METHOD"] == "POST"){

  // Validate email
  if(empty($_POST["email"])){
      $email_err = "Please enter a email.";
  } else{
      // Prepare a select statement
      $sql = "SELECT id FROM users WHERE email = ?";

      if($stmt = mysqli_prepare($link, $sql)){
          // Bind variables to the prepared statement as parameters
          mysqli_stmt_bind_param($stmt, "s", $param_email);

          // Set parameters
          $param_email = mysqli_real_escape_string($link, trim($_POST["email"]));

          // Attempt to execute the prepared statement
          if(mysqli_stmt_execute($stmt)){
              /* Store result */
              mysqli_stmt_store_result($stmt);

              if(mysqli_stmt_num_rows($stmt) == 1){
                  $username_err = "This email is already taken.";
              } else{
                  $email = mysqli_real_escape_string($link, trim($_POST["email"]));
              }
          } else{
              echo "Oops! Something went wrong. Please try again later.";
          }
      }

      // Close statement
      mysqli_stmt_close($stmt);
  }

   // Validate username
    if(empty($_POST["user"])){
        $username_err = "Please enter a username.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE username = ?";

        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set parameters
            $param_username = mysqli_real_escape_string($link, trim($_POST["user"]));

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* Store result */
                mysqli_stmt_store_result($stmt);

                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = mysqli_real_escape_string($link, trim($_POST["user"]));
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }

    // Validate mobile
    if(empty($_POST["cell"])){
        $cell_err = "Please enter a moble number.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE cell = ?";

        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_cell);

            // Set parameters
            $param_cell = mysqli_real_escape_string($link, trim($_POST["cell"]));

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* Store result */
                mysqli_stmt_store_result($stmt);

                if(mysqli_stmt_num_rows($stmt) == 1){
                    $cell_err = "This mobile # is already taken.";
                } else{
                    $cell = mysqli_real_escape_string($link, trim($_POST["cell"]));
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }

    // Validate password
    if(empty($_POST["pwd"])){
        $password_err = "Please enter a password.";
    } elseif(strlen(trim($_POST["pwd"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = mysqli_real_escape_string($link, trim($_POST["pwd"]));
    }

    // Validate confirm password
    if(empty($_POST["pwdre"])){
        $confirm_password_err = "Please confirm password.";
    } else{
        $confirm_password = mysqli_real_escape_string($link, trim($_POST["pwdre"]));
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }

    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($email_err) && empty($cell_err)){

        // Prepare an insert statement
        $sql = "INSERT INTO users (username, password, email, cell) VALUES (?, ?, ?, ?)";

        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssss", $param_username, $param_password, $param_email, $param_cell);

            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            $param_email = $email;
            $param_cell = $cell;

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: index.php");
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }

    // Close connection
    mysqli_close($link);
}

 ?>



<!DOCTYPE html>
<html lang="en">
<head>
  <title>Music Psychic - New User Account</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="play.png">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#"><span class="glyphicon glyphicon-cd"></span> Music Psychic</a>
    </div>
    <ul class="nav navbar-nav">
      <li><a href="index.php">Login</a></li>
      <li><a href="support.php">Support</a></li>
    </ul>
  </div>
</nav>

<div class="container">
<div class="row">
<div class="col-sm-2"></div>
<h2>Create A New User Account</h2>
<form class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
  <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
    <label class="control-label col-sm-2" for="u_email">Email:</label>
    <div class="col-sm-6">
      <input type="email" class="form-control" name="email" placeholder="Enter Email Address" value="<?php echo $email; ?>">
    </div>
  </div>
  <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>" >
    <label class="control-label col-sm-2" for="user">Username:</label>
    <div class="col-sm-6">
      <input type="text" class="form-control" name="user" placeholder="Enter Username" value="<?php echo $username; ?>">
      <span class="help-block"><?php echo $username_err; ?></span>
    </div>
  </div>
  <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
    <label class="control-label col-sm-2" for="pwd">Password:</label>
    <div class="col-sm-6">
      <input type="password" class="form-control" name="pwd" placeholder="Type Password" value="<?php echo $password; ?>">
      <span class="help-block"><?php echo $password_err; ?></span>
    </div>
  </div>
  <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
    <label class="control-label col-sm-2" for="pwdre">Retype Password:</label>
    <div class="col-sm-6">
      <input type="password" class="form-control" name="pwdre" placeholder="Retype Password" value="<?php echo $confirm_password; ?>">
      <span class="help-block"><?php echo $confirm_password_err; ?></span>
    </div>
  </div>
  <div class="form-group <?php echo (!empty($cell_err)) ? 'has-error' : ''; ?>">
    <label class="control-label col-sm-2" for="cell">Mobile#:</label>
    <div class="col-sm-6">
      <input type="text" class="form-control" name="cell" placeholder="Enter Mobile#" value="<?php echo $cell; ?>">
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-6">
      <button type="submit" class="btn btn-default" name="submit">Submit</button>
    </div>
  </div>
</form>
<div class="col-sm-2"></div>
</div>
</div>

<div class="jumbotron">
  <div class="container text-center">
    <h1>Music Psychic</h1>
    <p>The Music Fortune Teller.</p>
  </div>
</div>

</body>
