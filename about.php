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

<style>
.jumbotron {
  background-image: url("guitar.jpg");
  background-repeat: no-repeat;
  background-attachment: fixed;
  background-position: inherit;
  background-size: cover;
  color: white;
  margin-bottom: 0px;
}

#myCarousel{
  height: auto;
  width: auto;
}

</style>

<body>

  <nav class="navbar navbar-inverse" style="margin-bottom: 0px;">
    <div class="container-fluid">
      <div class="navbar-header">
        <a class="navbar-brand" href="#"><span class="glyphicon glyphicon-cd"></span> Music Psychic</a>
      </div>
      <ul class="nav navbar-nav">
        <li><a href="index.php">Login</a></li>
        <li><a href="support_exterior.php">Support</a></li>
        <li class="active"><a href="#">About</a></li>
      </ul>
    </div>
  </nav>

<div id="myCarousel" class="carousel slide" data-ride="carousel" >

  <!-- Indicators -->
  <ol class="carousel-indicators">
    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
    <li data-target="#myCarousel" data-slide-to="1"></li>
    <li data-target="#myCarousel" data-slide-to="2"></li>
  </ol>

  <!-- Wrapper for slides -->
  <div class="carousel-inner">
    <div class="item active">
      <img src="crowd.jpg" alt="vishnu-r-nair-639172-unsplash">
      <div class="carousel-caption d-none d-md-block">
       <h2>The Crowd Request</h2>
     </div>
    </div>

    <div class="item">
      <img src="artist.jpg" alt="austin-neill-247047-unsplash">
      <div class="carousel-caption d-none d-md-block">
       <h2>The Artist Performs</h2>
     </div>
    </div>

    <div class="item">
      <img src="heart.jpg" alt="anthony-delanoix-15928-unsplash">
      <div class="carousel-caption d-none d-md-block">
       <h2>Everyone Enjoys!</h2>
     </div>
    </div>
  </div>

  <!-- Left and right controls -->
  <a class="left carousel-control" href="#myCarousel" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="right carousel-control" href="#myCarousel" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right"></span>
    <span class="sr-only">Next</span>
  </a>
</div>

<div class="jumbotron">
  <div class="container text-center">
    <h1>Music Psychic</h1>
    <p>The Music Fortune Teller.</p>
  </div>
</div>
