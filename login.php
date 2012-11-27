<?php
include('db.php'); 
if(!isset($_POST['login']))//checking if user has entered this page directly
{
include('form.php');
}
else{
if(isset($_POST['email'])&&$_POST['email']==""||!isset($_POST['email']))
{
$error[] = "Email Field can't be left blank";
$usererror = "1";
}
if(!isset($usererror))
{
$email = mysql_real_escape_string($_POST['email']);
$sql = "SELECT * FROM User WHERE email = '$email'";
if(mysql_num_rows(mysql_query($sql))=="0")//1 means there is one entry same so we print error
{
$error[] = "Can't find a user with this email"; 
}
}
if(isset($_POST['pass'])&&$_POST['pass']==""||!isset($_POST['pass']))
{
$error[] = "password Field can't be left blank";
}
if(isset($error)){
if(is_array($error)){echo "<div class=\"error\"><span>please check the errors and refill the form<span><br/>";
foreach ($error as $ers) {
echo "<span>".$ers."</span><br/>";
}
echo "</div>";
include('form.php');
}
}
if(!isset($error)){
$semail=mysql_real_escape_string($_POST['email']);
$spass=md5($_POST['pass']);//for secure passwords
$find = "SELECT * FROM User WHERE email = '$semail' AND password = '$spass'";
if(mysql_num_rows(mysql_query($find))=="1"){
session_start();
$_SESSION['email'] = $semail;
$datetime = date( 'Y-m-d H:i:s' );
$logindate = "UPDATE `User` SET `lastLoggedIn` = '$datetime' WHERE `User`.`email` = '$semail';";
if(!mysql_query($logindate)){
	echo '<br />error setting login datetime <br />';
}
$_SESSION['msg']="Succesfully logged in!";
header("Location: /508");
}
else{
echo "Some Error occured durring processing your data. <a href=\"/508\">go back</a>";
}
}
}//close else
?>