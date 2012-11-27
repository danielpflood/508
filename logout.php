<?php
include('db.php');
session_start();
$semail = $_SESSION['email'];
$datetime = date( 'Y-m-d H:i:s' );
$logindate = "UPDATE `User` SET `lastLoggedOut` = '$datetime' WHERE `User`.`email` = '$semail';";
if(!mysql_query($logindate)){
	echo '<br />error setting login datetime <br />';
}
 unset($_SESSION['email']); 
 $_SESSION['msg']="Succesfully logged out!";
 header("Location: /508");

?>