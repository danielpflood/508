<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/508/func.php');


if(isset($_POST['to'])&&$_POST['to']==""||!isset($_POST['to'])){
	$error = true;
	$_SESSION['msg']='Who do you wan\'t to send your message to?';
	$messagetoerror = "1";
}
if(!isset($messagetoerror)){
	$to = mysql_real_escape_string($_POST['to']);
	if(!is_int($to)){
		$to_id=getUserID($to);
	}
	else{
		$to_id=$to;
	}
	$sql = "SELECT * FROM User WHERE userID  = '$to_id'";
	if(mysql_num_rows(mysql_query($sql))!="1"){
		$error = true;
		$_SESSION['msg']='Sorry, this user doesn\'t exist.';
	}
}
if(!isset($error)){
	$to = mysql_real_escape_string($_POST['to']);
	$to_id=null;
	if(!is_int($to)){
		$to_id=getUserID($to);
	}
	else{
		$to_id=$to;
	}
	$datetime = date( 'Y-m-d H:i:s' );
	if(isset($_POST['msg'])){
		$msg=mysql_real_escape_string($_POST['msg']);
	}
	$from = getCurrentUserID();
	$datetime = date( 'Y-m-d H:i:s' );
	if(isset($to_id)){
		$save = mysql_query("INSERT INTO `Message` (`messageID`, `fromID`, `toID`, `message`, `dateSent`, `dateRead`) VALUES (NULL, '$from', '$to_id', '$msg', '$datetime', NULL)");
	}
	if($save){
		$_SESSION['msg'].='Your message has been sent!';
		header('Location: /508/messages');
	}
	else{
		$_SESSION['msg']="Some error occured durring processing your data.";
		header('Location: /508/messages/new');
	}
}
else{
	header('Location: /508/messages/new');
}

?>