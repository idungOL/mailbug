<?php

$dummy[0]="gwapa@yahoo.com";
$dummy[1]="chinita@yahoo.com";
$dummy[2]="nntaclino@numlock.com.ph";

//creating users
	for($x=0;$x<3;$x++){
		$url = "http://api.stackmob.com/user/".$dummy[$x];

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
			$data = array("username" => $dummy[$x]);
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
?>