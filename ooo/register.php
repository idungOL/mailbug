<?php 
	if(empty($_POST)){
	$public_key = 'X-StackMob-API-Key: 7da60ed6-518f-4dc5-839c-6869c8ab9930';
			
?>

<!DOCTYPE html>
<html>
<head>

<title>Mailbug - Register</title>

		<link rel="stylesheet" type="text/css" href="mailbug.css" />
</head>

<body>
	<div id="headContainer">
		<div id="logoContainer">
			<img src="img/logo_title.png">
		</div>
		
		<div id="navContainer">
			<div id="navlinkContainer">
				<span class="navlinks"><a href="login.php">Log in</a></span>
				<span class="navlinks" id="active"><a href="">Register</a></span>
				<span class="navlinks"><a href="#">About</a></span>
			</div>
		</div>
		
		<img id="headBar" src="img/header_option_2.png">
	</div>
	
	<div id="contentContainer">
		<div id="registerContainer">
		
			<form action="register.php" method="post">
				<div class="titleContainer">
						<p>Register</p>				
				</div>
				<div id="inputContainer">
					 <center>				
					 <p><input type="text" name="fname" value="" placeholder="Firstname" vspace="5"></p>
					 <p><input type="text" name="lname" value="" placeholder="Lastname" vspace="5"></p>
					 <p><input type="text" name="email" value="" placeholder="Email" vspace="5"></p>
					 <p><input type="text" name="cEmail" value="" placeholder="Confirm Email" vspace="5"></p>
					 <p><input type="password" name="password" value="" placeholder="Password" vspace="5"></p>
					 <p><input type="password" name="cPassword" value="" placeholder="Confirm Password" vspace="5"></p>
					 </center>
					 
						 <div id="submitContainer">
						 	<input type="submit" value="" class="imgClass" id="submitBut"vspace="15"/>
						 </div>					
				</div>
			</form>
			
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
		$fname = $_POST['fname'];
		$lname = $_POST['lname'];
		$email = $_POST['email'];
		$cEmail= $_POST['cEmail'];
		$password = $_POST['password'];
		$cPassword = $_POST['cPassword'];
		
		if( (empty($fname)) || (empty($lname)) || (empty($email)) || (empty($cEmail)) || (empty($password)) || (empty($cPassword)) )
		{
				echo '<script>alert("Some fields are required.");</script>';
				echo '<script>window.history.back();</script>';
				exit;
		}

		if ($email!=$cEmail){
				echo '<script>alert("Email address does not match.");</script>';
				echo '<script>window.history.back();</script>';
				exit;
		}

		if ($password!=$cPassword){
				echo '<script>alert("Password does not match.");</script>';
				echo '<script>window.history.back();</script>';
				exit;
		}
		
			 $url = "http://api.stackmob.com/user/".$email;
			//$data = array(3=>"nntaclino@numlock.com.ph");
			$ch = curl_init($url);
			// curl_setopt($ch, CURLOPT_POST, 1);
			// curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
			curl_setopt($ch, CURLOPT_HTTPHEADER, 
					array('Content-Type: application/json; charset=UTF8',
						'Accept: application/vnd.stackmob+json; version=0', 
						'X-StackMob-API-Key: 7da60ed6-518f-4dc5-839c-6869c8ab9930'
						)); 
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
			$result = curl_exec($ch);

			
			
			$returnData = json_decode($result);
						
			
			if ($returnData->has_registered==TRUE){
							echo '<script>alert("Email address is invalid.");</script>';
							echo '<script>window.history.back();</script>';
							exit;
					}
					
			
			$url = "https://api.stackmob.com/user";
			$data = array("username" => $email, "firstname" => $fname, "lastname" => $lname, "password" => $password, "has_registered"=>TRUE);
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
			//print_r($result);
			
			$returnData = json_decode($result);
			
			if(empty($returnData->error)){
			echo '<script>alert("'.$returnData->username .' has been registered!");</script>';
			session_start();
			$url = "https://api.stackmob.com/user/accessToken";
			$data = array("username" => $email, "password" => $password, "token_type"=>"mac");
			
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
			header('Location: proj-list.php');
			}
	}

?>
