<?php 
	require('server.php');

	if (!isset($_SESSION['username'])) {
		$_SESSION['msg'] = "You must log in first";
		header('location: login.php');
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
	<link rel="stylesheet" type="text/css" href="style2.css">
</head>
<body>
	<div class="logout">
		<a href="index.php?logout='1'" class='btn'>Logout</a>
		<a href="index.php" class='btn'>News Feed</a>
	</div>
	<div class="header">
	<?php  if (isset($_SESSION['username'])) : ?>
		<img src="account.png" style="width:10%">
		<br>
		<h2><strong><?php echo $_SESSION['username']; ?></strong></h2>
	<?php endif ?>
	</div>
	<div class="content">

		<!-- notification message -->
		<?php if (isset($_SESSION['success'])) : ?>
			<div class="error success" >
				<h3>
					<?php 
						echo $_SESSION['success']; 
						unset($_SESSION['success']);
					?>
				</h3>
			</div>
		<?php endif ?>

		<!-- logged in user information -->
		<?php  if (isset($_SESSION['username'])) :?>
			<form class = "ph" action='add.php' method = "post" enctype="multipart/form-data">
				<input type = "file" name="uploadfile"/>
				<div class="forms"><br></div>
				<input type="submit" name = "post_photom" class = "btn" value = "Post a photo" />
			</form>
			<br>
			
			<?php
			$query0 = "SELECT id FROM users WHERE username='$_SESSION[username]'";
			$result0 = $result = mysqli_query($db, $query0);
			$row0 = $result0->fetch_assoc();
			
			$query = "SELECT PhotoLocation, photos.PhotoID,COUNT(likes.PhotoID) AS NoLikes, DataPostare FROM photos LEFT OUTER JOIN likes ON photos.PhotoID=likes.PhotoID WHERE photos.UserID = '$row0[id]' GROUP BY photos.PhotoID ORDER BY COUNT(likes.PhotoID) DESC, DataPostare DESC";
			$result = mysqli_query($db, $query);
			
			$query3 = "SELECT id FROM  users WHERE username = '$_SESSION[username]'";
			$result3 = mysqli_query($db, $query3);
			$row3 = $result3->fetch_assoc();
			?> 
			
			<table class = "tab">
			<?php while ($row = $result->fetch_assoc()) { 
				$query5 = "SELECT * FROM users, photos WHERE users.id = photos.UserID AND PhotoID='$row[PhotoID]'";
				$result5 = mysqli_query($db, $query5);
				$row5 = $result5->fetch_assoc();
			?>
				<tr>
				<br>
				<p><img src="user.png" style= "width:3%"><b><i><?php echo $row5['username']; ?></i></b></p>
				<p><?php echo $row['DataPostare'];?></p>
				<br>
				<img class = "photo" src="<?php echo $row['PhotoLocation']; ?>" style= "width:80%">
				<br>
				<p class="like">
			<?php
				$query0 = "SELECT * FROM likes WHERE UserID = '$row3[id]' AND PhotoID = '$row[PhotoID]'";
				$result0 = mysqli_query($db, $query0);
				if(mysqli_num_rows($result0) == 1){ ?>
					<a href='add.php?idm=<?php echo $row['PhotoID']; ?>' id = 'open-here'><img class = 'photo2' src='heart.png' style= 'width:5%'></a>
				<?php }else {?>
					<a href='add.php?idm=<?php echo $row['PhotoID']; ?>' id = 'open-here'><img class = 'photo2' src='heart2.png' style= 'width:5%'></a>
				<?php } ?>
				</p>
				<?php 
				echo "  ", $row['NoLikes'];
				echo "<br>"; 
				echo "<br>"; 
					$query2 = "SELECT * FROM comments, photos, users WHERE comments.PhotoID = photos.PhotoID AND users.id = comments.UserID AND photos.PhotoID ='$row[PhotoID]'";
					$result2 = mysqli_query($db, $query2);
					if(mysqli_num_rows($result2) > 0){ ?>
						<div class = "com">
						<?php
						while ($rows = $result2->fetch_assoc()) {   
							echo "<b>",$rows['username'],"</b>: ", $rows['Comment'];
							echo "<br>";
						}
						?>
						</div>
					<?php
					}
					?>
					<br>
					<div class="write">
						<form action = "add.php?idc=<?php echo $row['PhotoID']; ?>" method = "post">
							<input type="text" name="post_comment" placeholder="Write a comment"/>
						</form>
					</div>
					<br>
					<br>
					<?php 
					$query4 = "SELECT * FROM users, photos WHERE users.id = photos.UserID AND users.id = '$row3[id]' AND PhotoID='$row[PhotoID]'";
					$result4 = mysqli_query($db, $query4);
					if(mysqli_num_rows($result4) > 0){?>
						<div class = "delete">
							<a href="add.php?idpm=<?php echo $row['PhotoID']; ?>" id = 'open-here2' class='btn' name='delete'>Sterge</a>
						</div>
					<?php } ?>
					</tr>
				<?php } ?>
			</table>
		<?php endif ?>
		
	</div>
		
</body>
</html>