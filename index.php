<?php
// Start session
session_start();

// Check if the user is already logged in, if so then redirect them to user page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: show_user.php");
    exit;
}

// Config file included
require_once "dbconfig.php";

// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";

//Processing form data for submission
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Check if username is empty
    if(empty(trim($_POST["user"]))){
        $username_err = "Please enter username.";
    } else{
        $username = mysqli_real_escape_string($link, trim($_POST["user"]));
    }

    // Check if password is empty
    if(empty(trim($_POST["pwd"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = mysqli_real_escape_string($link, trim($_POST["pwd"]));
    }

    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT id, username, password FROM users WHERE username = ?";

        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set parameters
            $param_username = $username;

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);

                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();

                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;

                            // Redirect user to welcome page
                            header("location: show_user.php");
                        } else{
                            // Display an error message if password is not valid
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    $username_err = "No account found with that username.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
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
  <title>Music Psychic</title>
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
      <li class="active"><a href="#">Login</a></li>
      <li><a href="support_exterior.php">Support</a></li>
      <li><a href="about.php">About</a></li>
    </ul>
  </div>
</nav>

<div class="container-fluid">
	<div class="jumbotron">
	<form class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
		<div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
			<label class="control-label col-sm-2" for="user">Username:</label>
				<div class="col-sm-8">
					<input type="username" class="form-control" name="user" placeholder="Enter Username" value="<?php echo $username; ?>">
          <span class="help-block"><?php echo $username_err; ?></span>
				</div>
		</div>
		<div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
			<label class="control-label col-sm-2" for="pwd">Password:</label>
				<div class="col-sm-8">
					<input type="password" class="form-control" placeholder="Enter Password" name="pwd">
          <span class="help-block"><?php echo $password_err; ?></span>
				</div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-8">
      <input type="submit" class="btn btn-default" value="Login" >
                <p><a href="new_user.php">Create New Account</a></p>
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
