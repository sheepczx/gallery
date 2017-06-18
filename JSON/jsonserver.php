<?php
/*jsonserver.php reads the gallery table in the sql database and creates a json array
if moving the config.php (with the database details) have to be included*/
header('content-type: application/json');
require '/home/gbirge01/public_www/gallery/includes/config.php';
$jsonData=array();
$sqlRead="SELECT filename, name, description, details FROM gallery2";
$result= mysqli_query($link, $sqlRead);				//connect database
if ($result==false) {
	$content.= mysqli_error($link);
}else {
	
	while ($record = mysqli_fetch_assoc($result)) {	
		$jsonData[]= $record;
		
	}
}
$json= json_encode($jsonData);

echo $json;
?>