<?php
	session_start();
	if(empty($_SESSION['user'])){
	header('Location: login.php');
	}	
?>


<!DOCTYPE html>
<html>
<head>

<title>Mailbug - Projects</title>

		<link rel="stylesheet" type="text/css" href="mailbug.css" />
</head>

<body>
	<div id="headContainer">
		<div id="logoContainer">
			<img src="img/logo_title.png">
		</div>
		<div id="navContainer">
			<div id="navlinkContainer">
				<span class="navlinks" id="active"><a href="proj-list.php">Projects</a></span>
				<span class="navlinks"><a href="#">Settings</a></span>
				<span class="navlinks"><a href="#">About</a></span>
			</div>
		</div>
		<img id="headBar" src="img/header_option_1.png">
	</div>
	
	<div id="contentContainer">
		<div id="welcomeContainer">
			<p id="welcome">Welcome, <?php echo $_SESSION['user']->stackmob->user->firstname;?>!</p>				
		</div>
		
		<div id="addIssueCont">
			<form action="proj-select.php?projId=<?php echo $_SESSION['chosenProj']->project_id; ?>" method="post" >
				<div class="addTitleContainer">
					<p>Add an Issue</p>
				</div>
				<div id="txtArea">
					<center>		
					<textarea style="width:390px;height:200px;" name="issueTxt" wrap="type"> </textarea>
					<select name="assignTo" id="assignOp" style="width:auto" > 
									<?php 
										foreach($_SESSION['chosenProj']->project2users as $x=>$returnData2){			
											echo '<option class="assignV" value="'.$returnData2.'">';
											echo $returnData2;
											echo '</option>';
										}
										
									?>
									
						</select>
						
					</center>			
				</div>
				<center><input type="submit" value="" class="imgClass" id="submitBut"vspace="30"/></center>
			</form>	
		</div>
		
		
	</div>
	
	<div id="footContainer">
	<hr>
	<p id="footer">Copyright 2013 Team MailBug</p>
	</div>