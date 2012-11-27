<?php
	include('../func.php'); 
if(!isset($_POST['register']))//checking if user has entered this page directly
{
	include('form.php');
}
else{
if(isset($_POST['email'])&&$_POST['email']==""||!isset($_POST['email']))
{
	$error[] = "fill in your email"; 
	$emailerror = "1";
}
if(isset($_POST['email'])&&!$_POST['email']==""&&!preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/', $_POST['email']))
{
	$error[] = "Invalid email"; 
	$emailerror= "1";
}

if(!isset($emailerror))
{
	$email = mysql_real_escape_string($_POST['email']);
	$sql = "SELECT * FROM User WHERE email  = '$email'";
	if(mysql_num_rows(mysql_query($sql))=="1"){
		$error[] = "email has already been used"; 
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
	$semail=mysql_real_escape_string($_POST['email']);
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
		$save = mysql_query("INSERT INTO `User` (`userID`, `dateRegistered`, `lastLoggedIn`, `lastLoggedOut`, `firstName`, `lastName`, `email`, `password`, `ip`) VALUES (NULL, '$datetime', NULL, NULL, '$sfname', '$slname', '$semail', '$spass', '$sip')");
	}
	else if(isset($sfname)&&!isset($slname)){
		$save = mysql_query("INSERT INTO `User` (`userID`, `dateRegistered`, `lastLoggedIn`, `lastLoggedOut`, `firstName`, `lastName`, `email`, `password`, `ip`) VALUES (NULL, '$datetime', NULL, NULL, '$sfname', NULL, '$semail', '$spass', '$sip')");
	}
	else if(!isset($sfname)&&isset($slname)){
		$save = mysql_query("INSERT INTO `User` (`userID`, `dateRegistered`, `lastLoggedIn`, `lastLoggedOut`, `firstName`, `lastName`, `email`, `password`, `ip`) VALUES (NULL, '$datetime', NULL, NULL, NULL, '$slname', '$semail', '$spass', '$sip')");
	}
	else{
		$save = mysql_query("INSERT INTO `User` (`userID`, `dateRegistered`, `lastLoggedIn`, `lastLoggedOut`, `firstName`, `lastName`, `email`, `password`, `ip`) VALUES (NULL, '$datetime', NULL, NULL, NULL, NULL, '$semail', '$spass', '$sip')");
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