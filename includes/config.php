<?php 

define('HOST', "localhost");
define('USERNAME', "root");
define('PASSWORD','');
define('DB', "social_network");
$connection = mysqli_connect(HOST,USERNAME,PASSWORD,DB);
function format_date($date){
	return date("Y D M : g i a",strtotime($date));
}
?>


