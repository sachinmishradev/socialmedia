<?php

include("includes/config.php");


$token = $_REQUEST['token'];
$select = mysqli_query($connection,"SELECT * FROM members where token='$token'");
if(mysqli_num_rows($select)==1){
$update = mysqli_query($connection,"update activated='1' where token='".$token."'");
echo "you have successfully activated your account noe you can proceed to login ! ";
}else{echo "Sorry please try again later";}



?>