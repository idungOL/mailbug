

<?php

//working

//user2projects relation
$url = "http://api.stackmob.com/user/cait@yahoo.com";
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_HTTPHEADER, 
				array('Content-Type: application/json; charset=UTF8',
					'Accept: application/vnd.stackmob+json; version=0', 
					'X-StackMob-API-Key: 7da60ed6-518f-4dc5-839c-6869c8ab9930'
					)); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
$result = curl_exec($ch);
$returnData = json_decode($result);
//echo count($returnData);
echo "<pre>";
print_r($returnData);
echo "<br></pre>";

$projects = $returnData->user2projects;
if(empty($projects)){
	$projects=array("2984b3a6f8494a218b478079a5205536");
}else{
echo "<br>";

array_push($projects, "2984b3a6f8494a218b478079a5205536");
print_r($projects);
}

$url = "http://api.stackmob.com/user";
$data = array("username"=>"cait@yahoo.com", "user2projects"=>
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



?>