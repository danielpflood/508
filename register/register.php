<?php
	include('../func.php'); 
if(!isset($_POST['register']))//checking if user has entered this page directly
{
	include('form.php');
}
else{
if(isset($_POST['username'])&&$_POST['username']==""||!isset($_POST['username']))
{
	$error[] = "fill in your username"; 
	$usernameerror = "1";
}
if(isset($_POST['username'])&&!$_POST['username']==""&&!preg_match('/^(?=.{1,15}$)[a-zA-Z][a-zA-Z0-9]*(?: [a-zA-Z0-9]+)*$/', $_POST['username']))
{
	$error[] = "Invalid username"; 
	$usernameerror= "1";
}

if(!isset($usernameerror))
{
	$username = mysql_real_escape_string($_POST['username']);
	$sql = "SELECT * FROM User WHERE username  = '$username'";
	if(mysql_num_rows(mysql_query($sql))=="1"){
		$error[] = "username has already been used"; 
	}
}
if(isset($_POST['password'])&&$_POST['password']==""||!isset($_POST['password'])){
	$error[] = "fill in your password"; 
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
	$susername=mysql_real_escape_string($_POST['username']);
	$spass=md5($_POST['password']);//for secure passwords
	$sip=mysql_real_escape_string($_SERVER['HTTP_HOST']);
	$datetime = date( 'Y-m-d H:i:s' );
	if(isset($_POST['first_name'])){
		$sfname=mysql_real_escape_string($_POST['first_name']);
	}
	if(isset($_POST['last_name'])){
		$slname=mysql_real_escape_string($_POST['last_name']);
	}
	if(isset($sfname)&&isset($slname)){
		$save = mysql_query("INSERT INTO `User` (`userID`, `dateRegistered`, `lastLoggedIn`, `lastLoggedOut`, `firstName`, `lastName`, `username`, `password`, `ip`) VALUES (NULL, '$datetime', NULL, NULL, '$sfname', '$slname', '$susername', '$spass', '$sip')");
	}
	else if(isset($sfname)&&!isset($slname)){
		$save = mysql_query("INSERT INTO `User` (`userID`, `dateRegistered`, `lastLoggedIn`, `lastLoggedOut`, `firstName`, `lastName`, `username`, `password`, `ip`) VALUES (NULL, '$datetime', NULL, NULL, '$sfname', NULL, '$susername', '$spass', '$sip')");
	}
	else if(!isset($sfname)&&isset($slname)){
		$save = mysql_query("INSERT INTO `User` (`userID`, `dateRegistered`, `lastLoggedIn`, `lastLoggedOut`, `firstName`, `lastName`, `username`, `password`, `ip`) VALUES (NULL, '$datetime', NULL, NULL, NULL, '$slname', '$susername', '$spass', '$sip')");
	}
	else{
		$save = mysql_query("INSERT INTO `User` (`userID`, `dateRegistered`, `lastLoggedIn`, `lastLoggedOut`, `firstName`, `lastName`, `username`, `password`, `ip`) VALUES (NULL, '$datetime', NULL, NULL, NULL, NULL, '$susername', '$spass', '$sip')");
	}
	if($save){
		$_SESSION['msg']="You have successfully created your account! Now you can login:";
		header("Location: ../");
	}
	else{
		echo "<div class=\"warning\"><span>Some Error occured durring processing your data</div>";
	}
}
}

?>