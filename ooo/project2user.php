

<?php
//working

$url = "http://api.stackmob.com/project/f03d1aba694346119ad008672859ddbb";
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
	$users=array("nntaclino@numlock.com.ph");
}
else{
echo "<br>";
array_push($users, "nntaclino@numlock.com.ph");
print_r($users);
}

$url = "http://api.stackmob.com/project";
$data = array("project_id"=>"f03d1aba694346119ad008672859ddbb", "project2users"=>
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




?>