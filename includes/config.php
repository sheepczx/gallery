<?php
$link=mysqli_connect('mysqlsrv.dcs.bbk.ac.uk', 'gbirge01', 'bbkmysql', 'gbirge01db');
/*check connection*/
if( mysqli_connect_errno()){
	exit(mysqli_connect_error());
}
?>