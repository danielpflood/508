<?php
include($_SERVER['DOCUMENT_ROOT'].'/508/func.php');

if(!isset($_POST['createproject']))//checking if user has entered this page directly
{
	header('Location: /projects/new');
}
else{
	if(isset($_POST['project_name'])&&$_POST['project_name']==""||!isset($_POST['project_name'])){
		$error = true;
		$_SESSION['msg']='Please fill in the project name.';
		$projectnameerror = "1";
	}
	if(!isset($projectnameerror)){
		$project_name = mysql_real_escape_string($_POST['project_name']);
		$sql = "SELECT * FROM Project WHERE name  = '$project_name'";
		if(mysql_num_rows(mysql_query($sql))=="1"){
			$error = true;
			$_SESSION['msg']='Sorry, this project name is already in use.';
		}
	}
}
if(!isset($error)){
	$sproject_name=mysql_real_escape_string($_POST['project_name']);
	$datetime = date( 'Y-m-d H:i:s' );
	$user = getCurrentUserID();
	if(isset($_POST['project_name'])){
		$sproject_name=mysql_real_escape_string($_POST['project_name']);
	}
	if(isset($sproject_name)){
		$save = mysql_query("INSERT INTO `Project` (`projectID`, `name`, `dateCreated`, `type`) VALUES (NULL, '$sproject_name', '$datetime', 'ukn')");
	}
	if($save){
			$projectID = getProjectID($sproject_name);
			$save2 = mysql_query("INSERT INTO `UserOwnsProject` (`userId`, `projectID`) VALUES ('$user', '$projectID')");
			if($save2){
				$_SESSION['msg']="Succesfully created project!";
				header('Location: /508/projects');
			}
			else{
				$_SESSION['msg'].="<br />Error adding UserOwnsProject entry.";
				header('Location: /508');
			}
	}
	else{
		$_SESSION['msg']="Some error occured durring processing your data.";
		header('Location: /508/projects/new');
	}
}
else{
	header('Location: /508/projects/new');
}

?>