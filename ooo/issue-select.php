<?php
session_start();
if(empty($_SESSION['user'])){
header('Location: login.php');
}
if(empty($_GET['issueSel'])){
	header('Location: proj-list.php');
}

$_SESSION['issueSel']=$_GET['issueSel'];
/*
	echo "<pre>";
	print_r($_SESSION['issueSel']);
	echo "<br>";
	print_r($_SESSION['user']->stackmob->user->username);
	echo "<br>";
	print_r($_POST['action']);
	echo "</pre><br>";
*/


if(($_POST['action'])!=""){


	//create issue2actions relation and create action
	$url = "http://api.stackmob.com/issue/".$_SESSION['issueSel']."/issue2actions";
	$data = array("comment"=>$_POST['action'], "sm_owner"=> $_SESSION['user']->stackmob->user->username);
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
	$actionReturn = json_decode($result);
	$_SESSION['action']=$actionReturn;
	//echo "<pre>";
	//print_r($actionReturn);
	//echo "<br>";
	
	//creating action2issue relation
	
	$url = "http://api.stackmob.com/action";
	$data = array("action_id"=>$_SESSION['action']->action_id, "action2issue"=>
							$_SESSION['issueSel']);
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
	curl_setopt($ch, CURLOPT_HTTPHEADER, 
				array('Content-Type: application/json; charset=UTF8',
					'Accept: application/vnd.stackmob+json; version=0', 
					'X-StackMob-API-Key: 7da60ed6-518f-4dc5-839c-6869c8ab9930',
					'X-StackMob-Relations: action2issue=issue'
					)); 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
	$result = curl_exec($ch);
	$projReturn = json_decode($result);
	//print_r($projReturn);
	
	//create action2status relation and create status
	$url = "http://api.stackmob.com/action/".$_SESSION['action']->action_id."/action2status";
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
	$_SESSION['action2status']=$statusReturn;
	
	//creating status2action relation
	
	$url = "http://api.stackmob.com/status";
	$data = array("status_id"=>$_SESSION['status']->status_id, "status2action"=>
							$_SESSION['action']->action_id);
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
	curl_setopt($ch, CURLOPT_HTTPHEADER, 
				array('Content-Type: application/json; charset=UTF8',
					'Accept: application/vnd.stackmob+json; version=0', 
					'X-StackMob-API-Key: 7da60ed6-518f-4dc5-839c-6869c8ab9930',
					'X-StackMob-Relations: status2action=action'
					)); 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
	$result = curl_exec($ch);
	$projReturn = json_decode($result);
	//print_r($projReturn);

		
	
}

//query issue

$url = "http://api.stackmob.com/issue/".$_SESSION['issueSel'];
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_HTTPHEADER, 
				array('Content-Type: application/json; charset=UTF8',
					'Accept: application/vnd.stackmob+json; version=0', 
					'X-StackMob-API-Key: 7da60ed6-518f-4dc5-839c-6869c8ab9930',
					'X-StackMob-Expand: 1'
					)); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
$result = curl_exec($ch);
$returnData = json_decode($result);
$_SESSION['issue2actionSel']=$returnData;
/*
echo "<pre>";
print_r($returnData);
echo "</pre>";
*/


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
	
	<div id="contentContainer">
		<div id="welcomeContainer">
			<p id="welcome">Welcome, <?php echo $_SESSION['user']->stackmob->user->firstname; ?>!</p>				
		</div>
		
		<div id="issueSelectContainer">
			<div id="projSelectHead">
				<span id="projectTitle">Project Name: <?php echo $_SESSION['chosenProj']->name; ?></span>
				<span id="lopSpan"><a href="proj-select.php?projId=<?php echo $_SESSION['chosenProj']->project_id; ?>" id="lopLink">List of Issues</a></span>
			</div>
			
			<div id="issueDetail">
				<div id="issueHead">
					Issue Detail
				</div>
				<div id="issueBody">
					<span id="author">created by: <?php echo $returnData->sm_owner; ?></span>
					<span id="dateCreated"><?php echo date("F d, Y",$_SESSION['issue2actionSel']->createddate/1000); ?></span>
					<p id="appIssue"><?php echo $_SESSION['issue2actionSel']->description;  ?></p>
					<div id="commentContainer">
						<div id="issueComCont">
							<form action="issue-select.php?issueSel=<?php echo $_SESSION['issueSel']; ?>" method="post">
							<input type="text" placeholder="add comment" id="issueComment" name="action">	
							<span id="commentStatus">
								<div class="box" id="<?php echo $_SESSION['issue2actionSel']->issue2status->description; ?>"></div>
								<div id="status"><?php echo $_SESSION['issue2actionSel']->issue2status->description; ?>
									<form action="issue-select.php?issueSel=<?php echo $_SESSION['issueSel']; ?>" method="post">
										<select name="status" onchange="this.form.submit()" style="width:20px">
										<option value="open">Open</option>
										<option value="verified">Verified</option>
										<option value="resolved">Resolved</option>
										</select>
									</form>
								</div>
							</span>
							</form>
						</div>
											
					</div>			
				</div>
			
			</div>
			
			<?php if(isset($_SESSION['issue2actionSel']->issue2actions)){ 
				for($x=0;$x<count($_SESSION['issue2actionSel']->issue2actions);$x++){
			?>
			<div id="commentDetail">
			<form action="issue-select.php?issueSel=<?php echo $_SESSION['issueSel']; ?>" method="post">
				<div id="issueBody">
					<span id="author"><?php echo $_SESSION['issue2actionSel']->issue2actions[$x]->sm_owner; ?></span>
					<span id="dateCreated"><?php echo date("F d, Y", $_SESSION['issue2actionSel']->issue2actions[$x]->createddate/1000); ?></span>
					<p class="appIssue"><?php echo $_SESSION['issue2actionSel']->issue2actions[$x]->comment; ?> </p>
					<div id="commentContainer">
						<div id="commentCont">
							
							<input type="text" placeholder="add comment" id="issueReply">	
							<span id="comStatus">
								<div class="box" id="<?php echo $_SESSION['issue2actionSel']->issue2status->description; ?>"></div>
								<div id="status"><?php echo $_SESSION['issue2actionSel']->issue2status->description; ?>
									
										<select name="action" onchange="this.form.submit()" style="width:20px">
										<option value="open">Open</option>
										<option value="verified">Verified</option>
										<option value="resolved">Resolved</option>
										</select>
									
								</div>
							</span>
							
						</div>
											
					</div>			
				</div>
			</form>
			</div>
		
		
				<?php }} ?>	
		</div>



	
	</div>
	<div id="footContainer">
	<hr>
	<p id="footer">Copyright 2013 Team MailBug</p>
	</div>

	

	
	
	
</body>
</html>

