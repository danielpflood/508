<?php
include('db.php');
session_start();
$semail = $_SESSION['username'];
$datetime = date( 'Y-m-d H:i:s' );
$logindate = "UPDATE `User` SET `lastLoggedOut` = '$datetime' WHERE `User`.`username` = '$susername';";
if(!mysql_query($logindate)){
	echo '<br />error setting login datetime <br />';
}
 unset($_SESSION['username']); 
 $_SESSION['msg']="Succesfully logged out!";
 header("Location: /508");

?>