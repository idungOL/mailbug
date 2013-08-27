

<?php
$url = "http://api.stackmob.com/project/6a9e943ee0d640ffbf5e9ee35714d85a";
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

?>