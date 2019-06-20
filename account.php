<?php 
include_once("config.php");
session_start();
if(!isset($_SESSION['username'])){
   header("Location:login.php");
}
$username = $_SESSION['username'];
if(isset($_POST['upload'])){
	$_FILES['file']['name'] = $_POST['file_name'];
	$file_name = $_FILES['file']['name'];
	$file_type = $_FILES['file']['type'];
	$file_size = $_FILES['file']['size'];
  $file_tem_loc = $_FILES['file']['tmp_name'];
  if($file_type == 'video/mp4'){
    $file_store = "uploads/videos/".$file_name;
  }elseif($file_type == 'application/pdf'){
    $file_store = "uploads/pdfs/".$file_name.".pdf";
  }else{
    $file_store = "uploads/images/".$file_name;
  }
	//for video upload
	if($file_type == 'video/mp4'){
		move_uploaded_file($file_tem_loc, $file_store);
		shell_exec("aws s3 cp uploads/videos/\"".$file_name."\" s3://e-learning-project1/uploads/videos/");
		shell_exec("rm -f uploads/videos/\"".$file_name."\"");
		$sql = "insert into files values('$file_name', '$username', '$file_type')";
		if($mysqli->query($sql)){
			echo '<div class="alert alert-success alert-dismissible fade in" style="text-align:center;">
					<a class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<strong>Success!</strong> File Uploaded Successfully.
				  </div>';
		}
				elseif(($mysqli->error) == "Duplicate entry '$file_name' for key 'PRIMARY'"){
				echo '<div class="alert alert-danger alert-dismissible fade in" style="text-align:center">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<strong>ERROR!</strong> File name already taken!
				  </div>';
			}
	}
// For pdf upload
	elseif($file_type == 'application/pdf'){
		move_uploaded_file($file_tem_loc, $file_store);
		shell_exec("aws s3 cp uploads/pdfs/\"".$file_name.".pdf\" s3://e-learning-project1/uploads/pdfs/");
		shell_exec("rm -f uploads/pdfs/\"".$file_name."\"");
		$sql = "insert into files values('$file_name', '$username', '$file_type')";
		if($mysqli->query($sql)){
			echo '<div class="alert alert-success alert-dismissible fade in" style="text-align:center;">
					<a class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<strong>Success!</strong> File Uploaded Successfully.
				  </div>';
		}
				elseif(($mysqli->error) == "Duplicate entry '$file_name' for key 'PRIMARY'"){
				echo '<div class="alert alert-danger alert-dismissible fade in" style="text-align:center">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<strong>ERROR!</strong> File name already taken!
				  </div>';
			}
	}
// For image upload
	elseif($file_type == 'image/jpeg'){
		move_uploaded_file($file_tem_loc, $file_store);
		shell_exec("aws s3 cp uploads/images/\"".$file_name."\" s3://e-learning-project1/uploads/images/");
		shell_exec("rm -f uploads/images/\"".$file_name."\"");
		$sql = "insert into files values('$file_name', '$username', '$file_type')";
		if($mysqli->query($sql)){
			echo '<div class="alert alert-success alert-dismissible fade in" style="text-align:center;">
					<a class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<strong>Success!</strong> File Uploaded Successfully.
				  </div>';
		}
				elseif(($mysqli->error) == "Duplicate entry '$file_name' for key 'PRIMARY'"){
				echo '<div class="alert alert-danger alert-dismissible fade in" style="text-align:center">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<strong>ERROR!</strong> File name already taken!
				  </div>';
			}
	}
	else{
    echo '<div class="alert alert-danger alert-dismissible fade in" style="text-align:center">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<strong>ERROR!</strong> Unsupported file type! <br>
					Only mp4 videos, PDFs and jpeg images can be uploaded.</div>';
	}
}
if(isset($_POST['delete'])){
	$fileD = $_POST['fileDel'];
	$rows=$mysqli->query("select uploaded_by,name,type from files");
	while(list($user,$name,$type)=$rows->fetch_row()){
              if($user == $_SESSION['username']){
                if($type == 'video/mp4'){ 
					if($name==$fileD){
					 $sql = "delete from files where name='$name'";
                      $mysqli->query($sql); 
						shell_exec("aws s3 rm s3://e-learning-project1/uploads/videos/\"".$name."\"");
					  echo '<div class="alert alert-success alert-dismissible fade in" style="text-align:center;">
					<a class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<strong>Success!</strong> File Deleted Successfully.
				  </div>';
					}
				}
				else if($type == 'application/pdf'){ 
					if($name==$fileD){
					 $sql = "delete from files where name='$name'";
            $mysqli->query($sql); 
						shell_exec("aws s3 rm s3://e-learning-project1/uploads/pdfs/\"".$name.".pdf\"");
					  echo '<div class="alert alert-success alert-dismissible fade in" style="text-align:center;">
					<a class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<strong>Success!</strong> File Deleted Successfully.
				  </div>';
					}
				}
				else if($type == 'image/jpeg'){ 
					if($name==$fileD){
					 	$sql = "delete from files where name='$name'";
            $mysqli->query($sql); 
						shell_exec("aws s3 rm s3://e-learning-project1/uploads/images/\"".$name."\"");
					  echo '<div class="alert alert-success alert-dismissible fade in" style="text-align:center;">
					<a class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<strong>Success!</strong> File Deleted Successfully.
				  </div>';
					}
				}
			}
	}
}
?>
<html>
<head>
  <title>Account</title>
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
	<div class="well">
		<p style="font-size:20px; text-align: center"><b>Username : </b><?php echo"".$username;?></p>
		Upload mp4 video file/PDF/jpeg image so that others can learn as well.
	</div>
	<a href="#demo" class="btn btn-primary" data-toggle="collapse">Upload file</a>
	<a href="#demo2" class="btn btn-primary" data-toggle="collapse">Delete file</a>
	<div id="demo" class="collapse">
		<form action="account.php" method="post" enctype="multipart/form-data">
			<input type="text" name="file_name" placeholder="Enter File Name *" required><br>
			<input type="file" name="file" required>
			<input type="submit" name="upload" value="Upload" >
		</form>	  
	</div>
	
	<div id="demo2" class="collapse">
			<form method="post" action="account.php">	
				<select name="fileDel">
				<?php
				$rows=$mysqli->query("select uploaded_by,name,type from files");
				while(list($users,$names,$types)=$rows->fetch_row()){
					if($users == $_SESSION['username']){
					?>
					<option value="<?php echo $names?>"><?php echo $names?></option>
				<?php
					}
				}
				?>
				</select>
				<input type="submit" name="delete" value="Delete">
			</form>    
	</div>
	
</div>

<footer class="container-fluid text-center">
  <p>Anthem e-Learning Platform</p>
</footer>

</body>
</html>
