<?php 
/*display image.php uses the $_GET superglobal to get the image name, connects to the mysql
 database reading just the files info and printing out the description the name and the image */
$file=str_replace('display', '',$_GET['page']);
$reqimg='images/'.$file;
$details = getimagesize($reqimg);

$sqlRead="SELECT * FROM gallery2 where filename = '$file'";
$result= mysqli_query($link, $sqlRead);					//connect database
if ($result==false) {
	$content.= mysqli_error($link);
}else {
	$record = mysqli_fetch_assoc($result);
	$name=$record['name'];
	$description=$record['description'];
}														//separating html and php
$content.=htmlBuild('templates/displayimage.html',htmlentities($name),htmlentities($description),htmlentities($reqimg));
?>