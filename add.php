<?php 
	session_start();

	// variable declaration
	$username = "";
	$email    = "";
	$errors = array(); 
	$_SESSION['success'] = "";

	// connect to database
	$db = mysqli_connect('localhost', 'root', '', 'registration');


	//post a photo from index
	if (isset($_POST['post_photo'])) {
		$filename = $_FILES['uploadfile']['name'];
		$filetmpname = $_FILES['uploadfile']['tmp_name'];
		$folder = 'images/';
		
		move_uploaded_file($filetmpname, $folder.$filename);
		$query = "SELECT * FROM users WHERE username LIKE '$_SESSION[username]'";
		$results = mysqli_query($db, $query);
		$rows = $results->fetch_assoc();
		$date = date("Y-m-d H:i:s");
		if (mysqli_num_rows($results) == 1) {
			$query = "INSERT INTO `photos` (`PhotoLocation`, `UserID`,`DataPostare`) VALUES ('$filename','$rows[id]', '$date')";
			$result = mysqli_query($db, $query);
			if($result <> false){
				header('Location:index.php');
			}
		}

	}
	
	//post a photo from my profile
	if (isset($_POST['post_photom'])) {
		$filename = $_FILES['uploadfile']['name'];
		$filetmpname = $_FILES['uploadfile']['tmp_name'];
		$folder = 'images/';
		
		move_uploaded_file($filetmpname, $folder.$filename);
		$query = "SELECT * FROM users WHERE username LIKE '$_SESSION[username]'";
		$results = mysqli_query($db, $query);
		$rows = $results->fetch_assoc();
		$date = date("Y-m-d H:i:s");
		if (mysqli_num_rows($results) == 1) {
			$query = "INSERT INTO `photos` (`PhotoLocation`, `UserID`,`DataPostare`) VALUES ('$filename','$rows[id]', '$date')";
			$result = mysqli_query($db, $query);
			if($result <> false){
				header('Location:my_profile.php');
			}
		}

	}
	
	//increase/decrease likes from index
	if(isset($_GET['id'])){
		$query0 = "SELECT id FROM users WHERE username='$_SESSION[username]'";
		$result0 = mysqli_query($db, $query0);
		$row = $result0->fetch_assoc();
		
		$query = "SELECT * FROM likes WHERE UserID = '$row[id]' AND PhotoID = '$_GET[id]'";
		$result = mysqli_query($db, $query);
		if($result <> false) {
			$rows = $result->fetch_assoc();
			if (mysqli_num_rows($result) == 1) {
				$query1 = "DELETE FROM `likes` WHERE PhotoID = '$_GET[id]' AND UserID = '$row[id]'";
				$result1 = mysqli_query($db, $query1);
				header('Location:index.php#open-here');
			}
			else{
				$query1 = "INSERT INTO `likes` (`UserID`, `PhotoID`) VALUES ('$row[id]', '$_GET[id]')";
				$result1 = mysqli_query($db, $query1);
				if($result1<> false)
					header('Location:index.php#open-here');
			}
		}
	}
	
    //increase/decrease likes from my profile
	if(isset($_GET['idm'])){
		$query0 = "SELECT id FROM users WHERE username='$_SESSION[username]'";
		$result0 = mysqli_query($db, $query0);
		$row = $result0->fetch_assoc();
		
		$query = "SELECT * FROM likes WHERE UserID = '$row[id]' AND PhotoID = '$_GET[idm]'";
		$result = mysqli_query($db, $query);
		if($result <> false) {
			$rows = $result->fetch_assoc();
			if (mysqli_num_rows($result) == 1) {
				$query1 = "DELETE FROM `likes` WHERE PhotoID = '$_GET[idm]' AND UserID = '$row[id]'";
				$result1 = mysqli_query($db, $query1);
				header('Location:my_profile.php#open-here');
			}
			else{
				$query1 = "INSERT INTO `likes` (`UserID`, `PhotoID`) VALUES ('$row[id]', '$_GET[idm]')";
				$result1 = mysqli_query($db, $query1);
				if($result1<> false)
					header('Location:my_profile.php#open-here');
			}
		}
	}
	
	//delete photo from index
	if(isset($_GET['idp'])){
		$query0 = "DELETE FROM `photos` WHERE PhotoID= '$_GET[idp]'";
		$result0 = mysqli_query($db, $query0);
		if($result0<> false)
			header('Location:index.php');
	}
	
	//delete photo from my profile
	if(isset($_GET['idpm'])){
		$query0 = "DELETE FROM `photos` WHERE PhotoID= '$_GET[idpm]'";
		$result0 = mysqli_query($db, $query0);
		if($result0<> false)
			header('Location:my_profile.php');
	}
	
	
	//post comment
	if(isset($_GET['idc'])){
		if($_POST['post_comment']){
			$query = "SELECT * FROM users WHERE username LIKE '$_SESSION[username]'";
			$results = mysqli_query($db, $query);
			$rows = $results->fetch_assoc();
			$query1 = "INSERT INTO `comments` (`UserID`, `PhotoID`, `Comment`) VALUES ('$rows[id]', '$_GET[idc]', '$_POST[post_comment]')";
			$result1 = mysqli_query($db, $query1);
			if($result1 <> false){
				header('Location:index.php#open-here2');
			}
		}
	}
?>