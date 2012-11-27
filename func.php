<?php
session_start();
include_once('db.php');

function getProjectID($project_name){
	$getProjectID = mysql_query("SELECT DISTINCT `projectID` FROM `Project` WHERE `name` = '$project_name'");
	$row = mysql_fetch_array($getProjectID);
	if(isset($row)){
		$projectID = $row['projectID'];
		return $projectID;
	}
}
function getCurrentUserID(){
  	if (isset($_SESSION['email']) && $_SESSION['email'] != "") {
  		$semail = $_SESSION['email'];
    	$getUserID = mysql_query("SELECT DISTINCT `userID` FROM `User` WHERE `email` = '$semail'");
		$row = mysql_fetch_array($getUserID);
		if(isset($row)){
			$userID = $row['userID'];
			return $userID;
		}
    }
}
function getAppMessage(){
	if (isset($_SESSION['msg']) && $_SESSION['msg'] != "") {
		echo '<p style="color:green; font-size:small;">'.$_SESSION['msg'].'</p>';
		unset($_SESSION['msg']);
	}
}	
function loggedIn(){
	if (isset($_SESSION['email']) && $_SESSION['email'] != "") {
		return true;
	}
}
function listProjects(){
	echo '<h3>Your Projects:</h3><ul>';
	$userID = getCurrentUserID();
	$getProjects = mysql_query("SELECT * FROM `Project` WHERE `projectID` IN (SELECT DISTINCT `projectID` FROM `UserOwnsProject` WHERE `userId` = '$userID')");
	while($row = mysql_fetch_array($getProjects)){
		echo '<li><a href="#">'.$row['name'].'</a>  <span style="font-size:small; color:orange;">('.$row['type'].')</span> <span style="float:right; font-size:small; color:grey;">'.$row['dateCreated'].'</span></li>';
	}
	echo '</ul>';
}
?>