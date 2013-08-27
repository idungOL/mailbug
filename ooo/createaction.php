<?php

	$url = "http://api.stackmob.com/issue/53752e572a794d09a98de2e7faa37f7b/issue2actions";
	$data = array("comment"=>"ohh woh ohh", "sm_owner"=> "nntaclino@numlock.com.ph");
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
	echo "<br>";
	$actionReturn = json_decode($result);
	
	echo "<pre>";
	print_r($actionReturn);
	echo "</pre><br>";
?>