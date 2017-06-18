<?php
/* the galery.php reads the images directory connects to the mysql database and prints out all of the images with their names*/
$imgDir = opendir($dir.'/images');
while(false !== ($file = readdir($imgDir))){
	$file_parts = pathinfo($file);
	if((is_file('images/'.$file))&&($file_parts['extension']=="jpg")){ //checks if its a jpg image or not
		
		$sqlRead="SELECT * FROM gallery2 where filename = '$file'";	
		$result= mysqli_query($link, $sqlRead);					//connect database
		if ($result==false) {
			$content.= mysqli_error($link);
		}else {
			$record = mysqli_fetch_assoc($result);
			$name=$record['name'];
			$description=$record['description'];
		}														//separating html and php
		$content.=htmlBuild('templates/gallery.html',htmlentities($name),htmlentities($file));
	}
}

?>