<?php
include('func.php'); 
if(!isset($_POST['login'])){
	header("Location: /508");
}
else{
	if(isset($_POST['email'])&&$_POST['email']==""||!isset($_POST['email'])){
		$error[] = "Email Field can't be left blank";
		$usererror = "1";
	}
	if(!isset($usererror)){
		$email = mysql_real_escape_string($_POST['email']);
		$sql = "SELECT * FROM User WHERE email = '$email'";
		if(mysql_num_rows(mysql_query($sql))=="0"){
			$error[] = "Can't find a user with this email"; 
		}
	}
	if(isset($_POST['pass'])&&$_POST['pass']==""||!isset($_POST['pass'])){ 
		$error[] = "password Field can't be left blank"; 
	}
	if(isset($error)){
		if(is_array($error)){
			foreach ($error as $ers) {
				$_SESSION['msg'].="".$ers."<br />";
			}
			header("Location: /508");
		}
	}
	if(!isset($error)){
		$semail=mysql_real_escape_string($_POST['email']);
		$spass=md5($_POST['pass']);
		$find = "SELECT * FROM User WHERE email = '$semail' AND password = '$spass'";
		if(mysql_num_rows(mysql_query($find))=="1"){
			$_SESSION['email'] = $semail;
			$datetime = date( 'Y-m-d H:i:s' );
			$logindate = "UPDATE `User` SET `lastLoggedIn` = '$datetime' WHERE `User`.`email` = '$semail';";
			mysql_query($logindate);
			$_SESSION['msg']="Succesfully logged in!";
			header("Location: /508");
		}
		else{
			$_SESSION['msg'].="Some Error occured durring processing your data.";
			header("Location: /508");
		}
	}
}
?>