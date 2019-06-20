<?php 
	include_once("config.php");
	session_start();
	if(!isset($_SESSION['username'])){
   header("Location:login.php");
	}
?>
<html>
<head>
  <title>Videos</title>
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
		<li><a href="logout.php"><span class="glyphicon glyphicon-off"></span> Logout</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="container-fluid text-center">  
<div class="row">  	
	<?php
	    $rows=$mysqli->query("select uploaded_by,name,type from files");
	
		while(list($user,$name,$type)=$rows->fetch_row()){
            if($type == 'video/mp4'){
					?>
					<div class="col-sm-4">			
						<video width="100%" controls>
							<source src="<?php echo "https://s3.ap-south-1.amazonaws.com/e-learning-project1/uploads/videos/".rawurlencode($name); ?>">
						</video>						
						<button type="button" class="btn btn-primary btn-block"><?php echo "$name by $user"; ?></button>
						<br><br>
					</div>
    <?php
                
            }
		}
	?>
	
</div>
</div>


<footer class="container-fluid text-center">
    <p>Anthem e-Learning Platform</p>
</footer>

</body>
</html>
