<?php
/*jasonclient.php checks the url in line 6 and if everithing works fine prints out a 
table using the jsontable function or prints out an error message.
if you want to move the file the required function and (maybe) the url have to be changed*/
$curl = curl_init();
//require '/home/gbirge01/public_www/gallery/includes/functions.php';
curl_setopt($curl, CURLOPT_URL, 'http://titan.dcs.bbk.ac.uk/~gbirge01/gallery/JSON/jsonserver.php');
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$json = curl_exec($curl);

if($json){
	$json=json_decode($json, true);
	echo jsontable($json);
}else{
	echo 'Error code:', curl_errno($curl).'<br>';
	echo 'Error message:', curl_error($curl).'<br>';
}

curl_close($curl);

?>