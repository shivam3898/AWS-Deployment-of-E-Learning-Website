<?php 
include_once("config.php");
session_start();
if(isset($_SESSION['username'])){
   header("Location:index.php");
}

if(isset($_POST['commit'])){
		$username = $_POST['username'];
		$username = mysqli_real_escape_string($mysqli, $username);
		$password = $_POST['password'];
		$password = mysqli_real_escape_string($mysqli, $password);
		$sql = "SELECT * FROM `users` WHERE `username`='$username' and `password`='$password'";
		$result = $mysqli->query($sql);
		if($result->num_rows > 0){
			$_SESSION['username'] = $username;
			$_SESSION['password'] = $password;
			header("Location:index.php");
		}
		else{
			echo '<div class="alert alert-danger alert-dismissible fade in" style="text-align:center">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<strong>ERROR!</strong> Invalid username or password!
				  </div>';
		}
	}		
?>
<html>
<head>
  <title>Login</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
  <link rel="stylesheet" type="text/css" href="style.css" />
  <link rel="icon" type="image/ico" href="favicon.ico" />
</head>
<body>

<div class="jumbotron">
  <div class="container text-center">
    <h1>ANTHEM</h1>      
    <p>A Shared e-Learning Platform</p>
  </div>
</div>

<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand">ANTHEM</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li class="active"><a href="index.php">Home</a></li>
		<li class="dropdown">
			<a class="dropdown-toggle" data-toggle="dropdown" >All Notes
			<span class="caret"></span></a>
			<ul class="dropdown-menu">
			  <li><a href="videos.php">Videos</a></li>
			  <li><a href="pdfs.php">PDFs</a></li>
			  <li><a href="images.php">Images</a></li>
			</ul>
		  </li>
        <li><a href="about.html">About</a></li>
      </ul>
	  
      <ul class="nav navbar-nav navbar-right">
        <li><a href="account.php"><span class="glyphicon glyphicon-user"></span> Your Account</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="container">    
	<form action="login.php" method="post">
	  <div class="form-group">
		<label for="email">Username :</label>
		<input type="text" name="username" class="form-control" id="email">
	  </div>
	  <div class="form-group">
		<label for="pwd">Password:</label>
		<input type="password" name="password" class="form-control" id="pwd">
	  </div>
	  <button type="submit" class="btn btn-primary" name="commit">Log In</button>
	  <input type="button" class="btn btn-primary" onclick="window.location.href = 'signup.php';" value="Sign Up">
	</form>
</div>


<footer class="container-fluid text-center">
  <p>Anthem e-Learning Platform</p>
</footer>

</body>
</html>
