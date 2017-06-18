<?php
require_once 'includes/functions.php';
require_once 'includes/config.php';
$dir = dirname(__FILE__);
if (!isset($_GET['page'])) {
 $id = 'gallery'; 								// display gallery page as home page
} else {
    $id = $_GET['page']; 					// else requested page
}
if (substr_count($id, 'display')){			//not sure its safe have to work on it
	$id='display';
}
$content ="";
switch ($id) {
	case 'upload':
		require_once 'includes/head.html';
		include 'views/upload.php';
		break;
    case 'display' :
	
        include 'views/displayImage.php';
        break;
    case 'gallery' :
		require_once 'includes/head.html';
        include 'views/gallery.php';
        break;
	case 'json' :
		require_once 'includes/head.html';
        include 'JSON/jsonclient.php';
        break;
    default :
        include 'views/404.php';
}

echo $content;   							// Display content for requested view.


require_once "includes/footer.html";
mysqli_close($link);
?>

