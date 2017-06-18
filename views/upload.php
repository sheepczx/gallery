<?php
$submit = false;
$hasErrors = false;

if (isset($_POST['picfileupload'])) {											//validations for the name and description 
	$submit=true;     														
	if(isset($_POST['name'])){
		if(!validName(trim($_POST['name']))){
			$content.= "<p>Name should contain alphabetic characters, hyphen apostrophe or number</p>";
			$hasErrors=true;
		}
	}else{
		$content.= "<p> Please fill in Name</p>";
		$hasErrors=true;
	}
	if(isset($_POST['description'])){
		if (!validName(trim($_POST['description']))){
			$content.= "<p>Description should contain alphabetic characters, hyphen apostrophe or number</p>";
			$hasErrors=true;
		}
	}else{
		$content.= "<p> Please fill in description</p>";
		$hasErrors=true;
	}
}
if($submit==true && $hasErrors == false){										//if no error start the uploading process
	
	$file = $_FILES['userfile'];
	$error = $file['error'];
	if (is_uploaded_file($_FILES['userfile']['tmp_name'])) {
		if ($error == UPLOAD_ERR_OK) {
			if ((getimagesize($file['tmp_name'])[2])=='2'){ 					//mime type check 1 (not sure its the right way to check it so there is a 2. check)
				if(($_FILES['userfile']['type']== "image/jpeg")) {				//mime type check 2 (not to be trusted)
					$updir = $dir.'/temp/';
					$upfilename = (md5(basename($file['name'], 'jpg'))).".jpg"; 						//further work, name have to be different
					$newname = $updir.$upfilename;
					
					if (file_exists($dir.'/images/'.$upfilename)) {				//checking if the file exists
						$content.= "The file ".basename($file['name'])." already exists!";
						$hasErrors=true;
					} 
					if ($hasErrors==false) {
						$tmpname = $file['tmp_name'];
						if (move_uploaded_file($tmpname, $newname)) {			//file upload
							$content.= '<p>File successfully uploaded<p>';
							$width=150;											//save thumbnails:
							$height=150;
							img_resize($newname, $dir.'/thumbnails/'.$upfilename, $width, $height);
							$width=600;											//save large image
							$height=600;
							img_resize($newname, $dir.'/images/'.$upfilename, $width, $height);
							
							unlink($newname);									//delete the uploaded file
																				//data for mysql because mysql do not eat the lot of brackets and quotes and functions
							$savedImage=getimagesize($dir.'/images/'.$upfilename);
							$filename=$upfilename;
							$name=trim($_POST["name"]);
							$description=trim($_POST["description"]);
							$details=$savedImage[0]."x".$savedImage[1];
							$sqlWrite= "INSERT INTO gallery2 (filename, name, description, details) VALUES ('$filename', '$name', '$description', '$details')";
							
							$result= mysqli_query($link, $sqlWrite);			//connect database					
							
							if ($result==false) {								//mysql error check
								$content.= mysqli_error($link);
							}else {
																				// sql is ok, there is already a success message
							}	
							$_POST['name']='';									//clear the form
							$_POST['description']='';
						} else {
							$content.= 'File upload failed';
						}
					}
				} else {
					$content.= 'File type not permitted. Please upload a jpg file.';
				}
			}else {
					$content.= 'File type not permitted. Please upload a plain text file.';
			}
		} else if ($error == UPLOAD_ERR_NO_FILE) {
			$content.= 'No file selected.';
		} else if ($error == UPLOAD_ERR_INI_SIZE) {
			$content.= 'Maximum file size exceeded.';
		} else {
			$content.= 'Oops. Something went wrong.';
		}
	}	
}																				//separating html and php

$content.=htmlBuild('templates/form.html',(htmlentities($_SERVER['REQUEST_URI'], ENT_QUOTES, 'UTF-8')),(isset($_POST['name'])? htmlentities($_POST['name']):''),(isset($_POST['description'])? htmlentities($_POST['description']):''));
?>
 
	
