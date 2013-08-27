

<?php
/*$url = "http://api.stackmob.com/issue/2ed3fbf0bbe746d4bd6c09d5f48e450a";
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

print_r(date("F d, Y",$returnData->createddate/1000));
*/

$url = "http://api.stackmob.com/user/nntaclino@numlock.com.ph";
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
echo count($returnData);
echo "<pre>";
print_r($returnData);
echo "<br></pre>";



?>