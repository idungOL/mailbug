<?php
session_start();
if(empty($_SESSION['user'])){
	header('Location: login.php');
	
}

	
	//query project
	if(isset($_GET['projId'])){
	
	$url = "http://api.stackmob.com/project/".$_GET['projId'];
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_HTTPHEADER, 
				array('Content-Type: application/json; charset=UTF8',
					'Accept: application/vnd.stackmob+json; version=0', 
					'X-StackMob-API-Key: 7da60ed6-518f-4dc5-839c-6869c8ab9930'
					)); 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
	$result = curl_exec($ch);
	$returnProj = json_decode($result);
	$_SESSION['chosenProj']=$returnProj;
	}
	
	//echo $_POST['assignTo'];
	//echo $_POST['issueTxt'];
	//print_r($_SESSION['chosenProj']->project_id);
	
	
	//create project2issues relation and create issues
	if(isset($_POST['issueTxt'])){	
	$url = "http://api.stackmob.com/project/".$_SESSION['chosenProj']->project_id ."/project2issues";
	$data = array("description"=>$_POST['issueTxt'], "sm_owner"=> $_SESSION['user']->stackmob->user->username);
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
	curl_setopt($ch, CURLOPT_HTTPHEADER, 
				array('Content-Type: application/json; charset=UTF8',
					'Accept: application/vnd.stackmob+json; version=0', 
					'X-StackMob-API-Key: 7da60ed6-518f-4dc5-839c-6869c8ab9930'
					)); 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 	
	$result = curl_exec($ch);
	//echo "<br>";
	$issueReturn = json_decode($result);
	$_SESSION['issue']=$issueReturn;
	
	
	
	//create issue2project relation	
	
	
	
	$url = "http://api.stackmob.com/issue";
	$data = array("issue_id"=>$_SESSION['issue']->issue_id, "issue2project"=>
							$_SESSION['chosenProj']->project_id);
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
	curl_setopt($ch, CURLOPT_HTTPHEADER, 
				array('Content-Type: application/json; charset=UTF8',
					'Accept: application/vnd.stackmob+json; version=0', 
					'X-StackMob-API-Key: 7da60ed6-518f-4dc5-839c-6869c8ab9930',
					'X-StackMob-Relations: issue2project=project'
					)); 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
	$result = curl_exec($ch);
	$projReturn = json_decode($result);
	
	
//create issue2status relation and create status
	$url = "http://api.stackmob.com/issue/".$_SESSION['issue']->issue_id."/issue2status";
	$data = array("description"=>"open", "sm_owner"=>$_SESSION['user']->stackmob->user->username);
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
	curl_setopt($ch, CURLOPT_HTTPHEADER, 
				array('Content-Type: application/json; charset=UTF8',
					'Accept: application/vnd.stackmob+json; version=0', 
					'X-StackMob-API-Key: 7da60ed6-518f-4dc5-839c-6869c8ab9930'
					)); 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 	
	$result = curl_exec($ch);
	//echo "<br>";
	$statusReturn = json_decode($result);
	$_SESSION['status']=$statusReturn;
	
	//creating status2issue relation
	
	$url = "http://api.stackmob.com/status";
	$data = array("status_id"=>$_SESSION['status']->status_id, "status2issue"=>
							$_SESSION['issue']->issue_id);
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
	curl_setopt($ch, CURLOPT_HTTPHEADER, 
				array('Content-Type: application/json; charset=UTF8',
					'Accept: application/vnd.stackmob+json; version=0', 
					'X-StackMob-API-Key: 7da60ed6-518f-4dc5-839c-6869c8ab9930',
					'X-StackMob-Relations: status2issue=issue'
					)); 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
	$result = curl_exec($ch);
	$projReturn = json_decode($result);
	//print_r($projReturn);

	
	
	//create issue2user
	
	$url = "http://api.stackmob.com/issue";
	$data = array("issue_id"=>$_SESSION['issue']->issue_id, "issue2user"=>
							$_POST['assignTo']);
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
	curl_setopt($ch, CURLOPT_HTTPHEADER, 
				array('Content-Type: application/json; charset=UTF8',
					'Accept: application/vnd.stackmob+json; version=0', 
					'X-StackMob-API-Key: 7da60ed6-518f-4dc5-839c-6869c8ab9930',
					'X-StackMob-Relations: issue2project=user'
					)); 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
	$result = curl_exec($ch);
	$projReturn = json_decode($result);		
	
	//creating user2issue
	$url = "http://api.stackmob.com/user/".$_POST['assignTo'];
	
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_HTTPHEADER, 
		array('Content-Type: application/json; charset=UTF8',
			'Accept: application/vnd.stackmob+json; version=0', 
			'X-StackMob-API-Key: 7da60ed6-518f-4dc5-839c-6869c8ab9930'
			)); 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
	$result = curl_exec($ch);			
	
	$returnData = json_decode($result);	
	
	$issues = $returnData->user2issues;
	
	if(empty($issues)){
		$issues =array($_POST['assignTo']);
	}
	else{
	array_push($issues, $_POST['assignTo']);
	//print_r($issues);
	}
	
	
	$url = "http://api.stackmob.com/user";
	$data = array("username"=>$_POST['assignTo'], "user2issues"=>array(
							$_SESSION['issue']->issue_id));
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
	curl_setopt($ch, CURLOPT_HTTPHEADER, 
				array('Content-Type: application/json; charset=UTF8',
					'Accept: application/vnd.stackmob+json; version=0', 
					'X-StackMob-API-Key: 7da60ed6-518f-4dc5-839c-6869c8ab9930',
					'X-StackMob-Relations: user2issues=issue'
					)); 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
	$result = curl_exec($ch);
	$projReturn = json_decode($result);
	
	//print_r($projReturn);
		
	}


//querying issue

$url = "http://api.stackmob.com/issue/".$_SESSION['issue']->issue_id;
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_HTTPHEADER, 
				array('Content-Type: application/json; charset=UTF8',
					'Accept: application/vnd.stackmob+json; version=0', 
					'X-StackMob-API-Key: 7da60ed6-518f-4dc5-839c-6869c8ab9930'
					)); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
$result = curl_exec($ch);
$returnData = json_decode($result);

	$url = "http://api.stackmob.com/project/".$_GET['projId'];
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_HTTPHEADER, 
				array('Content-Type: application/json; charset=UTF8',
					'Accept: application/vnd.stackmob+json; version=0', 
					'X-StackMob-API-Key: 7da60ed6-518f-4dc5-839c-6869c8ab9930'
					)); 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
	$result = curl_exec($ch);
	$returnProj = json_decode($result);
	$_SESSION['chosenProj']=$returnProj;

	
?>

<!DOCTYPE html>
<html>
<head>

<title>Mailbug - Projects - Select</title>

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
	
	<div id="mid">
	<div id="contentContainer">
		<div id="welcomeContainer">
			<p id="welcome">Welcome, <?php echo $_SESSION['user']->stackmob->user->firstname;?>!</p>				
		</div>
	<div id="combo">
		<div id="projSelectContainer">
			<div id="projSelectHead">
				<span id="projectTitle">Project Name: <?php echo $_SESSION['chosenProj']->name; ?></span>
				<span id="lopSpan"><a href="proj-list.php" id="lopLink">List of Projects</a></span>
			</div>
			
			<div id="issueList">
				<p id="issueTitle">Issues</p>
					<div id="issueContent">
					
						<ol id="issueOl">
		<?php 
			foreach($_SESSION['chosenProj']->project2issues as $x=>$returnData2){
			echo '<li><a class="projA"href="issue-select.php?issueSel='.$returnData2.'">';
					$url = "http://api.stackmob.com/issue/".$returnData2;
					$ch = curl_init($url);
					curl_setopt($ch, CURLOPT_HTTPHEADER, 
					array('Content-Type: application/json; charset=UTF8',
						'Accept: application/vnd.stackmob+json; version=0', 
						'X-StackMob-API-Key: 7da60ed6-518f-4dc5-839c-6869c8ab9930'
						)); 
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
					$result = curl_exec($ch);
					$returnData = json_decode($result);
					echo $returnData->description;		
			echo '</a></li>';
			}
			
		?>
						</ol>
					<form action="issue-add.php" method="post">			
						<center><input type="submit" value="" class="imgClass" id="addBut"vspace="15"/></center>	
					</form>	
					</div>
						
			</div>
		</div>
		
		<!-- Right -->
		
		<div id="memberCont">
			<div id="memTitle">Members</div>
			<ul>
				<?php 
			foreach($returnProj->project2users as $x=>$returnData2){
			
			echo '<li>';
			echo $returnData2;
			echo '</a></li>';
			}
			
		?>			</ul>
			<form action="member-add.php" method="post">	
			<center><input type="submit" value="" class="imgClass" id="addBut"vspace="15"/></center>	
			</form>		
		</div>
	</div>
	</div>
	</div>

	<div id="footContainer">
	<br clear="all">
	<hr>
	<p id="footer">Copyright 2013 Team MailBug</p>
	</div>


</body>
</html>