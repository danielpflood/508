<?php
//TODO:convert all mysql to mysqli
session_start();
<<<<<<< HEAD
include_once('db.php');
function loadStuff(){
	echo '<script language="javascript" type="text/javascript" src="js/jquery-1.8.3.min.js"></script>';
=======
//include_once('db.php');
//DATABASE SETTINGS
$mysql_hostname = "localhost";
$mysql_user = "508";
$mysql_password = "508devDBpass";
$mysql_database = "508devDB";
$bd = mysql_connect($mysql_hostname, $mysql_user, $mysql_password) or die("Opps some thing went wrong with connection");
mysql_select_db($mysql_database, $bd) or die("Opps some thing went wrong! can't select db!");
/////////////////////////////////////
$_SESSION['home']='http://floodweb.info/508/';


/*****************
  JSON functions
******************/
function listUsersJSON(){
	$getUsers = mysql_query("SELECT `dateRegistered`, `lastLoggedIn`, `username` FROM `User`");
	$rows = array();
	while($row = mysql_fetch_assoc($getUsers)){
		$rows[] = $row;
	}
	return json_encode($rows);
}
function listProjectsJSON(){
	$getProjects = mysql_query("SELECT * FROM `Project`");
	$rows = array();
	while($row = mysql_fetch_assoc($getProjects)){
		$rows[] = $row;
	}
	return json_encode($rows);
}
function getUserUsernameJSON($id){
  	if (isset($id) && $id != "") {
    	$getUserUsername = mysql_query("SELECT DISTINCT `username` FROM `User` WHERE `userID` = '$id'");
		$row = mysql_fetch_array($getUserUsername);
		return json_encode($row);
    }
}
function getProjectNameJSON($id){
	$getProjectName = mysql_query("SELECT DISTINCT `name` FROM `Project` WHERE `projectID` = '$id'");
	$row = mysql_fetch_array($getProjectName);
	return json_encode($row);
}
function getUserIDJSON($username){
	$getUserID = mysql_query("SELECT DISTINCT `userID` FROM `User` WHERE `username` = '$username'");
	$row = mysql_fetch_array($getUserID);
	return json_encode($row);
}
function loadAutoCompleteUser(){
		    echo '
		    <script type="text/javascript">
			$().ready(function() {
			        $(".userfield").autocomplete("'.$_SESSION['home'].'listusers.php", {
			                width: 260,
			                matchContains: true,
			                //mustMatch: true,
			                minChars: 1,
			                multiple: true,
			                //highlight: false,
			                multipleSeparator: ",",
			                selectFirst: true
			        });
			});
			</script>
		    ';
>>>>>>> 980121d2575feff76c7cb95b4eba7b6459894ef5
}
function getProjectID($project_name){
	$getProjectID = mysql_query("SELECT DISTINCT `projectID` FROM `Project` WHERE `name` = '$project_name'");
	$row = mysql_fetch_array($getProjectID);
	if(isset($row)){
		$projectID = $row['projectID'];
		return $projectID;
	}
}
<<<<<<< HEAD
function getUserID($email){
	$getUserID = mysql_query("SELECT DISTINCT `userID` FROM `User` WHERE `email` = '$email'");
=======
function getUserID($username){
	$getUserID = mysql_query("SELECT DISTINCT `userID` FROM `User` WHERE `username` = '$username'");
>>>>>>> 980121d2575feff76c7cb95b4eba7b6459894ef5
	$row = mysql_fetch_array($getUserID);
	if(isset($row)){
		$userID = $row['userID'];
		return $userID;
	}
}
function getProjectName($id){
	$getProjectName = mysql_query("SELECT DISTINCT `name` FROM `Project` WHERE `projectID` = '$id'");
	$row = mysql_fetch_array($getProjectName);
	if(isset($row)){
		$projectName = $row['name'];
		return $projectName;
	}
}
function getCurrentUserID(){
  	if (isset($_SESSION['username']) && $_SESSION['username'] != "") {
  		$susername = $_SESSION['username'];
    	$getUserID = mysql_query("SELECT DISTINCT `userID` FROM `User` WHERE `username` = '$susername'");
		$row = mysql_fetch_array($getUserID);
		if(isset($row)){
			$userID = $row['userID'];
			return $userID;
		}
    }
}
function loggedIn(){
	if (isset($_SESSION['username']) && $_SESSION['username'] != "") {
		return true;
	}
}
<<<<<<< HEAD
function listOwnedProjects(){
	echo '<h3>Your Projects:</h3><form id="owned-projects" method="post" action="deleteProject.php"><ul>';
	$userID = getCurrentUserID();
	$getProjects = mysql_query("SELECT * FROM `Project` WHERE `projectID` IN (SELECT DISTINCT `projectID` FROM `UserOwnsProject` WHERE `userId` = '$userID')");
	$i=0;
	while($row = mysql_fetch_array($getProjects)){
		$i++;
		echo '<li><button name="deleteID" class="del_proj" value="'.$row['projectID'].'">Delete</button><a href="#" style="font-size:16px; text-decoration:none; padding-left:10px;">'.$row['name'].'</a>  <span style="float:right; font-size:small; color:grey;">'.$row['dateCreated'].'</span></li>';
	}
	echo '</ul></form>';
}
function listMessages(){
	echo '<h3>Your Messages:</h3><ul>';
	$userID = getCurrentUserID();
	$getMessages = mysql_query("SELECT `fromID`, `message`, `dateSent`, `dateRead` FROM `Message` WHERE `toID` = '$userID'");
	while($row = mysql_fetch_array($getMessages)){
		echo '<li><span style="font-variant:bold;">From: </span>'.getUserEmail($row['fromID']).'<span style="padding-left:15px; color:brown;">'.$row['message'].'</span> <span style="float:right; font-size:small; color:grey;">'.$row['dateSent'].'</span></li>';
	}
	echo '</ul>';
}
function getUserEmail($id){
  	if (isset($id) && $id != "") {
    	$getUserEmail = mysql_query("SELECT DISTINCT `email` FROM `User` WHERE `userID` = '$id'");
		$row = mysql_fetch_array($getUserEmail);
		if(isset($row)){
			$userEmail = $row['email'];
			return $userEmail;
		}
    }
}
=======
function curPageURL() {
 $pageURL = 'http';
 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 return $pageURL; 
}
function isOwner($projectID,$userID){
		$sql = mysql_query("SELECT * FROM `UserOwnsProject` WHERE `projectID` = '$projectID' AND `userId` = '$userID'");
		$row=mysql_fetch_array($sql);
		return (($row['userId']!='' && $row['userId']!=NULL) ? true : false);
}


function addUserToProject($projectID, $userID){
	if(empty($userID)){
		//$_SESSION['msg'].='User doesn\'t exist.';
		//$_SESSION['msg'].="\n";
		//header("Location: /508/projects");
	}
	else{
		$addUser = mysql_query("INSERT INTO `ProjectHasCollaborator` (`projectID`, `userID`) VALUES ('$projectID', '$userID')");
		if($addUser){
			$_SESSION['msg'].='Added collaborator "'.$userID.'" to "'.$projectID.'".';
			$_SESSION['msg'].="\n";
				//header("Location: /508/projects");
		}
		else{
			//todo add error handling
			$_SESSION['msg'].='Error adding collaborator "'.$userID.'" to "'.$projectID.'".';
			$_SESSION['msg'].="\n";
				//header("Location: /508/projects");
		}
	}
}
function listMessages(){
	echo '<h3>Your Messages:</h3><ul>';
	$userID = getCurrentUserID();
	$getMessages = mysql_query("SELECT `fromID`, `message`, `dateSent`, `dateRead` FROM `Message` WHERE `toID` = '$userID'");
	while($row = mysql_fetch_array($getMessages)){
		echo '<li><span style="font-variant:bold;">From: </span>'.getUserUsername($row['fromID']).'<span style="padding-left:15px; color:brown;">'.$row['message'].'</span> <span style="float:right; font-size:small; color:grey;">'.$row['dateSent'].'</span></li>';
	}
	echo '</ul>';
}

function listUsers(){
	echo '<link rel="stylesheet" type="text/css" href="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/css/jquery.dataTables.css">
		  <script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.2.min.js"></script>
		  <script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js"></script>';
	echo '<h3>Users:</h3>';
	echo '<table id="Users-Table">
			<thead>
				<tr>
					<th>User</th>
					<th>Registered</th>
					<th>Last Logged In</th>
					<th>Actions</th>
				</tr>
			</thead>
		  <tbody>';
	$getUsers = mysql_query("SELECT `dateRegistered`, `lastLoggedIn`, `username` FROM `User`");
	while($row = mysql_fetch_array($getUsers)){
		echo '<tr>
				<td>'.$row['username'].'</td>
				<td>'.$row['dateRegistered'].'</td>
				<td>'.$row['lastLoggedIn'].'</td>
				<td><a href="#">Message</a></td>
			  </tr>';
	}
	echo '</tbody></table>';
	echo '<script type="text/javascript">$(document).ready(function() {
    	     $(\'#Users-Table\').dataTable();
		  } );</script>';
}
//function getUserUsername($id){
//  	if (isset($id) && $id != "") {
//    	$getUserUsername = mysql_query("SELECT DISTINCT `username` FROM `User` WHERE `userID` = '$id'");
//		$row = mysql_fetch_array($getUserUsername);
//		if(isset($row)){
//			$userUsername = $row['username'];
//			return $userUsername;
//		}
//    }
//}
>>>>>>> 980121d2575feff76c7cb95b4eba7b6459894ef5
function deleteProject($id){
	if (isset($id) && $id != "") {
		$tempName = getProjectName($id);
    	$sql = mysql_query("DELETE FROM `Project` WHERE `projectID` = '$id';");
		if($sql){
			$_SESSION['msg'].='Deleted project "'.$tempName.'"';
			header("Location: /508/projects");
		}
    }
}
<<<<<<< HEAD
=======
function getCurrentVersionID($project_id){
	$sql = "SELECT * FROM `Version` WHERE `projectID` = ".$project_id." ORDER BY `versionNumber` DESC LIMIT 0, 30 ";
	$getVersions= mysql_query($sql);
	$row = mysql_fetch_array($getVersions);
	if(!empty($row['versionNumber'])){
		return $row['versionNumber'];
	}
	else{
		
		$_SESSION['msg'].='created first version for project. "';
	}
}
function getAllUsers(){
	$sql = mysql_query("SELECT DISTINCT `username` FROM `User`;");
	$ret = Array();
	if($sql){
		while($row = mysql_fetch_array($sql)){
		   array_push($ret, $row['username']);
		}
    	return $ret;
	}
	else{
		return NULL;
	}
}
>>>>>>> 980121d2575feff76c7cb95b4eba7b6459894ef5
function showUserSearch(){
	echo '<h3>Find Users</h3>
	<div id="findusers"><form method="post" action="search.php">
          <input type="text" name="search" id="search_box" class=\'search_box\'/>
          <input type="submit" value="Search" class="user_search_button" /><br />
      </form>
      <ul id="results" class="update">
      </ul></div>';
      echo '  <script type="text/javascript">
				$(function() {
				    $(".user_search_button").click(function() {
				        var searchString    = $("#search_box").val();
				        var data            = \'search=\'+ searchString;
				        if(searchString) {
				            $.ajax({
				                type: "POST",
				                url: "search.php",
				                data: data,
				                beforeSend: function(html) {
				                    $("#results").html(\'\'); 
				                    $("#searchresults").show();
				                    $(".word").html(searchString);
				               },
				               success: function(html){ 
				                    $("#results").show();
				                    $("#results").append(html);
				              }
				            });    
				        }
				        return false;
				    });
				});
				</script>';
}
?>