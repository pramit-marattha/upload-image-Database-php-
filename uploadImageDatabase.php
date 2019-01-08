
<html>
	<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, intial-scale=1.0"/>
	<title>Image Upload</title>
	<style>
	
		html, body{background: #ececec; height: 100%; margin: 0; font-family: Arial;}
		.main{height: 100%; display: flex; justify-content: center;}
		.main .image-box{width:300px; margin-top: 30px;}
		.main h2{text-align: center; color: #4D4D4D;}
		.main .tb{width: 100%; height: 40px; margin-bottom: 5px; padding-left: 5px;}
		.main .file_input{margin-top: 10px; margin-bottom: 10px;}
		.main .btn{width: 100%; height: 40px; border: none; border-radius: 3px; background: #27a465; color: #f7f7f7;}
		.main .msg{color: red; text-align: center;}
	
	</style>
	</head>

	<body>
	
	<strong>
		<?php if(isset($error)){echo $error;}?>
	</strong>

	<div class="container main" >
		<div class="image-box">
			<h2>Image upload</h2>
			<form method="POST" name="upfrm" action="" enctype="multipart/form-data">
				<div>
					<input type="text" placeholder="Enter image name" name="img-name" class="tb" />
					<input type="file" name="fileImg" class="file_input" />
					<input type="submit" value="Upload" name="uploadButton" class="btn" />
				</div>
			</form>
			<div class="msg">
				

			</div>
		</div>
	</div>
	</body>
	</html>
	
	<?php

	/*--  included connection files--*/
	include "../connection.php";

	/*--- created a variables to display the error message on design page ------*/
	$error = "";

	if (isset($_POST["uploadButton"]) == "Upload")
	{
		$uploadOk = 1;

		$fileImage = $_FILES["fileImg"]["tmp_name"];
		$fileName = $_FILES["fileImg"]["name"];

		/*image name variable that you will insert in database ---*/
		$imageName = $_POST["img-name"];

		//image directory where actual image will be store
		$path = "photo/".$fileName;

		$target = $path . basename($fileName);	

	/*---------------- validation checking ------------------*/
	if($imageName == "")
	{
		$error = "Please enter Image name.";
	}
	/*-------- insertion of image section -------------*/
	else
	{
		if(file_exists($path))
		{
			$error = "Sorry,The <b>".$fileName."</b> image already exist.";
			$uploadOk = 0;
		}
			else
			{
				$result = mysqli_connect($host, $user, $pass) or die("Connection error: ". mysqli_error());
				mysqli_select_db($result, $db) or die("Could not Connect to Database: ". mysqli_error());
				mysqli_query($result,"INSERT INTO imageDatabase(imageName,imagePath)
				VALUES('$imageName','$path')") or die ("image is not inserted". mysqli_error());
				move_uploaded_file($fileImage,$path);
				$error = "<p align=center>File ".$_FILES["fileImg"]["name"].""."<br />Image saved into database.";
			}
		}
	}
?>