<?php
//TODO:convert all mysql to mysqli
session_start();
include_once('db.php');
$_SESSION['home']='http://floodidas.dyndns.info/508/';
function loadStuff(){
	echo '<script language="javascript" type="text/javascript" src="/508/js/jquery-1.8.3.min.js"></script>'."\n";
	//echo '<script language="javascript" type="text/javascript" src="/508/js/bootstrap.min.js"></script>'."\n";
	//echo '<script language="javascript" type="text/javascript" src="/508/js/jquery.autoSuggest.js"></script>'."\n";
	echo '<link href="/508/css/reset.css" rel="stylesheet">'."\n";
	echo '<link href="/508/css/style.css" rel="stylesheet">'."\n";
	echo '<link href="/508/css/jquery.autocomplete.css" rel="stylesheet">'."\n";
	echo '<script src="/508/js/jquery.autocomplete.js"></script> '."\n";
	echo '<link href="/508/css/bootstrap.css" rel="stylesheet">'."\n";
	
	

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
}
function getProjectID($project_name){
	$getProjectID = mysql_query("SELECT DISTINCT `projectID` FROM `Project` WHERE `name` = '$project_name'");
	$row = mysql_fetch_array($getProjectID);
	if(isset($row)){
		$projectID = $row['projectID'];
		return $projectID;
	}
}
function getUserID($username){
	$getUserID = mysql_query("SELECT DISTINCT `userID` FROM `User` WHERE `username` = '$username'");
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
function getAppMessage(){
	if (isset($_SESSION['msg']) && $_SESSION['msg'] != "") {
		echo '<p style="color:green; font-size:small;">'.$_SESSION['msg'].'</p>';
		unset($_SESSION['msg']);
	}
}	
function loggedIn(){
	if (isset($_SESSION['username']) && $_SESSION['username'] != "") {
		return true;
	}
}
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
function listOwnedProjects(){
	$userID = getCurrentUserID();
	$getProjects = mysql_query("SELECT * FROM `Project` WHERE `projectID` IN (SELECT DISTINCT `projectID` FROM `UserOwnsProject` WHERE `userId` = '$userID')");
	$i=0;
	while($row = mysql_fetch_array($getProjects)){
		$i++;
		if($i==1){	echo '<h3>Projects you own:</h3><ul>';}
		echo '<li>
			<a href="'.curPageURL().'viewProject.php?projID='.$row['projectID'].'" style="font-size:16px; text-decoration:none; padding-left:10px;">'.$row['name'].'</a>  <span style="float:right; font-size:small; color:grey;">'.$row['dateCreated'].'</span>
			<a href="'.curPageURL().'addCollaborator.php?projID='.$row['projectID'].'" class="btn" style="font-size:16px; text-decoration:none; padding-left:10px;">Add Collaborator</a>
			<form id="owned-projects" method="post" action="deleteProject.php"><button name="deleteID" class="del_proj" value="'.$row['projectID'].'">Delete</button></form></li>';
	}
	echo '</ul>';
}
function listCollabProjects(){
	$userID = getCurrentUserID();
	$getProjects = mysql_query("SELECT * FROM `Project` WHERE `projectID` IN (SELECT DISTINCT `projectID` FROM `ProjectHasCollaborator` WHERE `userId` = '$userID')");
	$i=0;
	while($row = mysql_fetch_array($getProjects)){
		$i++;
		if($i==1){echo '<h3>Collab Projects:</h3><ul>';}
		echo '<li><a href="'.curPageURL().'viewProject.php?projID='.$row['projectID'].'" style="font-size:16px; text-decoration:none; padding-left:10px;">'.$row['name'].'</a>  <span style="float:right; font-size:small; color:grey;">'.$row['dateCreated'].'</span></li>';
	}
	echo '</ul>';
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
function getUserUsername($id){
  	if (isset($id) && $id != "") {
    	$getUserUsername = mysql_query("SELECT DISTINCT `username` FROM `User` WHERE `userID` = '$id'");
		$row = mysql_fetch_array($getUserUsername);
		if(isset($row)){
			$userUsername = $row['username'];
			return $userUsername;
		}
    }
}
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
function showProject($id){
	if (isset($id) && $id != "") {

		$tempName = getProjectName($id);
    	$sql = mysql_query("SELECT * FROM `Project` WHERE `projectID` = '$id';");
    	/*<a href="'.curPageURL().'addCollaborator.php?projID='.$row['projectID'].'" class="btn" style="font-size:16px; text-decoration:none; padding-left:10px;">Add Collaborator</a>
			<form id="owned-projects" method="post" action="deleteProject.php"><button name="deleteID" class="del_proj" value="'.$row['projectID'].'">Delete</button></form></li>';*/
		echo '<h3>'.getProjectName($id).'</h3>';
		if($sql){
			$row = mysql_fetch_row($sql);
			//echo '<pre>'.print_r($row).'</pre>';
			$row2 = mysql_fetch_row(mysql_query("SELECT `userId` FROM `UserOwnsProject` WHERE `projectID` = '$id';"));
			$owner = $row2[0];
			if(getCurrentUserID()==$owner){
				echo '<p>You own this project</p>';
			}
		}
    }
}
function listProjectCollaborators($project_id){
	$userID = getCurrentUserID();
	$getProjects = mysql_query("SELECT * FROM `ProjectHasCollaborator` WHERE `projectID` = $project_id");
	$i=0;
	while($row = mysql_fetch_array($getProjects)){
		$i++;
		if($i==1){echo '<h3>Collaborators</h3><ul>';}
		echo '<li>'.getUserUsername($row['userID']).'</li>';
	}
	echo '</ul>';
	echo '<a href="/508/projects/addCollaborator.php?projID='.$project_id.'" class="btn" style="font-size:16px; text-decoration:none; padding-left:10px;">Add Collaborator</a>';
}
function showProjectVersions($project_id){
	if (isset($project_id) && $project_id != "") {
		$tempName = getProjectName($project_id);
    	$sql = mysql_query("SELECT * FROM `Project` WHERE `projectID` = '$project_id';");
    	/*<a href="'.curPageURL().'addCollaborator.php?projID='.$row['projectID'].'" class="btn" style="font-size:16px; text-decoration:none; padding-left:10px;">Add Collaborator</a>
			<form id="owned-projects" method="post" action="deleteProject.php"><button name="deleteID" class="del_proj" value="'.$row['projectID'].'">Delete</button></form></li>';*/
		echo '<h3>Versions</h3>';
		$getVersions = mysql_query("SELECT * FROM `Version` WHERE `projectID` = '$project_id';");
		echo '<table>';
		while($row = mysql_fetch_array($getVersions)){
			echo '<tr>
					<td>'.$row['versionID'].'</td>
					<td>'.$row['versionNumber'].'</td>
					<td>'.$row['createdBy'].'</td>
					<td>'.$row['dateCreated'].'</td>
					<td>'.$row['changes'].'</td>
				  </tr>';
		}
		echo '</table><a href="/508/projects/newVersion.php?projID='.$project_id.'" class="btn" style="font-size:16px; text-decoration:none; padding-left:10px;">Create New Version</a>';
    }
}
function createNewVersion($project_id,$changes,$creator){
	$currentVersion = getCurrentVersionID($project_id);
	$newVersionNumber = $currentVersion+1;
	$datetime = date( 'Y-m-d H:i:s' );
	echo 'currentversion result= '.$currentVersion.'<br />';
	$newVersion = mysql_query("INSERT INTO `Version` (`versionNumber`, `projectID`, `createdBy`, `dateCreated`, `changes`) VALUES ('$newVersionNumber', '$project_id', '$creator', '$datetime', '$changes');");
	if($newVersion){
		$_SESSION['msg'].='Created new version. Version "'.($newVersionNumber).'.';
		$_SESSION['msg'].="\n";
			//header("Location: /508/projects");
	}
	else{
		//todo add error handling
		$_SESSION['msg'].='Error creating version "';
		$_SESSION['msg'].='$project_id,$changes,$creator ->'.$project_id.','.$changes.','.$creator."\n";
			//header("Location: /508/projects");
	}
}
function getCurrentVersionID($project_id){
	$sql = "SELECT * FROM `Version` WHERE `projectID` = ".$project_id." ORDER BY `versionNumber` DESC LIMIT 0, 30 ";
	$getVersions= mysql_query($sql);
	/*$latestVersionNum = -1;
	while($row = mysql_fetch_array($getVersions)){
		$i++;
		if($i==1){echo '<h3>Collaborators</h3><ul>';}
		echo '<li>'.getUserUsername($row['userID']).'</li>';
	}*/
	$row = mysql_fetch_array($getVersions);
	if(!empty($row['versionNumber'])){
		return $row['versionNumber'];
	}
	else{
		echo 'error in getCurrentVersionID';
		$_SESSION['msg'].='error in getCurrentVersionID "';
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