<?php
session_start();
if(empty($_SESSION['user'])){
	header('Location: login.php');
}
if(empty($_POST['projName'])){

	
?>

<!DOCTYPE html>
<html>
<head>

<title>Mailbug - Projects</title>

		<link rel="stylesheet" type="text/css" href="mailbug.css" />
		<script type="text/javascript" src="jquery-1.3.2.min.js"></script>
</head>

<body>
<script type="text/javascript">
 
$(document).ready(function(){
 
    var counter = 2;
 
    $("#addBut").click(function () {
 
	if(counter>15){
            alert("Only 15 textboxes allow");
            return false;
	}   
 
	var newTextBoxDiv = $(document.createElement('div'))
	     .attr("id", 'memberTF' + counter);
 
	newTextBoxDiv.after().html(
	      '<p><input type="text" name="' + counter + 
	      '"  placeholder="Email Address"></p>');
 
	newTextBoxDiv.appendTo("#memberTF");
 
 
	counter++;
     });
 /*
     $("#removeButton").click(function () {
	if(counter==1){
          alert("No more textbox to remove");
          return false;
       }   
 
	counter--;
 
        $("#TextBoxDiv" + counter).remove();
 
     });
 
     $("#getButtonValue").click(function () {
 
	var msg = '';
	for(i=1; i<counter; i++){
   	  msg += "\n Textbox #" + i + " : " + $('#textbox' + i).val();
	}
    	  alert(msg);
     });*/
  });
</script>

	<div id="bodyCon">
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
		<form action="projects.php" method="post">
			<div id="welcomeContainer">
				<p id="welcome">Welcome, <?php echo $_SESSION['user']->stackmob->user->firstname; ?>!</p>				
			</div>
			<div id="projectContainer">
				<center>
				<div class="titleContainer">
				
					<p>Create a Project</p></div>
					<p><input type="text" name="projName" value="" placeholder="Project Name" vspace="5"></p>
				</center>
			</div>
			
			<div id="memberContainer">
				<center>
				<div id="membertitleContainer">
					<p>Add a Member</p></div>
					<div id="memberTF">
					<p><input type="hidden" name="0" value="<?php echo $_SESSION['user']->stackmob->user->username; ?>" vspace="5"></p>
					<p><input type="text" name="1" placeholder="Email Address" vspace="5"></p>
					</div>
					<input type="button"  class="imgClass" id="addBut" vspace="15"/>
				</center>					
				
			</div>
			<div id="submitProj">
				
					<center>
						<input type="submit" class="imgClass" id="submitBut" vspace="15"/>
					</center>
				
			</div>
		</form>
		</div>
	
		<div id="footContainer">
		<hr>
		<p id="footer">Copyright 2013 Team MailBug</p>
		</div>
	
	</div>
		
</body>
</html>
<?php

}
else{


$url = "http://api.stackmob.com/user/".$_SESSION['user']->stackmob->user->username;
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_HTTPHEADER, 
				array('Content-Type: application/json; charset=UTF8',
					'Accept: application/vnd.stackmob+json; version=0', 
					'X-StackMob-API-Key: 7da60ed6-518f-4dc5-839c-6869c8ab9930'
					)); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
$result = curl_exec($ch);
$returnData = json_decode($result);
echo count($returnData);
echo "user: <pre>";
print_r($returnData);
echo "<br></pre>";

$num = count($_POST);


//*****creating users
	for($x=1;$x<$num-1;$x++){
		$url = "http://api.stackmob.com/user/".$_POST[$x];

		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, 
				array('Content-Type: application/json; charset=UTF8',
					'Accept: application/vnd.stackmob+json; version=0', 
					'X-StackMob-API-Key: 7da60ed6-518f-4dc5-839c-6869c8ab9930'
					)); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
		$result = curl_exec($ch);			
		
		$returnData = json_decode($result);	
		echo "<br><pre>";
		print_r($returnData);	
		echo "</pre>";
					
	
		if ($returnData->error==TRUE){										
			$url = "https://api.stackmob.com/user";
			$data = array("username" => $_POST[$x]);
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
			curl_setopt($ch, CURLOPT_HTTPHEADER, 
						array('Content-Type: application/json', 
							'Accept: application/vnd.stackmob+json; version=0', 
							'X-StackMob-API-Key: 7da60ed6-518f-4dc5-839c-6869c8ab9930'
							));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
			$result = curl_exec($ch);

		}
	
	}

//**************************


$projName = $_POST['projName'];


//creating project with relation to author (user2projects)
$url = "http://api.stackmob.com/user/".$_SESSION['user']->stackmob->user->username."/user2projects";
$data = array("name"=>$projName);
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
$projReturn = json_decode($result);
print_r($projReturn);
$_SESSION['project'] = $projReturn;


//user2projects relation
for($x=1;$x<$num-1;$x++){
$url = "http://api.stackmob.com/user/".$_POST[$x];
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_HTTPHEADER, 
				array('Content-Type: application/json; charset=UTF8',
					'Accept: application/vnd.stackmob+json; version=0', 
					'X-StackMob-API-Key: 7da60ed6-518f-4dc5-839c-6869c8ab9930'
					)); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
$result = curl_exec($ch);
$returnData = json_decode($result);

$projects = $returnData->user2projects;
if(empty($projects)){
	$projects=array($_SESSION['project']->project_id);
}else{
echo "<br>";

array_push($projects, $_SESSION['project']->project_id);
print_r($projects);
}

$url = "http://api.stackmob.com/user";
$data = array("username"=>$_POST[$x], "user2projects"=>
							$projects);
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, 
				array('Content-Type: application/json; charset=UTF8',
					'Accept: application/vnd.stackmob+json; version=0', 
					'X-StackMob-API-Key: 7da60ed6-518f-4dc5-839c-6869c8ab9930',
					'X-StackMob-Relations: project2users=project'
					)); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
$result = curl_exec($ch);
$projReturn = json_decode($result);
echo "<br><pre>";
print_r($projReturn);
echo "</pre>";


}


//****************
//creating project2users relation
for($x=0;$x<$num-1;$x++){
$url = "http://api.stackmob.com/project/".$_SESSION['project']->project_id;
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_HTTPHEADER, 
				array('Content-Type: application/json; charset=UTF8',
					'Accept: application/vnd.stackmob+json; version=0', 
					'X-StackMob-API-Key: 7da60ed6-518f-4dc5-839c-6869c8ab9930'
					)); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
$result = curl_exec($ch);
$returnData = json_decode($result);
echo count($returnData);
echo "<pre>";
print_r($returnData);
echo "<br></pre>";


$users = $returnData->project2users;
if(empty($users)){
	$users=array($_POST[$x]);
}
else{
array_push($users, $_POST[$x]);
print_r($users);
}

$url = "http://api.stackmob.com/project";
$data = array("project_id"=>$_SESSION['project']->project_id, "project2users"=>
							$users);
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, 
				array('Content-Type: application/json; charset=UTF8',
					'Accept: application/vnd.stackmob+json; version=0', 
					'X-StackMob-API-Key: 7da60ed6-518f-4dc5-839c-6869c8ab9930',
					'X-StackMob-Relations: project2users=user'
					)); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
$result = curl_exec($ch);
$projReturn = json_decode($result);
echo "<br><pre>";
print_r($projReturn);
echo "</pre>";


//HERE
	$url = "https://api.stackmob.com/user/refreshToken";
	$data = array("refresh_token" => $_SESSION['user']->refresh_token, 'grant_type' => 'refresh_token', "token_type"=>"mac", 'mac_algorithm' => 'hmac-sha-1');
	
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
	curl_setopt($ch, CURLOPT_HTTPHEADER, 
			array('Content-Type: application/x-www-form-urlencoded', 
				'Accept: application/vnd.stackmob+json; version=0', 
				'X-StackMob-API-Key: 7da60ed6-518f-4dc5-839c-6869c8ab9930',
				'X-StackMob-User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_8_4) AppleWebKit/536.30.1 (KHTML, like Gecko) Version/6.0.5 Safari/536.30.1',
				'X-StackMob-Expand: 1'
				));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
	$result = curl_exec($ch);
	//print_r(json_encode($data));
	//echo "<br>";
	$returnData = json_decode($result);	
	
	$_SESSION['user']=$returnData;
//HERE

}
//****************
//****************





if(empty($returnData->error)){
		$url = "https://api.stackmob.com/user/refreshToken";
		$data = array("refresh_token" => $_SESSION['user']->refresh_token, 'grant_type' => 'refresh_token', "token_type"=>"mac", 'mac_algorithm' => 'hmac-sha-1');
		
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
		curl_setopt($ch, CURLOPT_HTTPHEADER, 
				array('Content-Type: application/x-www-form-urlencoded', 
					'Accept: application/vnd.stackmob+json; version=0', 
					'X-StackMob-API-Key: 7da60ed6-518f-4dc5-839c-6869c8ab9930',
					'X-StackMob-User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_8_4) AppleWebKit/536.30.1 (KHTML, like Gecko) Version/6.0.5 Safari/536.30.1',
					'X-StackMob-Expand: 1'
					));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
		$result = curl_exec($ch);
		//print_r(json_encode($data));
		//echo "<br>";
		$returnData = json_decode($result);	
	
	unset($_SESSION['user']);
	$_SESSION['user']=$returnData;
	
	header('Location: proj-list.php');
}

}
	
?>