<?php

$url = "http://api.stackmob.com/project";
$data = array("name"=>"asasa1");
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

$url = "http://api.stackmob.com/user/nntaclino@numlock.com.ph/user2projects";
$data = array("name"=>"asasa2");
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
$projReturn = json_decode($result);
print_r($projReturn);
$_SESSION['project'] = $projReturn;

?>