<?php	
	$url = "https://api.stackmob.com/user/accessToken";
	$data = array("username" => "nntaclino@gmail.com", "password" => "test", "token_type"=>"mac");
	
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
	print_r($returnData);
	echo("</pre><br>");
	echo count($returnData->stackmob->user->user2projects);
	echo("<br><pre>");
	//print_r($returnData->stackmob->user->user2projects[0]->project_id);
	echo("</pre>");
	

	
?>