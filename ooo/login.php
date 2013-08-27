<?php
	if(isset($_SESSION['user'])){
	header('Location: proj-list.php');
	}

if(empty($_POST)){

?>

<!DOCTYPE html>
<html>
<head>

<title>Mailbug - Log In</title>

		
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
		<script type="text/javascript" src="http://static.stackmob.com/js/stackmob-js-0.9.2-bundled-min.js"></script>
		<link rel="stylesheet" type="text/css" href="mailbug.css" />
		<script type="text/javascript" src="sm.js"></script>
		
</head>

<body>
	<div id="headContainer">
		<div id="logoContainer">
			<img src="img/logo_title.png">
		</div>
		<div id="navContainer">
			<div id="navlinkContainer">
				<span class="navlinks" id="active"><a href="">Log in</a></span>
				<span class="navlinks"><a href="register.php">Register</a></span>
				<span class="navlinks"><a href="#">About</a></span>
			</div>
		</div>
		<img id="headBar" src="img/header_option_1.png">
	</div>
	
	<div id="contentContainer">
		<div id="loginContainer">
			<div class="titleContainer">
				<p>Log in</p>
			</div>
			<div id="inputContainer">
				<form action="login.php" method="post"><center>
					 <p><input type="text" name="email" value="" placeholder="Email address" vspace="15"></p>
					 <p><input type="password" name="password" value="" placeholder="Password" vspace="15"></p></center>
					 <div id="submitContainer">
					 	<input type="submit" value="" class="imgClass" id="submitBut"vspace="15"/>				 
					 </div>
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
}
else {
	session_start();
	$url = "https://api.stackmob.com/user/accessToken";
	$data = array("username" => $_POST['email'], "password" => $_POST['password'], "token_type"=>"mac");
	
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
	
	
	$returnData = json_decode($result);
	$_SESSION['user']=$returnData;


	
	echo("<pre>");
	print_r($returnData->stackmob->user->user2projects);
	echo count($returnData->stackmob->user->user2projects);
	echo("</pre>");
	
	


	if(empty($returnData->error)) {
		header('Location: proj-list.php');

	}
	else{
		echo '<script>alert("Invalid email address of password.");</script>';
		echo '<script>window.history.back();</script>';
	}
}
?>
