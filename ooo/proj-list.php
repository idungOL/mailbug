<?php
	session_start();
	if(empty($_SESSION['user'])){
	header('Location: login.php');
	}
	if(count($_SESSION['user']->stackmob->user->user2projects)>0){

	/*	echo "<pre>";
		print_r($_SESSION['user']->stackmob->user);
		print_r(count($_SESSION['user']->stackmob->user->user2projects)>0);
		echo "</pre><br>";
	*/	
?>

<!DOCTYPE html>
<html>
<head>

<title>Mailbug - Project List</title>

		<link rel="stylesheet" type="text/css" href="mailbug.css" />
</head>

<body>
	<div id="headContainer">
		<div id="logoContainer">
			<img src="img/logo_title.png">
		</div>
		<div id="navContainer">
			<div id="navlinkContainer">
				<span class="navlinks" id="active"><a href="projects.php">Projects</a></span>
				<span class="navlinks"><a href="#">Settings</a></span>
				<span class="navlinks"><a href="#">About</a></span>
			</div>
		</div>
		<img id="headBar" src="img/header_option_1.png">
	</div>
	
	<div id="contentContainer">
		<div id="welcomeContainer">
			<p id="welcome">Welcome, <?php echo $_SESSION['user']->stackmob->user->firstname; ?>!</p>				
		</div>
		
		<div id="projectListContainer">
			<div class="titleContainer">
				<p id="listTitle">List of Projects</p>
			</div>			
			<div id="projList"><center>
				<ul>
					<?php					 
						for($x=0;$x<count($_SESSION['user']->stackmob->user->user2projects);$x++){
							$url = "http://api.stackmob.com/project/".$_SESSION['user']->stackmob->user->user2projects[$x]->project_id;
							$ch = curl_init($url);
							curl_setopt($ch, CURLOPT_HTTPHEADER, 
											array('Content-Type: application/json; charset=UTF8',
												'Accept: application/vnd.stackmob+json; version=0', 
												'X-StackMob-API-Key: 7da60ed6-518f-4dc5-839c-6869c8ab9930'
												)); 
							curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
							$result = curl_exec($ch);
							//print_r(json_encode($data));
							//echo "<br>";
							$returnData2 = json_decode($result);
							echo '<li><a class="projA" href="proj-select.php?projId='.$_SESSION['user']->stackmob->user->user2projects[$x]->project_id.'">';
							echo $_SESSION['user']->stackmob->user->user2projects[$x]->name;
							echo '</a></li>';


						}
						
					?>
				</ul>
				<form action="projects.php" method="post">	
					<input type="submit" value="" class="imgClass" id="addBut"vspace="15"/></center>
				</form>
			</div>				
		</div>		
	</div>
	
	<div id="footContainer">
	<hr>
	<p id="footer">Copyright 2013 Team MailBug</p>
	</div>
	
</body>
</html>
<?php

} else {
	header('Location: projects.php');
}
?>
