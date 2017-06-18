<?php
function validName($name) { 
	/*this function validates names, returns true if the name is longer than
	2 characters only contain letters numbers aposthropes or hyphens.
	*/
	if ((strlen(trim($name)))<2){
		return false;
	}
	$alloved= array("'","-"," ");
	$name=str_replace($alloved, "", trim($name)); //ready to check alphanum
	if (!ctype_alnum($name)){
		return false;
	}
	return true;
}

function img_resize($original, $out_img_file, $new_width, $new_height) {
	/*this function resize a given image and save it to a given folder 
	accepts jpg gif and png files, returns jpg from all. the quality will be 90%.
	to use it you need the calcRatio function.
	the function asks for 4 arguments: first the file to manipulate(gif, jpg or png) 
	second the output directory then the max width and height.
	no known issues.
	*/
	$details = getimagesize($original);
	if ($details !== false) {
		switch ($details[2]) {
			case IMAGETYPE_JPEG: // JPG File
				$src = imagecreatefromjpeg($original);
				break;
			case IMAGETYPE_GIF: //gif File
				$src = imagecreatefromgif($original);
				break;
			case IMAGETYPE_PNG: // png File
				$src = imagecreatefrompng($original);
				break;
		}
		$width = $details[0];
		$height = $details[1];
		
		
		$ratio=calcRatio($width,$height,$new_width,$new_height);
		
		$new_height=$ratio['height'];
		$new_width=$ratio['width'];		
		
		$new = imagecreatetruecolor($new_width, $new_height);
		imagecopyresampled($new, $src, 0, 0, 0, 0, $new_width,
		$new_height, $width, $height);
		
		imagejpeg($new, $out_img_file, 90); // Save in images dir
		imagedestroy($src);
		imagedestroy($new);
	} else {
		echo '<p>Not valid image/problem opening it.</p>';
	}
}

function jsontable($json){
	/*this function creates a nice html table from any json arrays, printing out the tableheadings from the array only once*/
	//works fine with a 4 column table, further testing needed
	$tablehead=true;
	$content='';
	$content.= "<table border ='1'>";
	foreach($json as $row => $innerJson){
		if ($tablehead){
			foreach($innerJson as $picture => $value){
				$content.= "<th>".htmlentities($picture)."</th>";
			}
			$tablehead=false;
		}
		$content.="<tr>";
		foreach($innerJson as $picture => $value){
			$content.= "<td>".htmlentities($value)."</td>";
		}
		$content.= '</tr>';
	}
	$content.= "</table>";
	return $content;
}

function calcRatio($width,$height,$maxwidth,$maxheight){
	/*this funtion asks for 4 arguments the image size (width and height) and the max size (max width and max height) and returns a width height pair which fits into the max size but keeps the aspect ratio.
	
	*/
	if($width>$maxwidth||$height>$maxheight){   //if the given file bigger than the asked size:
        if($width != $height){
            if($width > $height){ //calculations landscape
                $targetwidth = $maxwidth;
                $targetheight = (($targetwidth * $height)/$width);
                if($targetheight > $maxheight){
                    $targetheight = $maxheight;
                    $targetwidth = (($width * $targetheight)/$height);
                }
            }else{ //calculations portrait
                $targetheight = $maxheight;
                $targetwidth = (($width * $targetheight)/$height);
                if($targetwidth > $maxwidth){
                    $targetwidth = $maxwidth;
                    $targetheight = (($targetwidth * $height)/$width);
                }
            }
        }else{ //calculations square
            $targetwidth = $targetheight = min($maxheight,$maxwidth);
		}
    }else{
		$targetheight=$height;
		$targetwidth=$width;
	}
	return array('height'=>(int)$targetheight,'width'=>(int)$targetwidth);
}

function htmlBuild($tpl,$first,$second,$third=NULL){
	/*a function for changing content in html and php. Asks for 4 arguments, first the parth for the template file, the next 3 is the content to be changed, the last one is optional, in html the changeable part have to be like{{first}} for the first argument {{second}} for the second argument. etc.
	returns the changed string*/
	$templ=file_get_contents($tpl);
	$content=str_replace("{{first}}", $first, $templ);
	$content=str_replace("{{second}}", $second, $content);
	$content=str_replace("{{third}}", $third, $content);
	return $content;
}

?>